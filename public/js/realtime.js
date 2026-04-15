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
        this._retryDelay  = 3000;
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
            self._retryDelay = 3000; // reset backoff
            self.onConnected();
        };

        this._es.addEventListener('new_attendances', function (e) {
            try { self.onNewAttendance(JSON.parse(e.data)); } catch (_) {}
        });

        /**
         * Server kirim event ini HANYA jika fp DB ≠ cookie tab ini.
         * Langsung trigger logout — tidak perlu validasi tambahan di client.
         */
        this._es.addEventListener('updated_attendances', function (e) {
            try {
                var data = JSON.parse(e.data);
                self.onUpdateAttendance(data);
            } catch (_) {}
        });

        // Server tutup stream setelah maxDuration (normal) → reconnect cepat
        this._es.addEventListener('close', function () {
            if (self._es) {
                self._es.close();
                self._es = null;
            }
            if (!self._stopped) {
                self._retryDelay = 1000; // ✅ reconnect lebih cepat setelah server close normal
                self._scheduleRetry();
            }
        });

        this._es.onerror = function (err) {
            if (!self._es) return;

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

        this._retryDelay = Math.min(this._retryDelay * 2, this._maxDelay);
    };

    return RealtimeMonitor;
})();