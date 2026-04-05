/**
 * RealtimeMonitor — SSE client
 *
 * Mendengarkan endpoint /api/realtime/attendance-stream dan memicu
 * callback saat server mengirim event.
 *
 * Usage:
 *   const monitor = new RealtimeMonitor({
 *       baseUrl: "http://localhost:8080/",
 *       user: "user@email.com",
 *       onConnected:        () => {},
 *       onDisconnected:     () => {},
 *       onError:            (err) => {},
 *       onNewAttendance:    (data) => {},
 *       onUpdateAttendance: (data) => {},
 *   });
 *   monitor.start();
 *   monitor.stop();
 *
 * ─────────────────────────────────────────────────────────────────────
 * CARA KERJA LOGOUT OTOMATIS:
 *
 *   Server (RealtimeDatabaseMonitoring) mengirim event 'updated_attendances'
 *   ketika fingerprint_device di DB BERBEDA dari cookie device_fp tab ini.
 *
 *   Artinya: ada perangkat/tab lain yang baru login dan mengambil alih sesi.
 *   Tab ini harus logout.
 *
 *   Layout.php menangani event ini di onUpdateAttendance:
 *     → Cukup periksa bahwa event memang terjadi (server sudah memvalidasi).
 *     → Tidak perlu membandingkan fingerprint lagi di client.
 * ─────────────────────────────────────────────────────────────────────
 */
window.RealtimeMonitor = (function () {

    function RealtimeMonitor(options) {
        this.baseUrl = (options.baseUrl || '').replace(/\/$/, '');
        this.user = options.user || '';
        this.onConnected = options.onConnected || function () { };
        this.onDisconnected = options.onDisconnected || function () { };
        this.onError = options.onError || function () { };
        this.onNewAttendance = options.onNewAttendance || function () { };
        this.onUpdateAttendance = options.onUpdateAttendance || function () { };

        this._es = null;
        this._retryTimer = null;
        this._stopped = false;
        this._retryDelay = 3000;   // mulai 3s
        this._maxDelay = 30000;  // maks 30s
    }

    RealtimeMonitor.prototype.start = function () {
        this._stopped = false;
        this._connect();
    };

    RealtimeMonitor.prototype.stop = function () {
        this._stopped = true;
        if (this._retryTimer) { clearTimeout(this._retryTimer); this._retryTimer = null; }
        if (this._es) { this._es.close(); this._es = null; }
    };

    RealtimeMonitor.prototype._connect = function () {
        if (this._stopped) return;

        var self = this;
        var url = this.baseUrl + '/api/realtime/attendance-stream';

        try {
            this._es = new EventSource(url);
        } catch (e) {
            this.onError(e);
            this._scheduleRetry();
            return;
        }

        this._es.onopen = function () {
            self._retryDelay = 3000; // reset backoff setelah berhasil konek
            self.onConnected();
        };

        // Event: absensi baru
        this._es.addEventListener('new_attendances', function (e) {
            try { self.onNewAttendance(JSON.parse(e.data)); } catch (_) { }
        });

        /**
         * Event: fingerprint di DB sudah diubah oleh perangkat lain.
         *
         * Server HANYA mengirim event ini jika fingerprint DB ≠ cookie tab ini,
         * sehingga di sini kita LANGSUNG trigger logout — tidak perlu bandingkan lagi.
         */
        this._es.addEventListener('updated_attendances', function (e) {
            try {
                var data = JSON.parse(e.data);
                self.onUpdateAttendance(data);
            } catch (_) { }
        });

        // Event: server tutup stream (batas durasi 25s) → reconnect dengan delay kecil
        // Tidak langsung _connect() untuk menghindari tight loop jika server terus-menerus close
        // Event close dari server
        this._es.addEventListener('close', function () {
            if (self._es) {
                self._es.close();
                self._es = null;  // ← set null DULU sebelum close agar onerror skip
            }
            if (!self._stopped) {
                self._retryDelay = 1000; // reconnect lebih cepat, server close = normal
                self._scheduleRetry();
            }
        });

        this._es.onerror = function (err) {
            if (!self._es) return; // ← kalau sudah null, berarti close yang handle, skip

            self.onDisconnected();
            self.onError(err);
            self._es.close();
            self._es = null;
            self._scheduleRetry();
        };
    };

    RealtimeMonitor.prototype._scheduleRetry = function () {
        if (this._stopped) return;
        var self = this;
        this._retryTimer = setTimeout(function () {
            self._retryTimer = null;
            self._connect();
        }, this._retryDelay);

        // Exponential backoff
        this._retryDelay = Math.min(this._retryDelay * 2, this._maxDelay);
    };

    return RealtimeMonitor;
})();