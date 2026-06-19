/**
 * Global Scripts
 * Street Dog Fundraising and Support Management System
 */

document.addEventListener('DOMContentLoaded', function () {

    // ---- Mobile Navigation Toggle ----
    const hamburger = document.getElementById('hamburger');
    const nav = document.getElementById('mainNav');

    if (hamburger && nav) {
        hamburger.addEventListener('click', function () {
            nav.classList.toggle('open');
            this.textContent = nav.classList.contains('open') ? '✕' : '☰';
        });

        // Close nav when clicking a link
        nav.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', function () {
                nav.classList.remove('open');
                hamburger.textContent = '☰';
            });
        });
    }

    // ---- Auto-dismiss alerts after 5 seconds ----
    var alerts = document.querySelectorAll('.alert');
    alerts.forEach(function (alert) {
        setTimeout(function () {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(function () {
                alert.remove();
            }, 300);
        }, 5000);
    });

    // ---- Smooth scroll for anchor links ----
    document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
        anchor.addEventListener('click', function (e) {
            var targetId = this.getAttribute('href');
            if (targetId === '#') return;
            var target = document.querySelector(targetId);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    // ---- Animated counter for stat numbers ----
    var counters = document.querySelectorAll('[data-count]');
    if (counters.length > 0) {
        var observed = new Set();
        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting && !observed.has(entry.target)) {
                    observed.add(entry.target);
                    animateCounter(entry.target);
                }
            });
        }, { threshold: 0.5 });

        counters.forEach(function (counter) {
            observer.observe(counter);
        });
    }

    function animateCounter(el) {
        var target = parseInt(el.getAttribute('data-count'));
        var prefix = el.getAttribute('data-prefix') || '';
        var duration = 1500;
        var step = target / (duration / 16);
        var current = 0;

        var timer = setInterval(function () {
            current += step;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            el.textContent = prefix + Math.floor(current).toLocaleString();
        }, 16);
    }

    // ---- Delete confirmation ----
    document.querySelectorAll('[data-confirm]').forEach(function (el) {
        el.addEventListener('click', function (e) {
            var message = this.getAttribute('data-confirm') || 'Are you sure you want to delete this?';
            if (!confirm(message)) {
                e.preventDefault();
            }
        });
    });

    // ---- Image preview on file input ----
    document.querySelectorAll('[data-preview]').forEach(function (input) {
        input.addEventListener('change', function () {
            var previewId = this.getAttribute('data-preview');
            var preview = document.getElementById(previewId);
            if (preview && this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    preview.innerHTML = '<img src="' + e.target.result + '" alt="Preview">';
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    });

    // ---- Active nav link highlighting ----
    var currentPath = window.location.pathname;
    document.querySelectorAll('.nav a, .sidebar-nav a').forEach(function (link) {
        var href = link.getAttribute('href');
        if (href && currentPath.includes(href.replace(/^\.\.\//, '').replace(/^\.\//, ''))) {
            link.classList.add('active');
        }
    });

    // ---- Progress bar animation ----
    document.querySelectorAll('.progress-fill').forEach(function (bar) {
        var width = bar.getAttribute('data-width');
        if (width) {
            setTimeout(function () {
                bar.style.width = width + '%';
            }, 200);
        }
    });

});
