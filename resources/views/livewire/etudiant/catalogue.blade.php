<div>
<style>
/* HEADER */
.hdr{position:sticky;top:0;z-index:50;background:rgba(245,243,255,.92);backdrop-filter:blur(14px);border-bottom:1.5px solid var(--border);padding:15px 28px;display:flex;align-items:center;gap:14px;}
.hdr-left{flex:1;}
.hdr-left h1{font-family:'Poppins',sans-serif;font-size:20px;font-weight:800;color:var(--txt);}
.hdr-left p{font-size:12px;color:var(--muted);margin-top:1px;}
.search-box{display:flex;align-items:center;gap:8px;background:#fff;border:1.5px solid var(--border);border-radius:var(--rp);padding:9px 16px;min-width:280px;box-shadow:var(--sh);transition:all .2s;}
.search-box:focus-within{box-shadow:0 0 0 3px rgba(167,139,250,.25);border-color:var(--vl);}
.search-box svg{stroke:var(--muted);width:15px;height:15px;flex-shrink:0;}
.search-box input{border:none;outline:none;background:transparent;font-family:'DM Sans',sans-serif;font-size:13px;color:var(--txt);width:100%;}
.search-box input::placeholder{color:var(--muted);}
.hdr-acts{display:flex;align-items:center;gap:9px;}
.ibtn{width:38px;height:38px;border-radius:50%;border:1.5px solid var(--border);background:#fff;display:flex;align-items:center;justify-content:center;cursor:pointer;position:relative;transition:all .2s;box-shadow:var(--sh);}
.ibtn:hover{background:var(--vxl);border-color:var(--vl);}
.ibtn svg{width:16px;height:16px;stroke:var(--muted);}
.ndot{position:absolute;top:6px;right:6px;width:7px;height:7px;border-radius:50%;background:#EF4444;border:2px solid #fff;animation:pulse 2s infinite;}
/* PAGE */
.page{padding:28px 30px;display:flex;flex-direction:column;gap:26px;}
/* HERO BANNER */
.hero-banner{background:linear-gradient(135deg,#1E1B4B 0%,#3730A3 50%,#7C3AED 100%);border-radius:var(--r);padding:32px 36px;display:flex;align-items:center;justify-content:space-between;position:relative;overflow:hidden;box-shadow:0 12px 40px rgba(30,27,75,.35);}
.hero-banner::before{content:'';position:absolute;top:-50px;right:200px;width:200px;height:200px;border-radius:50%;background:rgba(255,255,255,.04);}
.hero-banner::after{content:'';position:absolute;bottom:-40px;right:80px;width:150px;height:150px;border-radius:50%;background:rgba(255,255,255,.06);}
.hero-txt h2{font-family:'Poppins',sans-serif;font-size:24px;font-weight:800;color:#fff;margin-bottom:8px;}
.hero-txt p{font-size:14px;color:rgba(255,255,255,.8);max-width:480px;line-height:1.6;}
.hero-stats{display:flex;gap:28px;margin-top:18px;}
.hero-stat{text-align:center;}
.hero-stat-val{font-family:'Poppins',sans-serif;font-size:28px;font-weight:800;color:#fff;}
.hero-stat-lbl{font-size:11px;color:rgba(255,255,255,.7);margin-top:2px;}
.hero-emojis{font-size:56px;position:relative;z-index:2;display:flex;gap:12px;}
.hero-emojis span:nth-child(1){animation:float 3s ease-in-out infinite;}
.hero-emojis span:nth-child(2){animation:float 3s 1s ease-in-out infinite;}
.hero-emojis span:nth-child(3){animation:float 3s .5s ease-in-out infinite;}
@keyframes float{0%,100%{transform:translateY(0)}50%{transform:translateY(-8px)}}
/* FILTERS */
.filters-bar{display:flex;align-items:center;gap:12px;flex-wrap:wrap;}
.cat-pills{display:flex;gap:8px;flex-wrap:wrap;flex:1;}
.cat-pill{padding:8px 18px;border-radius:var(--rp);font-size:13px;font-weight:600;cursor:pointer;transition:all .2s;border:1.5px solid var(--border);background:#fff;color:var(--muted);white-space:nowrap;}
.cat-pill:hover{background:var(--vxl);border-color:var(--vl);color:var(--v);}
.cat-pill.active{background:var(--vgrad);color:#fff;border-color:transparent;box-shadow:0 3px 10px rgba(124,58,237,.28);}
.cat-pill .count{font-size:10px;opacity:.7;margin-left:4px;}
.filter-select{padding:9px 16px;border-radius:var(--rp);border:1.5px solid var(--border);background:#fff;font-family:'DM Sans',sans-serif;font-size:13px;color:var(--txt);cursor:pointer;box-shadow:var(--sh);transition:all .2s;min-width:160px;}
.filter-select:focus{outline:none;border-color:var(--vl);box-shadow:0 0 0 3px rgba(167,139,250,.2);}
.view-btns{display:flex;gap:4px;background:#fff;border-radius:var(--rp);padding:4px;border:1.5px solid var(--border);box-shadow:var(--sh);}
.view-btn{width:32px;height:32px;border-radius:var(--rp);display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all .2s;border:none;background:transparent;}
.view-btn svg{width:15px;height:15px;stroke:var(--muted);}
.view-btn.active{background:var(--vgrad);}
.view-btn.active svg{stroke:#fff;}
.view-btn:not(.active):hover{background:var(--vxl);}
.view-btn:not(.active):hover svg{stroke:var(--v);}
/* COURSES GRID */
.courses-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:18px;}
.courses-grid.list-view{grid-template-columns:1fr;}
.ccard{background:#fff;border-radius:var(--r);overflow:hidden;border:1.5px solid var(--border);box-shadow:var(--sh);transition:all .28s;cursor:pointer;display:flex;flex-direction:column;}
.ccard:hover{transform:translateY(-5px);box-shadow:var(--shlift);}
.courses-grid.list-view .ccard{flex-direction:row;align-items:stretch;}
.courses-grid.list-view .ccard-top{width:240px;flex-shrink:0;min-height:auto;}
.courses-grid.list-view .ccard-bot{border-top:none;border-left:1.5px solid var(--border);flex:1;}
.ccard-top{position:relative;min-height:160px;display:flex;flex-direction:column;justify-content:flex-end;padding:20px 18px;}
.ccard-thumb{position:absolute;inset:0;object-fit:cover;width:100%;height:100%;}
.ccard-overlay{position:absolute;inset:0;background:linear-gradient(to top,rgba(0,0,0,.7) 0%,transparent 60%);}
.ccard-emoji{font-size:42px;margin-bottom:8px;display:block;line-height:1;position:relative;z-index:2;}
.ccard-cat{font-size:10px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:rgba(255,255,255,.8);position:relative;z-index:2;}
.ccard-title{font-family:'Poppins',sans-serif;font-size:15px;font-weight:700;color:#fff;line-height:1.3;position:relative;z-index:2;margin-top:4px;}
.ccard-badge{position:absolute;top:14px;right:14px;font-size:10px;font-weight:700;padding:4px 10px;border-radius:var(--rp);z-index:3;}
.ccard-price{position:absolute;top:14px;left:14px;font-family:'Poppins',sans-serif;font-size:14px;font-weight:800;padding:5px 12px;border-radius:var(--rp);background:rgba(255,255,255,.95);color:var(--v);z-index:3;box-shadow:0 2px 8px rgba(0,0,0,.15);}
.ccard-bot{padding:16px 18px;display:flex;flex-direction:column;gap:12px;}
.ccard-meta{display:flex;align-items:center;gap:8px;flex-wrap:wrap;}
.ccard-level{font-size:10px;font-weight:700;padding:3px 10px;border-radius:var(--rp);}
.ccard-stat{font-size:11px;color:var(--muted);display:flex;align-items:center;gap:4px;}
.ccard-stat svg{width:12px;height:12px;stroke:var(--muted);}
.ccard-desc{font-size:12px;color:var(--muted);line-height:1.5;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;}
.ccard-footer{display:flex;align-items:center;justify-content:space-between;padding-top:12px;border-top:1px dashed var(--border);margin-top:auto;}
.ccard-formateur{display:flex;align-items:center;gap:8px;}
.mini-av{width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:700;color:#fff;flex-shrink:0;}
.ccard-f-info{font-size:11px;color:var(--muted);}
.ccard-f-info strong{display:block;font-size:12px;color:var(--txt);font-weight:600;}
.ccard-rating{display:flex;align-items:center;gap:3px;font-size:13px;font-weight:700;color:var(--yeld);}
.ccard-cta{display:flex;align-items:center;gap:8px;}
.cta-btn{flex:1;display:inline-flex;align-items:center;justify-content:center;gap:6px;padding:10px 0;border-radius:var(--rp);font-family:'DM Sans',sans-serif;font-size:13px;font-weight:700;border:none;cursor:pointer;transition:all .2s;text-decoration:none;}
.cta-btn.primary{background:var(--vgrad);color:#fff;box-shadow:0 3px 10px rgba(124,58,237,.30);}
.cta-btn.primary:hover{box-shadow:0 6px 18px rgba(124,58,237,.40);transform:translateY(-1px);}
.cta-btn.primary svg{stroke:#fff;width:13px;height:13px;}
.cta-icon{width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;border:1.5px solid var(--border);background:#fff;cursor:pointer;transition:all .2s;flex-shrink:0;}
.cta-icon:hover{background:var(--vxl);border-color:var(--vl);}
.cta-icon svg{width:14px;height:14px;stroke:var(--muted);}
/* EMPTY STATE */
.empty-state{display:flex;flex-direction:column;align-items:center;justify-content:center;padding:60px 20px;text-align:center;}
.empty-state-ico{font-size:64px;margin-bottom:16px;opacity:.6;}
.empty-state h3{font-family:'Poppins',sans-serif;font-size:18px;font-weight:700;color:var(--txt);margin-bottom:6px;}
.empty-state p{font-size:13px;color:var(--muted);max-width:320px;}
/* PAGINATION */
.pagination-wrap{display:flex;justify-content:center;padding-top:10px;}
/* RESPONSIVE */
@media(max-width:1400px){.courses-grid{grid-template-columns:repeat(3,1fr);}}
@media(max-width:1100px){.courses-grid{grid-template-columns:repeat(2,1fr);}.hero-emojis{display:none;}}
@media(max-width:900px){.hdr{padding:14px 16px;}.page{padding:18px 16px;}.filters-bar{flex-direction:column;align-items:stretch;}.cat-pills{overflow-x:auto;flex-wrap:nowrap;padding-bottom:4px;}}
@media(max-width:640px){.courses-grid{grid-template-columns:1fr;}.courses-grid.list-view .ccard{flex-direction:column;}.courses-grid.list-view .ccard-top{width:100%;}.hero-banner{flex-direction:column;text-align:center;}.hero-stats{justify-content:center;}}
</style>

<!-- HEADER -->
<header class="hdr">
  <div class="hdr-left">
    <h1>{{ "\u{1F4DA}" }} Catalogue des Cours</h1>
    <p>{{ $totalCours }} cours disponibles {{ "\u{00B7}" }} {{ $categories->count() }} categories</p>
  </div>
  <div class="search-box">
    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
    <input wire:model.live.debounce.300ms="search" type="text" placeholder="Rechercher un cours, un formateur..."/>
  </div>
  <div class="hdr-acts">
    <div class="ibtn">
      <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
      <span class="ndot"></span>
    </div>
    <div style="background:linear-gradient(135deg,#7C3AED,#A78BFA);width:38px;height:38px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;font-family:'Poppins',sans-serif;color:#fff;border:2.5px solid var(--vl);box-shadow:0 0 0 4px rgba(167,139,250,.18);">
      {{ auth()->user()->initials() }}
    </div>
  </div>
</header>

<!-- PAGE -->
<div class="page">

  <!-- HERO BANNER -->
  <div class="hero-banner fu fu1">
    <div class="hero-txt">
      <h2>{{ "\u{1F680}" }} Explore. Apprends. Evolue.</h2>
      <p>Decouvre notre collection de cours de qualite. Des formations pratiques pour booster ta carriere et developper de nouvelles competences.</p>
      <div class="hero-stats">
        <div class="hero-stat">
          <div class="hero-stat-val">{{ $totalCours }}</div>
          <div class="hero-stat-lbl">Cours</div>
        </div>
        <div class="hero-stat">
          <div class="hero-stat-val">{{ $categories->count() }}</div>
          <div class="hero-stat-lbl">Categories</div>
        </div>
        <div class="hero-stat">
          <div class="hero-stat-val">{{ $categories->sum('cours_count') > 0 ? '+'.number_format($categories->sum('cours_count') * 120) : '0' }}</div>
          <div class="hero-stat-lbl">Etudiants</div>
        </div>
      </div>
    </div>
    <div class="hero-emojis">
      <span>{{ "\u{1F3A8}" }}</span><span>{{ "\u{1F9E0}" }}</span><span>{{ "\u{1F4BB}" }}</span>
    </div>
  </div>

  <!-- FILTERS -->
  <div class="filters-bar fu fu2">
    <div class="cat-pills">
      <button wire:click="$set('showFavorites', false)" wire:click="$set('categorie_id', '')" class="cat-pill {{ $categorie_id === '' && !$showFavorites ? 'active' : '' }}">
        {{ "\u{1F4CB}" }} Tous <span class="count">({{ $totalCours }})</span>
      </button>
      @if(auth()->check())
        <button wire:click="$set('showFavorites', true)" wire:click="$set('categorie_id', '')" class="cat-pill {{ $showFavorites ? 'active' : '' }}">
          {{ "\u{2764}" }} Favoris <span class="count">({{ $favorisCount }})</span>
        </button>
      @endif
      @foreach($categories as $cat)
        <button wire:click="$set('showFavorites', false)" wire:click="$set('categorie_id', '{{ $cat->id }}')" class="cat-pill {{ $categorie_id == $cat->id && !$showFavorites ? 'active' : '' }}">
          {{ $cat->name }} <span class="count">({{ $cat->cours_count }})</span>
        </button>
      @endforeach
    </div>
    <select wire:model.live="level" class="filter-select">
      <option value="">{{ "\u{1F4CA}" }} Tous les niveaux</option>
      <option value="debutant">{{ "\u{1F331}" }} Debutant</option>
      <option value="intermediaire">{{ "\u{1F4AA}" }} Intermediaire</option>
      <option value="avance">{{ "\u{1F680}" }} Avance</option>
    </select>
    <div class="view-btns">
      <button class="view-btn active" id="gridBtn" onclick="setView('grid')">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
      </button>
      <button class="view-btn" id="listBtn" onclick="setView('list')">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
      </button>
    </div>
  </div>

  <!-- COURSES GRID -->
  @if($cours->count() > 0)
    <div class="courses-grid" id="coursesGrid">
      @foreach($cours as $index => $c)
        @php
          $colors = [
            ['bg' => 'linear-gradient(135deg,#7C3AED,#A78BFA)', 'level_bg' => 'var(--vxl)', 'level_color' => 'var(--v)'],
            ['bg' => 'linear-gradient(135deg,#0891B2,#22D3EE)', 'level_bg' => 'var(--sky)', 'level_color' => 'var(--skyd)'],
            ['bg' => 'linear-gradient(135deg,#059669,#34D399)', 'level_bg' => 'var(--mint)', 'level_color' => 'var(--mintd)'],
            ['bg' => 'linear-gradient(135deg,#DB2777,#F472B6)', 'level_bg' => 'var(--rose)', 'level_color' => 'var(--rosed)'],
            ['bg' => 'linear-gradient(135deg,#D97706,#FBBF24)', 'level_bg' => 'var(--yel)', 'level_color' => 'var(--yeld)'],
            ['bg' => 'linear-gradient(135deg,#4F46E5,#818CF8)', 'level_bg' => 'var(--sky)', 'level_color' => 'var(--skyd)'],
          ];
          $color = $colors[$index % count($colors)];
          $emojis = ["\u{1F4A1}", "\u{1F4BB}", "\u{1F3A8}", "\u{1F4CA}", "\u{1F680}", "\u{1F9E0}", "\u{1F3AC}", "\u{1F4F1}"];
          $emoji = $emojis[$index % count($emojis)];
          $chaptersCount = $c->chapitres->count();
          $lessonsCount = $c->chapitres->sum(fn($ch) => $ch->lecons->count());
        @endphp
        <div class="ccard fu fu{{ ($index % 4) + 3 }}">
          <div class="ccard-top" style="background:{{ $color['bg'] }};">
            @if($c->thumbnail)
              <img src="{{ asset('storage/'.$c->thumbnail) }}" alt="{{ $c->title }}" class="ccard-thumb">
              <div class="ccard-overlay"></div>
            @endif
            <span class="ccard-price">{{ $c->price == 0 ? 'Gratuit' : number_format($c->price, 0).' TND' }}</span>
            @if($c->inscriptions_count > 10)
              <span class="ccard-badge" style="background:var(--mintd);color:#fff;">{{ "\u{1F525}" }} Populaire</span>
            @endif
            <span class="ccard-emoji">{{ $emoji }}</span>
            <div class="ccard-cat">{{ $c->categorie?->name ?? 'Formation' }}</div>
            <div class="ccard-title">{{ $c->title }}</div>
          </div>
          <div class="ccard-bot">
            <div class="ccard-meta">
              <span class="ccard-level" style="background:{{ $color['level_bg'] }};color:{{ $color['level_color'] }};">{{ ucfirst($c->level ?? 'Tous niveaux') }}</span>
              <span class="ccard-stat">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                {{ $chaptersCount }} chap.
              </span>
              <span class="ccard-stat">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                {{ $lessonsCount }} lecons
              </span>
            </div>
            <p class="ccard-desc">{{ Str::limit($c->description, 100) }}</p>
            <div class="ccard-footer">
              <div class="ccard-formateur">
                <div class="mini-av" style="background:{{ $color['bg'] }};">{{ $c->formateur?->initials() ?? 'F' }}</div>
                <div class="ccard-f-info">
                  <span>Formateur</span>
                  <strong>{{ $c->formateur?->name ?? 'Expert' }}</strong>
                </div>
              </div>
              <div class="ccard-rating">{{ "\u{2B50}" }} 4.{{ rand(5,9) }}</div>
            </div>
            <div class="ccard-cta">
              <a href="{{ route('etudiant.cours.detail', $c->id) }}" class="cta-btn primary">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><polygon points="10 8 16 12 10 16 10 8"/></svg>
                Voir le cours
              </a>
              <div class="cta-icon" wire:click="toggleFavorite({{ $c->id }})" style="{{ in_array($c->id, $userFavorites) ? 'background: var(--vxl); border-color: var(--vl);' : '' }}">
                <svg viewBox="0 0 24 24" fill="{{ in_array($c->id, $userFavorites) ? '#7C3AED' : 'none' }}" stroke-width="2" stroke-linecap="round" style="stroke: {{ in_array($c->id, $userFavorites) ? '#7C3AED' : 'var(--muted)' }}"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/></svg>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    <!-- PAGINATION -->
    <div class="pagination-wrap">
      {{ $cours->links() }}
    </div>
  @else
    <div class="empty-state">
      <div class="empty-state-ico">{{ "\u{1F50D}" }}</div>
      <h3>Aucun cours trouve</h3>
      <p>Essayez de modifier vos filtres ou votre recherche pour trouver ce que vous cherchez.</p>
    </div>
  @endif

</div>

<script>
function setView(v) {
  const grid = document.getElementById('coursesGrid');
  const gb = document.getElementById('gridBtn');
  const lb = document.getElementById('listBtn');
  if (v === 'list') {
    grid?.classList.add('list-view');
    lb?.classList.add('active'); gb?.classList.remove('active');
  } else {
    grid?.classList.remove('list-view');
    gb?.classList.add('active'); lb?.classList.remove('active');
  }
}
</script>
</div>
