/* ============================================================
   DesignLMS — shared.js
   Script commun à toutes les pages (adapté pour Laravel)
   ============================================================ */

// ── Hamburger sidebar ────────────────────────────────────────
var _hbg = document.getElementById('hamburger');
var _sb  = document.getElementById('sidebar');
if (_hbg && _sb) {
  _hbg.addEventListener('click', function() {
    _sb.classList.toggle('open');
  });
  document.addEventListener('click', function(e) {
    if (window.innerWidth <= 900 && !_sb.contains(e.target) && !_hbg.contains(e.target)) {
      _sb.classList.remove('open');
    }
  });
}

// ── Global toast ─────────────────────────────────────────────
var _toastTimer = null;
window.showToast = function(msg, duration) {
  duration = duration || 2800;
  var t   = document.getElementById('__toast');
  var msg_el = document.getElementById('__toastMsg');
  if (!t || !msg_el) return;
  msg_el.textContent = msg;
  t.classList.add('show');
  if (_toastTimer) clearTimeout(_toastTimer);
  _toastTimer = setTimeout(function() { t.classList.remove('show'); }, duration);
};


