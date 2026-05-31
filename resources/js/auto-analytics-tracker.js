/**
 * Auto Analytics Tracker
 * Otomatis track aktivitas berdasarkan data attributes
 * Lebih mudah daripada harus modifikasi setiap elemen
 */

const AutoAnalyticsTracker = {
    init() {
        this.setupAutoTracking();
    },

    /**
     * Setup auto tracking dengan data attributes
     * 
     * Contoh penggunaan:
     * <button data-track-feature="kalkulator">Kalkulator</button>
     * <a href="#" data-track-event="1" data-track-type="click">Event Title</a>
     * <a href="#" data-track-download="1" data-track-title="Report">Download</a>
     */
    setupAutoTracking() {
        // Auto track feature clicks
        document.addEventListener('click', (e) => {
            const target = e.target.closest('[data-track-feature]');
            if (target) {
                const featureName = target.getAttribute('data-track-feature');
                AnalyticsTracker.trackFeature(featureName);
            }
        });

        // Auto track event interactions
        document.addEventListener('click', (e) => {
            const target = e.target.closest('[data-track-event]');
            if (target) {
                const eventId = target.getAttribute('data-track-event');
                const interactionType = target.getAttribute('data-track-type') || 'click';
                AnalyticsTracker.trackEvent(eventId, interactionType);
            }
        });

        // Auto track downloads
        document.addEventListener('click', (e) => {
            const target = e.target.closest('[data-track-download]');
            if (target) {
                const reportId = target.getAttribute('data-track-download');
                const reportTitle = target.getAttribute('data-track-title') || 'Report';
                AnalyticsTracker.trackDownload(reportId, reportTitle);
            }
        });

        // Auto track page views on navigation
        document.addEventListener('click', (e) => {
            const target = e.target.closest('[data-track-page]');
            if (target) {
                const pageName = target.getAttribute('data-track-page');
                AnalyticsTracker.trackPage(pageName);
            }
        });
    },

    /**
     * Easy integration - tambah data attributes ke HTML:
     * 
     * Feature buttons:
     * <button data-track-feature="kalkulator">Buka Kalkulator</button>
     * <button data-track-feature="kamus">Buka Kamus</button>
     * <button data-track-feature="gallery">Lihat Galeri</button>
     * 
     * Event interactions:
     * <div data-track-event="5" data-track-type="view">Event Title</div>
     * <button data-track-event="5" data-track-type="click">Lihat Detail</button>
     * <button data-track-event="5" data-track-type="interested">Tertarik</button>
     * 
     * Downloads:
     * <a data-track-download="1" data-track-title="Laporan Q1">Download Report</a>
     * <button data-track-download="3" data-track-title="Research Paper">Download</button>
     * 
     * Page navigation:
     * <a href="/kamus" data-track-page="kamus">Kamus Saham</a>
     * <a href="/events" data-track-page="events">Events</a>
     */
};

// Auto init ketika DOM ready
document.addEventListener('DOMContentLoaded', () => {
    AutoAnalyticsTracker.init();
});

// Export untuk module systems
if (typeof module !== 'undefined' && module.exports) {
    module.exports = AutoAnalyticsTracker;
}
