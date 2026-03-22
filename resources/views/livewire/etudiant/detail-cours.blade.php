<div>
<style>
/* HEADER */
.hdr{position:sticky;top:0;z-index:50;background:rgba(245,243,255,.92);backdrop-filter:blur(14px);border-bottom:1.5px solid var(--border);padding:15px 28px;display:flex;align-items:center;gap:14px;}
.hdr-back{display:flex;align-items:center;gap:8px;color:var(--muted);font-size:13px;font-weight:600;cursor:pointer;transition:all .2s;text-decoration:none;}
.hdr-back:hover{color:var(--v);}
.hdr-back svg{width:16px;height:16px;stroke:currentColor;}
.hdr-left{flex:1;}
.hdr-left h1{font-family:'Poppins',sans-serif;font-size:18px;font-weight:700;color:var(--txt);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:400px;}
.hdr-acts{display:flex;align-items:center;gap:9px;}
.ibtn{width:38px;height:38px;border-radius:50%;border:1.5px solid var(--border);background:#fff;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all .2s;box-shadow:var(--sh);}
.ibtn:hover{background:var(--vxl);border-color:var(--vl);}
.ibtn svg{width:16px;height:16px;stroke:var(--muted);}
/* PAGE */
.page{padding:0;}
/* HERO */
.hero{position:relative;padding:40px 30px;display:grid;grid-template-columns:1fr 380px;gap:40px;align-items:center;}
.hero::before{content:'';position:absolute;inset:0;background:linear-gradient(135deg,#1E1B4B 0%,#3730A3 50%,#7C3AED 100%);z-index:-1;}
.hero::after{content:'';position:absolute;top:-80px;right:100px;width:300px;height:300px;border-radius:50%;background:rgba(255,255,255,.04);z-index:0;}
.hero-content{position:relative;z-index:1;}
.hero-breadcrumb{display:flex;align-items:center;gap:8px;font-size:12px;color:rgba(255,255,255,.7);margin-bottom:16px;}
.hero-breadcrumb a{color:rgba(255,255,255,.7);text-decoration:none;transition:color .2s;}
.hero-breadcrumb a:hover{color:#fff;}
.hero-cat{display:inline-flex;align-items:center;gap:6px;background:rgba(255,255,255,.15);backdrop-filter:blur(8px);padding:6px 14px;border-radius:var(--rp);font-size:12px;font-weight:600;color:#fff;margin-bottom:12px;}
.hero-title{font-family:'Poppins',sans-serif;font-size:32px;font-weight:800;color:#fff;line-height:1.2;margin-bottom:14px;}
.hero-desc{font-size:14px;color:rgba(255,255,255,.85);line-height:1.7;margin-bottom:20px;max-width:560px;}
.hero-meta{display:flex;align-items:center;gap:20px;flex-wrap:wrap;}
.hero-meta-item{display:flex;align-items:center;gap:6px;font-size:13px;color:rgba(255,255,255,.9);}
.hero-meta-item svg{width:16px;height:16px;stroke:rgba(255,255,255,.7);}
.hero-rating{display:flex;align-items:center;gap:4px;font-weight:700;color:#FBBF24;}
.hero-card{position:relative;z-index:1;background:#fff;border-radius:var(--r);box-shadow:0 20px 60px rgba(0,0,0,.25);overflow:hidden;}
.hero-card-thumb{height:200px;position:relative;display:flex;align-items:center;justify-content:center;}
.hero-card-thumb img{width:100%;height:100%;object-fit:cover;}
.hero-card-thumb-placeholder{width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:72px;}
.hero-card-play{position:absolute;width:64px;height:64px;border-radius:50%;background:rgba(255,255,255,.95);display:flex;align-items:center;justify-content:center;cursor:pointer;box-shadow:0 8px 30px rgba(0,0,0,.2);transition:all .2s;}
.hero-card-play:hover{transform:scale(1.08);}
.hero-card-play svg{width:24px;height:24px;stroke:var(--v);margin-left:3px;}
.hero-card-body{padding:24px;}
.hero-card-price{display:flex;align-items:baseline;gap:10px;margin-bottom:16px;}
.hero-card-price-main{font-family:'Poppins',sans-serif;font-size:32px;font-weight:800;color:var(--v);}
.hero-card-price-old{font-size:16px;color:var(--muted);text-decoration:line-through;}
.hero-card-btn{width:100%;padding:14px;border-radius:var(--rp);font-family:'DM Sans',sans-serif;font-size:15px;font-weight:700;border:none;cursor:pointer;transition:all .2s;display:flex;align-items:center;justify-content:center;gap:8px;}
.hero-card-btn.primary{background:var(--vgrad);color:#fff;box-shadow:0 4px 16px rgba(124,58,237,.35);}
.hero-card-btn.primary:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(124,58,237,.42);}
.hero-card-btn.enrolled{background:var(--mint);color:var(--mintd);text-decoration:none;}
.hero-card-btn svg{width:18px;height:18px;stroke:currentColor;}
.hero-card-features{margin-top:20px;display:flex;flex-direction:column;gap:10px;}
.hero-card-feature{display:flex;align-items:center;gap:10px;font-size:13px;color:var(--txt);}
.hero-card-feature svg{width:18px;height:18px;stroke:var(--v);flex-shrink:0;}
/* CONTENT */
.content{padding:30px;display:grid;grid-template-columns:1fr 340px;gap:30px;}
/* STATS */
.stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:28px;}
.stat-card{background:#fff;border-radius:var(--rm);padding:18px;border:1.5px solid var(--border);box-shadow:var(--sh);text-align:center;transition:all .2s;}
.stat-card:hover{transform:translateY(-3px);box-shadow:var(--shlift);}
.stat-ico{font-size:24px;margin-bottom:8px;}
.stat-val{font-family:'Poppins',sans-serif;font-size:24px;font-weight:800;color:var(--txt);}
.stat-lbl{font-size:11px;color:var(--muted);margin-top:2px;}
/* SECTIONS */
.section{margin-bottom:28px;}
.section-title{font-family:'Poppins',sans-serif;font-size:18px;font-weight:700;color:var(--txt);margin-bottom:16px;display:flex;align-items:center;gap:10px;}
.section-title .pill{font-size:11px;font-weight:700;padding:3px 10px;border-radius:var(--rp);background:var(--vxl);color:var(--v);}
/* CURRICULUM */
.curriculum{display:flex;flex-direction:column;gap:12px;}
.chapter{background:#fff;border-radius:var(--rm);border:1.5px solid var(--border);box-shadow:var(--sh);overflow:hidden;}
.chapter-header{padding:16px 20px;display:flex;align-items:center;gap:14px;cursor:pointer;transition:all .2s;}
.chapter-header:hover{background:var(--vxl);}
.chapter.open .chapter-header{background:var(--vxl);border-bottom:1.5px solid var(--border);}
.chapter-num{width:36px;height:36px;border-radius:10px;background:var(--vgrad);display:flex;align-items:center;justify-content:center;font-family:'Poppins',sans-serif;font-size:14px;font-weight:800;color:#fff;flex-shrink:0;}
.chapter-info{flex:1;}
.chapter-title{font-family:'Poppins',sans-serif;font-size:14px;font-weight:700;color:var(--txt);}
.chapter-meta{font-size:11px;color:var(--muted);margin-top:2px;}
.chapter-toggle{width:28px;height:28px;border-radius:50%;background:var(--bg);display:flex;align-items:center;justify-content:center;transition:all .2s;}
.chapter-toggle svg{width:14px;height:14px;stroke:var(--muted);transition:transform .2s;}
.chapter.open .chapter-toggle svg{transform:rotate(180deg);}
.chapter-lessons{display:none;padding:0;}
.chapter.open .chapter-lessons{display:block;}
.lesson{display:flex;align-items:center;gap:12px;padding:14px 20px;border-bottom:1px solid var(--border);transition:all .2s;cursor:pointer;}
.lesson:last-child{border-bottom:none;}
.lesson:hover{background:rgba(124,58,237,.03);}
.lesson-ico{width:32px;height:32px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0;}
.lesson-info{flex:1;}
.lesson-title{font-size:13px;font-weight:500;color:var(--txt);}
.lesson-type{font-size:10px;color:var(--muted);margin-top:2px;}
.lesson-duration{font-size:12px;color:var(--muted);display:flex;align-items:center;gap:4px;}
.lesson-duration svg{width:12px;height:12px;stroke:var(--muted);}
.lesson-lock{width:24px;height:24px;display:flex;align-items:center;justify-content:center;}
.lesson-lock svg{width:14px;height:14px;stroke:var(--muted);}
/* SIDEBAR */
.sidebar{display:flex;flex-direction:column;gap:20px;}
/* INSTRUCTOR */
.instructor-card{background:#fff;border-radius:var(--r);border:1.5px solid var(--border);box-shadow:var(--sh);padding:24px;}
.instructor-header{display:flex;align-items:center;gap:14px;margin-bottom:16px;}
.instructor-av{width:56px;height:56px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-family:'Poppins',sans-serif;font-size:20px;font-weight:800;color:#fff;flex-shrink:0;}
.instructor-info h4{font-family:'Poppins',sans-serif;font-size:16px;font-weight:700;color:var(--txt);}
.instructor-info p{font-size:12px;color:var(--muted);margin-top:2px;}
.instructor-bio{font-size:13px;color:var(--muted);line-height:1.6;margin-bottom:16px;}
.instructor-stats{display:grid;grid-template-columns:repeat(2,1fr);gap:10px;}
.instructor-stat{text-align:center;padding:12px;border-radius:var(--rm);background:var(--bg);}
.instructor-stat-val{font-family:'Poppins',sans-serif;font-size:16px;font-weight:800;color:var(--txt);}
.instructor-stat-lbl{font-size:10px;color:var(--muted);margin-top:2px;}
/* REVIEWS MINI */
.reviews-card{background:#fff;border-radius:var(--r);border:1.5px solid var(--border);box-shadow:var(--sh);padding:24px;}
.reviews-summary{display:flex;align-items:center;gap:16px;margin-bottom:20px;padding-bottom:16px;border-bottom:1.5px solid var(--border);}
.reviews-avg{text-align:center;}
.reviews-avg-val{font-family:'Poppins',sans-serif;font-size:36px;font-weight:800;color:var(--txt);}
.reviews-avg-stars{color:#FBBF24;font-size:14px;margin-top:4px;}
.reviews-avg-count{font-size:11px;color:var(--muted);margin-top:2px;}
.reviews-bars{flex:1;display:flex;flex-direction:column;gap:6px;}
.review-bar-row{display:flex;align-items:center;gap:8px;font-size:11px;color:var(--muted);}
.review-bar{flex:1;height:6px;background:var(--bg);border-radius:var(--rp);overflow:hidden;}
.review-bar-fill{height:100%;background:var(--yel);border-radius:var(--rp);}
.review-item{display:flex;gap:12px;padding:14px 0;border-bottom:1px dashed var(--border);}
.review-item:last-child{border-bottom:none;padding-bottom:0;}
.review-av{width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:#fff;flex-shrink:0;}
.review-content{flex:1;}
.review-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:4px;}
.review-name{font-size:13px;font-weight:600;color:var(--txt);}
.review-rating{color:#FBBF24;font-size:12px;}
.review-text{font-size:12px;color:var(--muted);line-height:1.5;}
.review-date{font-size:10px;color:var(--muted);margin-top:6px;}
/* REVIEW FORM */
.review-form{background:#fff;border-radius:var(--r);border:1.5px solid var(--border);box-shadow:var(--sh);padding:24px;margin-bottom:28px;}
.review-form-title{font-family:'Poppins',sans-serif;font-size:16px;font-weight:700;color:var(--txt);margin-bottom:16px;display:flex;align-items:center;gap:10px;}
.star-rating{display:flex;gap:6px;margin-bottom:16px;}
.star{font-size:28px;cursor:pointer;transition:all .15s;opacity:.3;}
.star:hover,.star.active{opacity:1;transform:scale(1.1);}
.star.active{animation:starPop .3s ease;}
@keyframes starPop{0%{transform:scale(1);}50%{transform:scale(1.3);}100%{transform:scale(1.1);}}
.review-textarea{width:100%;min-height:100px;padding:14px;border:1.5px solid var(--border);border-radius:var(--rm);font-family:'DM Sans',sans-serif;font-size:14px;resize:vertical;transition:all .2s;}
.review-textarea:focus{outline:none;border-color:var(--vl);box-shadow:0 0 0 3px rgba(124,58,237,.1);}
.review-textarea::placeholder{color:var(--muted);}
.review-actions{display:flex;gap:10px;margin-top:16px;}
.review-btn{padding:12px 24px;border-radius:var(--rp);font-family:'DM Sans',sans-serif;font-size:14px;font-weight:600;border:none;cursor:pointer;transition:all .2s;display:flex;align-items:center;gap:8px;}
.review-btn.primary{background:var(--vgrad);color:#fff;box-shadow:0 4px 12px rgba(124,58,237,.3);}
.review-btn.primary:hover{transform:translateY(-2px);box-shadow:0 6px 18px rgba(124,58,237,.4);}
.review-btn.secondary{background:var(--bg);color:var(--muted);border:1.5px solid var(--border);}
.review-btn.secondary:hover{background:var(--vxl);color:var(--v);border-color:var(--vl);}
.review-btn.danger{background:var(--peach);color:var(--peachd);}
.review-btn.danger:hover{background:#FED7D7;color:#C53030;}
.review-btn svg{width:16px;height:16px;stroke:currentColor;}
.user-review-badge{display:inline-flex;align-items:center;gap:6px;padding:4px 12px;border-radius:var(--rp);background:var(--mint);color:var(--mintd);font-size:12px;font-weight:600;}
.review-prompt{background:linear-gradient(135deg,var(--vxl),#F5F3FF);border:1.5px dashed var(--vl);border-radius:var(--rm);padding:20px;text-align:center;cursor:pointer;transition:all .2s;}
.review-prompt:hover{background:var(--vxl);border-color:var(--v);}
.review-prompt-ico{font-size:32px;margin-bottom:8px;}
.review-prompt-text{font-size:14px;color:var(--v);font-weight:600;}
.review-prompt-sub{font-size:12px;color:var(--muted);margin-top:4px;}
/* ALL REVIEWS */
.all-reviews{background:#fff;border-radius:var(--r);border:1.5px solid var(--border);box-shadow:var(--sh);padding:24px;}
.all-reviews-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;padding-bottom:16px;border-bottom:1.5px solid var(--border);}
.reviews-title{font-family:'Poppins',sans-serif;font-size:18px;font-weight:700;color:var(--txt);display:flex;align-items:center;gap:10px;}
.reviews-title .count{font-size:13px;font-weight:600;padding:4px 12px;border-radius:var(--rp);background:var(--vxl);color:var(--v);}
.review-card{padding:20px;border-radius:var(--rm);border:1.5px solid var(--border);margin-bottom:14px;transition:all .2s;}
.review-card:hover{border-color:var(--vl);background:rgba(124,58,237,.02);}
.review-card:last-child{margin-bottom:0;}
.review-card-header{display:flex;align-items:center;gap:14px;margin-bottom:12px;}
.review-card-avatar{width:44px;height:44px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-family:'Poppins',sans-serif;font-size:16px;font-weight:700;color:#fff;flex-shrink:0;}
.review-card-info{flex:1;}
.review-card-name{font-family:'Poppins',sans-serif;font-size:14px;font-weight:600;color:var(--txt);}
.review-card-meta{display:flex;align-items:center;gap:10px;margin-top:3px;}
.review-card-stars{color:#FBBF24;font-size:13px;}
.review-card-date{font-size:11px;color:var(--muted);}
.review-card-text{font-size:14px;color:var(--txt);line-height:1.7;}
.no-reviews{text-align:center;padding:40px 20px;color:var(--muted);}
.no-reviews-ico{font-size:48px;margin-bottom:12px;}
.no-reviews-text{font-size:14px;}
/* PROGRESS CARD */
.progress-card{background:linear-gradient(135deg,var(--v),#A78BFA);border-radius:var(--r);padding:24px;color:#fff;}
.progress-card h4{font-family:'Poppins',sans-serif;font-size:16px;font-weight:700;margin-bottom:12px;}
.progress-bar-wrap{margin-bottom:12px;}
.progress-bar-bg{height:10px;background:rgba(255,255,255,.25);border-radius:var(--rp);overflow:hidden;}
.progress-bar-fill{height:100%;background:#fff;border-radius:var(--rp);transition:width .3s;}
.progress-info{display:flex;justify-content:space-between;font-size:12px;opacity:.9;}
.progress-btn{width:100%;margin-top:16px;padding:12px;border-radius:var(--rp);background:#fff;color:var(--v);font-family:'DM Sans',sans-serif;font-size:14px;font-weight:700;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;transition:all .2s;text-decoration:none;}
.progress-btn:hover{transform:translateY(-2px);box-shadow:0 6px 20px rgba(0,0,0,.15);}
.progress-btn svg{width:16px;height:16px;stroke:var(--v);}
/* FLASH */
.flash{padding:14px 20px;border-radius:var(--rm);margin:20px 30px 0;display:flex;align-items:center;gap:10px;font-size:13px;font-weight:500;}
.flash.success{background:var(--mint);color:var(--mintd);}
/* RESPONSIVE */
@media(max-width:1100px){.hero{grid-template-columns:1fr;padding:30px;}.hero-card{max-width:400px;}.content{grid-template-columns:1fr;}.sidebar{order:-1;}}
@media(max-width:900px){.stats-grid{grid-template-columns:repeat(2,1fr);}}
@media(max-width:600px){.hero{padding:20px;}.hero-title{font-size:24px;}.content{padding:20px;}.stats-grid{grid-template-columns:1fr 1fr;}}
</style>

<!-- HEADER -->
<header class="hdr">
  <a href="{{ route('etudiant.catalogue') }}" class="hdr-back">
    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
    Retour au catalogue
  </a>
  <div class="hdr-left">
    <h1>{{ $cours->title }}</h1>
  </div>
  <div class="hdr-acts">
    <div class="ibtn" onclick="showToast('{{ "\u{1F516}" }} Cours mis en favori !')">
      <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/></svg>
    </div>
    <div class="ibtn" onclick="showToast('{{ "\u{1F517}" }} Lien copie !')">
      <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
    </div>
    <div style="background:linear-gradient(135deg,#7C3AED,#A78BFA);width:38px;height:38px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;font-family:'Poppins',sans-serif;color:#fff;">
      {{ auth()->user()->initials() }}
    </div>
  </div>
</header>

<!-- FLASH MESSAGE -->
@if(session('success'))
  <div class="flash success">
    {{ "\u{2705}" }} {{ session('success') }}
  </div>
@endif

<!-- PAGE -->
<div class="page">

  <!-- HERO -->
  <div class="hero">
    <div class="hero-content">
      <div class="hero-breadcrumb">
        <a href="{{ route('etudiant.catalogue') }}">Catalogue</a>
        <span>{{ "\u{203A}" }}</span>
        <a href="{{ route('etudiant.catalogue') }}?categorie_id={{ $cours->categorie_id }}">{{ $cours->categorie?->name ?? 'Formation' }}</a>
        <span>{{ "\u{203A}" }}</span>
        <span>{{ Str::limit($cours->title, 30) }}</span>
      </div>
      <div class="hero-cat">
        {{ "\u{1F4DA}" }} {{ $cours->categorie?->name ?? 'Formation' }}
      </div>
      <h1 class="hero-title">{{ $cours->title }}</h1>
      <p class="hero-desc">{{ Str::limit($cours->description, 200) }}</p>
      <div class="hero-meta">
        <div class="hero-meta-item hero-rating">
          {{ "\u{2B50}" }} {{ number_format($avgRating, 1) }}
          <span style="color:rgba(255,255,255,.7);font-weight:400;">({{ $avis->count() }} avis)</span>
        </div>
        <div class="hero-meta-item">
          <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
          {{ number_format($studentsCount) }} etudiants
        </div>
        <div class="hero-meta-item">
          <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
          {{ $totalDuration > 60 ? floor($totalDuration / 60).'h '.($totalDuration % 60).'min' : $totalDuration.' min' }}
        </div>
        <div class="hero-meta-item">
          <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
          Mis a jour {{ $cours->updated_at->diffForHumans() }}
        </div>
      </div>
    </div>

    <div class="hero-card">
      <div class="hero-card-thumb" style="background:linear-gradient(135deg,#7C3AED,#A78BFA);">
        @if($cours->thumbnail)
          <img src="{{ asset('storage/'.$cours->thumbnail) }}" alt="{{ $cours->title }}">
        @else
          <div class="hero-card-thumb-placeholder">{{ "\u{1F3AC}" }}</div>
        @endif
        <div class="hero-card-play">
          <svg viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round"><polygon points="5 3 19 12 5 21 5 3"/></svg>
        </div>
      </div>
      <div class="hero-card-body">
        <div class="hero-card-price">
          <span class="hero-card-price-main">{{ $cours->price == 0 ? 'Gratuit' : number_format($cours->price, 0).' TND' }}</span>
          @if($cours->price > 0)
            <span class="hero-card-price-old">{{ number_format($cours->price * 1.5, 0) }} TND</span>
          @endif
        </div>

        @if($dejaInscrit)
          <a href="{{ route('etudiant.mes-cours') }}" class="hero-card-btn enrolled">
            {{ "\u{2705}" }} Deja inscrit - Continuer
          </a>
        @else
          <button wire:click="inscrire" wire:loading.attr="disabled" class="hero-card-btn primary">
            <span wire:loading.remove>
              <svg viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
              S'inscrire maintenant
            </span>
            <span wire:loading>Inscription...</span>
          </button>
        @endif

        <div class="hero-card-features">
          <div class="hero-card-feature">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>
            {{ $chaptersCount }} chapitres {{ "\u{00B7}" }} {{ $lessonsCount }} lecons
          </div>
          <div class="hero-card-feature">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>
            {{ $quizzesCount }} quiz {{ "\u{00B7}" }} {{ $questionsCount }} questions
          </div>
          <div class="hero-card-feature">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>
            Acces illimite a vie
          </div>
          <div class="hero-card-feature">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>
            Certificat de completion
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- CONTENT -->
  <div class="content">
    <div class="main-content">

      <!-- STATS -->
      <div class="stats-grid">
        <div class="stat-card" style="border-top:3px solid var(--v);">
          <div class="stat-ico">{{ "\u{1F4DA}" }}</div>
          <div class="stat-val">{{ $chaptersCount }}</div>
          <div class="stat-lbl">Chapitres</div>
        </div>
        <div class="stat-card" style="border-top:3px solid var(--skyd);">
          <div class="stat-ico">{{ "\u{1F3AC}" }}</div>
          <div class="stat-val">{{ $lessonsCount }}</div>
          <div class="stat-lbl">Lecons</div>
        </div>
        <div class="stat-card" style="border-top:3px solid var(--mintd);">
          <div class="stat-ico">{{ "\u{1F9E0}" }}</div>
          <div class="stat-val">{{ $quizzesCount }}</div>
          <div class="stat-lbl">Quiz</div>
        </div>
        <div class="stat-card" style="border-top:3px solid var(--yeld);">
          <div class="stat-ico">{{ "\u{1F464}" }}</div>
          <div class="stat-val">{{ number_format($studentsCount) }}</div>
          <div class="stat-lbl">Etudiants</div>
        </div>
      </div>

      <!-- CURRICULUM -->
      <div class="section">
        <div class="section-title">
          {{ "\u{1F4CB}" }} Programme du cours
          <span class="pill">{{ $chaptersCount }} chapitres</span>
        </div>
        <div class="curriculum">
          @forelse($cours->chapitres->sortBy('order') as $index => $chapitre)
            <div class="chapter {{ $index === 0 ? 'open' : '' }}" onclick="this.classList.toggle('open')">
              <div class="chapter-header">
                <div class="chapter-num">{{ $index + 1 }}</div>
                <div class="chapter-info">
                  <div class="chapter-title">{{ $chapitre->title }}</div>
                  <div class="chapter-meta">{{ $chapitre->lecons->count() }} lecons {{ "\u{00B7}" }} {{ $chapitre->lecons->sum('duration') ?? 0 }} min</div>
                </div>
                <div class="chapter-toggle">
                  <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><polyline points="6 9 12 15 18 9"/></svg>
                </div>
              </div>
              <div class="chapter-lessons">
                @forelse($chapitre->lecons->sortBy('order') as $lecon)
                  @php
                    $lessonIcons = [
                      'video' => ['ico' => "\u{1F3AC}", 'bg' => 'var(--vxl)'],
                      'document' => ['ico' => "\u{1F4C4}", 'bg' => 'var(--sky)'],
                      'text' => ['ico' => "\u{1F4DD}", 'bg' => 'var(--mint)'],
                    ];
                    $lessonStyle = $lessonIcons[$lecon->type] ?? ['ico' => "\u{1F4DA}", 'bg' => 'var(--bg)'];
                  @endphp
                  <div class="lesson">
                    <div class="lesson-ico" style="background:{{ $lessonStyle['bg'] }};">{{ $lessonStyle['ico'] }}</div>
                    <div class="lesson-info">
                      <div class="lesson-title">{{ $lecon->title }}</div>
                      <div class="lesson-type">{{ ucfirst($lecon->type ?? 'Lecon') }}</div>
                    </div>
                    <div class="lesson-duration">
                      <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                      {{ $lecon->duration ?? 0 }} min
                    </div>
                    @if(!$dejaInscrit)
                      <div class="lesson-lock">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                      </div>
                    @endif
                  </div>
                @empty
                  <div class="lesson" style="justify-content:center;color:var(--muted);">
                    Aucune lecon dans ce chapitre
                  </div>
                @endforelse
              </div>
            </div>
          @empty
            <div style="background:#fff;border-radius:var(--rm);padding:40px;text-align:center;border:1.5px solid var(--border);">
              <div style="font-size:48px;margin-bottom:12px;">{{ "\u{1F4DA}" }}</div>
              <div style="font-size:14px;color:var(--muted);">Le programme sera bientot disponible</div>
            </div>
          @endforelse
        </div>
      </div>

      <!-- DESCRIPTION -->
      <div class="section">
        <div class="section-title">{{ "\u{1F4DD}" }} Description du cours</div>
        <div style="background:#fff;border-radius:var(--r);padding:24px;border:1.5px solid var(--border);box-shadow:var(--sh);">
          <p style="font-size:14px;color:var(--txt);line-height:1.8;">{{ $cours->description }}</p>
        </div>
      </div>

      <!-- REVIEW FORM (for enrolled students) -->
      @if($dejaInscrit)
        <div class="section">
          <div class="section-title">
            {{ "\u{270D}" }} {{ $hasReviewed ? 'Mon avis' : 'Donner mon avis' }}
            @if($hasReviewed)
              <span class="user-review-badge">{{ "\u{2705}" }} Avis publie</span>
            @endif
          </div>

          @if($showReviewForm || !$hasReviewed)
            <div class="review-form">
              <div class="review-form-title">
                {{ "\u{2B50}" }} {{ $hasReviewed ? 'Modifier mon avis' : 'Evaluer ce cours' }}
              </div>

              <!-- Star Rating -->
              <div class="star-rating">
                @for($i = 1; $i <= 5; $i++)
                  <span
                    class="star {{ $rating >= $i ? 'active' : '' }}"
                    wire:click="setRating({{ $i }})"
                  >{{ "\u{2B50}" }}</span>
                @endfor
                <span style="font-size:14px;color:var(--muted);margin-left:10px;">
                  @switch($rating)
                    @case(1) Decevant @break
                    @case(2) Peut mieux faire @break
                    @case(3) Correct @break
                    @case(4) Tres bien @break
                    @case(5) Excellent ! @break
                  @endswitch
                </span>
              </div>

              <!-- Comment -->
              <textarea
                wire:model="comment"
                class="review-textarea"
                placeholder="Partagez votre experience avec ce cours... (optionnel)"
                maxlength="1000"
              ></textarea>
              <div style="font-size:11px;color:var(--muted);margin-top:6px;">{{ strlen($comment) }}/1000 caracteres</div>

              <!-- Actions -->
              <div class="review-actions">
                <button wire:click="submitReview" wire:loading.attr="disabled" class="review-btn primary">
                  <span wire:loading.remove wire:target="submitReview">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>
                    {{ $hasReviewed ? 'Mettre a jour' : 'Publier mon avis' }}
                  </span>
                  <span wire:loading wire:target="submitReview">Publication...</span>
                </button>
                @if($hasReviewed)
                  <button wire:click="toggleReviewForm" class="review-btn secondary">Annuler</button>
                  <button wire:click="deleteReview" wire:loading.attr="disabled" class="review-btn danger" onclick="return confirm('Supprimer votre avis ?')">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                    Supprimer
                  </button>
                @endif
              </div>
            </div>
          @else
            <!-- Show current review with edit option -->
            <div class="review-form" style="cursor:pointer;" wire:click="toggleReviewForm">
              <div style="display:flex;align-items:center;gap:14px;">
                <div style="font-size:32px;">{{ "\u{2B50}" }}</div>
                <div style="flex:1;">
                  <div style="font-size:18px;color:#FBBF24;margin-bottom:4px;">
                    {{ str_repeat("\u{2B50}", $userReview->rating) }}
                  </div>
                  @if($userReview->comment)
                    <p style="font-size:14px;color:var(--txt);line-height:1.6;">{{ $userReview->comment }}</p>
                  @else
                    <p style="font-size:13px;color:var(--muted);font-style:italic;">Aucun commentaire</p>
                  @endif
                  <div style="font-size:11px;color:var(--muted);margin-top:8px;">
                    Publie {{ $userReview->created_at->diffForHumans() }} · Cliquez pour modifier
                  </div>
                </div>
                <svg viewBox="0 0 24 24" fill="none" stroke="var(--muted)" stroke-width="2" stroke-linecap="round" style="width:20px;height:20px;"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
              </div>
            </div>
          @endif
        </div>
      @else
        <!-- Prompt to enroll to leave review -->
        <div class="section">
          <div class="section-title">{{ "\u{2B50}" }} Avis etudiants</div>
          <div class="review-prompt" onclick="document.querySelector('.hero-card-btn').click()">
            <div class="review-prompt-ico">{{ "\u{1F512}" }}</div>
            <div class="review-prompt-text">Inscrivez-vous pour laisser un avis</div>
            <div class="review-prompt-sub">Partagez votre experience apres avoir suivi ce cours</div>
          </div>
        </div>
      @endif

      <!-- ALL REVIEWS -->
      <div class="section">
        <div class="all-reviews">
          <div class="all-reviews-header">
            <div class="reviews-title">
              {{ "\u{1F4AC}" }} Tous les avis
              <span class="count">{{ $avis->count() }}</span>
            </div>
            @if($avis->count() > 0)
              <div style="display:flex;align-items:center;gap:8px;">
                <span style="font-family:'Poppins',sans-serif;font-size:24px;font-weight:800;color:var(--txt);">{{ number_format($avgRating, 1) }}</span>
                <span style="color:#FBBF24;">{{ str_repeat("\u{2B50}", (int)round($avgRating)) }}</span>
              </div>
            @endif
          </div>

          @if($avis->count() > 0)
            <!-- Rating distribution -->
            <div style="display:grid;grid-template-columns:repeat(5,1fr);gap:10px;margin-bottom:24px;padding:16px;background:var(--bg);border-radius:var(--rm);">
              @for($i = 5; $i >= 1; $i--)
                <div style="text-align:center;">
                  <div style="font-size:12px;color:var(--muted);margin-bottom:4px;">{{ $i }} {{ "\u{2B50}" }}</div>
                  <div style="height:40px;background:var(--vxl);border-radius:var(--rp);overflow:hidden;display:flex;flex-direction:column-reverse;">
                    <div style="height:{{ $ratingDistribution[$i]['percent'] }}%;background:{{ $i >= 4 ? 'var(--mintd)' : ($i >= 3 ? 'var(--yeld)' : 'var(--peachd)') }};border-radius:var(--rp);transition:height .3s;"></div>
                  </div>
                  <div style="font-size:11px;font-weight:600;color:var(--txt);margin-top:4px;">{{ $ratingDistribution[$i]['count'] }}</div>
                </div>
              @endfor
            </div>

            <!-- Reviews list -->
            @php
              $avatarColors = ['#7C3AED', '#0891B2', '#059669', '#DB2777', '#D97706', '#4F46E5', '#0D9488'];
            @endphp
            @foreach($avis as $index => $review)
              <div class="review-card">
                <div class="review-card-header">
                  <div class="review-card-avatar" style="background:{{ $avatarColors[$index % count($avatarColors)] }};">
                    {{ strtoupper(substr($review->inscription?->etudiant?->name ?? 'A', 0, 1)) }}
                  </div>
                  <div class="review-card-info">
                    <div class="review-card-name">
                      {{ $review->inscription?->etudiant?->name ?? 'Etudiant' }}
                      @if($review->inscription?->etudiant_id === auth()->id())
                        <span style="font-size:11px;padding:2px 8px;background:var(--vxl);color:var(--v);border-radius:var(--rp);margin-left:8px;">Vous</span>
                      @endif
                    </div>
                    <div class="review-card-meta">
                      <span class="review-card-stars">{{ str_repeat("\u{2B50}", $review->rating) }}{{ str_repeat("\u{2606}", 5 - $review->rating) }}</span>
                      <span class="review-card-date">{{ $review->created_at->diffForHumans() }}</span>
                    </div>
                  </div>
                </div>
                @if($review->comment)
                  <p class="review-card-text">{{ $review->comment }}</p>
                @else
                  <p style="font-size:13px;color:var(--muted);font-style:italic;">Cet etudiant n'a pas laisse de commentaire.</p>
                @endif
              </div>
            @endforeach
          @else
            <div class="no-reviews">
              <div class="no-reviews-ico">{{ "\u{1F4AD}" }}</div>
              <div class="no-reviews-text">Aucun avis pour le moment. Soyez le premier a evaluer ce cours !</div>
            </div>
          @endif
        </div>
      </div>

    </div>

    <!-- SIDEBAR -->
    <div class="sidebar">

      @if($dejaInscrit && $inscription)
        <!-- PROGRESS CARD -->
        <div class="progress-card">
          <h4>{{ "\u{1F4C8}" }} Ta progression</h4>
          <div class="progress-bar-wrap">
            <div class="progress-bar-bg">
              <div class="progress-bar-fill" style="width:{{ $inscription->progress ?? 0 }}%"></div>
            </div>
          </div>
          <div class="progress-info">
            <span>{{ $inscription->progress ?? 0 }}% complete</span>
            <span>{{ 100 - ($inscription->progress ?? 0) }}% restant</span>
          </div>
          <a href="{{ route('etudiant.mes-cours') }}" class="progress-btn">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round"><polygon points="5 3 19 12 5 21 5 3"/></svg>
            Continuer le cours
          </a>
        </div>
      @endif

      <!-- INSTRUCTOR -->
      <div class="instructor-card">
        <div class="section-title" style="margin-bottom:16px;">{{ "\u{1F468}\u{200D}\u{1F3EB}" }} Formateur</div>
        <div class="instructor-header">
          <div class="instructor-av" style="background:linear-gradient(135deg,#7C3AED,#A78BFA);">
            {{ $cours->formateur?->initials() ?? 'F' }}
          </div>
          <div class="instructor-info">
            <h4>{{ $cours->formateur?->name ?? 'Expert' }}</h4>
            <p>Formateur certifie</p>
          </div>
        </div>
        <p class="instructor-bio">
          Expert passionne avec plusieurs annees d'experience dans le domaine. Specialise dans l'accompagnement des apprenants vers la reussite.
        </p>
        <div class="instructor-stats">
          <div class="instructor-stat">
            <div class="instructor-stat-val">{{ $cours->formateur?->cours()->count() ?? 1 }}</div>
            <div class="instructor-stat-lbl">Cours</div>
          </div>
          <div class="instructor-stat">
            <div class="instructor-stat-val">{{ "\u{2B50}" }} 4.8</div>
            <div class="instructor-stat-lbl">Note moyenne</div>
          </div>
        </div>
      </div>

      <!-- REVIEWS -->
      <div class="reviews-card">
        <div class="section-title" style="margin-bottom:16px;">{{ "\u{2B50}" }} Avis etudiants</div>
        <div class="reviews-summary">
          <div class="reviews-avg">
            <div class="reviews-avg-val">{{ $avis->count() > 0 ? number_format($avgRating, 1) : '-' }}</div>
            <div class="reviews-avg-stars">{{ $avis->count() > 0 ? str_repeat("\u{2B50}", (int)round($avgRating)) : '' }}</div>
            <div class="reviews-avg-count">{{ $avis->count() }} avis</div>
          </div>
          <div class="reviews-bars">
            @for($i = 5; $i >= 1; $i--)
              <div class="review-bar-row">
                <span>{{ $i }}</span>
                <div class="review-bar"><div class="review-bar-fill" style="width:{{ $ratingDistribution[$i]['percent'] }}%"></div></div>
                <span>{{ $ratingDistribution[$i]['count'] }}</span>
              </div>
            @endfor
          </div>
        </div>

        @forelse($avis->take(3) as $review)
          @php $reviewColors = ['#7C3AED', '#0891B2', '#059669', '#DB2777', '#D97706']; @endphp
          <div class="review-item">
            <div class="review-av" style="background:{{ $reviewColors[array_rand($reviewColors)] }};">
              {{ strtoupper(substr($review->inscription?->etudiant?->name ?? 'A', 0, 1)) }}
            </div>
            <div class="review-content">
              <div class="review-header">
                <span class="review-name">{{ $review->inscription?->etudiant?->name ?? 'Anonyme' }}</span>
                <span class="review-rating">{{ str_repeat("\u{2B50}", $review->rating) }}</span>
              </div>
              <p class="review-text">{{ $review->comment ? Str::limit($review->comment, 100) : 'Aucun commentaire.' }}</p>
              <div class="review-date">{{ $review->created_at->diffForHumans() }}</div>
            </div>
          </div>
        @empty
          <div style="text-align:center;padding:20px;color:var(--muted);font-size:13px;">
            {{ "\u{1F4AC}" }} Aucun avis pour le moment
          </div>
        @endforelse

        @if($avis->count() > 3)
          <div style="text-align:center;margin-top:16px;">
            <a href="#all-reviews" style="font-size:13px;color:var(--v);font-weight:600;text-decoration:none;">
              Voir tous les avis ({{ $avis->count() }}) {{ "\u{2192}" }}
            </a>
          </div>
        @endif
      </div>

    </div>
  </div>

</div>
</div>
