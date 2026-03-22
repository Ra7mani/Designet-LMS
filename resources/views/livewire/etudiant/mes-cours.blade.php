<div>
<style>
/* HEADER */
.hdr{position:sticky;top:0;z-index:50;background:rgba(245,243,255,.90);backdrop-filter:blur(14px);border-bottom:1.5px solid var(--border);padding:15px 30px;display:flex;align-items:center;gap:14px;}
.hdr-left{flex:1;}
.hdr-left h1{font-family:'Poppins',sans-serif;font-size:20px;font-weight:800;color:var(--txt);}
.hdr-left p{font-size:12px;color:var(--muted);margin-top:1px;}
.search-box{display:flex;align-items:center;gap:8px;background:#fff;border:1.5px solid var(--border);border-radius:var(--rp);padding:9px 16px;min-width:260px;box-shadow:var(--sh);transition:all .2s;}
.search-box:focus-within{box-shadow:0 0 0 3px rgba(167,139,250,.25);border-color:var(--vl);}
.search-box svg{stroke:var(--muted);width:15px;height:15px;flex-shrink:0;}
.search-box input{border:none;outline:none;background:transparent;font-family:'DM Sans',sans-serif;font-size:13px;color:var(--txt);width:100%;}
.search-box input::placeholder{color:var(--muted);}
.search-clear{cursor:pointer;padding:4px;display:flex;align-items:center;justify-content:center;}
.search-clear:hover svg{stroke:var(--v);}
.hdr-acts{display:flex;align-items:center;gap:9px;}
.ibtn{width:38px;height:38px;border-radius:50%;border:1.5px solid var(--border);background:#fff;display:flex;align-items:center;justify-content:center;cursor:pointer;position:relative;transition:all .2s;box-shadow:var(--sh);}
.ibtn:hover{background:var(--vxl);border-color:var(--vl);}
.ibtn svg{width:16px;height:16px;stroke:var(--muted);}
/* PAGE */
.page{padding:28px 30px;display:flex;flex-direction:column;gap:26px;}
/* STATS STRIP */
.stats-strip{display:grid;grid-template-columns:repeat(5,1fr);gap:14px;}
.strip-card{background:#fff;border-radius:var(--r);padding:18px 16px;border:1.5px solid var(--border);box-shadow:var(--sh);transition:all .25s;cursor:default;text-align:center;}
.strip-card:hover{transform:translateY(-4px);box-shadow:var(--shlift);}
.strip-ico{font-size:22px;margin-bottom:6px;}
.strip-val{font-family:'Poppins',sans-serif;font-size:22px;font-weight:800;color:var(--txt);line-height:1;}
.strip-lbl{font-size:11px;color:var(--muted);margin-top:3px;}
/* TOOLBAR */
.toolbar{display:flex;align-items:center;gap:12px;flex-wrap:wrap;}
.tabs{display:flex;gap:6px;background:#fff;border-radius:var(--rp);padding:5px;border:1.5px solid var(--border);box-shadow:var(--sh);}
.tab{padding:7px 16px;border-radius:var(--rp);font-size:13px;font-weight:600;color:var(--muted);cursor:pointer;transition:all .2s;white-space:nowrap;}
.tab.active{background:var(--vgrad);color:#fff;box-shadow:0 3px 10px rgba(124,58,237,.28);}
.tab:not(.active):hover{background:var(--vxl);color:var(--v);}
/* SORT DROPDOWN */
.sort-wrapper{position:relative;}
.sort-btn{display:flex;align-items:center;gap:6px;padding:9px 16px;border-radius:var(--rp);border:1.5px solid var(--border);background:#fff;font-family:'DM Sans',sans-serif;font-size:13px;font-weight:500;color:var(--muted);cursor:pointer;box-shadow:var(--sh);transition:all .2s;}
.sort-btn:hover{background:var(--vxl);border-color:var(--vl);color:var(--v);}
.sort-btn svg{width:14px;height:14px;stroke:currentColor;}
.sort-dropdown{position:absolute;top:100%;left:0;margin-top:6px;background:#fff;border:1.5px solid var(--border);border-radius:var(--rm);box-shadow:var(--shlift);z-index:50;min-width:180px;display:none;}
.sort-dropdown.open{display:block;}
.sort-option{padding:10px 16px;font-size:13px;color:var(--txt);cursor:pointer;transition:all .15s;display:flex;align-items:center;gap:8px;}
.sort-option:hover{background:var(--vxl);color:var(--v);}
.sort-option.active{background:var(--vxl);color:var(--v);font-weight:600;}
.sort-option svg{width:14px;height:14px;stroke:currentColor;}
.view-btns{display:flex;gap:4px;background:#fff;border-radius:var(--rp);padding:4px;border:1.5px solid var(--border);box-shadow:var(--sh);}
.view-btn{width:32px;height:32px;border-radius:var(--rp);display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all .2s;}
.view-btn svg{width:15px;height:15px;stroke:var(--muted);}
.view-btn.active{background:var(--vgrad);}
.view-btn.active svg{stroke:#fff;}
.view-btn:not(.active):hover{background:var(--vxl);}
.view-btn:not(.active):hover svg{stroke:var(--v);}
.ml-auto{margin-left:auto;}
/* CURRENT CARD */
.section-title{font-family:'Poppins',sans-serif;font-size:16px;font-weight:700;color:var(--txt);margin-bottom:14px;display:flex;align-items:center;gap:8px;}
.section-title .pill{font-size:11px;font-weight:700;padding:2px 9px;border-radius:var(--rp);background:var(--vxl);color:var(--v);}
.current-card{background:#fff;border-radius:var(--r);border:1.5px solid var(--border);box-shadow:var(--sh);overflow:hidden;display:grid;grid-template-columns:340px 1fr;transition:all .28s;}
.current-card:hover{box-shadow:var(--shlift);transform:translateY(-3px);}
.cc-visual{position:relative;background:var(--vgrad);padding:32px 28px;display:flex;flex-direction:column;justify-content:space-between;min-height:220px;}
.cc-visual::before{content:'';position:absolute;bottom:-30px;right:-30px;width:140px;height:140px;border-radius:50%;background:rgba(255,255,255,.08);}
.cc-visual::after{content:'';position:absolute;top:-20px;left:60px;width:90px;height:90px;border-radius:50%;background:rgba(255,255,255,.05);}
.cc-emoji{font-size:56px;animation:float 3s ease-in-out infinite;z-index:2;line-height:1;}
.cc-cat{font-size:11px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:rgba(255,255,255,.7);margin-bottom:4px;}
.cc-name{font-family:'Poppins',sans-serif;font-size:20px;font-weight:800;color:#fff;line-height:1.25;}
.cc-live{display:inline-flex;align-items:center;gap:5px;margin-top:8px;background:rgba(255,255,255,.18);color:#fff;font-size:11px;font-weight:700;padding:4px 11px;border-radius:var(--rp);backdrop-filter:blur(6px);}
.cc-live-dot{width:7px;height:7px;border-radius:50%;background:#4ADE80;animation:pulse 1.5s infinite;}
.cc-body{padding:28px 30px;display:flex;flex-direction:column;justify-content:space-between;}
.cc-meta{display:flex;align-items:center;gap:10px;margin-bottom:16px;}
.cc-rating{display:inline-flex;align-items:center;gap:4px;font-size:13px;font-weight:700;color:var(--yeld);}
.cc-students{font-size:12px;color:var(--muted);}
.cc-level{font-size:11px;font-weight:700;padding:3px 10px;border-radius:var(--rp);background:var(--sky);color:var(--skyd);}
.cc-desc{font-size:13px;color:var(--muted);line-height:1.65;margin-bottom:20px;}
.cc-prog-label{display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;}
.cc-prog-label span{font-size:12px;color:var(--muted);}
.cc-prog-label strong{font-family:'Poppins',sans-serif;font-size:14px;font-weight:800;color:var(--v);}
.prog-track{height:10px;background:var(--vxl);border-radius:var(--rp);overflow:hidden;margin-bottom:12px;}
.prog-fill{height:100%;border-radius:var(--rp);background:var(--vgrad);box-shadow:0 2px 8px rgba(124,58,237,.35);}
.cc-chapters{font-size:12px;color:var(--muted);margin-bottom:20px;}
.cc-chapters span{font-weight:600;color:var(--txt);}
.cc-actions{display:flex;align-items:center;gap:10px;}
.btn-primary{display:inline-flex;align-items:center;gap:7px;background:var(--vgrad);color:#fff;border:none;cursor:pointer;font-family:'DM Sans',sans-serif;font-size:14px;font-weight:700;padding:11px 24px;border-radius:var(--rp);box-shadow:0 4px 16px rgba(124,58,237,.35);transition:all .2s;text-decoration:none;}
.btn-primary:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(124,58,237,.42);}
.btn-primary svg{width:15px;height:15px;stroke:#fff;}
.btn-ghost{display:inline-flex;align-items:center;gap:7px;background:#fff;color:var(--v);border:1.5px solid var(--border);cursor:pointer;font-family:'DM Sans',sans-serif;font-size:13px;font-weight:600;padding:10px 18px;border-radius:var(--rp);box-shadow:var(--sh);transition:all .2s;}
.btn-ghost:hover{background:var(--vxl);border-color:var(--vl);}
.btn-ghost svg{width:14px;height:14px;stroke:var(--v);}
.cc-formateur{display:flex;align-items:center;gap:8px;margin-left:auto;}
.cc-f-av{width:32px;height:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-family:'Poppins',sans-serif;font-weight:700;font-size:12px;color:#fff;}
.cc-f-name{font-size:12px;color:var(--muted);}
.cc-f-name strong{display:block;font-size:13px;color:var(--txt);font-weight:600;}
/* CHAPTERS PANEL */
.chapters-panel{grid-column:1/-1;border-top:1.5px solid var(--border);background:var(--bg);padding:24px 30px;display:none;}
.chapters-panel.open{display:block;}
.ch-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;}
.ch-item{background:#fff;border-radius:var(--rm);padding:14px 16px;border:1.5px solid var(--border);display:flex;align-items:center;gap:12px;cursor:pointer;transition:all .2s;}
.ch-item:hover{border-color:var(--vl);background:var(--vxl);}
.ch-item.done{border-color:rgba(5,150,105,.2);background:var(--mint);}
.ch-item.current{border-color:var(--v);background:var(--vxl);box-shadow:0 0 0 3px rgba(124,58,237,.12);}
.ch-num{width:32px;height:32px;border-radius:9px;display:flex;align-items:center;justify-content:center;font-family:'Poppins',sans-serif;font-size:12px;font-weight:800;flex-shrink:0;}
.ch-item.done .ch-num{background:var(--mintd);color:#fff;}
.ch-item.current .ch-num{background:var(--vgrad);color:#fff;}
.ch-item:not(.done):not(.current) .ch-num{background:#E5E7EB;color:var(--muted);}
.ch-info{flex:1;min-width:0;}
.ch-title{font-size:13px;font-weight:600;color:var(--txt);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
.ch-sub{font-size:11px;color:var(--muted);margin-top:2px;}
.ch-ico{font-size:16px;flex-shrink:0;}
/* COURSES GRID */
.courses-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:18px;}
.courses-grid.list-view{grid-template-columns:1fr;}
.ccard{background:#fff;border-radius:var(--r);overflow:hidden;border:1.5px solid var(--border);box-shadow:var(--sh);transition:all .28s;cursor:pointer;display:flex;flex-direction:column;text-decoration:none;}
.ccard:hover{transform:translateY(-5px);box-shadow:var(--shlift);}
.courses-grid.list-view .ccard{flex-direction:row;align-items:stretch;}
.courses-grid.list-view .ccard-top{width:200px;flex-shrink:0;min-height:auto;}
.courses-grid.list-view .ccard-bot{border-top:none;border-left:1.5px solid var(--border);}
.ccard-top{padding:24px 20px 18px;position:relative;display:flex;flex-direction:column;gap:3px;}
.ccard-emoji{font-size:36px;margin-bottom:6px;display:block;line-height:1;}
.ccard-cat{font-size:10px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;margin-bottom:3px;}
.ccard-title{font-family:'Poppins',sans-serif;font-size:15px;font-weight:700;color:var(--txt);line-height:1.3;}
.ccard-sub{font-size:11px;color:var(--muted);margin-top:2px;}
.ccard-badge{position:absolute;top:14px;right:14px;font-size:10px;font-weight:700;padding:3px 9px;border-radius:var(--rp);}
.ccard-formateur{display:flex;align-items:center;gap:7px;margin-top:10px;padding-top:10px;border-top:1px dashed var(--border);}
.mini-av{width:24px;height:24px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:9px;font-weight:700;color:#fff;flex-shrink:0;}
.ccard-bot{padding:14px 20px 18px;border-top:1px solid var(--border);flex:1;display:flex;flex-direction:column;}
.ccard-stats{display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;}
.ccard-stat{font-size:11px;color:var(--muted);display:flex;align-items:center;gap:4px;}
.ccard-stat svg{width:12px;height:12px;stroke:var(--muted);}
.ccard-rating{display:flex;align-items:center;gap:3px;font-size:12px;font-weight:700;color:var(--yeld);}
.prog-row{display:flex;justify-content:space-between;align-items:center;margin-bottom:6px;}
.prog-row span{font-size:11px;color:var(--muted);}
.prog-row strong{font-family:'Poppins',sans-serif;font-size:13px;font-weight:800;}
.prog-track-sm{height:7px;background:rgba(0,0,0,.07);border-radius:var(--rp);overflow:hidden;margin-bottom:12px;}
.prog-fill-sm{height:100%;border-radius:var(--rp);}
.ccard-cta{display:flex;align-items:center;gap:8px;margin-top:auto;}
.cta-btn{flex:1;display:inline-flex;align-items:center;justify-content:center;gap:6px;padding:9px 0;border-radius:var(--rp);font-family:'DM Sans',sans-serif;font-size:13px;font-weight:700;border:none;cursor:pointer;transition:all .2s;text-decoration:none;}
.cta-btn.primary{background:var(--vgrad);color:#fff;box-shadow:0 3px 10px rgba(124,58,237,.30);}
.cta-btn.primary:hover{box-shadow:0 6px 18px rgba(124,58,237,.40);transform:translateY(-1px);}
.cta-btn.primary svg{stroke:#fff;width:13px;height:13px;}
.cta-btn.success{background:var(--mint);color:var(--mintd);}
.cta-btn.new{background:var(--sky);color:var(--skyd);}
.cta-icon{width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;border:1.5px solid var(--border);background:#fff;cursor:pointer;transition:all .2s;flex-shrink:0;}
.cta-icon:hover{background:var(--vxl);border-color:var(--vl);}
.cta-icon svg{width:14px;height:14px;stroke:var(--muted);}
/* COMPLETED */
.completed-list{display:flex;flex-direction:column;gap:12px;}
.comp-card{background:#fff;border-radius:var(--rm);padding:18px 20px;border:1.5px solid var(--border);box-shadow:var(--sh);display:flex;align-items:center;gap:16px;transition:all .2s;cursor:pointer;text-decoration:none;}
.comp-card:hover{border-color:var(--mintd);background:var(--mint);transform:translateX(4px);}
.comp-ico{width:52px;height:52px;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:24px;flex-shrink:0;}
.comp-info{flex:1;min-width:0;}
.comp-title{font-family:'Poppins',sans-serif;font-size:14px;font-weight:700;color:var(--txt);}
.comp-sub{font-size:12px;color:var(--muted);margin-top:2px;}
.comp-date{font-size:11px;color:var(--mintd);font-weight:600;margin-top:4px;}
.comp-right{display:flex;flex-direction:column;align-items:flex-end;gap:8px;}
.comp-score{font-family:'Poppins',sans-serif;font-size:20px;font-weight:800;color:var(--mintd);}
.comp-score span{font-size:11px;font-weight:400;color:var(--muted);}
.comp-cert{display:inline-flex;align-items:center;gap:5px;font-size:11px;font-weight:700;color:var(--v);background:var(--vxl);padding:4px 10px;border-radius:var(--rp);cursor:pointer;}
.comp-cert:hover{background:var(--v);color:#fff;}
.comp-cert svg{width:12px;height:12px;stroke:currentColor;}
/* CATALOGUE BANNER */
.catalogue-banner{background:linear-gradient(135deg,#1E1B4B 0%,#3730A3 50%,#7C3AED 100%);border-radius:var(--r);padding:28px 32px;display:flex;align-items:center;justify-content:space-between;position:relative;overflow:hidden;box-shadow:0 12px 40px rgba(30,27,75,.35);}
.catalogue-banner::before{content:'';position:absolute;top:-50px;right:200px;width:200px;height:200px;border-radius:50%;background:rgba(255,255,255,.04);}
.catalogue-banner::after{content:'';position:absolute;bottom:-40px;right:80px;width:150px;height:150px;border-radius:50%;background:rgba(255,255,255,.06);}
.cb-txt h3{font-family:'Poppins',sans-serif;font-size:20px;font-weight:800;color:#fff;margin-bottom:6px;}
.cb-txt p{font-size:13px;color:rgba(255,255,255,.75);max-width:400px;line-height:1.6;}
.cb-emojis{font-size:52px;position:relative;z-index:2;display:flex;gap:12px;}
.cb-emojis span:nth-child(1){animation:float 3s ease-in-out infinite;}
.cb-emojis span:nth-child(2){animation:float 3s 1s ease-in-out infinite;}
.cb-emojis span:nth-child(3){animation:float 3s .5s ease-in-out infinite;}
.cb-actions{display:flex;gap:10px;margin-top:18px;}
.cb-btn{display:inline-flex;align-items:center;gap:7px;padding:11px 22px;border-radius:var(--rp);font-family:'DM Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;transition:all .2s;border:none;text-decoration:none;}
.cb-btn.white{background:#fff;color:var(--v);box-shadow:0 4px 16px rgba(0,0,0,.18);}
.cb-btn.white:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(0,0,0,.22);}
.cb-btn.outline{background:rgba(255,255,255,.12);color:#fff;border:1.5px solid rgba(255,255,255,.25);}
.cb-btn.outline:hover{background:rgba(255,255,255,.2);}
/* EMPTY STATE */
.empty-state{text-align:center;padding:60px 30px;background:#fff;border-radius:var(--r);border:1.5px solid var(--border);}
.empty-state-icon{font-size:64px;margin-bottom:16px;}
.empty-state-title{font-family:'Poppins',sans-serif;font-size:18px;font-weight:700;color:var(--txt);margin-bottom:8px;}
.empty-state-text{font-size:14px;color:var(--muted);margin-bottom:20px;}
.empty-state-btn{display:inline-flex;align-items:center;gap:8px;background:var(--vgrad);color:#fff;padding:12px 24px;border-radius:var(--rp);font-weight:600;text-decoration:none;transition:all .2s;}
.empty-state-btn:hover{transform:translateY(-2px);box-shadow:0 6px 20px rgba(124,58,237,.35);}
/* RESPONSIVE */
@media(max-width:1200px){.stats-strip{grid-template-columns:repeat(3,1fr);}.courses-grid{grid-template-columns:repeat(2,1fr);}.ch-grid{grid-template-columns:repeat(2,1fr);}}
@media(max-width:960px){.current-card{grid-template-columns:1fr;}.cc-visual{min-height:180px;}}
@media(max-width:900px){.hdr{padding:14px 16px;}.page{padding:18px 16px;}.search-box{min-width:180px;}}
@media(max-width:640px){.stats-strip{grid-template-columns:repeat(2,1fr);}.courses-grid{grid-template-columns:1fr;}.ch-grid{grid-template-columns:1fr;}.toolbar{gap:8px;}.catalogue-banner{flex-direction:column;gap:18px;}.cb-emojis{display:none;}.courses-grid.list-view .ccard{flex-direction:column;}.courses-grid.list-view .ccard-top{width:100%;}.tabs{overflow-x:auto;}}
</style>

<!-- HEADER -->
<header class="hdr">
  <div class="hdr-left">
    <h1>📚 Mes Cours</h1>
    <p>{{ $stats['total'] }} cours · {{ $stats['en_cours'] }} en cours · {{ $stats['termines'] }} termines</p>
  </div>
  <div class="search-box">
    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Rechercher un cours..."/>
    @if(strlen($search) > 0)
      <div class="search-clear" wire:click="$set('search', '')">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" style="width:14px;height:14px;"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
      </div>
    @endif
  </div>
  
</header>

<!-- PAGE -->
<div class="page">

  <!-- CATALOGUE BANNER -->
  <div class="catalogue-banner fu fu1">
    <div class="cb-txt">
      <h3>Decouvre de nouveaux cours 🚀</h3>
      <p>Explore notre catalogue complet. Developpe de nouvelles competences, obtiens des certificats et propulse ta carriere.</p>
      <div class="cb-actions">
        <a href="{{ route('etudiant.catalogue') }}" class="cb-btn white">Explorer le catalogue</a>
      </div>
    </div>
    <div class="cb-emojis">
      <span>🎨</span><span>🧠</span><span>💻</span>
    </div>
  </div>

  <!-- STATS STRIP -->
  <div class="stats-strip fu fu1">
    <div class="strip-card" style="border-top:3px solid var(--v);">
      <div class="strip-ico">🎯</div>
      <div class="strip-val">{{ $stats['en_cours'] }}</div>
      <div class="strip-lbl">En cours</div>
    </div>
    <div class="strip-card" style="border-top:3px solid var(--mintd);">
      <div class="strip-ico">✅</div>
      <div class="strip-val">{{ $stats['termines'] }}</div>
      <div class="strip-lbl">Termines</div>
    </div>
    <div class="strip-card" style="border-top:3px solid var(--yeld);">
      <div class="strip-ico">📖</div>
      <div class="strip-val">{{ $stats['lessons_completed'] }}/{{ $stats['total_lessons'] }}</div>
      <div class="strip-lbl">Lecons</div>
    </div>
    <div class="strip-card" style="border-top:3px solid var(--rosed);">
      <div class="strip-ico">⏱️</div>
      <div class="strip-val">{{ $stats['heures'] }}h</div>
      <div class="strip-lbl">Temps estime</div>
    </div>
    <div class="strip-card" style="border-top:3px solid var(--skyd);">
      <div class="strip-ico">🏅</div>
      <div class="strip-val">{{ $stats['avg_progress'] }}%</div>
      <div class="strip-lbl">Progression moy.</div>
    </div>
  </div>

  <!-- TOOLBAR -->
  <div class="toolbar fu fu2">
    <div class="tabs">
      <div class="tab {{ $tab === 'tous' ? 'active' : '' }}" wire:click="setTab('tous')">Tous <span style="opacity:.7;">({{ $stats['total'] }})</span></div>
      <div class="tab {{ $tab === 'en-cours' ? 'active' : '' }}" wire:click="setTab('en-cours')">En cours <span style="opacity:.7;">({{ $stats['en_cours'] }})</span></div>
      <div class="tab {{ $tab === 'termine' ? 'active' : '' }}" wire:click="setTab('termine')">Termines <span style="opacity:.7;">({{ $stats['termines'] }})</span></div>
      @if($stats['nouveaux'] > 0)
        <div class="tab {{ $tab === 'nouveau' ? 'active' : '' }}" wire:click="setTab('nouveau')">Nouveaux <span style="opacity:.7;">({{ $stats['nouveaux'] }})</span></div>
      @endif
    </div>

    <div class="sort-wrapper" x-data="{ open: false }">
      <button class="sort-btn" @click="open = !open">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><line x1="21" y1="10" x2="7" y2="10"/><line x1="21" y1="6" x2="3" y2="6"/><line x1="21" y1="14" x2="3" y2="14"/><line x1="21" y1="18" x2="7" y2="18"/></svg>
        @switch($sortBy)
          @case('recent') Recents @break
          @case('progress') Progression @break
          @case('name') Nom A-Z @break
          @case('enrolled') Date inscription @break
          @default Trier par
        @endswitch
      </button>
      <div class="sort-dropdown" :class="{ 'open': open }" @click.outside="open = false">
        <div class="sort-option {{ $sortBy === 'recent' ? 'active' : '' }}" wire:click="setSort('recent')" @click="open = false">
          <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
          Plus recents
        </div>
        <div class="sort-option {{ $sortBy === 'progress' ? 'active' : '' }}" wire:click="setSort('progress')" @click="open = false">
          <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><line x1="12" y1="20" x2="12" y2="10"/><line x1="18" y1="20" x2="18" y2="4"/><line x1="6" y1="20" x2="6" y2="16"/></svg>
          Progression
        </div>
        <div class="sort-option {{ $sortBy === 'name' ? 'active' : '' }}" wire:click="setSort('name')" @click="open = false">
          <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><path d="M3 6h18M3 12h12M3 18h6"/></svg>
          Nom A-Z
        </div>
        <div class="sort-option {{ $sortBy === 'enrolled' ? 'active' : '' }}" wire:click="setSort('enrolled')" @click="open = false">
          <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
          Date inscription
        </div>
      </div>
    </div>

    <div class="view-btns ml-auto">
      <div class="view-btn {{ $view === 'grid' ? 'active' : '' }}" wire:click="setView('grid')">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
      </div>
      <div class="view-btn {{ $view === 'list' ? 'active' : '' }}" wire:click="setView('list')">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
      </div>
    </div>
  </div>

  @if($inscriptions->count() > 0)

    @if($dernierCours && ($tab === 'tous' || $tab === 'en-cours'))
    <!-- CURRENTLY STUDYING -->
    <section class="fu fu2">
      <div class="section-title">
        🔥 Reprendre
        <span class="pill">{{ number_format($dernierCours->progress, 0) }}%</span>
      </div>
      <div class="current-card" id="currentCard">
        <div class="cc-visual">
          <div class="cc-emoji">💡</div>
          <div>
            <div class="cc-cat">{{ $dernierCours->cours->categorie?->name ?? 'Formation' }}</div>
            <div class="cc-name">{{ $dernierCours->cours->title }}</div>
            <div class="cc-live">
              <div class="cc-live-dot"></div>
              En cours · {{ number_format($dernierCours->progress, 0) }}% complete
            </div>
          </div>
        </div>
        <div class="cc-body">
          <div>
            <div class="cc-meta">
              <div class="cc-level">{{ ucfirst($dernierCours->cours->level ?? 'Debutant') }}</div>
              <div class="cc-students">{{ $dernierCours->cours->chapitres?->count() ?? 0 }} chapitres</div>
            </div>
            <div class="cc-desc">
              {{ Str::limit($dernierCours->cours->description ?? 'Continuez votre apprentissage et maitrisez de nouvelles competences.', 180) }}
            </div>
            <div class="cc-prog-label">
              <span>Progression globale</span>
              <strong>{{ number_format($dernierCours->progress, 0) }}%</strong>
            </div>
            <div class="prog-track">
              <div class="prog-fill" style="width:{{ $dernierCours->progress }}%"></div>
            </div>
            <div class="cc-chapters">
              @php
                $lessonsCount = $dernierCours->cours->chapitres->flatMap->lecons->count();
                $lessonsCompleted = (int)($lessonsCount * ($dernierCours->progress / 100));
              @endphp
              <span>{{ $lessonsCompleted }}/{{ $lessonsCount }}</span> lecons completees
            </div>
          </div>
          <div class="cc-actions">
            <a href="{{ route('etudiant.cours.detail', $dernierCours->cours->id) }}" class="btn-primary">
              <svg viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round"><polygon points="5 3 19 12 5 21 5 3"/></svg>
              Continuer
            </a>
            <div class="cc-formateur">
              <div class="cc-f-av" style="background:linear-gradient(135deg,#0284C7,#38BDF8);">{{ $dernierCours->cours->formateur?->initials() ?? 'F' }}</div>
              <div class="cc-f-name">
                Formateur
                <strong>{{ $dernierCours->cours->formateur?->name ?? 'Expert' }}</strong>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    @endif

    <!-- COURSES GRID -->
    @if($tab !== 'termine')
      @php $coursesToShow = $tab === 'nouveau' ? $coursNouveaux : $coursEnCours; @endphp
      @if($coursesToShow->count() > 0)
      <section class="fu fu3">
        <div class="section-title">
          {{ $tab === 'nouveau' ? '🆕 Nouveaux cours' : '📖 En cours' }}
          <span class="pill">{{ $coursesToShow->count() }}</span>
        </div>
        <div class="courses-grid {{ $view === 'list' ? 'list-view' : '' }}">
          @foreach($coursesToShow as $index => $inscription)
            @php
              $colors = [
                ['bg'=>'var(--vxl)','cat'=>'var(--v)','badge'=>'var(--v)'],
                ['bg'=>'var(--mint)','cat'=>'var(--mintd)','badge'=>'var(--mintd)'],
                ['bg'=>'var(--rose)','cat'=>'var(--rosed)','badge'=>'var(--rosed)'],
                ['bg'=>'var(--yel)','cat'=>'var(--yeld)','badge'=>'var(--yeld)'],
                ['bg'=>'var(--sky)','cat'=>'var(--skyd)','badge'=>'var(--skyd)'],
              ];
              $color = $colors[$index % count($colors)];
              $emojis = ['🎬','💻','🔐','📊','🎨','📱','🧠','📝'];
              $emoji = $emojis[$index % count($emojis)];
              $isNew = $inscription->enrolled_at && $inscription->enrolled_at->gt(now()->subDays(7)) && $inscription->progress < 10;
              $lessonsCount = $inscription->cours->chapitres->flatMap->lecons->count();
            @endphp
            <a href="{{ route('etudiant.cours.detail', $inscription->cours->id) }}" class="ccard">
              <div class="ccard-top" style="background:{{ $color['bg'] }};">
                <span class="ccard-badge" style="background:{{ $color['badge'] }};color:#fff;">
                  {{ $isNew ? 'Nouveau' : 'En cours' }}
                </span>
                <span class="ccard-emoji">{{ $emoji }}</span>
                <div class="ccard-cat" style="color:{{ $color['cat'] }};">{{ $inscription->cours->categorie?->name ?? 'Formation' }}</div>
                <div class="ccard-title">{{ $inscription->cours->title }}</div>
                <div class="ccard-sub">{{ ucfirst($inscription->cours->level ?? 'Debutant') }}</div>
                <div class="ccard-formateur">
                  <div class="mini-av" style="background:linear-gradient(135deg,{{ $color['badge'] }},{{ $color['cat'] }});">{{ $inscription->cours->formateur?->initials() ?? 'F' }}</div>
                  <div><div style="font-size:10px;color:var(--muted);">Formateur</div><strong style="font-size:12px;color:var(--txt);">{{ $inscription->cours->formateur?->name ?? 'Expert' }}</strong></div>
                </div>
              </div>
              <div class="ccard-bot">
                <div class="ccard-stats">
                  <div class="ccard-stat">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                    {{ $lessonsCount }} lecons
                  </div>
                  <div class="ccard-stat">
                    {{ $inscription->cours->chapitres?->count() ?? 0 }} chap.
                  </div>
                </div>
                <div class="prog-row">
                  <span>Progression</span>
                  <strong style="color:{{ $color['cat'] }};">{{ number_format($inscription->progress, 0) }}%</strong>
                </div>
                <div class="prog-track-sm">
                  <div class="prog-fill-sm" style="width:{{ $inscription->progress }}%;background:{{ $color['cat'] }};"></div>
                </div>
                <div class="ccard-cta">
                  <span class="cta-btn {{ $isNew ? 'new' : 'primary' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" style="width:14px;height:14px;stroke:currentColor;"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                    {{ $isNew ? 'Commencer' : 'Continuer' }}
                  </span>
                </div>
              </div>
            </a>
          @endforeach
        </div>
      </section>
      @endif
    @endif

    <!-- COMPLETED -->
    @if(($tab === 'tous' || $tab === 'termine') && $coursTermines->count() > 0)
    <section class="fu fu4">
      <div class="section-title">🎓 Cours termines <span class="pill">{{ $coursTermines->count() }}</span></div>
      <div class="completed-list">
        @foreach($coursTermines as $inscription)
          <a href="{{ route('etudiant.cours.detail', $inscription->cours->id) }}" class="comp-card">
            <div class="comp-ico" style="background:var(--mint);">🎓</div>
            <div class="comp-info">
              <div class="comp-title">{{ $inscription->cours->title }}</div>
              <div class="comp-sub">{{ $inscription->cours->categorie?->name ?? 'Formation' }} · {{ $inscription->cours->chapitres?->count() ?? 0 }} chapitres</div>
              <div class="comp-date">✅ Termine {{ $inscription->completed_at?->diffForHumans() ?? 'recemment' }}</div>
            </div>
            <div class="comp-right">
              <div class="comp-score">100 <span>%</span></div>
              @if($inscription->certificat)
                <div class="comp-cert">
                  <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                  Certificat
                </div>
              @endif
            </div>
          </a>
        @endforeach
      </div>
    </section>
    @endif

  @else
    <!-- EMPTY STATE -->
    <div class="empty-state fu fu2">
      <div class="empty-state-icon">📚</div>
      <div class="empty-state-title">
        @if(strlen($search) > 0)
          Aucun resultat pour "{{ $search }}"
        @else
          Aucun cours trouve
        @endif
      </div>
      <div class="empty-state-text">
        @if(strlen($search) > 0)
          Essayez avec d'autres termes de recherche
        @elseif($tab !== 'tous')
          Aucun cours dans cette categorie
        @else
          Tu n'es inscrit a aucun cours pour le moment
        @endif
      </div>
      @if($tab === 'tous' && strlen($search) === 0)
        <a href="{{ route('etudiant.catalogue') }}" class="empty-state-btn">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:18px;height:18px;"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          Explorer le catalogue
        </a>
      @else
        <button wire:click="$set('search', '')" wire:click="setTab('tous')" class="empty-state-btn" style="border:none;cursor:pointer;">
          Voir tous les cours
        </button>
      @endif
    </div>
  @endif

</div>
</div>
