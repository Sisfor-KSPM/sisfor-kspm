/**
 * Analytics Tracking Helper
 * Gunakan untuk tracking aktivitas user dari frontend
 */

const AnalyticsTracker = {
    baseUrl: '/api/analytics',

    /**
     * Track penggunaan fitur
     * @param {string} featureName - Nama fitur (contoh: "kalkulator", "kamus", dll)
     */
    trackFeature(featureName) {
        this._post('/track-feature', { feature_name: featureName });
    },

    /**
     * Track interaksi dengan event
     * @param {number} eventId - ID event
     * @param {string} interactionType - Tipe interaksi (view, click, attend, interested)
     */
    trackEvent(eventId, interactionType = 'click') {
        this._post('/track-event', {
            event_id: eventId,
            interaction_type: interactionType,
        });
    },

    /**
     * Track unduhan file/report
     * @param {number} reportId - ID report/riset
     * @param {string} reportTitle - Judul report
     */
    trackDownload(reportId, reportTitle) {
        this._post('/track-download', {
            report_id: reportId,
            report_title: reportTitle,
        });
    },

    /**
     * Track akses halaman
     * @param {string} pageName - Nama halaman (contoh: "kamus", "events", dll)
     */
    trackPage(pageName) {
        this._post('/track-page', { page_name: pageName });
    },

    /**
     * Internal method untuk POST request
     */
    _post(endpoint, data) {
        fetch(this.baseUrl + endpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
            },
            body: JSON.stringify(data),
        }).catch(error => console.error('Analytics tracking error:', error));
    },
};

// Export untuk CommonJS atau bisa diakses global
if (typeof module !== 'undefined' && module.exports) {
    module.exports = AnalyticsTracker;
}
