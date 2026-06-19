/**
 * Admin Panel Scripts
 * Street Dog Fundraising and Support Management System
 */

document.addEventListener('DOMContentLoaded', function () {

    // ---- Sidebar Toggle (Mobile/Tablet) ----
    var sidebarToggle = document.getElementById('sidebarToggle');
    var sidebar = document.getElementById('sidebar');
    var overlay = document.getElementById('sidebarOverlay');

    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function () {
            sidebar.classList.toggle('open');
            if (overlay) overlay.classList.toggle('open');
        });

        if (overlay) {
            overlay.addEventListener('click', function () {
                sidebar.classList.remove('open');
                overlay.classList.remove('open');
            });
        }
    }

    // ---- Table Search/Filter ----
    var tableSearch = document.getElementById('tableSearch');
    if (tableSearch) {
        tableSearch.addEventListener('input', function () {
            var query = this.value.toLowerCase();
            var table = document.querySelector('.table-wrapper table');
            if (!table) return;

            var rows = table.querySelectorAll('tbody tr');
            rows.forEach(function (row) {
                var text = row.textContent.toLowerCase();
                row.style.display = text.includes(query) ? '' : 'none';
            });
        });
    }

    // ---- Select All Checkboxes ----
    var selectAll = document.getElementById('selectAll');
    if (selectAll) {
        selectAll.addEventListener('change', function () {
            var checkboxes = document.querySelectorAll('.row-checkbox');
            checkboxes.forEach(function (cb) {
                cb.checked = selectAll.checked;
            });
        });
    }

    // ---- Status Filter Dropdown ----
    var statusFilter = document.getElementById('statusFilter');
    if (statusFilter) {
        statusFilter.addEventListener('change', function () {
            var selected = this.value.toLowerCase();
            var table = document.querySelector('.table-wrapper table');
            if (!table) return;

            var rows = table.querySelectorAll('tbody tr');
            rows.forEach(function (row) {
                if (!selected) {
                    row.style.display = '';
                    return;
                }
                var statusCell = row.querySelector('[data-status]');
                if (statusCell) {
                    var status = statusCell.getAttribute('data-status').toLowerCase();
                    row.style.display = status === selected ? '' : 'none';
                }
            });
        });
    }

    // ---- Print Report ----
    var printBtn = document.getElementById('printReport');
    if (printBtn) {
        printBtn.addEventListener('click', function () {
            window.print();
        });
    }

});
