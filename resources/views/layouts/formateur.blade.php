<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<title>DesignLMS Formateur — {{ $slot ?? '' }}</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="{{ asset('formateur/style.css') }}"/>
@livewireStyles
</head>
<body @class(['dark-mode' => auth()->user()?->dark_mode])>

<aside class="sidebar" id="sidebar">
  <div class="sidebar-logo">
    <div class="logo-icon">🎓</div>
    <div>
      <div class="logo-text">DesignLMS</div>
      <div class="logo-role">Espace Formateur</div>
    </div>
  </div>

  <span class="nav-section-label">Principal</span>
  <a class="nav-item{{ request()->routeIs('formateur.dashboard') ? ' active' : '' }}" href="{{ route('formateur.dashboard') }}">
    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
    Tableau de bord
  </a>
  <a class="nav-item{{ request()->routeIs('formateur.mes-cours') ? ' active' : '' }}" href="{{ route('formateur.mes-cours') }}">
    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
    Mes Cours
  </a>
  <a class="nav-item{{ request()->routeIs('formateur.creer-cours') ? ' active' : '' }}" href="{{ route('formateur.creer-cours') }}">
    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
    Créer un Cours
  </a>
  <a class="nav-item{{ request()->routeIs('formateur.etudiants') ? ' active' : '' }}" href="{{ route('formateur.etudiants') }}">
    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
    Mes Étudiants<span class="nav-badge" id="sidebarStudentsBadge">{{ auth()->user()->cours()->withCount('inscriptions')->get()->sum('inscriptions_count') }}</span>
  </a>
  <a class="nav-item{{ request()->routeIs('formateur.forum') ? ' active' : '' }}" href="{{ route('formateur.forum') }}">
    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
    Messages non lus<span class="nav-badge" id="sidebarMessagesBadge">0</span>
  </a>

  <span class="nav-section-label">Pédagogie</span>
  <a class="nav-item{{ request()->routeIs('formateur.quiz') ? ' active' : '' }}" href="{{ route('formateur.quiz') }}">
    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
    Quiz &amp; Examens
  </a>
  <a class="nav-item{{ request()->routeIs('formateur.forum') ? ' active' : '' }}" href="{{ route('formateur.forum') }}">
    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
    Forum &amp; Messages
  </a>
  <a class="nav-item{{ request()->routeIs('formateur.planning') ? ' active' : '' }}" href="{{ route('formateur.planning') }}">
    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
    Planning &amp; Lives
  </a>

  <span class="nav-section-label">Analytics</span>
  <a class="nav-item{{ request()->routeIs('formateur.statistiques') ? ' active' : '' }}" href="{{ route('formateur.statistiques') }}">
    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
    Statistiques &amp; Revenus
  </a>

  <div class="sidebar-stat-block">
    <div class="ssb-row">
      <div class="ssb-item"><div class="ssb-val">{{ auth()->user()->cours()->count() }}</div><div class="ssb-lbl">Cours actifs</div></div>
      <div class="ssb-divider"></div>
      <div class="ssb-item"><div class="ssb-val">{{ auth()->user()->cours()->withCount('inscriptions')->get()->sum('inscriptions_count') }}</div><div class="ssb-lbl">Étudiants</div></div>
      <div class="ssb-divider"></div>
      <div class="ssb-item"><div class="ssb-val">{{ number_format(auth()->user()->cours()->avg('rating') ?? 0, 1) }}⭐</div><div class="ssb-lbl">Note moy.</div></div>
    </div>
  </div>

  <div class="sidebar-footer">
    <a href="{{ route('formateur.profil') }}" style="display: flex; align-items: center; gap: 12px; background: linear-gradient(135deg, #0d9488 0%, #14b8a6 100%); padding: 12px 16px; border-radius: 12px; border: 1.5px solid rgba(20, 184, 166, 0.3); text-decoration: none; transition: all .2s; position: relative;" onmouseover="this.style.boxShadow='0 8px 16px rgba(13, 148, 136, 0.3)'; this.style.transform='translateY(-2px)'" onmouseout="this.style.boxShadow='none'; this.style.transform='translateY(0)'">
      <div class="av-sm" style="background: linear-gradient(135deg, #0369a1, #0284d4); width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; border-radius: 50%; flex-shrink: 0;">
        <span style="font-size: 18px; font-weight: 800; color: white;">{{ substr(auth()->user()->name, 0, 2) }}</span>
      </div>
      <div style="flex: 1; min-width: 0; pointer-events: none;">
        <div style="font-size: 13px; font-weight: 600; color: white; margin-bottom: 2px;">{{ auth()->user()->name }}</div>
        <div style="font-size: 12px; color: rgba(255, 255, 255, 0.9); font-weight: 400;">Formateur</div>
      </div>
      <form method="POST" action="{{ route('logout') }}" style="flex-shrink: 0; position: absolute; right: 12px;" onclick="event.stopPropagation();">
        @csrf
        <button type="submit" style="background: linear-gradient(135deg, #0369a1, #0284d4); border: none; border-radius: 50%; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all .2s; box-shadow: 0 2px 8px rgba(3, 105, 161, 0.3);" title="Déconnexion" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
          <svg viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke="white" style="width: 18px; height: 18px;"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
        </button>
      </form>
    </a>
  </div>
</aside>

<button class="hamburger" id="hamburger" onclick="toggleSidebar()">
  <svg viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
</button>

<div class="main-wrapper">
  <header class="page-header">
    <div style="flex:1">
      <h1>Bonjour 👋 {{ auth()->user()->first_name ?? auth()->user()->name }}!</h1>
      <p id="hdate">Chargement…</p>
    </div>
    <div class="search-bar" id="searchBar">
      <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
      <input placeholder="Chercher…" id="searchInput" onkeyup="performSearch(this.value)"/>
      <div class="search-results" id="searchResults" style="display:none;"></div>
    </div>
    <div class="icon-btn" onclick="toggleNotifDropdown()" title="Notifications">
      <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
      <span class="notif-badge" id="notifBadge">0</span>
    </div>
    <a href="{{ route('formateur.creer-cours') }}" class="btn btn-primary btn-sm">
      <svg viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      Nouveau cours
    </a>
    <a href="{{ route('formateur.profil') }}" class="header-avatar" style="background:linear-gradient(135deg,#0284C7,#38BDF8);border:2.5px solid #38BDF8;box-shadow:0 0 0 4px rgba(56,189,248,.18);">{{ substr(auth()->user()->name, 0, 2) }}</a>
  </header>

  <div class="page-content">
    {{ $slot }}
  </div>
</div>

<!-- Notifications Dropdown -->
<div class="notif-dropdown" id="notifDropdown">
  <div class="notif-header">
    <h4>Notifications</h4>
    <button class="notif-close" onclick="closeNotifDropdown()">✕</button>
  </div>
  <div class="notif-list" id="notifList">
    <!-- Will be populated by JavaScript -->
  </div>
</div>

<!-- Mobile overlay for sidebar -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

<script>
var D=['Dim','Lun','Mar','Mer','Jeu','Ven','Sam'],M=['janv','févr','mars','avr','mai','juin','juil','août','sept','oct','nov','déc'],n=new Date();
var hdate = document.getElementById('hdate');
if(hdate) hdate.textContent=D[n.getDay()]+' '+n.getDate()+' '+M[n.getMonth()]+' '+n.getFullYear()+' — Bonne journée !';

// Hamburger menu toggle
function toggleSidebar() {
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('sidebarOverlay');
  sidebar.classList.toggle('open');
  overlay.classList.toggle('active');
}

// Close sidebar when clicking nav item
document.querySelectorAll('.nav-item').forEach(item => {
  item.addEventListener('click', () => {
    if (window.innerWidth < 900) {
      const sidebar = document.getElementById('sidebar');
      sidebar.classList.remove('open');
      document.getElementById('sidebarOverlay').classList.remove('active');
    }
  });
});

// Notifications dropdown
function toggleNotifDropdown() {
  const dropdown = document.getElementById('notifDropdown');
  dropdown.classList.toggle('active');
}

function closeNotifDropdown() {
  document.getElementById('notifDropdown').classList.remove('active');
}

// Close dropdown when clicking outside
document.addEventListener('click', (e) => {
  const notifBtn = document.querySelector('.icon-btn');
  const dropdown = document.getElementById('notifDropdown');
  if (!notifBtn.contains(e.target) && !dropdown.contains(e.target)) {
    closeNotifDropdown();
  }
});

// Load notifications from API
function loadNotifications() {
  const notifList = document.getElementById('notifList');

  fetch('/formateur/api/notifications')
    .then(response => response.json())
    .then(data => {
      const items = data?.items || [];
      const unreadCount = data?.unread_count || 0;

      if (!items || items.length === 0) {
        notifList.innerHTML = '<div class="notif-empty">Aucune notification</div>';
        updateNotificationBadge(0);
        return;
      }

      notifList.innerHTML = items.map(notif => `
        <div class="notif-item">
          <div class="notif-avatar">${notif.user_avatar}</div>
          <div class="notif-content">
            <div class="notif-message"><strong>${notif.user_name}</strong> ${notif.message}</div>
            <div class="notif-course">${notif.course_title}</div>
            <div class="notif-time">${notif.created_at}</div>
          </div>
        </div>
      `).join('');

      updateNotificationBadge(unreadCount);
    })
    .catch(error => {
      console.error('Error loading notifications:', error);
      notifList.innerHTML = '<div class="notif-empty">Erreur lors du chargement</div>';
      if (typeof showToast === 'function') showToast('Erreur API notifications');
    });
}

// Update badge count
function updateNotificationBadge(count) {
  const badge = document.querySelector('.notif-badge');
  if (!badge) return;

  badge.textContent = count > 0 ? count : '0';

  if (count === 0) {
    badge.style.display = 'none';
  } else {
    badge.style.display = 'flex';
    badge.title = count + ' notification' + (count > 1 ? 's' : '');
  }
}

// Load notifications when dropdown opens
document.addEventListener('click', function(e) {
  const notifBtn = document.querySelector('.icon-btn');
  if (notifBtn && notifBtn.contains(e.target)) {
    loadNotifications();
  }
});

function loadSidebarStats() {
  fetch('/formateur/api/sidebar-stats')
    .then(response => response.json())
    .then(data => {
      const studentsBadge = document.getElementById('sidebarStudentsBadge');
      const messagesBadge = document.getElementById('sidebarMessagesBadge');
      if (studentsBadge) studentsBadge.textContent = data?.students_count ?? 0;
      if (messagesBadge) messagesBadge.textContent = data?.messages_unread ?? 0;
    })
    .catch(() => { if (typeof showToast === 'function') showToast('Erreur API sidebar'); });
}

setInterval(loadSidebarStats, 5000);
setInterval(loadNotifications, 10000);
loadSidebarStats();
loadNotifications();

</script>

<div class="toast" id="_toast"><span id="_toastMsg"></span></div>

@livewireScripts
<script src="{{ asset('formateur/shared.js') }}"></script>
</body>
</html>
