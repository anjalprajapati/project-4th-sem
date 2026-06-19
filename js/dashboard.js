/**
 * Dashboard Interactivity
 */
document.addEventListener('DOMContentLoaded', function() {
    // Progress bars animate on load
    document.querySelectorAll('.progress-fill').forEach(function(bar) {
        var target = bar.getAttribute('data-width') || bar.style.width.replace('%','');
        bar.style.width = '0%';
        setTimeout(function() {
            bar.style.width = target + '%';
        }, 300);
    });
});
