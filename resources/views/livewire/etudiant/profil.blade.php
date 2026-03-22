<div>
<style>
/* HEADER */
.hdr{position:sticky;top:0;z-index:50;background:rgba(245,243,255,.92);backdrop-filter:blur(14px);border-bottom:1.5px solid var(--border);padding:15px 28px;display:flex;align-items:center;gap:14px;}
.hdr h1{font-family:'Poppins',sans-serif;font-size:20px;font-weight:800;color:var(--txt);flex:1;}
.edit-btn{display:flex;align-items:center;gap:6px;background:var(--vgrad);color:#fff;border:none;padding:9px 20px;border-radius:var(--rp);font-family:'DM Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;box-shadow:0 4px 14px rgba(124,58,237,.3);transition:all .2s;}
.edit-btn:hover{transform:translateY(-1px);}
.edit-btn svg{width:14px;height:14px;stroke:#fff;}
.ibtn{width:38px;height:38px;border-radius:50%;border:1.5px solid var(--border);background:#fff;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all .2s;box-shadow:var(--sh);position:relative;}
.ibtn:hover{background:var(--vxl);border-color:var(--vl);}
.ibtn svg{width:16px;height:16px;stroke:var(--muted);}
.ndot{position:absolute;top:6px;right:6px;width:7px;height:7px;border-radius:50%;background:#EF4444;border:2px solid #fff;animation:pulse 2s infinite;}

/* PAGE */
.page{padding:0;}
.prof-layout{display:grid;grid-template-columns:340px 1fr;gap:0;min-height:calc(100vh - 72px);}

/* Animations */
@keyframes spin{to{transform:rotate(360deg)}}
@keyframes barGrow{from{width:0}to{width:var(--w)}}
@keyframes float{0%,100%{transform:translateY(0)}50%{transform:translateY(-7px)}}

/* LEFT PANEL */
.prof-left{background:#fff;border-right:1.5px solid var(--border);padding:28px 24px;display:flex;flex-direction:column;gap:22px;position:sticky;top:72px;height:calc(100vh - 72px);overflow-y:auto;}

/* Avatar section */
.prof-avatar-wrap{display:flex;flex-direction:column;align-items:center;text-align:center;}
.prof-av-ring{position:relative;width:110px;height:110px;margin-bottom:14px;}
.prof-av{width:110px;height:110px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-family:'Poppins',sans-serif;font-weight:900;font-size:38px;color:#fff;background:linear-gradient(135deg,#7C3AED,#A78BFA);box-shadow:0 8px 28px rgba(124,58,237,.3);position:relative;z-index:1;}
.prof-av-ring::before{content:'';position:absolute;inset:-4px;border-radius:50%;background:linear-gradient(135deg,#7C3AED,#A78BFA,#DB2777);opacity:.3;animation:spin 4s linear infinite;}
.prof-av-edit{position:absolute;bottom:4px;right:4px;width:30px;height:30px;border-radius:50%;background:var(--vgrad);border:3px solid #fff;display:flex;align-items:center;justify-content:center;cursor:pointer;z-index:2;box-shadow:var(--sh);}
.prof-av-edit svg{width:13px;height:13px;stroke:#fff;}
.prof-name{font-family:'Poppins',sans-serif;font-size:22px;font-weight:800;color:var(--txt);}
.prof-role{font-size:13px;color:var(--muted);margin-top:3px;}
.prof-joined{font-size:11px;color:var(--muted);margin-top:6px;}

/* Rank badge */
.rank-card{background:var(--vgrad);border-radius:var(--rm);padding:14px 18px;display:flex;align-items:center;gap:12px;box-shadow:0 6px 20px rgba(124,58,237,.25);}
.rank-ico{font-size:28px;animation:float 3s ease-in-out infinite;}
.rank-info{flex:1;}
.rank-title{font-family:'Poppins',sans-serif;font-size:14px;font-weight:800;color:#fff;}
.rank-sub{font-size:11px;color:rgba(255,255,255,.75);margin-top:2px;}
.rank-num{font-family:'Poppins',sans-serif;font-size:22px;font-weight:900;color:#fff;}

/* XP block */
.xp-full{background:var(--vxl);border-radius:var(--rm);padding:16px;}
.xp-top-row{display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;}
.xp-lvl{font-family:'Poppins',sans-serif;font-size:13px;font-weight:800;color:var(--v);}
.xp-pts{font-size:12px;color:var(--muted);}
.xp-bar-bg{height:10px;background:rgba(124,58,237,.15);border-radius:var(--rp);overflow:hidden;margin-bottom:6px;}
.xp-bar{height:100%;border-radius:var(--rp);background:var(--vgrad);--w:68%;width:0;animation:barGrow 1.4s .3s cubic-bezier(.22,1,.36,1) both;box-shadow:0 2px 8px rgba(124,58,237,.3);}
.xp-next{font-size:11px;color:var(--muted);}

/* Quick stats */
.quick-stats{display:grid;grid-template-columns:1fr 1fr;gap:10px;}
.qs{background:var(--bg);border-radius:var(--rm);padding:14px 12px;text-align:center;border:1.5px solid var(--border);transition:all .2s;}
.qs:hover{background:var(--vxl);border-color:var(--vl);}
.qs-ico{font-size:18px;margin-bottom:4px;}
.qs-val{font-family:'Poppins',sans-serif;font-size:20px;font-weight:800;color:var(--txt);}
.qs-lbl{font-size:10px;color:var(--muted);margin-top:2px;}

/* Contact info */
.contact-list{display:flex;flex-direction:column;gap:10px;}
.ci{display:flex;align-items:center;gap:10px;}
.ci-ico{width:32px;height:32px;border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:15px;flex-shrink:0;}
.ci-info{flex:1;min-width:0;}
.ci-lbl{font-size:10px;color:var(--muted);font-weight:600;}
.ci-val{font-size:13px;color:var(--txt);font-weight:500;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}

/* Social links */
.social-row{display:flex;gap:8px;flex-wrap:wrap;}
.soc-btn{display:flex;align-items:center;gap:6px;padding:7px 13px;border-radius:var(--rp);border:1.5px solid var(--border);background:#fff;font-size:12px;font-weight:600;color:var(--muted);cursor:pointer;transition:all .2s;}
.soc-btn:hover{background:var(--vxl);border-color:var(--vl);color:var(--v);}

/* RIGHT PANEL */
.prof-right{padding:28px;display:flex;flex-direction:column;gap:22px;overflow-y:auto;}

/* Section header */
.sec-hdr{font-family:'Poppins',sans-serif;font-size:16px;font-weight:700;color:var(--txt);margin-bottom:14px;display:flex;align-items:center;gap:8px;}
.sec-pill{font-size:11px;font-weight:700;padding:2px 9px;border-radius:var(--rp);background:var(--vxl);color:var(--v);font-family:'DM Sans',sans-serif;}

/* BIO card */
.bio-card{background:var(--card);border-radius:var(--r);border:1.5px solid var(--border);box-shadow:var(--sh);padding:22px 24px;}
.bio-text{font-size:14px;color:var(--txt);line-height:1.7;margin-bottom:16px;}
.skills-wrap{display:flex;gap:8px;flex-wrap:wrap;}
.skill-tag{font-size:12px;font-weight:700;padding:5px 14px;border-radius:var(--rp);cursor:pointer;transition:all .15s;}
.skill-tag:hover{transform:translateY(-2px);}

/* EDIT FORM CARD */
.edit-card{background:var(--card);border-radius:var(--r);border:1.5px solid var(--border);box-shadow:var(--sh);padding:22px 24px;}
.form-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:16px;}
.fg{display:flex;flex-direction:column;gap:5px;}
.fg.full{grid-column:1/-1;}
.fg label{font-size:12px;font-weight:600;color:var(--muted);}
.fg input,.fg textarea,.fg select{border:1.5px solid var(--border);border-radius:var(--rs);padding:10px 14px;font-family:'DM Sans',sans-serif;font-size:13px;color:var(--txt);transition:all .2s;width:100%;background:#fff;}
.fg input:focus,.fg textarea:focus,.fg select:focus{outline:none;border-color:var(--vl);box-shadow:0 0 0 3px rgba(167,139,250,.2);}
.fg textarea{resize:vertical;min-height:80px;}
.form-actions{display:flex;gap:10px;justify-content:flex-end;}
.fa-btn{padding:10px 22px;border-radius:var(--rp);font-family:'DM Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;transition:all .2s;}
.fa-btn.primary{background:var(--vgrad);color:#fff;box-shadow:0 3px 10px rgba(124,58,237,.28);}
.fa-btn.primary:hover{transform:translateY(-1px);}
.fa-btn.ghost{background:var(--bg);color:var(--muted);border:1.5px solid var(--border);}

/* COURSE HISTORY */
.course-history{display:flex;flex-direction:column;gap:12px;}
.ch-item{background:var(--card);border-radius:var(--rm);border:1.5px solid var(--border);box-shadow:var(--sh);padding:16px 18px;display:flex;align-items:center;gap:14px;cursor:pointer;transition:all .2s;}
.ch-item:hover{border-color:var(--vl);transform:translateX(4px);}
.ch-ico{width:46px;height:46px;border-radius:13px;display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0;}
.ch-info{flex:1;min-width:0;}
.ch-title{font-family:'Poppins',sans-serif;font-size:14px;font-weight:700;color:var(--txt);}
.ch-sub{font-size:11px;color:var(--muted);margin-top:2px;}
.ch-prog{margin-top:7px;}
.ch-prog-row{display:flex;align-items:center;gap:8px;}
.ch-bar{flex:1;height:5px;background:rgba(0,0,0,.07);border-radius:var(--rp);overflow:hidden;}
.ch-fill{height:100%;border-radius:var(--rp);}
.ch-pct{font-size:12px;font-weight:700;min-width:34px;text-align:right;}
.ch-right{text-align:right;flex-shrink:0;}
.ch-status{font-size:11px;font-weight:700;padding:3px 9px;border-radius:var(--rp);display:inline-block;margin-bottom:6px;}
.ch-time{font-size:11px;color:var(--muted);}

/* BADGES MINI */
.badges-mini{display:flex;gap:10px;flex-wrap:wrap;}
.bm{text-align:center;cursor:pointer;transition:all .2s;}
.bm:hover{transform:translateY(-3px);}
.bm-ico{width:52px;height:52px;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:26px;margin-bottom:5px;}
.bm-lbl{font-size:10px;font-weight:700;color:var(--muted);}

/* CERTIF MINI */
.certs-mini{display:flex;flex-direction:column;gap:10px;}
.cert-mini{background:var(--card);border-radius:var(--rm);padding:14px 18px;border:1.5px solid var(--border);box-shadow:var(--sh);display:flex;align-items:center;gap:14px;cursor:pointer;transition:all .2s;}
.cert-mini:hover{border-color:var(--v);background:var(--vxl);transform:translateX(3px);}
.cert-mini-ico{width:44px;height:44px;border-radius:12px;background:var(--vgrad);display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0;box-shadow:0 4px 12px rgba(124,58,237,.25);}
.cert-mini-info{flex:1;}
.cert-mini-name{font-size:14px;font-weight:700;color:var(--txt);}
.cert-mini-sub{font-size:11px;color:var(--muted);margin-top:2px;}
.cert-dl{width:32px;height:32px;border-radius:50%;background:#fff;display:flex;align-items:center;justify-content:center;box-shadow:var(--sh);cursor:pointer;transition:all .2s;flex-shrink:0;}
.cert-dl:hover{background:var(--v);}
.cert-dl:hover svg{stroke:#fff;}
.cert-dl svg{width:14px;height:14px;stroke:var(--v);}

/* ACTIVITY FEED */
.af-list{display:flex;flex-direction:column;gap:2px;}
.af-item{display:flex;align-items:center;gap:12px;padding:11px 14px;border-radius:var(--rm);transition:all .15s;cursor:pointer;}
.af-item:hover{background:var(--vxl);}
.af-ico{width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0;}
.af-msg{flex:1;font-size:13px;color:var(--txt);line-height:1.4;}
.af-msg strong{font-weight:600;}
.af-time{font-size:11px;color:var(--muted);flex-shrink:0;}

@media(max-width:1100px){.prof-layout{grid-template-columns:1fr;}.prof-left{position:static;height:auto;border-right:none;border-bottom:1.5px solid var(--border);}}
@media(max-width:900px){.prof-right{padding:18px 16px;}.form-grid{grid-template-columns:1fr;}}
@media(max-width:600px){.quick-stats{grid-template-columns:repeat(4,1fr);gap:8px;}.qs-val{font-size:16px;}}
</style>

<!-- HEADER -->
<header class="hdr">
  <h1>{{ "\u{1F464}" }} Mon Profil</h1>
  <button class="edit-btn" wire:click="toggleEditMode">
    <svg viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
    {{ $editMode ? 'Annuler' : 'Modifier le profil' }}
  </button>
  @if($editMode)
    <span wire:loading class="ibtn" title="Sauvegarde en cours..."><svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg></span>
  @endif
  <div class="ibtn"><svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg><span class="ndot"></span></div>
</header>

<div class="page">
  <div class="prof-layout">

    <!-- LEFT: PROFILE CARD -->
    <div class="prof-left">

      <!-- Avatar -->
      <div class="prof-avatar-wrap fu fu1">
        <div class="prof-av-ring">
          @if($avatarPreview && $avatarUpdated)
            <img src="{{ $avatarPreview }}?t={{ now()->timestamp }}" alt="{{ $user->name }}" style="width:110px;height:110px;border-radius:50%;object-fit:cover;display:block;box-shadow:0 8px 28px rgba(124,58,237,.3);">
          @elseif($avatarPreview)
            <img src="{{ $avatarPreview }}" alt="{{ $user->name }}" style="width:110px;height:110px;border-radius:50%;object-fit:cover;display:block;box-shadow:0 8px 28px rgba(124,58,237,.3);">
          @else
            <div class="prof-av">{{ auth()->user()->initials() }}</div>
          @endif
          <label for="avatarInput" class="prof-av-edit" style="cursor: pointer;">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
          </label>
          <input type="file" id="avatarInput" wire:model.live="avatar" accept="image/*" style="display:none;">
        </div>
        <div class="prof-name">{{ $firstName }} {{ $lastName }}</div>
        <div class="prof-role">{{ "\u{1F393}" }} Etudiant passionné</div>
        <div class="prof-joined">{{ "\u{1F4C5}" }} Membre depuis {{ $user->created_at->translatedFormat('F Y') }}</div>

        <!-- Logout Button in Sidebar -->
        <form method="POST" action="{{ route('logout') }}" style="margin-top: 12px;">
          @csrf
          <button type="submit" class="fa-btn ghost" style="width: 100%; justify-content: center; gap: 6px;">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" style="width: 14px; height: 14px;"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            Déconnexion
          </button>
        </form>
      </div>

      <!-- Rank -->
      <div class="rank-card fu fu2">
        <div class="rank-ico">{{ "\u{1F396}" }}</div>
        <div class="rank-info">
          <div class="rank-title">Apprenant Motive</div>
          <div class="rank-sub">Classement general</div>
        </div>
        <div class="rank-num">#{{ rand(10, 99) }}</div>
      </div>

      <!-- XP -->
      <div class="xp-full fu fu2">
        <div class="xp-top-row">
          <div class="xp-lvl">{{ "\u{26A1}" }} Niveau {{ $level }}</div>
          <div class="xp-pts">{{ $totalXp }} / {{ $level * 500 }} XP</div>
        </div>
        <div class="xp-bar-bg"><div class="xp-bar" style="--w:{{ $xpPercent }}%;"></div></div>
        <div class="xp-next">{{ ($level * 500) - $totalXp }} XP pour atteindre le Niveau {{ $level + 1 }} {{ "\u{1F680}" }}</div>
      </div>

      <!-- Quick Stats -->
      <div class="quick-stats fu fu3">
        <div class="qs"><div class="qs-ico">{{ "\u{1F4DA}" }}</div><div class="qs-val">{{ $inscriptions->count() }}</div><div class="qs-lbl">Cours</div></div>
        <div class="qs"><div class="qs-ico">{{ "\u{2705}" }}</div><div class="qs-val">{{ $inscriptions->where('status', \App\Enums\EnrollStatus::Completed)->count() }}</div><div class="qs-lbl">Termines</div></div>
        <div class="qs"><div class="qs-ico">{{ "\u{1F3C5}" }}</div><div class="qs-val">{{ $badges->count() }}</div><div class="qs-lbl">Badges</div></div>
        <div class="qs"><div class="qs-ico">{{ "\u{1F393}" }}</div><div class="qs-val">{{ $certificats->count() }}</div><div class="qs-lbl">Certifs</div></div>
      </div>

      <!-- Contact Info -->
      <div class="fu fu4">
        <div style="font-family:'Poppins',sans-serif;font-size:13px;font-weight:700;color:var(--txt);margin-bottom:12px;">{{ "\u{1F4CB}" }} Informations</div>
        <div class="contact-list">
          <div class="ci"><div class="ci-ico" style="background:var(--vxl);">{{ "\u{1F4E7}" }}</div><div class="ci-info"><div class="ci-lbl">Email</div><div class="ci-val">{{ $email }}</div></div></div>
          <div class="ci"><div class="ci-ico" style="background:var(--mint);">{{ "\u{1F4CD}" }}</div><div class="ci-info"><div class="ci-lbl">Localisation</div><div class="ci-val">{{ $location ?: 'Non renseigné' }}</div></div></div>
          <div class="ci"><div class="ci-ico" style="background:var(--yel);">{{ "\u{1F382}" }}</div><div class="ci-info"><div class="ci-lbl">Inscrit depuis</div><div class="ci-val">{{ $user->created_at->translatedFormat('d F Y') }}</div></div></div>
          <div class="ci"><div class="ci-ico" style="background:var(--sky);">{{ "\u{1F393}" }}</div><div class="ci-info"><div class="ci-lbl">Niveau</div><div class="ci-val">Niveau {{ $level }}</div></div></div>
          <div class="ci"><div class="ci-ico" style="background:var(--rose);">{{ "\u{1F4BC}" }}</div><div class="ci-info"><div class="ci-lbl">Objectif</div><div class="ci-val">{{ $professional_objective ?: 'Non renseigné' }}</div></div></div>
        </div>
      </div>

      <!-- Social Links -->
      <div class="fu fu5">
        <div style="font-family:'Poppins',sans-serif;font-size:13px;font-weight:700;color:var(--txt);margin-bottom:10px;">{{ "\u{1F517}" }} Reseaux</div>
        <div class="social-row">
          @if($linkedin_url)
            <a href="{{ $linkedin_url }}" target="_blank" class="soc-btn">{{ "\u{1F535}" }} LinkedIn</a>
          @else
            <div class="soc-btn" style="opacity: 0.5; cursor: default;">{{ "\u{1F535}" }} LinkedIn</div>
          @endif
          @if($github_url)
            <a href="{{ $github_url }}" target="_blank" class="soc-btn">{{ "\u{26AB}" }} GitHub</a>
          @else
            <div class="soc-btn" style="opacity: 0.5; cursor: default;">{{ "\u{26AB}" }} GitHub</div>
          @endif
          @if($portfolio_url)
            <a href="{{ $portfolio_url }}" target="_blank" class="soc-btn">{{ "\u{1F310}" }} Portfolio</a>
          @else
            <div class="soc-btn" style="opacity: 0.5; cursor: default;">{{ "\u{1F310}" }} Portfolio</div>
          @endif
        </div>
      </div>

    </div><!-- /prof-left -->

    <!-- RIGHT: CONTENT -->
    <div class="prof-right">

      <!-- BIO -->
      <section class="fu fu1">
        <div class="sec-hdr">{{ "\u{1F4DD}" }} A propos de moi</div>
        <div class="bio-card">
          <div class="bio-text">{{ $bio ?: 'Ajoutez une biographie pour compléter votre profil...' }}</div>
          <div style="font-family:'Poppins',sans-serif;font-size:13px;font-weight:700;color:var(--txt);margin-bottom:10px;">{{ "\u{1F3F7}" }} Compétences & intérêts</div>
          <div class="skills-wrap">
            @forelse($selectedSkills as $index => $skill)
              <div style="display:inline-flex;align-items:center;gap:6px;background:var(--vxl);color:var(--v);padding:5px 10px;border-radius:var(--rp);font-size:12px;font-weight:700;">
                {{ $skill }}
                @if($editMode)
                  <button type="button" wire:click="removeSkill({{ $index }})" style="background:none;border:none;color:inherit;cursor:pointer;font-weight:bold;padding:0;margin:0;">✕</button>
                @endif
              </div>
            @empty
              <span style="color: var(--muted); font-size: 12px;">Aucune compétence renseignée</span>
            @endforelse
          </div>
        </div>
      </section>

      <!-- EDIT FORM -->
      @if($editMode)
      <section id="editSection" class="fu fu1">
        <div class="sec-hdr">{{ "\u{270F}" }} Modifier mes informations</div>
        <div class="edit-card">
          <div class="form-grid">
            <div class="fg">
              <label>Prenom</label>
              <input wire:model.live="firstName" type="text" placeholder="Votre prénom"/>
              @if($errors->has('firstName'))
                <span style="color: #ef4444; font-size: 11px;">{{ $errors->first('firstName') }}</span>
              @endif
            </div>
            <div class="fg">
              <label>Nom</label>
              <input wire:model.live="lastName" type="text" placeholder="Votre nom"/>
              @if($errors->has('lastName'))
                <span style="color: #ef4444; font-size: 11px;">{{ $errors->first('lastName') }}</span>
              @endif
            </div>
            <div class="fg">
              <label>Email</label>
              <input wire:model.live="email" type="email" placeholder="email@example.com"/>
              @if($errors->has('email'))
                <span style="color: #ef4444; font-size: 11px;">{{ $errors->first('email') }}</span>
              @endif
            </div>
            <div class="fg">
              <label>Telephone</label>
              <input wire:model.live="phone" type="tel" placeholder="+212 6XX XXX XXX"/>
              @if($errors->has('phone'))
                <span style="color: #ef4444; font-size: 11px;">{{ $errors->first('phone') }}</span>
              @endif
            </div>
            <div class="fg">
              <label>Localisation</label>
              <input wire:model.live="location" type="text" placeholder="Ville, Pays"/>
              @if($errors->has('location'))
                <span style="color: #ef4444; font-size: 11px;">{{ $errors->first('location') }}</span>
              @endif
            </div>
            <div class="fg">
              <label>Objectif professionnel</label>
              <input wire:model.live="professional_objective" type="text" placeholder="Ex: Développeur Full Stack"/>
              @if($errors->has('professional_objective'))
                <span style="color: #ef4444; font-size: 11px;">{{ $errors->first('professional_objective') }}</span>
              @endif
            </div>
            <div class="fg">
              <label>LinkedIn</label>
              <input wire:model.live="linkedin_url" type="url" placeholder="https://linkedin.com/in/username"/>
              @if($errors->has('linkedin_url'))
                <span style="color: #ef4444; font-size: 11px;">{{ $errors->first('linkedin_url') }}</span>
              @endif
            </div>
            <div class="fg">
              <label>GitHub</label>
              <input wire:model.live="github_url" type="url" placeholder="https://github.com/username"/>
              @if($errors->has('github_url'))
                <span style="color: #ef4444; font-size: 11px;">{{ $errors->first('github_url') }}</span>
              @endif
            </div>
            <div class="fg">
              <label>Portfolio</label>
              <input wire:model.live="portfolio_url" type="url" placeholder="https://monsite.com"/>
              @if($errors->has('portfolio_url'))
                <span style="color: #ef4444; font-size: 11px;">{{ $errors->first('portfolio_url') }}</span>
              @endif
            </div>
            <div class="fg full">
              <label>Biographie</label>
              <textarea wire:model.live="bio" placeholder="Parlez de vous, vos passions, vos objectifs..."></textarea>
              @if($errors->has('bio'))
                <span style="color: #ef4444; font-size: 11px;">{{ $errors->first('bio') }}</span>
              @endif
            </div>
            <div class="fg full">
              <label>{{ "\u{1F3F7}" }} Ajouter une compétence</label>
              <div style="display: flex; gap: 8px;">
                <input wire:model="skillInput" type="text" placeholder="Ex: Laravel, Vue.js, Design..." @keyup.enter="addSkill"/>
                <button type="button" wire:click="addSkill" class="fa-btn primary" style="flex-shrink: 0;">+ Ajouter</button>
              </div>
              @if($errors->has('skillInput'))
                <span style="color: #ef4444; font-size: 11px;">{{ $errors->first('skillInput') }}</span>
              @endif
              @if(count($selectedSkills) >= 12)
                <span style="color: #ef4444; font-size: 11px;">⚠️ Maximum 12 compétences</span>
              @endif
            </div>
          </div>
        </div>
      </section>
      @endif

      <!-- COURSE HISTORY -->
      <section class="fu fu2">
        <div class="sec-hdr">{{ "\u{1F4DA}" }} Mes cours <span class="sec-pill">{{ $inscriptions->count() }}</span></div>
        <div class="course-history">
          @forelse($inscriptions as $index => $inscription)
            @php
              $colors = [
                ['bg' => 'var(--vxl)', 'fill' => 'var(--v)', 'ico' => "\u{1F4A1}"],
                ['bg' => 'var(--rose)', 'fill' => 'var(--rosed)', 'ico' => "\u{1F4BB}"],
                ['bg' => 'var(--mint)', 'fill' => 'var(--mintd)', 'ico' => "\u{1F3AC}"],
                ['bg' => 'var(--sky)', 'fill' => 'var(--skyd)', 'ico' => "\u{1F4CA}"],
                ['bg' => 'var(--yel)', 'fill' => 'var(--yeld)', 'ico' => "\u{1F680}"],
              ];
              $color = $colors[$index % count($colors)];
              $isCompleted = $inscription->status === \App\Enums\EnrollStatus::Completed;
              $progress = $isCompleted ? 100 : ($inscription->progress ?? 0);
            @endphp
            <div class="ch-item">
              <div class="ch-ico" style="background:{{ $color['bg'] }};">{{ $color['ico'] }}</div>
              <div class="ch-info">
                <div class="ch-title">{{ $inscription->cours->title }}</div>
                <div class="ch-sub">{{ $inscription->cours->categorie->name ?? 'Categorie' }} {{ "\u{00B7}" }} {{ $inscription->cours->formateur->name ?? 'Formateur' }} {{ "\u{00B7}" }} {{ $inscription->created_at->translatedFormat('d M Y') }}</div>
                <div class="ch-prog">
                  <div class="ch-prog-row">
                    <div class="ch-bar"><div class="ch-fill" style="--w:{{ $progress }}%;width:0;background:{{ $color['fill'] }};animation:barGrow 1.2s {{ 0.3 + ($index * 0.1) }}s both;"></div></div>
                    <div class="ch-pct" style="color:{{ $color['fill'] }};">{{ $progress }}%</div>
                  </div>
                </div>
              </div>
              <div class="ch-right">
                @if($isCompleted)
                  <span class="ch-status" style="background:var(--mint);color:var(--mintd);">{{ "\u{2705}" }} Termine</span>
                @else
                  <span class="ch-status" style="background:{{ $color['bg'] }};color:{{ $color['fill'] }};">{{ "\u{1F504}" }} En cours</span>
                @endif
                <div class="ch-time">{{ "\u{23F1}" }} Inscrit {{ $inscription->created_at->diffForHumans() }}</div>
              </div>
            </div>
          @empty
            <div class="ch-item">
              <div class="ch-ico" style="background:var(--bg);">{{ "\u{1F4DA}" }}</div>
              <div class="ch-info">
                <div class="ch-title">Aucun cours inscrit</div>
                <div class="ch-sub">Commencez votre apprentissage aujourd'hui !</div>
              </div>
            </div>
          @endforelse
        </div>
      </section>

      <!-- BADGES -->
      <section class="fu fu3">
        <div class="sec-hdr">{{ "\u{1F3C5}" }} Mes badges <span class="sec-pill">{{ $badges->count() }} obtenus</span></div>
        <div style="background:var(--card);border-radius:var(--r);border:1.5px solid var(--border);box-shadow:var(--sh);padding:20px 24px;">
          <div class="badges-mini">
            @php
              $badgeColors = [
                ['bg' => 'var(--vxl)', 'color' => 'var(--v)'],
                ['bg' => 'var(--rose)', 'color' => 'var(--rosed)'],
                ['bg' => 'var(--yel)', 'color' => 'var(--yeld)'],
                ['bg' => 'var(--mint)', 'color' => 'var(--mintd)'],
                ['bg' => 'var(--sky)', 'color' => 'var(--skyd)'],
              ];
            @endphp
            @forelse($badges as $index => $badge)
              @php $bColor = $badgeColors[$index % count($badgeColors)]; @endphp
              <div class="bm" onclick="showToast('{{ "\u{1F3C5}" }} {{ $badge->name }} — {{ $badge->description }}')">
                <div class="bm-ico" style="background:{{ $bColor['bg'] }};">
                  @if($badge->image_url)
                    <img src="{{ $badge->image_url }}" alt="{{ $badge->name }}" style="width:26px;height:26px;">
                  @else
                    {{ "\u{1F3C5}" }}
                  @endif
                </div>
                <div class="bm-lbl" style="color:{{ $bColor['color'] }};">{{ Str::limit($badge->name, 12) }}</div>
              </div>
            @empty
              <div class="bm" style="opacity:.5;">
                <div class="bm-ico" style="background:#F3F4F6;">{{ "\u{1F512}" }}</div>
                <div class="bm-lbl" style="color:#9CA3AF;">Aucun badge</div>
              </div>
            @endforelse
          </div>
        </div>
      </section>

      <!-- CERTIFICATS -->
      <section class="fu fu4">
        <div class="sec-hdr">{{ "\u{1F393}" }} Mes certificats <span class="sec-pill">{{ $certificats->count() }} obtenus</span></div>
        <div class="certs-mini">
          @forelse($certificats as $certificat)
            <div class="cert-mini">
              <div class="cert-mini-ico">{{ "\u{1F4A1}" }}</div>
              <div class="cert-mini-info">
                <div class="cert-mini-name">{{ $certificat->inscription->cours->title }}</div>
                <div class="cert-mini-sub">Emis le {{ $certificat->issued_at->translatedFormat('d M Y') }} {{ "\u{00B7}" }} N° {{ $certificat->certificate_number }}</div>
              </div>
              @if($certificat->pdf_url)
                <a href="{{ $certificat->pdf_url }}" target="_blank" class="cert-dl"><svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg></a>
              @else
                <div class="cert-dl" onclick="showToast('{{ "\u{1F4C4}" }} PDF non disponible')"><svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg></div>
              @endif
            </div>
          @empty
            <div class="cert-mini" style="opacity:.6;">
              <div class="cert-mini-ico">{{ "\u{1F512}" }}</div>
              <div class="cert-mini-info">
                <div class="cert-mini-name">Aucun certificat</div>
                <div class="cert-mini-sub">Terminez un cours pour obtenir votre certificat</div>
              </div>
            </div>
          @endforelse
        </div>
      </section>

      <!-- ACTIVITY -->
      <section class="fu fu5">
        <div class="sec-hdr">{{ "\u{1F550}" }} Activite recente</div>
        <div style="background:var(--card);border-radius:var(--r);border:1.5px solid var(--border);box-shadow:var(--sh);padding:14px;">
          <div class="af-list">
            @php
              // Build activities from inscriptions, badges, and certificates
              $activities = collect();

              // Course enrollments
              foreach($inscriptions as $insc) {
                $activities->push([
                  'type' => 'enrollment',
                  'icon' => "\u{1F4DA}",
                  'bg' => 'var(--vxl)',
                  'message' => "Inscription au cours <strong>{$insc->cours->title}</strong>",
                  'date' => $insc->created_at,
                ]);

                // Course completions
                if($insc->status === \App\Enums\EnrollStatus::Completed && $insc->completed_at) {
                  $activities->push([
                    'type' => 'completion',
                    'icon' => "\u{2705}",
                    'bg' => 'var(--mint)',
                    'message' => "Cours <strong>{$insc->cours->title}</strong> termine",
                    'date' => $insc->completed_at,
                  ]);
                }
              }

              // Badges earned
              foreach($badges as $badge) {
                $activities->push([
                  'type' => 'badge',
                  'icon' => "\u{1F3C5}",
                  'bg' => 'var(--yel)',
                  'message' => "Badge <strong>{$badge->name}</strong> debloque",
                  'date' => $badge->earned_at ?? $badge->created_at,
                ]);
              }

              // Certificates issued
              foreach($certificats as $cert) {
                $activities->push([
                  'type' => 'certificate',
                  'icon' => "\u{1F393}",
                  'bg' => 'var(--sky)',
                  'message' => "Certificat <strong>{$cert->inscription->cours->title}</strong> emis",
                  'date' => $cert->issued_at ?? $cert->created_at,
                ]);
              }

              // Sort by date descending and take last 6
              $activities = $activities->sortByDesc('date')->take(6);
            @endphp

            @forelse($activities as $activity)
              <div class="af-item">
                <div class="af-ico" style="background:{{ $activity['bg'] }};">{{ $activity['icon'] }}</div>
                <div class="af-msg">{!! $activity['message'] !!}</div>
                <div class="af-time">{{ $activity['date']->diffForHumans() }}</div>
              </div>
            @empty
              <div class="af-item">
                <div class="af-ico" style="background:var(--bg);">{{ "\u{1F4AD}" }}</div>
                <div class="af-msg">Aucune activite recente</div>
                <div class="af-time">-</div>
              </div>
            @endforelse
          </div>
        </div>
      </section>

    </div><!-- /prof-right -->
  </div>
</div>

<script>
// Livewire event listeners for notifications
Livewire.on('notify', (data) => {
  if (typeof showToast === 'function') {
    showToast(data.message);
  }
});

// Scroll to edit section on demand
Livewire.on('scroll-to-edit', () => {
  const editSection = document.querySelector('#editSection');
  if (editSection) {
    editSection.scrollIntoView({behavior:'smooth', block:'start'});
  }
});
</script>
</div>
