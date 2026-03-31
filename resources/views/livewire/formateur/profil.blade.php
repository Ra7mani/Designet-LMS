<div>
<style>
.profil-layout{display:grid;grid-template-columns:320px 1fr;gap:24px;align-items:start;}
.profil-left{display:flex;flex-direction:column;gap:18px;position:sticky;top:72px;}
.avatar-section{background:linear-gradient(135deg, #0d9488 0%, #14b8a6 100%);border-radius:12px;padding:28px;text-align:center;position:relative;overflow:hidden;}
.avatar-section::before{content:"";position:absolute;top:-40px;right:-40px;width:160px;height:160px;border-radius:50%;background:rgba(255,255,255,.06);}
.avatar-big{width:100px;height:100px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-family:Poppins,sans-serif;font-weight:900;font-size:36px;color:#fff;margin:0 auto 14px;border:4px solid rgba(255,255,255,.25);position:relative;cursor:pointer;background:linear-gradient(135deg, #0369a1, #0284d4);}
.avatar-big:hover::after{content:"📷";position:absolute;inset:0;background:rgba(0,0,0,.4);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:28px;}
.profil-name{font-family:Poppins,sans-serif;font-size:20px;font-weight:900;color:#fff;margin-bottom:4px;}
.profil-title{font-size:13px;color:rgba(255,255,255,.7);}
.profil-badges{display:flex;gap:6px;justify-content:center;flex-wrap:wrap;margin-top:12px;}
.p-badge{background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.2);border-radius:8px;padding:4px 12px;font-size:11px;font-weight:700;color:#fff;}
.profil-stats-row{display:flex;gap:12px;margin-top:18px;}
.psr-item{flex:1;text-align:center;background:rgba(255,255,255,.1);border-radius:8px;padding:10px;border:1px solid rgba(255,255,255,.1);}
.psr-val{font-family:Poppins,sans-serif;font-size:18px;font-weight:900;color:#fff;}
.psr-lbl{font-size:9px;color:rgba(255,255,255,.6);margin-top:2px;}
.info-card{background:#fff;border-radius:12px;border:1.5px solid #e5e7eb;box-shadow:0 1px 3px rgba(0,0,0,.1);}
.info-row{display:flex;align-items:center;gap:12px;padding:13px 18px;border-bottom:1px solid #e5e7eb;transition:background .15s;}
.info-row:last-child{border-bottom:none;}
.info-row:hover{background:#f9fafb;}
.info-ico{font-size:18px;width:28px;text-align:center;flex-shrink:0;}
.info-lbl{font-size:11px;color:#6b7280;}
.info-val{font-size:13px;font-weight:600;color:#1f2937;}
.profil-right{display:flex;flex-direction:column;gap:20px;}
.edit-form{display:flex;flex-direction:column;gap:14px;}
.skill-tag{display:inline-flex;align-items:center;gap:6px;background:#f0fdf4;color:#0d9488;border:1.5px solid rgba(13,148,136,.2);border-radius:8px;padding:5px 12px;font-size:12px;font-weight:600;cursor:pointer;transition:all .2s;}
.skill-tag:hover{background:rgba(13,148,136,.15);}
.skill-tag .remove{font-size:14px;color:#0d9488;opacity:.6;}
.card{background:#fff;border-radius:12px;border:1.5px solid #e5e7eb;box-shadow:0 1px 3px rgba(0,0,0,.1);padding:20px;}
.card-title{font-size:15px;font-weight:700;color:#1f2937;margin-bottom:12px;}
.card-p{padding:20px;}
.card-sub{float:right;font-size:13px;font-weight:400;}
.form-input{width:100%;padding:10px 12px;border:1.5px solid #d1d5db;border-radius:6px;font-size:13px;font-family:DM Sans,sans-serif;color:#1f2937;transition:all .2s;box-sizing:border-box;}
.form-input:focus{outline:none;border-color:#0d9488;box-shadow:0 0 0 3px rgba(13,148,136,.1);}
.form-label{font-size:12px;font-weight:600;color:#1f2937;display:block;margin-bottom:6px;}
.form-group{display:flex;flex-direction:column;gap:6px;}
.form-grid-2{display:grid;grid-template-columns:repeat(2,1fr);gap:16px;}
.btn{padding:10px 16px;border-radius:6px;font-size:13px;font-weight:600;border:none;cursor:pointer;transition:all .2s;}
.btn-primary{background:linear-gradient(135deg, #0d9488 0%, #14b8a6 100%);color:#fff;box-shadow:0 2px 8px rgba(13,148,136,.3);}
.btn-primary:hover{transform:translateY(-2px);}
.btn-outline{background:#fff;color:#1f2937;border:1.5px solid #d1d5db;}
.btn-outline:hover{background:#f9fafb;}
.btn-danger{background:#fff;color:#dc2626;border:1.5px solid #fca5a5;}
.btn-danger:hover{background:#fca5a5;color:#fff;}
.btn-sm{padding:8px 12px;font-size:12px;}
.toggle-switch{position:relative;width:44px;height:24px;display:inline-flex;align-items:center;cursor:pointer;}
.toggle-switch input{opacity:0;width:0;height:0;}
.toggle-slider{position:absolute;cursor:pointer;top:0;left:0;right:0;bottom:0;background:#d1d5db;border-radius:12px;transition:all .3s;flex-shrink:0;}
.toggle-slider::before{content:'';position:absolute;height:18px;width:18px;left:3px;bottom:3px;background:#fff;border-radius:50%;transition:all .3s;}
.toggle-switch input:checked+.toggle-slider{background:#0d9488;}
.toggle-switch input:checked+.toggle-slider::before{transform:translateX(20px);}
.page-header{display:flex;align-items:center;gap:24px;padding:30px;justify-content:space-between;background:#fff;border-bottom:1.5px solid #e5e7eb;margin-bottom:28px;border-radius:12px 12px 0 0;}
.page-header h1{font-family:Poppins,sans-serif;font-size:24px;font-weight:800;color:#1f2937;margin:0;}
.page-header p{font-size:13px;color:#6b7280;margin:4px 0 0 0;}
@media(max-width:1100px){.profil-layout{grid-template-columns:1fr;}.profil-left{position:static;display:grid;grid-template-columns:1fr 1fr;}}
@media(max-width:640px){.profil-layout{grid-template-columns:1fr;}.profil-left{grid-template-columns:1fr;}.form-grid-2{grid-template-columns:1fr;}}

</style>

<div class="page-header">
  <div>
    <h1>👤 Mon Profil</h1>
    <p>Gérez vos informations et paramètres</p>
  </div>
  <div style="display:flex;gap:10px;">
    <button class="btn btn-outline btn-sm" id="editBtn" onclick="toggleEdit()">✏️ Modifier le profil</button>
    <button class="btn btn-primary btn-sm" id="saveBtn" style="display:none;" onclick="saveProfile()">✅ Enregistrer</button>
  </div>
</div>

<div class="page-content" style="padding:0 30px 30px 30px;">
  <div class="profil-layout">
    <!-- LEFT -->
    <div class="profil-left">
      <div class="avatar-section">
        <div class="avatar-big" onclick="showToast('📷 Changer la photo')">{{ substr(auth()->user()->name, 0, 2) }}</div>
        <div class="profil-name">{{ auth()->user()->name }}</div>
        <div class="profil-title">Formateur</div>
        <div style="display:flex;justify-content:center;gap:6px;align-items:center;margin-top:6px;font-size:12px;color:rgba(255,255,255,.9);">
          <span style="width:8px;height:8px;background:#4ade80;border-radius:50%;"></span>
          En ligne · Disponible
        </div>
        <div class="profil-badges">
          <div class="p-badge">🏆 Formateur</div>
          <div class="p-badge">⭐ {{ number_format(auth()->user()->cours()->avg('rating') ?? 0, 1) }}</div>
          <div class="p-badge">📚 {{ auth()->user()->cours()->count() }} cours</div>
        </div>
        <div class="profil-stats-row">
          <div class="psr-item">
            <div class="psr-val">{{ auth()->user()->cours()->withCount('inscriptions')->get()->sum('inscriptions_count') }}</div>
            <div class="psr-lbl">Étudiants</div>
          </div>
          <div class="psr-item">
            <div class="psr-val">{{ number_format(auth()->user()->cours()->avg('rating') ?? 0, 1) }}⭐</div>
            <div class="psr-lbl">Note</div>
          </div>
          <div class="psr-item">
            <div class="psr-val">0€</div>
            <div class="psr-lbl">Revenus</div>
          </div>
        </div>
      </div>

      <div class="info-card">
        <div style="padding:14px 18px 10px;font-size:12px;font-weight:700;color:#6b7280;letter-spacing:.06em;text-transform:uppercase;">Informations</div>
        <div class="info-row">
          <div class="info-ico">📧</div>
          <div>
            <div class="info-lbl">Email</div>
            <div class="info-val">{{ auth()->user()->email }}</div>
          </div>
        </div>
        <div class="info-row">
          <div class="info-ico">📱</div>
          <div>
            <div class="info-lbl">Téléphone</div>
            <div class="info-val">{{ auth()->user()->phone ?? 'Non fourni' }}</div>
          </div>
        </div>
        <div class="info-row">
          <div class="info-ico">📅</div>
          <div>
            <div class="info-lbl">Formateur depuis</div>
            <div class="info-val">{{ auth()->user()->created_at->format('F Y') }}</div>
          </div>
        </div>
      </div>
    </div>

    <!-- RIGHT -->
    <div class="profil-right">

      <!-- BIOGRAPHIE -->
      <div class="card card-p">
        <div class="card-title">📝 Biographie &amp; Expertise <span class="card-sub"><a href="#" onclick="toggleEdit()" style="color:#0d9488;font-weight:600;text-decoration:none;">Modifier</a></span></div>
        <div id="bioView">
          <p style="font-size:14px;color:#1f2937;line-height:1.75;margin-bottom:16px;">
            {{ auth()->user()->bio ?? 'Aucune biographie renseignée.' }}
          </p>
        </div>
        <div id="bioEdit" style="display:none;">
          <textarea class="form-input" rows="5" id="bioTextarea" style="resize:vertical;">{{ auth()->user()->bio ?? '' }}</textarea>
        </div>
        <div style="margin-top:16px;">
          <div style="font-size:12px;font-weight:700;color:#6b7280;margin-bottom:10px;">DOMAINES D'EXPERTISE</div>
          <div style="display:flex;flex-wrap:wrap;gap:8px;min-height:30px;">
            <button class="skill-tag" style="border-style:dashed;background:#fff;color:#0d9488;" onclick="showToast('➕ Compétence ajoutée')">+ Ajouter</button>
          </div>
        </div>
      </div>

      <!-- FORMULAIRE ÉDITION -->
      <div class="card card-p" id="editFormCard" style="display:none;">
        <div class="card-title">✏️ Modifier les informations</div>
        <div class="edit-form">
          <div class="form-grid-2">
            <div class="form-group">
              <label class="form-label">Prénom</label>
              <input class="form-input" id="firstNameInput" value="{{ explode(' ', auth()->user()->name)[0] }}"/>
            </div>
            <div class="form-group">
              <label class="form-label">Nom</label>
              <input class="form-input" id="lastNameInput" value="{{ isset(explode(' ', auth()->user()->name)[1]) ? explode(' ', auth()->user()->name)[1] : '' }}"/>
            </div>
          </div>
          <div class="form-group">
            <label class="form-label">Titre professionnel</label>
            <input class="form-input" id="titleInput" value="Formateur"/>
          </div>
          <div class="form-grid-2">
            <div class="form-group">
              <label class="form-label">Email</label>
              <input class="form-input" type="email" id="emailInput" value="{{ auth()->user()->email }}"/>
            </div>
            <div class="form-group">
              <label class="form-label">Téléphone</label>
              <input class="form-input" id="phoneInput" value="{{ auth()->user()->phone ?? '' }}"/>
            </div>
          </div>
          <div class="form-grid-2">
            <div class="form-group">
              <label class="form-label">Ville</label>
              <input class="form-input" id="cityInput" value=""/>
            </div>
            <div class="form-group">
              <label class="form-label">Pays</label>
              <select class="form-input">
                <option selected>Tunisie</option>
                <option>Maroc</option>
                <option>Algérie</option>
                <option>France</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="form-label">Portfolio URL</label>
            <input class="form-input" type="url" id="portfolioInput" value=""/>
          </div>
        </div>
      </div>

      <!-- MES COURS (aperçu) -->
      <div class="card card-p">
        <div class="card-title">📚 Mes cours publiés <span class="card-sub"><a href="{{ route('formateur.mes-cours') }}" style="color:#0d9488;font-weight:600;text-decoration:none;">Gérer →</a></span></div>
        <div style="display:flex;flex-direction:column;gap:10px;">
          @forelse(auth()->user()->cours()->take(3)->get() as $course)
            <div style="display:flex;align-items:center;gap:12px;padding:12px;background:#f9fafb;border-radius:8px;">
              <div style="width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg, #0d9488 0%, #14b8a6 100%);display:flex;align-items:center;justify-content:center;font-size:22px;">📚</div>
              <div style="flex:1;">
                <div style="font-size:13px;font-weight:700;color:#1f2937;">{{ $course->nom }}</div>
                <div style="font-size:11px;color:#6b7280;">{{ $course->inscriptions()->count() }} étudiants · ⭐ {{ number_format($course->rating ?? 0, 1) }} · Revenus</div>
                <div style="margin-top:5px;height:4px;background:rgba(0,0,0,.07);border-radius:8px;overflow:hidden;">
                  <div style="height:100%;width:75%;background:linear-gradient(135deg, #0d9488 0%, #14b8a6 100%);border-radius:8px;"></div>
                </div>
              </div>
              <span style="background:#d1f4eb;color:#0d9488;padding:4px 10px;border-radius:6px;font-size:11px;font-weight:600;">✅</span>
            </div>
          @empty
            <div style="text-align:center;padding:20px;color:#6b7280;">
              <p>Aucun cours publié</p>
              <a href="{{ route('formateur.creer-cours') }}" style="color:#0d9488;font-weight:600;text-decoration:none;">Créer un cours</a>
            </div>
          @endforelse
        </div>
      </div>

      <!-- ACTIVITÉ RÉCENTE -->
      <div class="card card-p">
        <div class="card-title">📋 Activité récente</div>
        <div>
          <div style="display:flex;gap:12px;padding:12px 0;border-bottom:1px solid #e5e7eb;">
            <div style="width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0;background:#f0fdf4;">💬</div>
            <div style="flex:1;">
              <div style="font-size:13px;color:#1f2937;line-height:1.4;"><strong>Vous avez répondu</strong> à la question d'un étudiant dans le forum</div>
              <div style="font-size:11px;color:#6b7280;margin-top:3px;">Il y a quelques heures</div>
            </div>
          </div>
          <div style="display:flex;gap:12px;padding:12px 0;border-bottom:1px solid #e5e7eb;">
            <div style="width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0;background:#d1f4eb;">✅</div>
            <div style="flex:1;">
              <div style="font-size:13px;color:#1f2937;line-height:1.4;"><strong>Vous avez corrigé</strong> les devoirs d'étudiants</div>
              <div style="font-size:11px;color:#6b7280;margin-top:3px;">Hier</div>
            </div>
          </div>
          <div style="display:flex;gap:12px;padding:12px 0;">
            <div style="width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0;background:#e0f2fe;">🎬</div>
            <div style="flex:1;">
              <div style="font-size:13px;color:#1f2937;line-height:1.4;"><strong>Live terminé</strong> — {{ auth()->user()->cours()->first()?->nom ?? 'Cours' }}</div>
              <div style="font-size:11px;color:#6b7280;margin-top:3px;">Il y a 2 jours</div>
            </div>
          </div>
        </div>
      </div>

      <!-- PARAMÈTRES COMPTE -->
      <div class="card" style="overflow:hidden;">
        <div style="padding:18px 24px 12px;">
          <div class="card-title">⚙️ Paramètres du compte</div>
        </div>
        <div>
          <div class="info-row" style="padding:14px 24px;">
            <div style="font-size:20px;width:28px;text-align:center;">🔔</div>
            <div style="flex:1;">
              <div style="font-size:13px;font-weight:600;color:#1f2937;">Notifications email</div>
              <div style="font-size:11px;color:#6b7280;">Questions et messages des étudiants</div>
            </div>
            <label class="toggle-switch">
              <input type="checkbox" checked />
              <span class="toggle-slider"></span>
            </label>
          </div>
          <div class="info-row" style="padding:14px 24px;">
            <div style="font-size:20px;width:28px;text-align:center;">📊</div>
            <div style="flex:1;">
              <div style="font-size:13px;font-weight:600;color:#1f2937;">Rapport hebdomadaire</div>
              <div style="font-size:11px;color:#6b7280;">Statistiques envoyées chaque semaine</div>
            </div>
            <label class="toggle-switch">
              <input type="checkbox" checked />
              <span class="toggle-slider"></span>
            </label>
          </div>
          <div class="info-row" style="padding:14px 24px;border-bottom:none;">
            <div style="font-size:20px;width:28px;text-align:center;">🔐</div>
            <div style="flex:1;">
              <div style="font-size:13px;font-weight:600;color:#1f2937;">Authentification 2FA</div>
              <div style="font-size:11px;color:#6b7280;">Sécurité renforcée de votre compte</div>
            </div>
            <label class="toggle-switch">
              <input type="checkbox" />
              <span class="toggle-slider"></span>
            </label>
          </div>
          <div style="padding:14px 24px;display:flex;gap:10px;flex-wrap:wrap;">
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
              @csrf
              <button type="submit" class="btn btn-danger btn-sm">👋 Déconnexion</button>
            </form>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

</div>

<script>
var editing = false;
function toggleEdit(){
  editing = !editing;
  document.getElementById('editFormCard').style.display = editing ? '' : 'none';
  document.getElementById('bioEdit').style.display = editing ? '' : 'none';
  document.getElementById('bioView').style.display = editing ? 'none' : '';
  document.getElementById('editBtn').style.display = editing ? 'none' : '';
  document.getElementById('saveBtn').style.display = editing ? '' : 'none';
}
function saveProfile(){
  editing = false;
  document.getElementById('editFormCard').style.display = 'none';
  document.getElementById('bioEdit').style.display = 'none';
  document.getElementById('bioView').style.display = '';
  document.getElementById('editBtn').style.display = '';
  document.getElementById('saveBtn').style.display = 'none';
  showToast('✅ Profil mis à jour avec succès !');
}
</script>