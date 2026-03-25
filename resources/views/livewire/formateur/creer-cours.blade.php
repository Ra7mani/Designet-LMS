<div>
  <style>
    .wizard-steps{display:flex;gap:0;margin-bottom:28px;background:var(--card);border-radius:var(--r);padding:6px;border:1.5px solid var(--border);box-shadow:var(--sh);}
    .wstep{flex:1;text-align:center;padding:12px;border-radius:var(--rm);cursor:pointer;transition:all .2s;}
    .wstep.active{background:var(--vgrad);color:#fff;box-shadow:0 4px 12px rgba(13,148,136,.28);}
    .wstep:not(.active):hover{background:var(--vxl);}
    .wstep-num{font-family:Poppins,sans-serif;font-size:18px;font-weight:900;margin-bottom:3px;}
    .wstep-lbl{font-size:11px;font-weight:600;opacity:.85;}
    .wstep.done .wstep-num::before{content:"✓ ";}
    .upload-zone{border:2px dashed var(--border);border-radius:var(--rm);padding:32px;text-align:center;cursor:pointer;transition:all .2s;background:var(--bg);}
    .upload-zone:hover{border-color:var(--vl);background:var(--vxl);}
    .upload-zone-ico{font-size:40px;margin-bottom:10px;}
    .upload-zone p{font-size:13px;color:var(--muted);}
    .editor-toolbar{display:flex;gap:6px;padding:10px 14px;border-bottom:1.5px solid var(--border);background:var(--bg);flex-wrap:wrap;}
    .editor-btn{padding:5px 10px;border-radius:var(--rs);border:1.5px solid var(--border);background:#fff;font-size:12px;font-weight:600;cursor:pointer;transition:all .15s;}
    .editor-btn:hover{background:var(--vxl);border-color:var(--vl);color:var(--v);}
    .editor-area{min-height:180px;padding:14px;font-family:DM Sans,sans-serif;font-size:14px;border:none;outline:none;width:100%;resize:vertical;}
    .chapter-builder-item{display:flex;align-items:center;gap:10px;padding:12px 14px;border-radius:var(--rm);border:1.5px solid var(--border);background:var(--bg);margin-bottom:10px;cursor:grab;}
    .chapter-builder-item:active{cursor:grabbing;}
    .drag-handle{color:var(--muted);font-size:18px;cursor:grab;flex-shrink:0;}
    .content-type-btns{display:flex;gap:10px;flex-wrap:wrap;}
    .ctype-btn{display:flex;flex-direction:column;align-items:center;gap:6px;padding:16px 20px;border-radius:var(--rm);border:1.5px solid var(--border);background:#fff;cursor:pointer;transition:all .2s;text-align:center;}
    .ctype-btn:hover{border-color:var(--vl);background:var(--vxl);transform:translateY(-2px);}
    .ctype-btn.selected{border-color:var(--v);background:var(--vxl);box-shadow:0 0 0 3px rgba(13,148,136,.12);}
    .ctype-ico{font-size:28px;}
    .ctype-lbl{font-size:12px;font-weight:700;color:var(--txt);}
    .preview-card{position:sticky;top:72px;}
    .price-row{display:flex;gap:10px;align-items:center;}
    .price-currency{padding:10px 14px;background:var(--vxl);border-radius:var(--rs) 0 0 var(--rs);font-weight:700;color:var(--v);border:1.5px solid var(--border);border-right:none;}
    .price-input{border-radius:0 var(--rs) var(--rs) 0 !important;}
    .level-btns{display:flex;gap:8px;}
    .level-btn{padding:8px 16px;border-radius:var(--rp);border:1.5px solid var(--border);background:#fff;font-size:13px;font-weight:600;cursor:pointer;transition:all .2s;color:var(--muted);}
    .level-btn:hover{border-color:var(--vl);color:var(--v);}
    .level-btn.selected{background:var(--vgrad);color:#fff;border-color:transparent;}
    .form-error{color:#dc2626;font-size:12px;margin-top:4px;display:block;font-weight:500;}
    .is-invalid{border-color:#dc2626 !important;}
  </style>

  <!-- WIZARD STEPS -->
  <div class="wizard-steps fu fu1">
    <div class="wstep @if($step === 1) active @elseif($step > 1) done @endif" wire:click="setStep(1)">
      <div class="wstep-num">1</div>
      <div class="wstep-lbl">Informations</div>
    </div>
    <div class="wstep @if($step === 2) active @elseif($step > 2) done @endif" wire:click="setStep(2)">
      <div class="wstep-num">2</div>
      <div class="wstep-lbl">Contenu</div>
    </div>
    <div class="wstep @if($step === 3) active @elseif($step > 3) done @endif" wire:click="setStep(3)">
      <div class="wstep-num">3</div>
      <div class="wstep-lbl">Quiz & Devoirs</div>
    </div>
    <div class="wstep @if($step === 4) active @endif" wire:click="setStep(4)">
      <div class="wstep-num">4</div>
      <div class="wstep-lbl">Prix & Publication</div>
    </div>
  </div>

  <div class="grid-2 fu fu2" style="align-items:start;">
    <!-- LEFT: FORM -->
    <div style="display:flex;flex-direction:column;gap:20px;">

      <!-- STEP 1: Infos générales -->
      @if($step === 1)
      <div class="card card-p">
        <div class="card-title">📋 Informations générales</div>
        <div style="display:flex;flex-direction:column;gap:14px;">
          <div class="form-group">
            <label class="form-label">Titre du cours *</label>
            <input class="form-input @error('title') is-invalid @enderror" wire:model.live="title" placeholder="Ex: UX/UI Design Avancé"/>
            @error('title')<span class="form-error">{{ $message }}</span>@enderror
          </div>
          <div class="form-grid-2">
            <div class="form-group">
              <label class="form-label">Catégorie *</label>
              <select class="form-select @error('category_id') is-invalid @enderror" wire:model.live="category_id">
                <option value="0">Sélectionner une catégorie</option>
                @forelse($categories as $cat)
                  <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @empty
                  <option>Aucune catégorie disponible</option>
                @endforelse
              </select>
              @error('category_id')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
              <label class="form-label">Langue</label>
              <select class="form-select" wire:model.live="language">
                <option>Français</option>
                <option>Arabe</option>
                <option>Anglais</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="form-label">Niveau *</label>
            <div class="level-btns">
              <div class="level-btn @if($level === 'beginner') selected @endif" wire:click="setLevel('beginner')">Débutant</div>
              <div class="level-btn @if($level === 'intermediate') selected @endif" wire:click="setLevel('intermediate')">Intermédiaire</div>
              <div class="level-btn @if($level === 'advanced') selected @endif" wire:click="setLevel('advanced')">Avancé</div>
              <div class="level-btn @if($level === 'all') selected @endif" wire:click="setLevel('all')">Tous niveaux</div>
            </div>
            @error('level')<span class="form-error">{{ $message }}</span>@enderror
          </div>
          <div class="form-group">
            <label class="form-label">Description courte *</label>
            <input class="form-input @error('shortDescription') is-invalid @enderror" wire:model.live="shortDescription" placeholder="Ex: Maîtrisez les design systems…"/>
            @error('shortDescription')<span class="form-error">{{ $message }}</span>@enderror
          </div>
          <div class="form-group">
            <label class="form-label">Description complète</label>
            <div class="card" style="overflow:hidden;">
              <div class="editor-toolbar">
                <button class="editor-btn" type="button">
                  <strong>B</strong>
                </button>
                <button class="editor-btn" type="button">
                  <em>I</em>
                </button>
                <button class="editor-btn" type="button">
                  <u>U</u>
                </button>
                <button class="editor-btn" type="button">≡</button>
                <button class="editor-btn" type="button">🔗</button>
                <button class="editor-btn" type="button">🖼</button>
              </div>
              <textarea class="editor-area" wire:model.live="description" placeholder="Décrivez votre cours en détail…"></textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="form-label">Image de couverture</label>
            <div class="upload-zone" onclick="document.querySelector('input[type=file]').click()">
              <div class="upload-zone-ico">🖼️</div>
              <p>Glissez une image ici ou cliquez pour sélectionner<br/><small>PNG, JPG — 1280×720px recommandé</small></p>
            </div>
            <input type="file" style="display:none;" wire:model.live="coverImage" accept="image/*"/>
          </div>
        </div>
      </div>
      @endif

      <!-- STEP 2: Chapitres -->
      @if($step === 2)
      <div class="card card-p">
        <div class="card-title">📚 Chapitres &amp; Contenu
          <button class="btn btn-primary btn-sm" style="margin-left:auto;" wire:click="addChapter">+ Ajouter</button>
        </div>
        <div id="chapterList">
          @forelse($chapters as $index => $chapter)
          <div class="chapter-builder-item">
            <span class="drag-handle">⠿</span>
            <div style="width:28px;height:28px;border-radius:8px;background:var(--mintd);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:11px;flex-shrink:0;">{{ $index + 1 }}</div>
            <div style="flex:1;min-width:0;"><input class="form-input" style="padding:7px 10px;" wire:model.live="chapters.{{ $index }}.title" placeholder="Titre du chapitre"/></div>
            <span class="pill pill-teal">{{ ucfirst($chapter['type'] ?? 'Vidéo') }}</span>
            <button class="btn btn-sm btn-ghost" type="button" wire:click="editChapter({{ $index }})">Éditer</button>
            <button class="btn btn-sm btn-outline" type="button" wire:click="removeChapter({{ $index }})">✕</button>
          </div>
          @empty
          <p style="color:var(--muted);text-align:center;padding:20px;">Aucun chapitre pour le moment. Cliquez sur "Ajouter" pour commencer.</p>
          @endforelse
        </div>
        <div style="margin-top:14px;">
          <div class="form-label" style="margin-bottom:10px;">Type de contenu à ajouter</div>
          <div class="content-type-btns">
            <div class="ctype-btn @if($selectedContentType === 'video') selected @endif" wire:click="setContentType('video')"><div class="ctype-ico">🎬</div><div class="ctype-lbl">Vidéo</div></div>
            <div class="ctype-btn @if($selectedContentType === 'pdf') selected @endif" wire:click="setContentType('pdf')"><div class="ctype-ico">📄</div><div class="ctype-lbl">PDF / Doc</div></div>
            <div class="ctype-btn @if($selectedContentType === 'quiz') selected @endif" wire:click="setContentType('quiz')"><div class="ctype-ico">📝</div><div class="ctype-lbl">Quiz</div></div>
            <div class="ctype-btn @if($selectedContentType === 'assignment') selected @endif" wire:click="setContentType('assignment')"><div class="ctype-ico">🎓</div><div class="ctype-lbl">Devoir</div></div>
            <div class="ctype-btn @if($selectedContentType === 'link') selected @endif" wire:click="setContentType('link')"><div class="ctype-ico">🔗</div><div class="ctype-lbl">Lien</div></div>
          </div>
        </div>
      </div>
      @endif

      <!-- STEP 3: Quiz & Devoirs -->
      @if($step === 3)
      <div class="card card-p">
        <div class="card-title">📝 Quiz &amp; Devoirs</div>
        <div style="display:flex;flex-direction:column;gap:14px;">
          <p style="color:var(--muted);font-size:13px;">Les quizzes et devoirs permettront aux étudiants d'évaluer leur apprentissage et de pratiquer.</p>
          <button class="btn btn-primary" wire:click="addQuiz">+ Ajouter un Quiz</button>
          <button class="btn btn-primary" wire:click="addAssignment">+ Ajouter un Devoir</button>
        </div>
      </div>
      @endif

      <!-- STEP 4: PRIX -->
      @if($step === 4)
      <div class="card card-p">
        <div class="card-title">💰 Prix &amp; Publication</div>
        <div style="display:flex;flex-direction:column;gap:14px;">
          <div class="form-group">
            <label class="form-label">Prix</label>
            <div class="price-row">
              <div class="price-currency">€</div>
              <input class="form-input price-input" type="number" wire:model.live="price" step="0.01" min="0"/>
            </div>
          </div>
          <div class="form-group">
            <label class="form-label">Code promo (optionnel)</label>
            <input class="form-input" wire:model.live="promoCode" placeholder="Ex: LAUNCH20 — 20% de réduction"/>
          </div>
          <div style="display:flex;align-items:center;justify-content:space-between;padding:14px;background:var(--bg);border-radius:var(--rm);border:1.5px solid var(--border);">
            <div>
              <div style="font-size:14px;font-weight:600;color:var(--txt);">Cours certifiant</div>
              <div style="font-size:11px;color:var(--muted);margin-top:2px;">Les étudiants reçoivent un certificat à la fin</div>
            </div>
            <label class="toggle">
              <input type="checkbox" wire:model.live="certificateEnabled"/>
              <div class="toggle-track"></div>
              <div class="toggle-thumb"></div>
            </label>
          </div>
          <div style="display:flex;align-items:center;justify-content:space-between;padding:14px;background:var(--bg);border-radius:var(--rm);border:1.5px solid var(--border);">
            <div>
              <div style="font-size:14px;font-weight:600;color:var(--txt);">Forum de discussion</div>
              <div style="font-size:11px;color:var(--muted);margin-top:2px;">Activer le forum pour ce cours</div>
            </div>
            <label class="toggle">
              <input type="checkbox" wire:model.live="forumEnabled"/>
              <div class="toggle-track"></div>
              <div class="toggle-thumb"></div>
            </label>
          </div>
        </div>
      </div>
      @endif

    </div>

    <!-- RIGHT: PREVIEW -->
    <div class="preview-card">
      <div class="card card-p fu fu3">
        <div class="card-title">👁 Aperçu</div>
        <div style="background:linear-gradient(135deg,#134E4A,#0D9488);border-radius:var(--rm);padding:20px;margin-bottom:14px;text-align:center;">
          <div style="font-size:48px;margin-bottom:10px;">✨</div>
          <div style="font-family:Poppins,sans-serif;font-size:16px;font-weight:800;color:#fff;margin-bottom:4px;">{{ $title ?: 'Titre du cours' }}</div>
          <div style="font-size:12px;color:rgba(255,255,255,.7);">{{ $this->categoryName }} · {{ $level ?: 'Niveau' }} · Votre nom</div>
        </div>
        <div style="display:flex;flex-direction:column;gap:10px;font-size:13px;color:var(--muted);">
          <div style="display:flex;justify-content:space-between;"><span>Catégorie</span><strong style="color:var(--txt);">{{ $this->categoryName }}</strong></div>
          <div style="display:flex;justify-content:space-between;"><span>Niveau</span><strong style="color:var(--txt);">{{ ucfirst($level) ?: 'Non défini' }}</strong></div>
          <div style="display:flex;justify-content:space-between;"><span>Chapitres</span><strong style="color:var(--txt);">{{ count($chapters) }} / 22</strong></div>
          <div style="display:flex;justify-content:space-between;"><span>Prix</span><strong style="color:var(--v);">{{ $price ?: '0' }}€</strong></div>
          <div style="display:flex;justify-content:space-between;"><span>Certificat</span><strong style="color:var(--mintd);">{{ $certificateEnabled ? '✅ Oui' : '❌ Non' }}</strong></div>
        </div>
        <div style="margin-top:16px;padding-top:14px;border-top:1px solid var(--border);">
          <div style="font-size:11px;color:var(--muted);margin-bottom:8px;">Progression de création</div>
          <div class="prog-bar"><div class="prog-fill prog-v prog-anim" style="--w:{{ count($chapters) > 0 ? (count($chapters) / 22 * 100) : 0 }}%"></div></div>
          <div style="font-size:11px;color:var(--muted);margin-top:5px;">{{ count($chapters) > 0 ? (count($chapters) / 22 * 100) : 0 }}% — {{ count($chapters) }}/22 chapitres créés</div>
        </div>
        <div style="margin-top:16px;display:flex;flex-direction:column;gap:8px;">
          <button class="btn btn-primary" style="width:100%;" type="button" wire:click="publishCourse">🚀 Soumettre pour publication</button>
          <button class="btn btn-outline" style="width:100%;" type="button" wire:click="saveDraft">💾 Sauvegarder le brouillon</button>
          <button class="btn btn-ghost" style="width:100%;" type="button">👁 Aperçu étudiant</button>
        </div>
      </div>
    </div>
  </div>

</div>
