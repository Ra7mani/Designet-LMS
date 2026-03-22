<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>DesignLMS — {{ $title ?? 'Espace Étudiant' }}</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="{{ asset('etudiant/style.css') }}"/>
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar" id="sidebar">
  <div class="sidebar-logo">
    <div class="logo-icon">🎓</div>
    <span class="logo-text">DesignLMS</span>
  </div>

  <span class="nav-section-label">Navigation</span>
  <a class="nav-item {{ request()->routeIs('etudiant.dashboard') ? 'active' : '' }}" href="{{ route('etudiant.dashboard') }}">
    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
    Tableau de bord
  </a>
  <a class="nav-item {{ request()->routeIs('etudiant.mes-cours') ? 'active' : '' }}" href="{{ route('etudiant.mes-cours') }}">
    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
    Mes Cours
    <span class="nav-badge">{{ auth()->user()->inscriptions()->count() }}</span>
  </a>
  <a class="nav-item {{ request()->routeIs('etudiant.progression') ? 'active' : '' }}" href="{{ route('etudiant.progression') }}">
    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
    Ma Progression
  </a>
  <a class="nav-item {{ request()->routeIs('etudiant.planning') ? 'active' : '' }}" href="{{ route('etudiant.planning') }}">
    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
    Planning
  </a>
  <a class="nav-item {{ request()->routeIs('etudiant.forum') ? 'active' : '' }}" href="{{ route('etudiant.forum') }}">
    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
    Forum &amp; Messages
  </a>

  <span class="nav-section-label">Réalisations</span>
  <a class="nav-item {{ request()->routeIs('etudiant.badges') ? 'active' : '' }}" href="{{ route('etudiant.badges') }}">
    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/></svg>
    Badges &amp; Certif.
  </a>
  <a class="nav-item {{ request()->routeIs('etudiant.quiz') ? 'active' : '' }}" href="{{ route('etudiant.quiz') }}">
    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
    Quiz &amp; Examens
  </a>
  <a class="nav-item {{ request()->routeIs('etudiant.parametres') ? 'active' : '' }}" href="{{ route('etudiant.parametres') }}">
    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93A10 10 0 0 0 4.93 19.07M19.07 19.07A10 10 0 0 0 4.93 4.93"/></svg>
    Paramètres
  </a>

  <!-- XP Bar -->
  <div class="sidebar-xp">
    <div class="sidebar-xp-row">
      <span>⚡ Niveau {{ auth()->user()->inscriptions()->where('status','completed')->count() + 1 }}</span>
      <span>{{ auth()->user()->inscriptions()->count() * 100 }} XP</span>
    </div>
    <div class="sidebar-xp-bg">
      <div class="sidebar-xp-fill"></div>
    </div>
  </div>

  <!-- User Card -->
  <div class="sidebar-footer">
    <a class="user-card" href="{{ route('etudiant.profil') }}">
      <div class="av-sm" style="background:linear-gradient(135deg,#7C3AED,#A78BFA)">
        {{ auth()->user()->initials() }}
      </div>
      <div class="user-info">
        <div class="u-name">{{ auth()->user()->name }}</div>
        <div class="u-role">Étudiant</div>
      </div>
    </a>
    <form method="POST" action="{{ route('logout') }}" class="logout-form">
      @csrf
      <button type="submit" class="logout-btn" title="Déconnexion">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke="currentColor"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
      </button>
    </form>
  </div>
</aside>

<!-- HAMBURGER -->
<button class="hamburger" id="hamburger" onclick="document.getElementById('sidebar').classList.toggle('open')">
  <svg viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
</button>

<!-- MAIN -->
<div class="main-wrapper">
  {{ $slot }}
</div>

<div class="toast" id="__toast"><span id="__toastMsg"></span></div>
<script src="{{ asset('etudiant/shared.js') }}"></script>
</body>
</html>
