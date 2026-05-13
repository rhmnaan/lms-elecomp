window.RealtimeMonitor = (function () {

    function RealtimeMonitor(options) {
        this.baseUrl          = (options.baseUrl || '').replace(/\/$/, '');
        this.user             = options.user || '';
        this.onConnected      = options.onConnected      || function () {};
        this.onDisconnected   = options.onDisconnected   || function () {};
        this.onError          = options.onError          || function () {};
        this.onNewAttendance  = options.onNewAttendance  || function () {};
        this.onUpdateAttendance = options.onUpdateAttendance || function () {};

        this._es          = null;
        this._retryTimer  = null;
        this._stopped     = false;
        this._retryDelay  = 2000;  // ✅ mulai dari 2 detik
        this._maxDelay    = 30000;
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
        var url  = this.baseUrl + '/api/realtime/attendance-stream';

        try {
            this._es = new EventSource(url);
        } catch (e) {
            this.onError(e);
            this._scheduleRetry();
            return;
        }

        this._es.onopen = function () {
            self._retryDelay = 2000; // reset backoff ke 2 detik
            self.onConnected();
        };

        this._es.addEventListener('new_attendances', function (e) {
            try { self.onNewAttendance(JSON.parse(e.data)); } catch (_) {}
        });

        /**
         * ✅ Server kirim event 'updated_attendances' HANYA jika:
         *    fingerprint DB ≠ fingerprint cookie tab ini
         * 
         * Artinya: ada device baru yang login → tab ini harus logout
         * Langsung trigger logout tanpa validasi tambahan
         */
        this._es.addEventListener('updated_attendances', function (e) {
            try {
                var data = JSON.parse(e.data);
                console.log('[SSE] Fingerprint mismatch detected:', data);
                self.onUpdateAttendance(data);
            } catch (err) {
                console.error('[SSE] Parse error:', err);
            }
        });

        // ✅ Server tutup stream setelah maxDuration (normal) → reconnect cepat
        this._es.addEventListener('close', function () {
            console.log('[SSE] Server closed connection (normal)');
            if (self._es) {
                self._es.close();
                self._es = null;
            }
            if (!self._stopped) {
                self._retryDelay = 500; // ✅ reconnect sangat cepat untuk polling berkelanjutan
                self._scheduleRetry();
            }
        });

        this._es.onerror = function (err) {
            if (!self._es) return;

            console.error('[SSE] Connection error:', err);
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
        
        console.log('[SSE] Retry in ' + (this._retryDelay / 1000) + 's');
        
        this._retryTimer = setTimeout(function () {
            self._retryTimer = null;
            self._connect();
        }, this._retryDelay);

        // Exponential backoff untuk error, tapi dibatasi
        this._retryDelay = Math.min(this._retryDelay * 1.5, this._maxDelay);
    };

    return RealtimeMonitor;
})();