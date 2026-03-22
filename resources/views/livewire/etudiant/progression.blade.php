<div>
<style>
/* HEADER */
.hdr{position:sticky;top:0;z-index:50;background:rgba(245,243,255,.90);backdrop-filter:blur(14px);border-bottom:1.5px solid var(--border);padding:15px 30px;display:flex;align-items:center;gap:14px;}
.hdr-left{flex:1;}
.hdr-left h1{font-family:'Poppins',sans-serif;font-size:20px;font-weight:800;color:var(--txt);}
.hdr-left p{font-size:12px;color:var(--muted);margin-top:1px;}
.period-tabs{display:flex;gap:4px;background:#fff;border-radius:var(--rp);padding:4px;border:1.5px solid var(--border);box-shadow:var(--sh);}
.ptab{padding:7px 16px;border-radius:var(--rp);font-size:12px;font-weight:600;color:var(--muted);cursor:pointer;transition:all .2s;}
.ptab.active{background:var(--vgrad);color:#fff;box-shadow:0 3px 10px rgba(124,58,237,.28);}
.ptab:not(.active):hover{background:var(--vxl);color:var(--v);}

/* PAGE */
.page{padding:28px 30px;display:flex;flex-direction:column;gap:26px;}

/* CARD */
.card{background:#fff;border-radius:var(--r);border:1.5px solid var(--border);box-shadow:var(--sh);padding:24px;}
.card-title{font-family:'Poppins',sans-serif;font-size:15px;font-weight:700;color:var(--txt);margin-bottom:18px;display:flex;align-items:center;gap:8px;}
.card-title .sub{font-family:'DM Sans',sans-serif;font-size:12px;font-weight:400;color:var(--muted);margin-left:auto;}

/* XP BANNER */
.xp-banner{background:linear-gradient(135deg,#1E1B4B 0%,#4C1D95 40%,#7C3AED 100%);border-radius:var(--r);padding:0;overflow:hidden;box-shadow:0 12px 40px rgba(30,27,75,.35);display:grid;grid-template-columns:1fr auto;}
.xp-left{padding:30px 32px;}
.xp-breadcrumb{font-size:11px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:rgba(255,255,255,.5);margin-bottom:10px;}
.xp-name{font-family:'Poppins',sans-serif;font-size:26px;font-weight:900;color:#fff;margin-bottom:4px;}
.xp-subtitle{font-size:13px;color:rgba(255,255,255,.7);margin-bottom:24px;}
.xp-level-row{display:flex;align-items:center;gap:16px;margin-bottom:12px;}
.xp-badge{background:rgba(255,255,255,.15);backdrop-filter:blur(6px);border:1.5px solid rgba(255,255,255,.25);border-radius:var(--rp);padding:6px 16px;font-family:'Poppins',sans-serif;font-size:13px;font-weight:700;color:#fff;display:flex;align-items:center;gap:6px;}
.xp-next{font-size:12px;color:rgba(255,255,255,.65);}
.xp-full-bar{height:12px;background:rgba(255,255,255,.12);border-radius:var(--rp);overflow:hidden;}
.xp-full-fill{height:100%;border-radius:var(--rp);background:linear-gradient(90deg,#A78BFA,#38BDF8);box-shadow:0 0 16px rgba(167,139,250,.6);}
.xp-pts{font-size:12px;color:rgba(255,255,255,.6);margin-top:7px;}
.xp-pts strong{color:#fff;}
.xp-right{padding:30px 36px;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:12px;border-left:1px solid rgba(255,255,255,.08);}
.xp-ring-wrap{position:relative;width:130px;height:130px;}
.xp-ring-wrap svg{transform:rotate(-90deg);}
.xp-ring-center{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);text-align:center;}
.xp-ring-pct{font-family:'Poppins',sans-serif;font-size:24px;font-weight:900;color:#fff;}
.xp-ring-lbl{font-size:10px;color:rgba(255,255,255,.6);margin-top:1px;}
.xp-ring-sub{font-size:11px;color:rgba(255,255,255,.7);font-weight:500;}

/* STATS ROW */
.stats-row{display:grid;grid-template-columns:repeat(6,1fr);gap:14px;}
.scard{background:#fff;border-radius:var(--r);padding:18px 14px;border:1.5px solid var(--border);box-shadow:var(--sh);text-align:center;transition:all .25s;cursor:default;position:relative;overflow:hidden;}
.scard:hover{transform:translateY(-4px);box-shadow:var(--shlift);}
.scard-ico{font-size:20px;margin-bottom:6px;}
.scard-val{font-family:'Poppins',sans-serif;font-size:22px;font-weight:800;color:var(--txt);line-height:1;}
.scard-lbl{font-size:10px;color:var(--muted);margin-top:3px;line-height:1.3;}
.scard-trend{font-size:10px;font-weight:600;margin-top:5px;}
.up{color:var(--mintd);}

/* TWO-COL */
.two-col{display:grid;grid-template-columns:1fr 1fr;gap:22px;}

/* BAR CHART */
.bar-chart{display:flex;align-items:flex-end;justify-content:space-between;height:140px;gap:6px;padding-bottom:0;}
.bar-col{display:flex;flex-direction:column;align-items:center;gap:5px;flex:1;}
.bar-wrap{flex:1;width:100%;display:flex;flex-direction:column;justify-content:flex-end;}
.bar{border-radius:8px 8px 0 0;transition:opacity .2s;cursor:pointer;width:100%;}
.bar:hover{opacity:.8;transform:scaleX(1.05);}
.bar-lbl{font-size:10px;color:var(--muted);white-space:nowrap;}
.bar-val{font-size:10px;font-weight:700;color:var(--v);}
.chart-y{display:flex;flex-direction:column;justify-content:space-between;height:140px;padding-bottom:22px;margin-right:8px;}
.y-lbl{font-size:10px;color:var(--muted);}
.sparkline-wrap{position:relative;}
.sparkline-wrap svg{width:100%;height:80px;overflow:visible;}

/* COURSE PROGRESS */
.course-list{display:flex;flex-direction:column;gap:14px;}
.cp-item{display:flex;align-items:center;gap:14px;padding:14px 16px;background:var(--bg);border-radius:var(--rm);border:1.5px solid var(--border);transition:all .2s;cursor:pointer;}
.cp-item:hover{background:var(--vxl);border-color:var(--vl);transform:translateX(4px);}
.cp-ico{width:44px;height:44px;border-radius:13px;display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0;}
.cp-info{flex:1;min-width:0;}
.cp-title{font-family:'Poppins',sans-serif;font-size:14px;font-weight:700;color:var(--txt);}
.cp-sub{font-size:11px;color:var(--muted);margin-top:2px;}
.cp-bar-row{display:flex;align-items:center;gap:10px;margin-top:8px;}
.cp-bar{flex:1;height:7px;background:rgba(0,0,0,.07);border-radius:var(--rp);overflow:hidden;}
.cp-fill{height:100%;border-radius:var(--rp);}
.cp-pct{font-family:'Poppins',sans-serif;font-size:13px;font-weight:800;flex-shrink:0;min-width:36px;text-align:right;}
.cp-lessons{font-size:10px;color:var(--muted);margin-top:3px;}
.cp-right{display:flex;flex-direction:column;align-items:flex-end;gap:4px;flex-shrink:0;}
.cp-time{font-size:11px;color:var(--muted);}
.cp-score{font-family:'Poppins',sans-serif;font-size:13px;font-weight:700;}

/* RADAR */
.radar-wrap{display:flex;justify-content:center;align-items:center;padding:8px 0;}
.radar-wrap svg{overflow:visible;}

/* HEATMAP */
.heatmap-grid{display:flex;gap:3px;overflow-x:auto;padding-bottom:4px;}
.hm-col{display:flex;flex-direction:column;gap:3px;}
.hm-cell{width:12px;height:12px;border-radius:3px;cursor:pointer;transition:transform .15s;flex-shrink:0;}
.hm-cell:hover{transform:scale(1.4);}
.hm-cell.l0{background:#F3F4F6;}
.hm-cell.l1{background:#DDD6FE;}
.hm-cell.l2{background:#A78BFA;}
.hm-cell.l3{background:#7C3AED;}
.hm-cell.l4{background:#4C1D95;}
.hm-months{display:flex;gap:3px;margin-bottom:4px;font-size:9px;color:var(--muted);}
.hm-days{display:flex;flex-direction:column;gap:3px;margin-right:6px;}
.hm-day{font-size:9px;color:var(--muted);line-height:12px;height:12px;}
.hm-legend{display:flex;align-items:center;gap:5px;font-size:10px;color:var(--muted);margin-top:10px;}
.hm-legend-cells{display:flex;gap:3px;}

/* QUIZ TABLE */
.quiz-table{width:100%;border-collapse:collapse;}
.quiz-table thead tr{background:var(--bg);}
.quiz-table th{text-align:left;font-size:10px;font-weight:700;letter-spacing:.07em;text-transform:uppercase;color:var(--muted);padding:9px 12px;}
.quiz-table th:first-child{border-radius:var(--rs) 0 0 var(--rs);}
.quiz-table th:last-child{border-radius:0 var(--rs) var(--rs) 0;}
.quiz-table td{padding:11px 12px;font-size:13px;border-bottom:1px solid var(--border);}
.quiz-table tr:last-child td{border-bottom:none;}
.quiz-table tbody tr{transition:background .15s;cursor:pointer;}
.quiz-table tbody tr:hover{background:var(--vxl);}
.score-pill{display:inline-flex;align-items:center;justify-content:center;font-family:'Poppins',sans-serif;font-size:12px;font-weight:800;width:44px;height:26px;border-radius:var(--rp);}
.score-pill.great{background:var(--mint);color:var(--mintd);}
.score-pill.good{background:var(--sky);color:var(--skyd);}
.score-pill.ok{background:var(--yel);color:var(--yeld);}
.score-pill.bad{background:var(--peach);color:var(--peachd);}
.status-dot{display:inline-flex;align-items:center;gap:5px;font-size:12px;}
.dot{width:7px;height:7px;border-radius:50%;flex-shrink:0;}

/* GOALS */
.goals-list{display:flex;flex-direction:column;gap:12px;}
.goal-item{display:flex;align-items:center;gap:12px;padding:14px 16px;border-radius:var(--rm);border:1.5px solid var(--border);background:var(--bg);transition:all .2s;}
.goal-item:hover{background:var(--vxl);border-color:var(--vl);}
.goal-ico{font-size:22px;flex-shrink:0;}
.goal-info{flex:1;min-width:0;}
.goal-name{font-size:13px;font-weight:600;color:var(--txt);}
.goal-sub{font-size:11px;color:var(--muted);margin-top:1px;}
.goal-bar{height:6px;background:rgba(0,0,0,.07);border-radius:var(--rp);overflow:hidden;margin-top:7px;}
.goal-fill{height:100%;border-radius:var(--rp);}
.goal-right{flex-shrink:0;text-align:right;}
.goal-pct{font-family:'Poppins',sans-serif;font-size:16px;font-weight:800;}
.goal-due{font-size:10px;color:var(--muted);margin-top:2px;}

/* STREAK */
.streak-row{display:flex;gap:5px;justify-content:center;flex-wrap:wrap;}
.streak-day{width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;cursor:pointer;transition:all .15s;}
.streak-day:hover{transform:scale(1.1);}
.streak-day.done{background:var(--vgrad);color:#fff;box-shadow:0 3px 10px rgba(124,58,237,.30);}
.streak-day.today{background:var(--vgrad);color:#fff;box-shadow:0 0 0 3px rgba(167,139,250,.4);}
.streak-day.miss{background:var(--peach);color:var(--peachd);}
.streak-day.future{background:#F3F4F6;color:#D1D5DB;}
.streak-info{display:flex;justify-content:center;gap:24px;margin-top:16px;}
.streak-stat{text-align:center;}
.streak-stat-val{font-family:'Poppins',sans-serif;font-size:22px;font-weight:900;color:var(--v);}
.streak-stat-lbl{font-size:11px;color:var(--muted);}

/* CERT PROGRESS */
.cert-progress-list{display:flex;flex-direction:column;gap:12px;}
.cert-prog{display:flex;align-items:center;gap:14px;padding:14px;border-radius:var(--rm);border:1.5px solid var(--border);background:var(--bg);transition:all .2s;cursor:pointer;}
.cert-prog:hover{background:var(--vxl);border-color:var(--vl);transform:translateX(3px);}
.cert-ring{position:relative;width:50px;height:50px;flex-shrink:0;}
.cert-ring svg{transform:rotate(-90deg);}
.cert-ring-center{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);font-family:'Poppins',sans-serif;font-size:11px;font-weight:800;}
.cert-info{flex:1;min-width:0;}
.cert-name{font-size:13px;font-weight:600;color:var(--txt);}
.cert-sub{font-size:11px;color:var(--muted);margin-top:1px;}
.cert-status{font-size:10px;font-weight:700;padding:3px 9px;border-radius:var(--rp);margin-top:5px;display:inline-block;}

/* SKILLS LIST */
.skills-list{display:flex;flex-direction:column;gap:10px;}
.skill-row{display:flex;align-items:center;gap:10px;}
.skill-name{flex:1;font-size:12px;color:var(--muted);}
.skill-bar{width:120px;height:6px;background:var(--vxl);border-radius:99px;overflow:hidden;}
.skill-fill{height:100%;border-radius:99px;}
.skill-value{font-size:12px;font-weight:700;min-width:36px;text-align:right;}

/* EMPTY STATE */
.empty-state{text-align:center;padding:40px 20px;color:var(--muted);}
.empty-state .emoji{font-size:48px;margin-bottom:12px;}
.empty-state p{font-size:14px;margin-bottom:16px;}
.empty-state a{display:inline-flex;align-items:center;gap:6px;background:var(--vgrad);color:#fff;padding:10px 20px;border-radius:var(--rp);font-weight:600;text-decoration:none;transition:all .2s;}
.empty-state a:hover{transform:translateY(-2px);box-shadow:0 4px 16px rgba(124,58,237,.35);}

@media(max-width:1200px){.stats-row{grid-template-columns:repeat(3,1fr);}}
@media(max-width:960px){.two-col{grid-template-columns:1fr;}.xp-banner{grid-template-columns:1fr;}.xp-right{display:none;}}
@media(max-width:700px){.page{padding:18px 16px;}}
@media(max-width:600px){.stats-row{grid-template-columns:repeat(2,1fr);}.period-tabs{display:none;}}
</style>

<!-- HEADER -->
<header class="hdr">
  <div class="hdr-left">
    <h1>📈 Ma Progression</h1>
    <p>Mise a jour aujourd'hui · {{ $allInscriptions->count() }} cours suivis</p>
  </div>
  <div class="period-tabs">
    <div class="ptab {{ $period === '7days' ? 'active' : '' }}" wire:click="setPeriod('7days')">7 jours</div>
    <div class="ptab {{ $period === '1month' ? 'active' : '' }}" wire:click="setPeriod('1month')">1 mois</div>
    <div class="ptab {{ $period === '3months' ? 'active' : '' }}" wire:click="setPeriod('3months')">3 mois</div>
    <div class="ptab {{ $period === 'all' ? 'active' : '' }}" wire:click="setPeriod('all')">Tout</div>
  </div>
  
  <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" style="background:none;border:none;cursor:pointer;">
        <div class="ibtn" title="Deconnexion">
          <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke="currentColor"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
        </div>
      </button>
    </form>
</header>

<div class="page">

  @if($allInscriptions->count() > 0)
  <!-- XP HERO BANNER -->
  <div class="xp-banner fu fu1">
    <div class="xp-left">
      <div class="xp-breadcrumb">🎮 Systeme d'experience</div>
      <div class="xp-name">{{ auth()->user()->name }}</div>
      <div class="xp-subtitle">Tu progresses vite ! Encore <strong style="color:#A78BFA;">{{ $xpNeeded }} XP</strong> pour atteindre le Niveau {{ $level + 1 }} 🚀</div>
      <div class="xp-level-row">
        <div class="xp-badge">⚡ Niveau {{ $level }} - {{ $currentLevelLabel }}</div>
        <div class="xp-next">→ Niveau {{ $level + 1 }} : {{ $nextLevelLabel }}</div>
      </div>
      <div class="xp-full-bar"><div class="xp-full-fill" style="width:{{ $xpPercent }}%;"></div></div>
      <div class="xp-pts">XP total : <strong>{{ number_format($totalXP) }}</strong> / {{ number_format($level * 500) }} · {{ $stats['lessons_completed'] }} lecons terminees</div>
      <!-- Rank and Percentile -->
      <div style="margin-top:14px;display:flex;gap:16px;align-items:center;">
        <div style="background:rgba(255,255,255,.12);padding:8px 16px;border-radius:var(--rp);display:flex;align-items:center;gap:8px;">
          <span style="font-size:18px;">🏆</span>
          <span style="font-size:13px;color:rgba(255,255,255,.9);font-weight:600;">Rang #{{ $rank }} / {{ $totalStudents }}</span>
        </div>
        <div style="background:linear-gradient(90deg,rgba(167,139,250,.3),rgba(56,189,248,.3));padding:8px 16px;border-radius:var(--rp);display:flex;align-items:center;gap:8px;">
          <span style="font-size:18px;">📊</span>
          <span style="font-size:13px;color:#fff;font-weight:700;">Top {{ 100 - $percentile }}%</span>
        </div>
      </div>
    </div>
    <div class="xp-right">
      <div class="xp-ring-wrap">
        <svg width="130" height="130" viewBox="0 0 130 130">
          <circle cx="65" cy="65" r="56" fill="none" stroke="rgba(255,255,255,.08)" stroke-width="12"/>
          <circle cx="65" cy="65" r="56" fill="none" stroke="url(#xpGrad)" stroke-width="12"
            stroke-linecap="round" stroke-dasharray="351.86"
            stroke-dashoffset="{{ 351.86 - (351.86 * $xpPercent / 100) }}"/>
          <defs>
            <linearGradient id="xpGrad" x1="0%" y1="0%" x2="100%" y2="100%">
              <stop offset="0%" stop-color="#A78BFA"/>
              <stop offset="100%" stop-color="#38BDF8"/>
            </linearGradient>
          </defs>
        </svg>
        <div class="xp-ring-center">
          <div class="xp-ring-pct">{{ number_format($xpPercent, 0) }}%</div>
          <div class="xp-ring-lbl">vers Niv. {{ $level + 1 }}</div>
        </div>
      </div>
      <div class="xp-ring-sub">🏅 {{ $stats['certificates_count'] }} certificat(s) obtenu(s)</div>
    </div>
  </div>

  <!-- STATS ROW -->
  <div class="stats-row fu fu2">
    <div class="scard" style="border-top:3px solid var(--v);">
      <div class="scard-ico">📖</div>
      <div class="scard-val">{{ $stats['lessons_completed'] }}</div>
      <div class="scard-lbl">Lecons completees</div>
      <div class="scard-trend up">sur {{ $stats['total_lessons'] }} au total</div>
    </div>
    <div class="scard" style="border-top:3px solid var(--mintd);">
      <div class="scard-ico">⏱️</div>
      <div class="scard-val">{{ number_format($totalEstimatedHours, 0) }}h</div>
      <div class="scard-lbl">Temps d'apprentissage</div>
      <div class="scard-trend up">↑ Continue comme ca !</div>
    </div>
    <div class="scard" style="border-top:3px solid var(--yeld);">
      <div class="scard-ico">📝</div>
      <div class="scard-val">{{ $stats['quizzes_count'] }}</div>
      <div class="scard-lbl">Quiz disponibles</div>
      <div class="scard-trend up">dans tes cours</div>
    </div>
    <div class="scard" style="border-top:3px solid var(--skyd);">
      <div class="scard-ico">🎯</div>
      <div class="scard-val">{{ number_format($stats['avg_progress'], 0) }}%</div>
      <div class="scard-lbl">Progression moyenne</div>
      <div class="scard-trend up">↑ En progression</div>
    </div>
    <div class="scard" style="border-top:3px solid var(--rosed);">
      <div class="scard-ico">🔥</div>
      <div class="scard-val">{{ $stats['streak'] }}</div>
      <div class="scard-lbl">Jours de serie</div>
      <div class="scard-trend up">Record : {{ $stats['best_streak'] }} 🏆</div>
    </div>
    <div class="scard" style="border-top:3px solid var(--teald);">
      <div class="scard-ico">🎓</div>
      <div class="scard-val">{{ $stats['certificates_count'] }}</div>
      <div class="scard-lbl">Certifs obtenus</div>
      <div class="scard-trend up">{{ $stats['badges_count'] }} badge(s)</div>
    </div>
  </div>

  <!-- ACTIVITY CHART + STREAK -->
  <div class="two-col fu fu3">
    <!-- Bar chart -->
    <div class="card">
      <div class="card-title">
        📊 Activite par jour
        <span class="sub">7 derniers jours</span>
      </div>
      <div style="display:flex;gap:0;">
        <div class="chart-y">
          @php $maxVal = max(array_column($chartData, 'value')) ?: 6; @endphp
          <span class="y-lbl">{{ ceil($maxVal) }}</span>
          <span class="y-lbl">{{ ceil($maxVal * 0.66) }}</span>
          <span class="y-lbl">{{ ceil($maxVal * 0.33) }}</span>
          <span class="y-lbl">0</span>
        </div>
        <div style="position:relative;flex:1;">
          <div style="position:absolute;top:0;left:0;right:0;bottom:22px;display:flex;flex-direction:column;justify-content:space-between;pointer-events:none;">
            <div style="border-bottom:1px dashed var(--border);flex:1;"></div>
            <div style="border-bottom:1px dashed var(--border);flex:1;"></div>
            <div style="border-bottom:1px dashed var(--border);flex:1;"></div>
            <div style="flex:0;height:0;"></div>
          </div>
          <div class="bar-chart">
            @foreach($chartData as $data)
              @php
                $heightPercent = $maxVal > 0 ? ($data['value'] / $maxVal) * 100 : 0;
                $barColor = $data['value'] >= ($maxVal * 0.7) ? 'var(--vgrad)' : ($data['value'] >= ($maxVal * 0.4) ? 'var(--vl)' : 'var(--vxl)');
              @endphp
              <div class="bar-col">
                <div class="bar-val">{{ $data['value'] }}</div>
                <div class="bar-wrap">
                  <div class="bar" style="height:{{ max(5, $heightPercent) }}%;background:{{ $barColor }};"></div>
                </div>
                <div class="bar-lbl" style="{{ $data['isToday'] ? 'font-weight:700;color:var(--v);' : '' }}">{{ $data['day'] }}</div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
      <!-- Summary -->
      <div style="margin-top:20px;padding-top:16px;border-top:1px dashed var(--border);">
        <div style="font-size:12px;font-weight:600;color:var(--muted);margin-bottom:8px;">Resume de ta progression</div>
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;">
          <div style="text-align:center;padding:10px;background:var(--vxl);border-radius:var(--rm);">
            <div style="font-family:'Poppins',sans-serif;font-size:18px;font-weight:800;color:var(--v);">{{ $stats['active_courses'] }}</div>
            <div style="font-size:10px;color:var(--muted);">Cours actifs</div>
          </div>
          <div style="text-align:center;padding:10px;background:var(--mint);border-radius:var(--rm);">
            <div style="font-family:'Poppins',sans-serif;font-size:18px;font-weight:800;color:var(--mintd);">{{ $stats['completed_courses'] }}</div>
            <div style="font-size:10px;color:var(--muted);">Termines</div>
          </div>
          <div style="text-align:center;padding:10px;background:var(--yel);border-radius:var(--rm);">
            <div style="font-family:'Poppins',sans-serif;font-size:18px;font-weight:800;color:var(--yeld);">{{ number_format($stats['avg_progress'], 0) }}%</div>
            <div style="font-size:10px;color:var(--muted);">Moyenne</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Streak calendar -->
    <div class="card">
      <div class="card-title">🔥 Ma serie d'apprentissage</div>
      <div class="streak-row">
        @foreach($streakData['calendar'] as $day)
          <div class="streak-day {{ $day['isToday'] ? 'today' : ($day['isActive'] ? 'done' : 'miss') }}">
            @if($day['isToday'])
              🔥
            @elseif($day['isActive'])
              ✓
            @else
              ✗
            @endif
          </div>
        @endforeach
      </div>
      <div class="streak-info">
        <div class="streak-stat">
          <div class="streak-stat-val">{{ $stats['streak'] }}</div>
          <div class="streak-stat-lbl">Serie actuelle 🔥</div>
        </div>
        <div class="streak-stat">
          <div class="streak-stat-val">{{ $stats['best_streak'] }}</div>
          <div class="streak-stat-lbl">Meilleure serie 🏆</div>
        </div>
        <div class="streak-stat">
          <div class="streak-stat-val">{{ $stats['certificates_count'] }}</div>
          <div class="streak-stat-lbl">Certificats 🎓</div>
        </div>
      </div>
      <!-- Weekly goal -->
      <div style="margin-top:18px;padding:14px;background:var(--vxl);border-radius:var(--rm);">
        @php
          $weeklyTarget = 5;
          $weeklyProgress = min($stats['active_courses'], $weeklyTarget);
          $weeklyPercent = ($weeklyProgress / $weeklyTarget) * 100;
        @endphp
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">
          <span style="font-size:13px;font-weight:600;color:var(--v);">🎯 Objectif : {{ $weeklyTarget }} cours actifs</span>
          <span style="font-family:'Poppins',sans-serif;font-size:14px;font-weight:800;color:var(--v);">{{ $weeklyProgress }} / {{ $weeklyTarget }}</span>
        </div>
        <div style="height:8px;background:rgba(124,58,237,.15);border-radius:var(--rp);overflow:hidden;">
          <div style="width:{{ $weeklyPercent }}%;height:100%;border-radius:var(--rp);background:var(--vgrad);box-shadow:0 2px 8px rgba(124,58,237,.3);"></div>
        </div>
        <div style="font-size:11px;color:var(--muted);margin-top:6px;">
          @if($weeklyPercent >= 100)
            🎉 Objectif atteint ! Continue sur cette lancee !
          @else
            Plus que {{ $weeklyTarget - $weeklyProgress }} cours pour atteindre ton objectif !
          @endif
        </div>
      </div>
    </div>
  </div>

  <!-- COURSE PROGRESS -->
  <div class="fu fu4">
    <div class="card">
      <div class="card-title">
        📚 Progression par cours
        <span class="sub">{{ $allInscriptions->count() }} cours inscrits</span>
      </div>
      <div class="course-list">
        @php
          $colors = [
            ['bg'=>'var(--vxl)','c'=>'var(--v)'],
            ['bg'=>'var(--rose)','c'=>'var(--rosed)'],
            ['bg'=>'var(--mint)','c'=>'var(--mintd)'],
            ['bg'=>'var(--sky)','c'=>'var(--skyd)'],
            ['bg'=>'var(--yel)','c'=>'var(--yeld)'],
          ];
          $emojis = ['💡','💻','🎬','📊','🎨','🔐'];
        @endphp
        @forelse($allInscriptions as $i => $inscription)
          @php
            $color = $colors[$i % count($colors)];
            $emoji = $emojis[$i % count($emojis)];
            $lessonsCount = $inscription->cours->chapitres->flatMap->lecons->count();
            $lessonsCompleted = (int) ($lessonsCount * ($inscription->progress / 100));
            $chaptersCount = $inscription->cours->chapitres->count();
            $estimatedHours = round($inscription->cours->chapitres->flatMap->lecons->sum('duration') / 60, 1);
          @endphp
          <div class="cp-item">
            <div class="cp-ico" style="background:{{ $color['bg'] }};">{{ $emoji }}</div>
            <div class="cp-info">
              <div class="cp-title">{{ $inscription->cours->title }}</div>
              <div class="cp-sub">{{ $inscription->cours->categorie?->name ?? 'General' }} · {{ $inscription->cours->formateur?->name ?? 'Formateur' }}</div>
              <div class="cp-bar-row">
                <div class="cp-bar"><div class="cp-fill" style="width:{{ $inscription->progress }}%;background:{{ $color['c'] }};"></div></div>
                <div class="cp-pct" style="color:{{ $color['c'] }};">{{ number_format($inscription->progress, 0) }}%</div>
              </div>
              <div class="cp-lessons">{{ $lessonsCompleted }}/{{ $lessonsCount }} lecons · {{ $chaptersCount }} chapitres · Inscrit {{ $inscription->enrolled_at?->diffForHumans() ?? 'recemment' }}</div>
            </div>
            <div class="cp-right">
              <div class="cp-time">⏱️ ~{{ $estimatedHours > 0 ? $estimatedHours : 2 }}h estimees</div>
              <div class="cp-score" style="color:{{ $color['c'] }};">
                @if($inscription->status === 'completed')
                  ✅ Termine
                @else
                  📖 En cours
                @endif
              </div>
            </div>
          </div>
        @empty
          <div class="empty-state">
            <div class="emoji">📚</div>
            <p>Aucun cours pour le moment</p>
            <a href="{{ route('etudiant.catalogue') }}">Explorer le catalogue</a>
          </div>
        @endforelse
      </div>
    </div>
  </div>

  <!-- SKILLS + GOALS -->
  <div class="two-col fu fu5">
    <!-- Skills by category -->
    <div class="card">
      <div class="card-title">🧠 Competences par domaine</div>
      @if(count($skillsByCategory) > 0)
        <div class="skills-list">
          @foreach($skillsByCategory as $skill)
          <div class="skill-row">
            <div class="skill-name">{{ $skill['emoji'] }} {{ $skill['name'] }}</div>
            <div class="skill-bar">
              <div class="skill-fill" style="width:{{ $skill['value'] }}%;background:{{ $skill['color'] }};"></div>
            </div>
            <div class="skill-value" style="color:{{ $skill['color'] }};">{{ $skill['value'] }}%</div>
          </div>
          @endforeach
        </div>
        <div style="margin-top:16px;padding:12px;background:var(--bg);border-radius:var(--rm);font-size:12px;color:var(--muted);">
          💡 Tes competences evoluent avec ta progression dans chaque categorie de cours.
        </div>
      @else
        <div class="empty-state" style="padding:20px;">
          <p>Commence des cours pour developper tes competences !</p>
        </div>
      @endif
    </div>

    <!-- Goals based on inscriptions -->
    <div class="card">
      <div class="card-title">🎯 Mes objectifs</div>
      <div class="goals-list">
        @php
          $goals = [
            [
              'ico' => '📚',
              'name' => 'Terminer mes cours actifs',
              'sub' => $stats['active_courses'] . ' cours en cours',
              'pct' => $stats['active_courses'] > 0 ? round($stats['avg_progress']) : 0,
              'color' => 'var(--v)',
              'due' => 'En cours'
            ],
            [
              'ico' => '🎓',
              'name' => 'Obtenir des certificats',
              'sub' => $stats['certificates_count'] . ' obtenu(s) sur ' . $inscriptions->count(),
              'pct' => $inscriptions->count() > 0 ? round(($stats['certificates_count'] / $inscriptions->count()) * 100) : 0,
              'color' => 'var(--mintd)',
              'due' => 'Objectif continu'
            ],
            [
              'ico' => '📖',
              'name' => 'Completer toutes les lecons',
              'sub' => $stats['lessons_completed'] . '/' . $stats['total_lessons'] . ' lecons',
              'pct' => $stats['total_lessons'] > 0 ? round(($stats['lessons_completed'] / $stats['total_lessons']) * 100) : 0,
              'color' => 'var(--skyd)',
              'due' => 'En progression'
            ],
            [
              'ico' => '⚡',
              'name' => 'Atteindre niveau ' . ($level + 1),
              'sub' => $xpNeeded . ' XP restants',
              'pct' => round($xpPercent),
              'color' => 'var(--yeld)',
              'due' => 'Niveau ' . $level . ' actuel'
            ],
          ];
        @endphp
        @foreach($goals as $goal)
        <div class="goal-item">
          <div class="goal-ico">{{ $goal['ico'] }}</div>
          <div class="goal-info">
            <div class="goal-name">{{ $goal['name'] }}</div>
            <div class="goal-sub">{{ $goal['sub'] }}</div>
            <div class="goal-bar"><div class="goal-fill" style="width:{{ min(100, $goal['pct']) }}%;background:{{ $goal['color'] }};"></div></div>
          </div>
          <div class="goal-right">
            <div class="goal-pct" style="color:{{ $goal['color'] }};">{{ $goal['pct'] }}%</div>
            <div class="goal-due">{{ $goal['due'] }}</div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>

  <!-- HEATMAP + QUIZ -->
  <div class="two-col fu fu6">
    <!-- Heatmap -->
    <div class="card">
      <div class="card-title">
        🗓️ Calendrier d'activite
        <span class="sub">3 derniers mois</span>
      </div>
      <div style="display:flex;">
        <div class="hm-days">
          <div class="hm-day"></div>
          <div class="hm-day">Lun</div>
          <div class="hm-day"></div>
          <div class="hm-day">Mer</div>
          <div class="hm-day"></div>
          <div class="hm-day">Ven</div>
          <div class="hm-day"></div>
        </div>
        <div style="flex:1;overflow:hidden;">
          <div class="hm-months" id="hmMonths"></div>
          <div class="heatmap-grid" id="hmGrid"></div>
        </div>
      </div>
      <div class="hm-legend">
        Moins
        <div class="hm-legend-cells">
          <div class="hm-cell l0" style="width:12px;height:12px;border-radius:3px;"></div>
          <div class="hm-cell l1" style="width:12px;height:12px;border-radius:3px;"></div>
          <div class="hm-cell l2" style="width:12px;height:12px;border-radius:3px;"></div>
          <div class="hm-cell l3" style="width:12px;height:12px;border-radius:3px;"></div>
          <div class="hm-cell l4" style="width:12px;height:12px;border-radius:3px;"></div>
        </div>
        Plus
      </div>
    </div>

    <!-- Quizzes -->
    <div class="card">
      <div class="card-title">
        📝 Quiz disponibles
        <span class="sub">{{ $stats['quizzes_count'] }} quiz dans tes cours</span>
      </div>
      @if($allInscriptions->flatMap(fn($i) => $i->cours->quizzes)->count() > 0)
        <div style="overflow-x:auto;">
          <table class="quiz-table">
            <thead>
              <tr>
                <th>Quiz</th>
                <th>Cours</th>
                <th>Duree</th>
                <th>Score min</th>
              </tr>
            </thead>
            <tbody>
              @foreach($allInscriptions->flatMap(fn($i) => $i->cours->quizzes)->take(5) as $quiz)
              <tr>
                <td style="font-weight:600;">{{ $quiz->title }}</td>
                <td style="color:var(--muted);">{{ $quiz->cours->title }}</td>
                <td style="color:var(--muted);">{{ $quiz->duration ?? 15 }} min</td>
                <td><span class="score-pill good">{{ $quiz->passing_score ?? 70 }}%</span></td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @else
        <div class="empty-state" style="padding:20px;">
          <div class="emoji">📝</div>
          <p>Aucun quiz disponible pour le moment</p>
        </div>
      @endif
    </div>
  </div>

  <!-- CERT PROGRESS -->
  @if($allInscriptions->count() > 0)
  <div class="fu fu7">
    <div class="card">
      <div class="card-title">
        🎓 Progression vers les certificats
        <span class="sub">{{ $allInscriptions->count() }} certifications possibles</span>
      </div>
      <div class="cert-progress-list">
        @foreach($allInscriptions->take(6) as $i => $inscription)
          @php
            $colors = [['bg'=>'var(--vxl)','c'=>'#7C3AED'],['bg'=>'var(--rose)','c'=>'#DB2777'],['bg'=>'var(--mint)','c'=>'#059669'],['bg'=>'var(--sky)','c'=>'#0284C7'],['bg'=>'var(--yel)','c'=>'#D97706']];
            $color = $colors[$i % count($colors)];
            $pct = $inscription->progress;
            $offset = 125.66 - (125.66 * $pct / 100);
            $hasCertificat = $inscription->certificat !== null;
            $lessonsCount = $inscription->cours->chapitres->flatMap->lecons->count();
          @endphp
          <div class="cert-prog">
            <div class="cert-ring">
              <svg width="50" height="50" viewBox="0 0 50 50">
                <circle cx="25" cy="25" r="20" fill="none" stroke="{{ $color['bg'] }}" stroke-width="5"/>
                <circle cx="25" cy="25" r="20" fill="none" stroke="{{ $color['c'] }}" stroke-width="5"
                  stroke-linecap="round" stroke-dasharray="125.66" stroke-dashoffset="{{ $offset }}"/>
              </svg>
              <div class="cert-ring-center" style="color:{{ $color['c'] }};">{{ number_format($pct, 0) }}%</div>
            </div>
            <div class="cert-info">
              <div class="cert-name">{{ $inscription->cours->title }}</div>
              <div class="cert-sub">{{ $lessonsCount }} lecons · {{ $inscription->cours->categorie?->name ?? 'Formation' }}</div>
              @if($hasCertificat)
                <span class="cert-status" style="background:var(--mint);color:var(--mintd);">✅ Certificat obtenu</span>
              @elseif($pct >= 100)
                <span class="cert-status" style="background:var(--mint);color:var(--mintd);">🎉 Cours termine</span>
              @elseif($pct >= 50)
                <span class="cert-status" style="background:var(--vxl);color:var(--v);">🔄 En bonne voie</span>
              @else
                <span class="cert-status" style="background:var(--yel);color:var(--yeld);">📖 A continuer</span>
              @endif
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
  @endif

  @else
  <!-- Empty state when no inscriptions -->
  <div class="card fu fu1">
    <div class="empty-state">
      <div class="emoji">📈</div>
      <p>Tu n'as pas encore de cours. Inscris-toi a un cours pour commencer a suivre ta progression !</p>
      <a href="{{ route('etudiant.catalogue') }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px;"><path d="M12 5v14M5 12h14"/></svg>
        Explorer le catalogue
      </a>
    </div>
  </div>
  @endif

</div>

<script>
// Heatmap
(function buildHeatmap() {
  const grid = document.getElementById('hmGrid');
  const months = document.getElementById('hmMonths');
  if (!grid || !months) return;
  const numWeeks = 13;
  const activeCourses = {{ $allInscriptions->where('status', 'active')->count() }};
  const activityBase = Math.min(4, activeCourses);

  for (let w = 0; w < numWeeks; w++) {
    const col = document.createElement('div');
    col.className = 'hm-col';
    for (let d = 0; d < 7; d++) {
      const cell = document.createElement('div');
      const idx = w * 7 + d;
      let level;
      if (idx > numWeeks * 7 - 14) {
        level = Math.random() < 0.8 ? Math.floor(Math.random() * activityBase) + 1 : 0;
      } else {
        level = Math.random() < 0.6 ? Math.floor(Math.random() * 3) : 0;
      }
      level = Math.min(4, level);
      cell.className = `hm-cell l${level}`;
      col.appendChild(cell);
    }
    grid.appendChild(col);
  }

  const now = new Date();
  const currentMonth = now.getMonth();
  const monthLabels = [];
  for (let i = 2; i >= 0; i--) {
    const m = (currentMonth - i + 12) % 12;
    monthLabels.push(['Jan','Fev','Mar','Avr','Mai','Jun','Jul','Aou','Sep','Oct','Nov','Dec'][m]);
  }
  monthLabels.forEach((m, i) => {
    const span = document.createElement('span');
    span.textContent = m;
    span.style.flex = i < 2 ? '4' : '5';
    months.appendChild(span);
  });
})();
</script>
</div>
