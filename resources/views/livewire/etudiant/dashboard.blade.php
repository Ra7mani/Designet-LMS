<div>
<style>
/* HEADER */
.hdr{position:sticky;top:0;z-index:50;background:rgba(245,243,255,.88);backdrop-filter:blur(14px);border-bottom:1.5px solid var(--border);padding:15px 30px;display:flex;align-items:center;gap:14px;}
.hdr-left{flex:1;}
.hdr-left h1{font-family:'Poppins',sans-serif;font-size:21px;font-weight:800;color:var(--txt);}
.hdr-left p{font-size:12px;color:var(--muted);margin-top:2px;}
/* SEARCH */
.search-box{display:flex;align-items:center;gap:8px;background:#fff;border:1.5px solid var(--border);border-radius:var(--rp);padding:9px 16px;min-width:280px;box-shadow:var(--sh);transition:all .2s;position:relative;}
.search-box:focus-within{box-shadow:0 0 0 3px rgba(167,139,250,.25);border-color:var(--vl);}
.search-box svg{stroke:var(--muted);width:16px;height:16px;flex-shrink:0;}
.search-box input{border:none;outline:none;background:transparent;font-family:'DM Sans',sans-serif;font-size:13px;color:var(--txt);width:100%;}
.search-box input::placeholder{color:var(--muted);}
.search-results{position:absolute;top:100%;left:0;right:0;background:#fff;border:1.5px solid var(--border);border-radius:var(--rm);margin-top:6px;box-shadow:var(--shlift);z-index:100;max-height:300px;overflow-y:auto;}
.search-item{display:flex;align-items:center;gap:12px;padding:12px 16px;cursor:pointer;transition:all .15s;text-decoration:none;color:var(--txt);}
.search-item:hover{background:var(--vxl);}
.search-item-icon{width:40px;height:40px;border-radius:10px;background:var(--vxl);display:flex;align-items:center;justify-content:center;font-size:18px;}
.search-item-info{flex:1;}
.search-item-title{font-size:13px;font-weight:600;color:var(--txt);}
.search-item-cat{font-size:11px;color:var(--muted);}
.search-empty{padding:20px;text-align:center;color:var(--muted);font-size:13px;}
.search-clear{cursor:pointer;padding:4px;}
.search-clear:hover svg{stroke:var(--v);}
.hdr-acts{display:flex;align-items:center;gap:10px;}
.ibtn{width:40px;height:40px;border-radius:50%;border:1.5px solid var(--border);background:#fff;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all .2s;box-shadow:var(--sh);position:relative;}
.ibtn:hover{background:var(--vxl);border-color:var(--vl);}
.ibtn svg{width:17px;height:17px;stroke:var(--muted);}
.notif-badge{position:absolute;top:-2px;right:-2px;min-width:18px;height:18px;border-radius:50%;background:#EF4444;color:#fff;font-size:10px;font-weight:700;display:flex;align-items:center;justify-content:center;border:2px solid #fff;}
/* NOTIFICATIONS PANEL */
.notif-panel{position:absolute;top:50px;right:0;width:340px;background:#fff;border:1.5px solid var(--border);border-radius:var(--r);box-shadow:var(--shlift);z-index:100;overflow:hidden;}
.notif-header{padding:16px 18px;border-bottom:1.5px solid var(--border);display:flex;align-items:center;justify-content:space-between;}
.notif-header h3{font-family:'Poppins',sans-serif;font-size:15px;font-weight:700;color:var(--txt);}
.notif-header span{font-size:11px;color:var(--v);cursor:pointer;}
.notif-list{max-height:320px;overflow-y:auto;}
.notif-item{display:flex;gap:12px;padding:14px 18px;border-bottom:1px solid var(--border);transition:all .15s;cursor:pointer;}
.notif-item:hover{background:var(--vxl);}
.notif-item:last-child{border-bottom:none;}
.notif-item.unread{background:rgba(124,58,237,.03);}
.notif-item.unread::before{content:'';position:absolute;left:8px;width:6px;height:6px;border-radius:50%;background:var(--v);}
.notif-icon{width:36px;height:36px;border-radius:10px;background:var(--vxl);display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0;}
.notif-content{flex:1;}
.notif-title{font-size:13px;font-weight:600;color:var(--txt);}
.notif-msg{font-size:12px;color:var(--muted);margin-top:2px;line-height:1.4;}
.notif-time{font-size:10px;color:var(--muted);margin-top:4px;}
.notif-empty{padding:30px;text-align:center;color:var(--muted);font-size:13px;}
/* CONTENT GRID */
.content{flex:1;padding:28px 30px;display:grid;grid-template-columns:1fr 330px;gap:24px;align-items:start;}
.lc{display:flex;flex-direction:column;gap:24px;}
.rc{display:flex;flex-direction:column;gap:22px;}
.sh{display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;}
.st{font-family:'Poppins',sans-serif;font-weight:700;font-size:16px;color:var(--txt);display:flex;align-items:center;gap:7px;}
.sc{background:var(--vxl);color:var(--v);font-size:11px;font-weight:700;padding:2px 8px;border-radius:var(--rp);}
.sa{font-size:12px;font-weight:600;color:var(--v);cursor:pointer;text-decoration:none;}
.sa:hover{text-decoration:underline;}
/* XP BANNER */
.xp-banner{background:linear-gradient(135deg,#1E1B4B 0%,#4C1D95 50%,#7C3AED 100%);border-radius:var(--r);padding:20px 24px;display:flex;align-items:center;gap:20px;position:relative;overflow:hidden;box-shadow:0 8px 30px rgba(30,27,75,.3);}
.xp-banner::before{content:'';position:absolute;top:-30px;right:100px;width:120px;height:120px;border-radius:50%;background:rgba(255,255,255,.05);}
.xp-avatar{width:56px;height:56px;border-radius:50%;background:linear-gradient(135deg,#A78BFA,#7C3AED);display:flex;align-items:center;justify-content:center;font-family:'Poppins',sans-serif;font-size:20px;font-weight:800;color:#fff;border:3px solid rgba(255,255,255,.25);flex-shrink:0;}
.xp-info{flex:1;}
.xp-name{font-family:'Poppins',sans-serif;font-size:16px;font-weight:700;color:#fff;margin-bottom:2px;}
.xp-level{font-size:12px;color:rgba(255,255,255,.7);margin-bottom:10px;}
.xp-level strong{color:#A78BFA;}
.xp-bar{height:8px;background:rgba(255,255,255,.15);border-radius:var(--rp);overflow:hidden;margin-bottom:6px;}
.xp-bar-fill{height:100%;border-radius:var(--rp);background:linear-gradient(90deg,#A78BFA,#38BDF8);box-shadow:0 0 12px rgba(167,139,250,.5);}
.xp-text{font-size:11px;color:rgba(255,255,255,.6);}
.xp-text strong{color:#fff;}
.xp-badge{background:rgba(255,255,255,.12);backdrop-filter:blur(6px);border:1.5px solid rgba(255,255,255,.2);border-radius:var(--rp);padding:10px 16px;text-align:center;flex-shrink:0;}
.xp-badge-level{font-family:'Poppins',sans-serif;font-size:24px;font-weight:900;color:#fff;line-height:1;}
.xp-badge-label{font-size:10px;color:rgba(255,255,255,.7);margin-top:2px;}
/* EXAM ALERT */
.exam-alert{background:linear-gradient(135deg,#FEF3C7,#FDE68A);border:1.5px solid rgba(217,119,6,.2);border-radius:var(--rm);padding:14px 18px;display:flex;align-items:center;gap:14px;}
.exam-alert-icon{width:42px;height:42px;border-radius:12px;background:#FCD34D;display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0;}
.exam-alert-info{flex:1;}
.exam-alert-title{font-family:'Poppins',sans-serif;font-size:13px;font-weight:700;color:#92400E;}
.exam-alert-sub{font-size:12px;color:#B45309;margin-top:2px;}
.exam-alert-btn{background:#D97706;color:#fff;border:none;padding:8px 16px;border-radius:var(--rp);font-size:12px;font-weight:600;cursor:pointer;transition:all .2s;}
.exam-alert-btn:hover{background:#B45309;transform:translateY(-1px);}
/* HERO */
.hero{background:var(--vgrad);border-radius:var(--r);padding:28px 32px;display:flex;align-items:center;justify-content:space-between;position:relative;overflow:hidden;box-shadow:0 10px 36px rgba(124,58,237,.32);}
.hero::before{content:'';position:absolute;top:-40px;right:120px;width:180px;height:180px;border-radius:50%;background:rgba(255,255,255,.07);}
.hero::after{content:'';position:absolute;bottom:-30px;right:60px;width:120px;height:120px;border-radius:50%;background:rgba(255,255,255,.05);}
.hero-txt h2{font-family:'Poppins',sans-serif;font-size:22px;font-weight:800;color:#fff;margin-bottom:6px;}
.hero-txt p{font-size:13px;color:rgba(255,255,255,.8);max-width:320px;line-height:1.6;}
.hero-btn{display:inline-flex;align-items:center;gap:7px;margin-top:18px;background:#fff;color:var(--v);font-family:'DM Sans',sans-serif;font-size:13px;font-weight:700;border:none;cursor:pointer;padding:10px 20px;border-radius:var(--rp);box-shadow:0 4px 16px rgba(0,0,0,.15);transition:all .2s;text-decoration:none;}
.hero-btn:hover{transform:translateY(-2px);box-shadow:0 8px 22px rgba(0,0,0,.2);}
.hero-emoji{font-size:72px;position:relative;z-index:2;animation:float 3.5s ease-in-out infinite;user-select:none;}
/* STATS */
.stats{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;}
.scard{background:#fff;border-radius:var(--r);padding:20px 18px;box-shadow:var(--sh);border:1.5px solid var(--border);transition:all .25s;position:relative;overflow:hidden;}
.scard::after{content:'';position:absolute;top:-18px;right:-18px;width:72px;height:72px;border-radius:50%;opacity:.10;}
.scard.mint::after{background:var(--mintd);}
.scard.rose::after{background:var(--rosed);}
.scard.yel::after{background:var(--yeld);}
.scard.sky::after{background:var(--skyd);}
.scard:hover{transform:translateY(-4px);box-shadow:var(--shlift);}
.scard-ico{width:38px;height:38px;border-radius:11px;display:flex;align-items:center;justify-content:center;font-size:17px;margin-bottom:11px;}
.scard.mint .scard-ico{background:var(--mint);}
.scard.rose .scard-ico{background:var(--rose);}
.scard.yel .scard-ico{background:var(--yel);}
.scard.sky .scard-ico{background:var(--sky);}
.scard-val{font-family:'Poppins',sans-serif;font-size:26px;font-weight:800;color:var(--txt);line-height:1;}
.scard-lbl{font-size:11px;color:var(--muted);margin-top:3px;}
/* COURSES GRID */
.courses-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px;}
.ccard{background:#fff;border-radius:var(--r);overflow:hidden;box-shadow:var(--sh);border:1.5px solid var(--border);transition:all .25s;cursor:pointer;text-decoration:none;display:block;}
.ccard:hover{transform:translateY(-4px);box-shadow:var(--shlift);}
.ccard-top{padding:18px 18px 14px;position:relative;}
.ccard-emoji{font-size:28px;margin-bottom:8px;display:block;}
.ccard-cat{font-size:10px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;margin-bottom:5px;}
.ccard-title{font-family:'Poppins',sans-serif;font-size:15px;font-weight:700;color:var(--txt);margin-bottom:4px;line-height:1.3;}
.ccard-sub{font-size:11px;color:var(--muted);}
.ccard-teacher{display:flex;align-items:center;gap:7px;margin-top:10px;}
.mini-av{width:24px;height:24px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:9px;font-weight:700;color:#fff;flex-shrink:0;}
.ccard-teacher span{font-size:11px;color:var(--muted);}
.ccard-bot{padding:12px 18px 16px;border-top:1px solid var(--border);}
.ccard-prog-row{display:flex;justify-content:space-between;align-items:center;font-size:11px;color:var(--muted);margin-bottom:7px;}
.ccard-prog-row strong{font-family:'Poppins',sans-serif;font-size:13px;font-weight:700;}
.prog-bar{height:6px;background:rgba(0,0,0,.07);border-radius:var(--rp);overflow:hidden;}
.prog-fill{height:100%;border-radius:var(--rp);}
.cbadge{position:absolute;top:14px;right:14px;font-size:10px;font-weight:700;padding:3px 9px;border-radius:var(--rp);}
/* CALENDAR */
.cal-card{background:#fff;border-radius:var(--r);padding:22px;box-shadow:var(--sh);border:1.5px solid var(--border);}
.cal-hdr{display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;}
.cal-month{font-family:'Poppins',sans-serif;font-size:15px;font-weight:700;color:var(--txt);}
.cal-nav{display:flex;gap:5px;}
.cal-nbtn{width:28px;height:28px;border-radius:50%;border:1.5px solid var(--border);background:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all .2s;}
.cal-nbtn:hover{background:var(--vxl);border-color:var(--vl);}
.cal-nbtn svg{width:13px;height:13px;stroke:var(--muted);}
.cal-dh{display:grid;grid-template-columns:repeat(7,1fr);text-align:center;font-size:10px;font-weight:700;color:var(--muted);margin-bottom:6px;}
.cal-dh span{padding:4px 0;}
.cal-grid{display:grid;grid-template-columns:repeat(7,1fr);gap:2px;}
.cd{aspect-ratio:1;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:500;border-radius:50%;cursor:pointer;transition:all .15s;color:var(--txt);}
.cd:hover{background:var(--vxl);color:var(--v);}
.cd.other{color:#D1D5DB;}
.cd.today{background:var(--vgrad);color:#fff;font-weight:700;box-shadow:0 4px 12px rgba(124,58,237,.35);}
.cal-legend{display:flex;gap:12px;margin-top:12px;flex-wrap:wrap;}
.cl-item{display:flex;align-items:center;gap:5px;font-size:10px;color:var(--muted);}
.cl-dot{width:8px;height:8px;border-radius:50%;}
@media(max-width:1100px){.content{grid-template-columns:1fr;}.rc{order:-1;}.stats{grid-template-columns:repeat(2,1fr);}.search-box{min-width:200px;}}
@media(max-width:700px){.content{padding:18px 16px;}.stats{grid-template-columns:1fr;}.courses-grid{grid-template-columns:1fr;}.search-box{display:none;}.xp-banner{flex-direction:column;text-align:center;}.xp-badge{margin-top:10px;}}
</style>

<!-- HEADER -->
<header class="hdr">
  <div class="hdr-left">
    <h1>Bienvenue 👋 {{ auth()->user()->name }} !</h1>
    <p id="hdate">{{ now()->locale('fr')->isoFormat('dddd D MMMM YYYY') }} — Continue comme ca, tu es sur la bonne voie !</p>
  </div>

  <!-- SEARCH BOX -->
  <div class="search-box">
    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Rechercher un cours..." />
    @if(strlen($search) > 0)
      <div class="search-clear" wire:click="clearSearch">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" style="width:14px;height:14px;"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
      </div>
    @endif

    @if(count($searchResults) > 0)
      <div class="search-results">
        @foreach($searchResults as $result)
          <a href="{{ route('etudiant.cours.detail', $result['id']) }}" class="search-item">
            <div class="search-item-icon">📚</div>
            <div class="search-item-info">
              <div class="search-item-title">{{ $result['title'] }}</div>
              <div class="search-item-cat">{{ $result['categorie']['name'] ?? 'Formation' }}</div>
            </div>
          </a>
        @endforeach
      </div>
    @elseif(strlen($search) >= 2 && count($searchResults) === 0)
      <div class="search-results">
        <div class="search-empty">Aucun cours trouve pour "{{ $search }}"</div>
      </div>
    @endif
  </div>

  <div class="hdr-acts">
    <!-- NOTIFICATIONS -->
    <div style="position:relative;">
      <div class="ibtn" wire:click="toggleNotifications">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
        @if($unreadCount > 0)
          <span class="notif-badge">{{ $unreadCount }}</span>
        @endif
      </div>

      @if($showNotifications)
        <div class="notif-panel" wire:click.outside="toggleNotifications">
          <div class="notif-header">
            <h3>🔔 Notifications</h3>
            <span>Tout marquer lu</span>
          </div>
          <div class="notif-list">
            @forelse($notifications as $index => $notif)
              <div class="notif-item {{ !$notif['read'] ? 'unread' : '' }}" wire:click="markNotificationRead({{ $index }})">
                <div class="notif-icon">{{ $notif['icon'] }}</div>
                <div class="notif-content">
                  <div class="notif-title">{{ $notif['title'] }}</div>
                  <div class="notif-msg">{{ $notif['message'] }}</div>
                  <div class="notif-time">{{ $notif['time'] }}</div>
                </div>
              </div>
            @empty
              <div class="notif-empty">🎉 Aucune notification</div>
            @endforelse
          </div>
        </div>
      @endif
    </div>

   
    
  </div>
</header>

<!-- CONTENT -->
<div class="content">

  <!-- LEFT COLUMN -->
  <div class="lc">

    <!-- XP BANNER -->
    <div class="xp-banner fu fu1">
      <div class="xp-avatar">{{ auth()->user()->initials() }}</div>
      <div class="xp-info">
        <div class="xp-name">{{ auth()->user()->name }}</div>
        <div class="xp-level">⚡ Niveau {{ $level }} · <strong>{{ $currentLevelLabel }}</strong></div>
        <div class="xp-bar">
          <div class="xp-bar-fill" style="width:{{ $xpPercent }}%;"></div>
        </div>
        <div class="xp-text"><strong>{{ number_format($totalXP) }} XP</strong> · Encore {{ $xpNeeded }} XP pour le niveau {{ $level + 1 }}</div>
      </div>
      <div class="xp-badge">
        <div class="xp-badge-level">{{ $level }}</div>
        <div class="xp-badge-label">NIVEAU</div>
      </div>
    </div>

    <!-- EXAM ALERT -->
    @if($prochainExamen)
    <div class="exam-alert fu fu1">
      <div class="exam-alert-icon">📝</div>
      <div class="exam-alert-info">
        <div class="exam-alert-title">Prochain examen : {{ $prochainExamen->title }}</div>
        <div class="exam-alert-sub">{{ $prochainExamen->cours->title }} · {{ $prochainExamen->duration ?? 30 }} min</div>
      </div>
      <a href="{{ route('etudiant.cours.detail', $prochainExamen->cours_id) }}" class="exam-alert-btn">Voir le cours</a>
    </div>
    @endif

    <!-- HERO BANNER -->
    <div class="hero fu fu2">
      <div class="hero-txt">
        @if($dernierCours)
          <h2>Reprends la ou tu t'es arrete 🔥</h2>
          <p>Tu es a <strong style="color:#fff;">{{ number_format($dernierCours->progress, 0) }}%</strong> de ton cours <strong style="color:#fff;">{{ $dernierCours->cours->title }}</strong>. Continue !</p>
          <a href="{{ route('etudiant.cours.detail', $dernierCours->cours->id) }}" class="hero-btn">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" width="14" height="14"><polygon points="5 3 19 12 5 21 5 3"/></svg>
            Continuer le cours
          </a>
        @else
          <h2>Bienvenue sur DesignLMS 🎉</h2>
          <p>Commence ton parcours en explorant le catalogue de cours disponibles !</p>
          <a href="{{ route('etudiant.catalogue') }}" class="hero-btn">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" width="14" height="14"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            Explorer les cours
          </a>
        @endif
      </div>
      <div class="hero-emoji">📚</div>
    </div>

    <!-- STATS -->
    <section class="fu fu3">
      <div class="sh">
        <span class="st">📊 Vue d'ensemble</span>
      </div>
      <div class="stats">
        <div class="scard mint">
          <div class="scard-ico">📚</div>
          <div class="scard-val">{{ $stats['cours_en_cours'] }}</div>
          <div class="scard-lbl">Cours en cours</div>
        </div>
        <div class="scard rose">
          <div class="scard-ico">✅</div>
          <div class="scard-val">{{ $stats['lecons_completees'] }}</div>
          <div class="scard-lbl">Lecons completees</div>
        </div>
        <div class="scard yel">
          <div class="scard-ico">🏅</div>
          <div class="scard-val">{{ $stats['badges'] }}</div>
          <div class="scard-lbl">Badges obtenus</div>
        </div>
        <div class="scard sky">
          <div class="scard-ico">🎓</div>
          <div class="scard-val">{{ $stats['certificats'] }}</div>
          <div class="scard-lbl">Certificats</div>
        </div>
      </div>
    </section>

    <!-- MES COURS -->
    <section class="fu fu4">
      <div class="sh">
        <span class="st">🎒 Mes cours <span class="sc">{{ $inscriptions->count() }}</span></span>
        <a class="sa" href="{{ route('etudiant.mes-cours') }}">Tout voir →</a>
      </div>

      @if($inscriptions->count() > 0)
        <div class="courses-grid">
          @foreach($inscriptions->take(4) as $inscription)
            @php
              $colors = [
                ['bg'=>'var(--vxl)','cat'=>'var(--v)','prog'=>'var(--v)','badge_bg'=>'var(--v)'],
                ['bg'=>'var(--mint)','cat'=>'var(--mintd)','prog'=>'var(--mintd)','badge_bg'=>'var(--mintd)'],
                ['bg'=>'var(--rose)','cat'=>'var(--rosed)','prog'=>'var(--rosed)','badge_bg'=>'var(--rosed)'],
                ['bg'=>'var(--yel)','cat'=>'var(--yeld)','prog'=>'var(--yeld)','badge_bg'=>'var(--yeld)'],
              ];
              $color = $colors[$loop->index % 4];
              $emojis = ['📖', '💻', '🎨', '📊'];
              $emoji = $emojis[$loop->index % 4];
            @endphp
            <a href="{{ route('etudiant.cours.detail', $inscription->cours->id) }}" class="ccard" style="text-decoration:none;">
              <div class="ccard-top" style="background:{{ $color['bg'] }};">
                <span class="cbadge" style="background:{{ $color['badge_bg'] }};color:#fff;">
                  {{ $inscription->status === 'completed' ? 'Termine' : 'En cours' }}
                </span>
                <span class="ccard-emoji">{{ $emoji }}</span>
                <div class="ccard-cat" style="color:{{ $color['cat'] }};">
                  {{ $inscription->cours->categorie?->name ?? 'General' }}
                </div>
                <div class="ccard-title">{{ $inscription->cours->title }}</div>
                <div class="ccard-sub">{{ ucfirst($inscription->cours->level) }}</div>
                <div class="ccard-teacher">
                  <div class="mini-av" style="background:linear-gradient(135deg,#7C3AED,#A78BFA);">
                    {{ $inscription->cours->formateur?->initials() ?? 'F' }}
                  </div>
                  <span>{{ $inscription->cours->formateur?->name ?? 'Formateur' }}</span>
                </div>
              </div>
              <div class="ccard-bot">
                <div class="ccard-prog-row">
                  <span>Progression</span>
                  <strong style="color:{{ $color['prog'] }};">{{ number_format($inscription->progress, 0) }}%</strong>
                </div>
                <div class="prog-bar">
                  <div class="prog-fill" style="width:{{ $inscription->progress }}%;background:{{ $color['prog'] }};"></div>
                </div>
              </div>
            </a>
          @endforeach
        </div>
      @else
        <div style="text-align:center;padding:40px;background:#fff;border-radius:18px;border:1.5px solid var(--border);">
          <div style="font-size:48px;margin-bottom:12px;">📚</div>
          <p style="color:var(--muted);font-size:14px;">Tu n'es inscrit a aucun cours pour le moment.</p>
          <a href="{{ route('etudiant.catalogue') }}" style="display:inline-block;margin-top:16px;background:var(--vgrad);color:#fff;padding:10px 24px;border-radius:999px;font-size:13px;font-weight:600;text-decoration:none;">
            Explorer le catalogue
          </a>
        </div>
      @endif
    </section>

  </div><!-- /lc -->

  <!-- RIGHT COLUMN -->
  <div class="rc">

    <!-- CALENDRIER -->
    <div class="cal-card fu fu2">
      <div class="cal-hdr">
        <span class="cal-month">{{ now()->locale('fr')->isoFormat('MMMM YYYY') }}</span>
        <div class="cal-nav">
          <button class="cal-nbtn" onclick="chM(-1)">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke="currentColor"><polyline points="15 18 9 12 15 6"/></svg>
          </button>
          <button class="cal-nbtn" onclick="chM(1)">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke="currentColor"><polyline points="9 18 15 12 9 6"/></svg>
          </button>
        </div>
      </div>
      <div class="cal-dh">
        <span>L</span><span>M</span><span>M</span><span>J</span><span>V</span><span>S</span><span>D</span>
      </div>
      <div class="cal-grid" id="calG"></div>
      <div class="cal-legend">
        <div class="cl-item"><div class="cl-dot" style="background:var(--v)"></div> Aujourd'hui</div>
        <div class="cl-item"><div class="cl-dot" style="background:var(--mintd)"></div> Cours</div>
        <div class="cl-item"><div class="cl-dot" style="background:var(--peachd)"></div> Examen</div>
      </div>
    </div>

    <!-- PROGRESSION GLOBALE -->
    <div class="fu fu3" style="background:#fff;border-radius:var(--r);padding:20px;border:1.5px solid var(--border);box-shadow:var(--sh);">
      <div class="sh" style="margin-bottom:14px;">
        <span class="st">📈 Progression globale</span>
      </div>
      @forelse($inscriptions->take(4) as $inscription)
        <div style="margin-bottom:14px;">
          <div style="display:flex;justify-content:space-between;font-size:12px;margin-bottom:5px;">
            <span style="font-weight:600;color:var(--txt);">{{ Str::limit($inscription->cours->title, 25) }}</span>
            <span style="font-weight:700;color:var(--v);">{{ number_format($inscription->progress, 0) }}%</span>
          </div>
          <div class="prog-bar">
            <div class="prog-fill" style="width:{{ $inscription->progress }}%;background:var(--vgrad);"></div>
          </div>
        </div>
      @empty
        <p style="color:var(--muted);font-size:13px;text-align:center;">Aucun cours en cours.</p>
      @endforelse
    </div>

    <!-- OBJECTIF HEBDO -->
    <div class="fu fu4" style="background:linear-gradient(135deg,#D1FAE5,#A7F3D0);border-radius:var(--r);padding:20px;border:1.5px solid rgba(5,150,105,.15);box-shadow:0 4px 20px rgba(5,150,105,.10);">
      <div style="font-family:'Poppins',sans-serif;font-size:14px;font-weight:700;color:var(--mintd);margin-bottom:4px;">🎯 Objectif de la semaine</div>
      <div style="font-size:12px;color:#065F46;margin-bottom:14px;">Complete 5 lecons cette semaine !</div>
      <div style="height:10px;background:rgba(5,150,105,.15);border-radius:999px;overflow:hidden;margin-bottom:8px;">
        <div style="width:{{ min(($stats['lecons_completees'] / 5) * 100, 100) }}%;height:100%;background:var(--mintd);border-radius:999px;"></div>
      </div>
      <div style="font-size:11px;color:#065F46;">{{ min($stats['lecons_completees'], 5) }} / 5 lecons completees 💪</div>
    </div>

  </div><!-- /rc -->

</div><!-- /content -->

<script>
const DN=['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'];
const MN=['Janvier','Fevrier','Mars','Avril','Mai','Juin','Juillet','Aout','Septembre','Octobre','Novembre','Decembre'];
let cy=new Date().getFullYear(), cm=new Date().getMonth();

function renderCal(){
  const g=document.getElementById('calG'); if(!g) return; g.innerHTML='';
  const first=new Date(cy,cm,1).getDay();
  const dim=new Date(cy,cm+1,0).getDate();
  const dimp=new Date(cy,cm,0).getDate();
  const offset=first===0?6:first-1;
  for(let i=offset-1;i>=0;i--){const d=document.createElement('div');d.className='cd other';d.textContent=dimp-i;g.appendChild(d);}
  const today=new Date();
  for(let d=1;d<=dim;d++){
    const el=document.createElement('div');el.className='cd';el.textContent=d;
    const isT=(d===today.getDate()&&cm===today.getMonth()&&cy===today.getFullYear());
    if(isT) el.classList.add('today');
    g.appendChild(el);
  }
  const total=offset+dim;
  const rem=total%7===0?0:7-(total%7);
  for(let d=1;d<=rem;d++){const el=document.createElement('div');el.className='cd other';el.textContent=d;g.appendChild(el);}
  document.querySelector('.cal-month').textContent=`${MN[cm]} ${cy}`;
}
function chM(d){cm+=d;if(cm>11){cm=0;cy++;}if(cm<0){cm=11;cy--;}renderCal();}
renderCal();
</script>

</div>
