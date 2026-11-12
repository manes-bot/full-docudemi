/* DocuDemi UI Helpers
   Hanya perilaku visual antarmuka. Tidak menyentuh form, route, atau logic backend. */
(function () {
    'use strict';

    function initUI() {
        var doc = document;
        var body = doc.body;

        /* 1. Drawer Sidebar (Mobile Toggle) ------------------------------------- */
        var toggle = doc.querySelector('[data-nav-toggle]');
        var backdrop = doc.querySelector('[data-nav-backdrop]');

        function setDrawer(open) {
            body.classList.toggle('sidebar-open', open);
            if (toggle) {
                toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
            }
        }

        if (toggle) {
            toggle.onclick = function (e) {
                e.preventDefault();
                e.stopPropagation();
                setDrawer(!body.classList.contains('sidebar-open'));
            };
        }

        if (backdrop) {
            backdrop.onclick = function (e) {
                e.preventDefault();
                setDrawer(false);
            };
        }

        doc.querySelectorAll('.sidebar .menu-item').forEach(function (link) {
            link.onclick = function () {
                setDrawer(false);
            };
        });

        /* Reset drawer saat layar di-resize ke Desktop (> 768px) */
        var desktopQuery = window.matchMedia('(min-width: 768px)');
        var onBreakpoint = function (e) { 
            if (e.matches) { setDrawer(false); } 
        };

        if (desktopQuery.addEventListener) {
            desktopQuery.addEventListener('change', onBreakpoint);
        } else if (desktopQuery.addListener) {
            desktopQuery.addListener(onBreakpoint);
        }

        /* 2. Escape / Klik Latar Menutup Modal & Drawer ------------------- */
        doc.addEventListener('keydown', function (e) {
            if (e.key !== 'Escape') { return; }
            setDrawer(false);
            doc.querySelectorAll('.modal-overlay').forEach(function (m) {
                if (m.style.display === 'flex') { m.style.display = 'none'; }
            });
        });

        doc.addEventListener('mousedown', function (e) {
            var t = e.target;
            if (t && t.classList && t.classList.contains('modal-overlay')) {
                t.style.display = 'none';
            }
        });

        /* 3. Bungkus Semua <table> dengan .table-responsive ---------------- */
        doc.querySelectorAll('.content-body table').forEach(function (table) {
            if (table.closest('.table-responsive')) { return; }
            var wrap = doc.createElement('div');
            wrap.className = 'table-responsive';
            table.parentNode.insertBefore(wrap, table);
            wrap.appendChild(table);
        });

        /* 4. Upload Box: Tandai saat File Dipilih / Di-drag ---------------- */
        doc.querySelectorAll('input[type="file"].upload-box').forEach(function (input) {
            input.onchange = function () {
                input.classList.toggle('has-file', input.files && input.files.length > 0);
            };

            ['dragenter', 'dragover'].forEach(function (ev) {
                input.addEventListener(ev, function () { 
                    input.classList.add('is-dragover'); 
                });
            });

            ['dragleave', 'drop'].forEach(function (ev) {
                input.addEventListener(ev, function () { 
                    input.classList.remove('is-dragover'); 
                });
            });
        });
    }

    /* Pastikan script berjalan setelah DOM selesai di-parse */
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initUI);
    } else {
        initUI();
    }
})();