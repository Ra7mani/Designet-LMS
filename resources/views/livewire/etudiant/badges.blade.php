<div>
<style>
/* ============================================================
   BADGES PAGE — Page-specific styles
   ============================================================ */

/* Additional animations for badges page */
@keyframes shine{0%{background-position:-200% center}100%{background-position:200% center}}
@keyframes sparkle{0%,100%{opacity:0;transform:scale(0)}50%{opacity:1;transform:scale(1)}}
@keyframes float{0%,100%{transform:translateY(0px)}50%{transform:translateY(-12px)}}
@keyframes barGrow{from{width:0 !important}to{width:var(--w) !important}}
@keyframes pulse{0%,100%{opacity:1}50%{opacity:.6}}

:root {
  --v: #7C3AED;
  --vl: #a78bfa;
  --vxl: #f3e8ff;
  --vgrad: linear-gradient(135deg, #7C3AED 0%, #a78bfa 100%);
  --card: #fff;
  --bg: #f5f3ff;
  --border: #e5e7eb;
  --txt: #111827;
  --muted: #6b7280;
  --sh: 0 2px 8px rgba(30,27,75,.08);
  --shlift: 0 8px 16px rgba(30,27,75,.12);
  --r: 16px;
  --rm: 12px;
  --rp: 8px;

  --rose: #fce7f3;
  --rosed: #be185d;
  --yel: #fef3c7;
  --yeld: #d97706;
  --mint: #ccfbf1;
  --mintd: #14b8a6;
  --sky: #cffafe;
  --skyd: #0891b2;
  --peach: #fed7aa;
  --peachd: #ea580c;
  --teal: #a7f3d0;
  --teald: #059669;
}

/* HEADER */
.hdr{position:sticky;top:0;z-index:50;background:rgba(245,243,255,.92);backdrop-filter:blur(14px);border-bottom:1.5px solid var(--border);padding:15px 28px;display:flex;align-items:center;gap:14px;}
.hdr h1{font-family:'Poppins',sans-serif;font-size:20px;font-weight:800;color:var(--txt);flex:1;}
.tabs{display:flex;gap:4px;background:#fff;border-radius:var(--rp);padding:4px;border:1.5px solid var(--border);box-shadow:var(--sh);}
.tab{padding:7px 16px;border-radius:var(--rp);font-size:12px;font-weight:600;color:var(--muted);cursor:pointer;transition:all .2s;}
.tab.active{background:var(--vgrad);color:#fff;}
.tab:not(.active):hover{background:var(--vxl);color:var(--v);}
.ibtn{width:38px;height:38px;border-radius:50%;border:1.5px solid var(--border);background:#fff;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all .2s;box-shadow:var(--sh);position:relative;flex-shrink:0;}
.ibtn:hover{background:var(--vxl);border-color:var(--vl);}
.ibtn svg{width:16px;height:16px;stroke:var(--muted);}
.ndot{position:absolute;top:6px;right:6px;width:7px;height:7px;border-radius:50%;background:#EF4444;border:2px solid #fff;animation:pulse 2s infinite;}
.hdr-av{width:38px;height:38px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-family:'Poppins',sans-serif;font-weight:700;font-size:12px;color:#fff;border:2.5px solid #F472B6;box-shadow:0 0 0 4px rgba(244,114,182,.18);}

/* PAGE */
.page{padding:26px 28px;display:flex;flex-direction:column;gap:24px;}
.section-title{font-family:'Poppins',sans-serif;font-size:16px;font-weight:700;color:var(--txt);margin-bottom:14px;display:flex;align-items:center;gap:8px;}
.section-title .pill{font-size:11px;font-weight:700;padding:2px 9px;border-radius:var(--rp);background:var(--vxl);color:var(--v);font-family:'DM Sans',sans-serif;}
.section-title .sub{font-size:12px;font-weight:400;color:var(--muted);margin-left:auto;font-family:'DM Sans',sans-serif;}

/* HERO BANNER */
.hero{background:linear-gradient(135deg,#1E1B4B 0%,#4C1D95 40%,#7C3AED 100%);border-radius:var(--r);padding:28px 32px;display:grid;grid-template-columns:1fr auto;gap:20px;box-shadow:0 12px 40px rgba(30,27,75,.35);position:relative;overflow:hidden;}
.hero::before{content:'';position:absolute;top:-60px;right:260px;width:220px;height:220px;border-radius:50%;background:rgba(255,255,255,.04);}
.hero-left h2{font-family:'Poppins',sans-serif;font-size:24px;font-weight:900;color:#fff;margin-bottom:6px;}
.hero-left p{font-size:13px;color:rgba(255,255,255,.7);max-width:420px;line-height:1.6;margin-bottom:20px;}
.hero-stats{display:flex;gap:20px;}
.hstat{text-align:center;}
.hstat-val{font-family:'Poppins',sans-serif;font-size:26px;font-weight:900;color:#fff;}
.hstat-lbl{font-size:11px;color:rgba(255,255,255,.6);margin-top:2px;}
.hero-right{display:flex;flex-direction:column;align-items:center;justify-content:center;gap:8px;}
.rank-badge{background:rgba(255,255,255,.12);border:1.5px solid rgba(255,255,255,.25);border-radius:var(--r);padding:20px 24px;text-align:center;backdrop-filter:blur(8px);}
.rank-badge .rank-ico{font-size:42px;animation:float 3s ease-in-out infinite;display:block;margin-bottom:8px;}
.rank-badge .rank-title{font-family:'Poppins',sans-serif;font-size:14px;font-weight:800;color:#fff;}
.rank-badge .rank-sub{font-size:11px;color:rgba(255,255,255,.65);margin-top:2px;}

/* STATS STRIP */
.stats-strip{display:grid;grid-template-columns:repeat(5,1fr);gap:14px;}
.scard{background:var(--card);border-radius:var(--rm);padding:18px 14px;text-align:center;border:1.5px solid var(--border);box-shadow:var(--sh);transition:all .2s;}
.scard:hover{transform:translateY(-3px);box-shadow:var(--shlift);}
.sc-ico{font-size:22px;margin-bottom:7px;}
.sc-val{font-family:'Poppins',sans-serif;font-size:24px;font-weight:800;color:var(--txt);}
.sc-lbl{font-size:10px;color:var(--muted);margin-top:3px;}

/* BADGES GRID */
.badges-grid{display:grid;grid-template-columns:repeat(5,1fr);gap:16px;}
.badge-card{background:var(--card);border-radius:var(--rm);padding:20px 14px 16px;text-align:center;border:1.5px solid var(--border);box-shadow:var(--sh);cursor:pointer;transition:all .25s cubic-bezier(.22,1,.36,1);position:relative;overflow:hidden;}
.badge-card::before{content:'';position:absolute;inset:0;background:linear-gradient(135deg,transparent 60%,rgba(255,255,255,.08));pointer-events:none;}
.badge-card:hover{transform:translateY(-5px) scale(1.02);box-shadow:var(--shlift);}
.badge-card.locked{opacity:.45;filter:grayscale(.9);}
.badge-card.locked:hover{transform:none;box-shadow:var(--sh);}
.badge-card.new-badge{border-color:var(--v);box-shadow:0 0 0 3px rgba(124,58,237,.18),var(--sh);}
.new-label{position:absolute;top:8px;right:8px;background:var(--peachd);color:#fff;font-size:9px;font-weight:800;padding:2px 7px;border-radius:var(--rp);letter-spacing:.04em;}
.badge-ico-wrap{width:64px;height:64px;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;font-size:32px;position:relative;}
.badge-ico-wrap .sparkle{position:absolute;font-size:10px;animation:sparkle 1.5s infinite;}
.badge-ico-wrap .s1{top:2px;right:6px;animation-delay:0s;}
.badge-ico-wrap .s2{bottom:4px;left:8px;animation-delay:.5s;}
.badge-ico-wrap .s3{top:10px;left:2px;animation-delay:1s;}
.badge-name{font-family:'Poppins',sans-serif;font-size:13px;font-weight:700;color:var(--txt);margin-bottom:3px;line-height:1.2;}
.badge-desc{font-size:11px;color:var(--muted);line-height:1.4;margin-bottom:8px;}
.badge-date{font-size:10px;font-weight:700;padding:3px 10px;border-radius:var(--rp);display:inline-block;}
.badge-xp{font-size:11px;font-weight:700;color:var(--v);margin-top:5px;}

/* CERT SECTION */
.cert-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:18px;}
.cert-card{background:var(--card);border-radius:var(--r);border:1.5px solid var(--border);box-shadow:var(--sh);overflow:hidden;transition:all .25s cubic-bezier(.22,1,.36,1);}
.cert-card:hover{transform:translateY(-4px);box-shadow:var(--shlift);}
.cert-card.locked-cert{opacity:.6;}

.cert-header{padding:24px 24px 18px;position:relative;}
.cert-header.obtained{background:linear-gradient(135deg,#1E1B4B 0%,#4C1D95 60%,#7C3AED 100%);}
.cert-header.in-progress{background:linear-gradient(135deg,#F5F3FF,#EDE9FE);}
.cert-header.locked-h{background:linear-gradient(135deg,#F9FAFB,#F3F4F6);}

.cert-watermark{position:absolute;right:16px;top:50%;transform:translateY(-50%);font-size:56px;opacity:.12;}
.cert-ico-badge{width:52px;height:52px;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:26px;margin-bottom:12px;}
.cert-name{font-family:'Poppins',sans-serif;font-size:17px;font-weight:800;margin-bottom:4px;}
.cert-header.obtained .cert-name{color:#fff;}
.cert-header.in-progress .cert-name{color:var(--v);}
.cert-header.locked-h .cert-name{color:#9CA3AF;}
.cert-issuer{font-size:12px;margin-bottom:12px;}
.cert-header.obtained .cert-issuer{color:rgba(255,255,255,.7);}
.cert-header.in-progress .cert-issuer{color:var(--muted);}
.cert-header.locked-h .cert-issuer{color:#9CA3AF;}
.cert-tag{display:inline-flex;align-items:center;gap:5px;font-size:11px;font-weight:700;padding:4px 12px;border-radius:var(--rp);}

.cert-body{padding:18px 24px 20px;}
.cert-meta-row{display:flex;gap:16px;margin-bottom:14px;flex-wrap:wrap;}
.cert-meta{display:flex;flex-direction:column;}
.cert-meta label{font-size:10px;color:var(--muted);font-weight:600;text-transform:uppercase;letter-spacing:.06em;}
.cert-meta span{font-size:13px;font-weight:600;color:var(--txt);margin-top:2px;}
.cert-prog-row{display:flex;align-items:center;justify-content:space-between;margin-bottom:7px;}
.cert-prog-row span{font-size:12px;color:var(--muted);}
.cert-prog-row strong{font-family:'Poppins',sans-serif;font-size:14px;font-weight:800;}
.cert-bar{height:8px;background:rgba(0,0,0,.07);border-radius:var(--rp);overflow:hidden;margin-bottom:14px;}
.cert-fill{height:100%;border-radius:var(--rp);}
.cert-actions{display:flex;gap:8px;}
.cbtn{flex:1;padding:10px;border-radius:var(--rp);font-family:'DM Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;transition:all .2s;border:none;display:flex;align-items:center;justify-content:center;gap:6px;}
.cbtn.primary{background:var(--vgrad);color:#fff;box-shadow:0 4px 14px rgba(124,58,237,.3);}
.cbtn.primary:hover{transform:translateY(-1px);box-shadow:0 8px 20px rgba(124,58,237,.35);}
.cbtn.primary svg{stroke:#fff;width:14px;height:14px;}
.cbtn.ghost{background:var(--vxl);color:var(--v);}
.cbtn.ghost:hover{background:rgba(124,58,237,.15);}
.cbtn.ghost svg{stroke:var(--v);width:14px;height:14px;}
.cbtn.disabled{background:#F3F4F6;color:#9CA3AF;cursor:not-allowed;}

/* CERT SHOWCASE (obtained - shine effect) */
.cert-card.obtained-card .cert-header{background:linear-gradient(135deg,#1E1B4B 0%,#4C1D95 60%,#7C3AED 100%);}
.shine-effect{position:relative;overflow:hidden;}
.shine-effect::after{content:'';position:absolute;top:0;left:-100%;width:60%;height:100%;background:linear-gradient(90deg,transparent,rgba(255,255,255,.08),transparent);animation:shine 3s 1s ease-in-out infinite;}

/* NEXT BADGES */
.next-badges-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;}
.next-badge{background:var(--card);border-radius:var(--rm);padding:16px 12px 14px;border:1.5px dashed var(--border);text-align:center;cursor:pointer;transition:all .2s;}
.next-badge:hover{border-color:var(--vl);background:var(--vxl);}
.nb-ico{font-size:28px;filter:grayscale(.8);opacity:.5;margin-bottom:8px;}
.nb-name{font-size:12px;font-weight:700;color:var(--muted);margin-bottom:4px;}
.nb-cond{font-size:11px;color:var(--muted);line-height:1.4;margin-bottom:8px;}
.nb-prog{height:5px;background:rgba(0,0,0,.07);border-radius:var(--rp);overflow:hidden;}
.nb-fill{height:100%;border-radius:var(--rp);}
.nb-pct{font-size:10px;color:var(--v);font-weight:700;margin-top:4px;}

/* RESPONSIVE */
@media(max-width:1200px){.badges-grid{grid-template-columns:repeat(4,1fr);}.stats-strip{grid-template-columns:repeat(3,1fr);}}
@media(max-width:960px){.badges-grid{grid-template-columns:repeat(3,1fr);}.cert-grid{grid-template-columns:1fr;}.next-badges-grid{grid-template-columns:repeat(3,1fr);}.hero{grid-template-columns:1fr;}.hero-right{display:none;}}
@media(max-width:900px){.page{padding:18px 16px;}}
@media(max-width:640px){.badges-grid{grid-template-columns:repeat(2,1fr);}.stats-strip{grid-template-columns:repeat(2,1fr);}.next-badges-grid{grid-template-columns:repeat(2,1fr);}}
</style>

<header class="hdr">
  <h1>🏅 Badges & Certificats</h1>
  <div class="tabs">
    <div class="tab active" onclick="switchTab(this)">Badges</div>
    <div class="tab" onclick="switchTab(this)">Certificats</div>
    <div class="tab" onclick="switchTab(this)">Classement</div>
  </div>
</header>

<div class="page">

  <!-- HERO -->
  <div class="hero">
    <div class="hero-left">
      <h2>Ton palmarès, {{ auth()->user()->name }} 🏆</h2>
      <p>Tu as débloqué <strong style="color:#A78BFA;">{{ $metrics['badges_count'] }} badges</strong> et obtenu <strong style="color:#A78BFA;">{{ $metrics['certificates_count'] }} certificats</strong> officiels. Continue sur cette lancée pour grimper dans le classement !</p>
      <div class="hero-stats">
        <div class="hstat"><div class="hstat-val">{{ $metrics['badges_count'] }}</div><div class="hstat-lbl">Badges obtenus</div></div>
        <div class="hstat"><div class="hstat-val">{{ $metrics['certificates_count'] }}</div><div class="hstat-lbl">Certifs officiels</div></div>
        <div class="hstat"><div class="hstat-val">{{ number_format($metrics['total_xp']) }}</div><div class="hstat-lbl">XP total</div></div>
        <div class="hstat"><div class="hstat-val">Top {{ $metrics['top_percent'] }}%</div><div class="hstat-lbl">Classement</div></div>
      </div>
    </div>
    <div class="hero-right">
      <div class="rank-badge">
        <span class="rank-ico">🎖️</span>
        <div class="rank-title">Niv. {{ $metrics['level'] }}</div>
        <div class="rank-sub">Rang #{{ $metrics['rank'] }} · Top {{ $metrics['top_percent'] }}%</div>
      </div>
    </div>
  </div>

  <!-- STATS -->
  <div class="stats-strip">
    <div class="scard" style="border-top:3px solid var(--v);"><div class="sc-ico">🏅</div><div class="sc-val">{{ $metrics['badges_count'] }}</div><div class="sc-lbl">Badges débloqués</div></div>
    <div class="scard" style="border-top:3px solid var(--mintd);"><div class="sc-ico">🔒</div><div class="sc-val">{{ $lockedBadges->count() }}</div><div class="sc-lbl">À débloquer</div></div>
    <div class="scard" style="border-top:3px solid var(--yeld);"><div class="sc-ico">🎓</div><div class="sc-val">{{ $certificats->count() }}</div><div class="sc-lbl">Certifs obtenus</div></div>
    <div class="scard" style="border-top:3px solid var(--skyd);"><div class="sc-ico">⏳</div><div class="sc-val">0</div><div class="sc-lbl">Certifs en cours</div></div>
    <div class="scard" style="border-top:3px solid var(--rosed);"><div class="sc-ico">⚡</div><div class="sc-val">{{ number_format($metrics['total_xp']) }}</div><div class="sc-lbl">XP total gagné</div></div>
  </div>

  <!-- BADGES OBTENUS -->
  <section>
    <div class="section-title">✨ Badges obtenus <span class="pill">{{ $badges->count() }}</span></div>
    <div class="badges-grid">
      @forelse($badges as $badge)
        <div class="badge-card">
          <div class="badge-ico-wrap" style="background:var(--vxl);">🏆</div>
          <div class="badge-name">{{ $badge->name }}</div>
          <div class="badge-desc">{{ $badge->description }}</div>
          <span class="badge-date" style="background:var(--vxl);color:var(--v);">{{ optional($badge->earned_at)->format('d/m/Y') ?? optional($badge->created_at)->format('d/m/Y') }}</span>
          <div class="badge-xp">+{{ rand(50, 300) }} XP</div>
        </div>
      @empty
        <div class="badge-card locked">
          <div class="badge-ico-wrap" style="background:var(--vxl);">🔒</div>
          <div class="badge-name">Aucun badge obtenu</div>
          <div class="badge-desc">Commence tes cours pour débloquer tes premiers badges.</div>
        </div>
      @endforelse
    </div>
  </section>

  <!-- PROCHAINS BADGES -->
  <section>
    <div class="section-title">🔓 Prochains badges à débloquer <span class="pill">{{ $lockedBadges->count() }} restants</span></div>
    <div class="next-badges-grid">
      @forelse($lockedBadges as $locked)
        <div class="next-badge">
          <div class="nb-ico">🏆</div>
          <div class="nb-name">{{ $locked['name'] }}</div>
          <div class="nb-cond">{{ $locked['condition'] }}</div>
          <div class="nb-prog"><div class="nb-fill" style="width:{{ $locked['progress_percent'] }}%;background:var(--v);"></div></div>
          <div class="nb-pct">{{ $locked['progress_percent'] }}% — {{ $locked['progress_value'] }}/{{ $locked['progress_target'] }}</div>
        </div>
      @empty
        <div class="next-badge">
          <div class="nb-ico">🎉</div>
          <div class="nb-name">Tous débloqués!</div>
          <div class="nb-cond">Excellent travail, il n'y a plus de badge verrouillé.</div>
        </div>
      @endforelse
    </div>
  </section>

  <!-- CERTIFICATS -->
  <section>
    <div class="section-title">🎓 Certificats officiels <span class="pill">{{ $certificats->count() }}</span></div>
    <div class="cert-grid">
      @forelse($certificats as $certificat)
        <div class="cert-card obtained-card shine-effect">
          <div class="cert-header obtained">
            <div class="cert-watermark">🎓</div>
            <div class="cert-ico-badge" style="background:rgba(255,255,255,.15);">📜</div>
            <div class="cert-name">{{ $certificat->inscription->cours->title ?? 'Certificat' }}</div>
            <div class="cert-issuer">DesignLMS · {{ optional($certificat->inscription->cours)->formateur->name ?? 'N/A' }}</div>
            <span class="cert-tag" style="background:rgba(255,255,255,.2);color:#fff;">✅ Certifié · {{ optional($certificat->issued_at)->format('d/m/Y') }}</span>
          </div>
          <div class="cert-body">
            <div class="cert-meta-row">
              <div class="cert-meta"><label>Numéro</label><span>#{{ $certificat->certificate_number }}</span></div>
              <div class="cert-meta"><label>Date</label><span>{{ optional($certificat->issued_at)->format('d/m/Y') }}</span></div>
            </div>
            <div class="cert-actions">
              <a href="{{ route('etudiant.certificats.download', $certificat) }}" class="cbtn primary">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Télécharger PDF
              </a>
            </div>
          </div>
        </div>
      @empty
        <div style="grid-column:1/-1;background:var(--card);border-radius:var(--r);border:1.5px solid var(--border);padding:40px;text-align:center;">
          <div style="font-size:40px;margin-bottom:12px;">📋</div>
          <div style="font-size:17px;font-weight:800;color:var(--txt);margin-bottom:6px;">Aucun certificat pour le moment</div>
          <div style="font-size:13px;color:var(--muted);">Termine un cours pour générer automatiquement ton certificat PDF.</div>
        </div>
      @endforelse
    </div>
  </section>

  <!-- CLASSEMENT -->
  <section>
    <div class="section-title">🏆 Classement général des étudiants <span class="pill">Top {{ $leaderboard->count() }}</span></div>
    <div style="background:var(--card);border-radius:var(--r);border:1.5px solid var(--border);box-shadow:var(--sh);overflow:hidden;">
      <table style="width:100%;border-collapse:collapse;">
        <thead>
          <tr style="background:var(--bg);border-bottom:1.5px solid var(--border);">
            <th style="padding:14px 18px;font-size:11px;font-weight:700;color:var(--muted);text-align:left;text-transform:uppercase;letter-spacing:.04em;">Rang</th>
            <th style="padding:14px 18px;font-size:11px;font-weight:700;color:var(--muted);text-align:left;text-transform:uppercase;letter-spacing:.04em;">Étudiant</th>
            <th style="padding:14px 18px;font-size:11px;font-weight:700;color:var(--muted);text-align:left;text-transform:uppercase;letter-spacing:.04em;">XP</th>
            <th style="padding:14px 18px;font-size:11px;font-weight:700;color:var(--muted);text-align:left;text-transform:uppercase;letter-spacing:.04em;">Badges</th>
            <th style="padding:14px 18px;font-size:11px;font-weight:700;color:var(--muted);text-align:left;text-transform:uppercase;letter-spacing:.04em;">Certificats</th>
            <th style="padding:14px 18px;font-size:11px;font-weight:700;color:var(--muted);text-align:left;text-transform:uppercase;letter-spacing:.04em;">Cours terminés</th>
          </tr>
        </thead>
        <tbody>
          @foreach($leaderboard as $entry)
            <tr style="border-bottom:1px solid var(--border);{{ $entry['user']->id === auth()->id() ? 'background:#ecfeff;' : '' }}">
              <td style="padding:14px 18px;font-size:13px;color:var(--txt);font-weight:600;">#{{ $entry['rank'] }}</td>
              <td style="padding:14px 18px;font-size:13px;color:var(--txt);font-weight:600;">{{ $entry['user']->name }} @if($entry['user']->id === auth()->id())<span style="color:var(--v);font-weight:700;">(Vous)</span>@endif</td>
              <td style="padding:14px 18px;font-size:13px;color:var(--txt);font-weight:600;">{{ number_format($entry['xp']) }}</td>
              <td style="padding:14px 18px;font-size:13px;color:var(--txt);font-weight:600;">{{ $entry['badges'] }}</td>
              <td style="padding:14px 18px;font-size:13px;color:var(--txt);font-weight:600;">{{ $entry['certificates'] }}</td>
              <td style="padding:14px 18px;font-size:13px;color:var(--txt);font-weight:600;">{{ $entry['completed_courses'] }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </section>

</div>

<script>
function switchTab(el) {
  document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
  el.classList.add('active');
}
</script>
