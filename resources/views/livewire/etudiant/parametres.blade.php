<div>
<style>
/* HEADER */
.hdr {
    position: sticky;
    top: 0;
    z-index: 50;
    background: rgba(245, 243, 255, .90);
    backdrop-filter: blur(14px);
    border-bottom: 1.5px solid var(--border);
    padding: 15px 30px;
    display: flex;
    align-items: center;
    gap: 14px;
    justify-content: space-between;
}
.hdr-left {
    flex: 1;
}
.hdr-left h1 {
    font-family: 'Poppins', sans-serif;
    font-size: 20px;
    font-weight: 800;
    color: var(--txt);
}
.hdr-left p {
    font-size: 12px;
    color: var(--muted);
    margin-top: 1px;
}
.hdr-right {
    display: flex;
    gap: 10px;
}

/* PAGE */
.page {
    padding: 28px 30px;
    display: flex;
    gap: 26px;
}

/* SIDEBAR NAV */
.settings-nav {
    width: 240px;
    flex-shrink: 0;
    display: flex;
    flex-direction: column;
    gap: 4px;
}
.nav-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 16px;
    border-radius: var(--rs);
    color: var(--muted);
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: all .2s;
    text-decoration: none;
    border: none;
    background: none;
    width: 100%;
    text-align: left;
}
.nav-item svg {
    width: 18px;
    height: 18px;
    stroke: currentColor;
}
.nav-item:hover {
    background: var(--vxl);
    color: var(--v);
}
.nav-item.active {
    background: var(--vgrad);
    color: #fff;
    box-shadow: 0 4px 14px rgba(124, 58, 237, .28);
}
.nav-item.active svg {
    stroke: #fff;
}

/* MAIN */
.settings-main {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 20px;
}

/* SECTION */
.settings-section {
    background: #fff;
    border-radius: var(--r);
    padding: 28px;
    border: 1.5px solid var(--border);
    box-shadow: var(--sh);
}
.section-title {
    font-family: 'Poppins', sans-serif;
    font-size: 16px;
    font-weight: 700;
    color: var(--txt);
    margin-bottom: 6px;
}
.section-desc {
    font-size: 13px;
    color: var(--muted);
    margin-bottom: 24px;
}

/* FORM */
.form-row {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
    margin-bottom: 16px;
}
.form-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
}
.form-group.full {
    grid-column: 1 / -1;
}
.form-group label {
    font-size: 12px;
    font-weight: 600;
    color: var(--txt);
}
.form-group input,
.form-group select,
.form-group textarea {
    padding: 11px 14px;
    border: 1.5px solid var(--border);
    border-radius: var(--rs);
    font-family: 'DM Sans', sans-serif;
    font-size: 13px;
    color: var(--txt);
    transition: all .2s;
}
.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: var(--vl);
    box-shadow: 0 0 0 3px rgba(167, 139, 250, .15);
}
.form-group textarea {
    min-height: 100px;
    resize: vertical;
}
.form-error {
    font-size: 11px;
    color: #ef4444;
    margin-top: 2px;
}

.form-success {
    font-size: 11px;
    color: #10b981;
    margin-top: 2px;
    font-weight: 600;
}

/* PASSWORD INPUT GROUP */
.password-input-group {
    position: relative;
    display: flex;
    align-items: center;
}
.password-input-group input {
    width: 100%;
    padding-right: 40px;
}
.eye-icon {
    position: absolute;
    right: 12px;
    background: none;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 24px;
    height: 24px;
    color: var(--muted);
    transition: all .2s;
    padding: 0;
}
.eye-icon:hover {
    color: var(--v);
}
.eye-icon svg {
    width: 18px;
    height: 18px;
    stroke: currentColor;
}

/* TOGGLE */
.toggle-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 0;
    border-bottom: 1px solid var(--border);
}
.toggle-row:last-child {
    border-bottom: none;
}
.toggle-info {}
.toggle-label {
    font-size: 14px;
    font-weight: 600;
    color: var(--txt);
    margin-bottom: 2px;
}
.toggle-desc {
    font-size: 12px;
    color: var(--muted);
}
.toggle {
    position: relative;
    width: 48px;
    height: 26px;
}
.toggle input {
    opacity: 0;
    width: 0;
    height: 0;
}
.toggle-slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: #E5E7EB;
    border-radius: var(--rp);
    transition: all .3s;
}
.toggle-slider::before {
    content: '';
    position: absolute;
    height: 20px;
    width: 20px;
    left: 3px;
    bottom: 3px;
    background: #fff;
    border-radius: 50%;
    transition: all .3s;
    box-shadow: 0 2px 6px rgba(0, 0, 0, .15);
}
.toggle input:checked + .toggle-slider {
    background: var(--vgrad);
}
.toggle input:checked + .toggle-slider::before {
    transform: translateX(22px);
}

/* BUTTONS */
.form-actions {
    display: flex;
    gap: 12px;
    margin-top: 8px;
}
.btn-save {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: var(--vgrad);
    color: #fff;
    border: none;
    cursor: pointer;
    font-family: 'DM Sans', sans-serif;
    font-size: 13px;
    font-weight: 700;
    padding: 11px 24px;
    border-radius: var(--rp);
    box-shadow: 0 4px 14px rgba(124, 58, 237, .28);
    transition: all .2s;
}
.btn-save:hover:not(:disabled) {
    transform: translateY(-2px);
}
.btn-save:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}
.btn-save svg {
    width: 14px;
    height: 14px;
    stroke: #fff;
}
.btn-ghost {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: #fff;
    color: var(--muted);
    border: 1.5px solid var(--border);
    cursor: pointer;
    font-family: 'DM Sans', sans-serif;
    font-size: 13px;
    font-weight: 600;
    padding: 10px 20px;
    border-radius: var(--rp);
    transition: all .2s;
}
.btn-ghost:hover {
    background: var(--bg);
    border-color: var(--muted);
}
.btn-secondary {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: rgba(167, 139, 250, 0.1);
    color: var(--v);
    border: 1.5px solid var(--vl);
    cursor: pointer;
    font-family: 'DM Sans', sans-serif;
    font-size: 13px;
    font-weight: 600;
    padding: 10px 20px;
    border-radius: var(--rp);
    transition: all .2s;
}
.btn-secondary:hover {
    background: rgba(167, 139, 250, 0.2);
}
.btn-danger {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: #fff;
    color: var(--peachd);
    border: 1.5px solid var(--peach);
    cursor: pointer;
    font-family: 'DM Sans', sans-serif;
    font-size: 13px;
    font-weight: 600;
    padding: 10px 20px;
    border-radius: var(--rp);
    transition: all .2s;
}
.btn-danger:hover {
    background: var(--peach);
    color: #fff;
}

/* SUBSECTION */
.subsection {
    margin-bottom: 26px;
    padding-bottom: 16px;
    border-bottom: 1px solid var(--border);
}
.subsection:last-child {
    border-bottom: none;
}
.subsection h3 {
    font-size: 14px;
    font-weight: 600;
    color: var(--txt);
    margin-bottom: 12px;
}

/* PREFERENCE ITEM */
.preference-item {
    display: grid;
    grid-template-columns: 1fr 200px;
    align-items: center;
    gap: 16px;
    padding: 12px 0;
    border-bottom: 1px solid var(--border);
}
.preference-item:last-child {
    border-bottom: none;
}
.preference-item label {
    font-weight: 500;
    color: var(--txt);
}
.preference-item select {
    padding: 8px 12px;
    border: 1.5px solid var(--border);
    border-radius: var(--rs);
    font-size: 13px;
    color: var(--txt);
}

/* SUBSCRIPTION PLAN CARD */
.plan-card {
    background: linear-gradient(135deg, rgba(167, 139, 250, 0.1), rgba(109, 40, 217, 0.05));
    border: 1.5px solid var(--vl);
    border-radius: var(--r);
    padding: 16px;
    margin: 20px 0;
}
.plan-card h3 {
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 8px;
}
.plan-card p {
    font-size: 13px;
    color: var(--muted);
}

/* DANGER ZONE */
.danger-zone {
    border-color: var(--peach) !important;
}
.danger-zone .section-title {
    color: var(--peachd);
}

/* RECOVERY CODES */
.recovery-codes-box {
    background: #fffaed;
    border: 1.5px solid #ffd89b;
    border-radius: var(--r);
    padding: 16px;
    margin: 16px 0;
}
.recovery-codes-box h4 {
    font-size: 14px;
    font-weight: 600;
    color: #92400e;
    margin-bottom: 8px;
}
.recovery-codes-box p {
    font-size: 12px;
    color: #b45309;
    margin-bottom: 12px;
}
.recovery-codes-box ul {
    list-style: none;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 8px;
}
.recovery-codes-box li {
    font-family: 'Courier New', monospace;
    font-size: 12px;
    background: white;
    padding: 8px;
    border-radius: 4px;
    border: 1px solid #fde68a;
}

/* QR CODE */
.qr-code-wrapper {
    display: flex;
    justify-content: center;
    margin: 20px 0;
}
.qr-code-wrapper svg {
    max-width: 200px;
    height: auto;
}

/* MODAL */
.modal-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 100;
}
.modal {
    background: white;
    border-radius: var(--r);
    padding: 28px;
    max-width: 500px;
    width: 90%;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
}
.modal h2 {
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 12px;
    color: var(--txt);
}
.modal p {
    font-size: 14px;
    color: var(--muted);
    margin-bottom: 16px;
}
.modal input {
    width: 100%;
    padding: 11px 14px;
    border: 1.5px solid var(--border);
    border-radius: var(--rs);
    font-size: 13px;
    margin-bottom: 16px;
    box-sizing: border-box;
}
.modal-actions {
    display: flex;
    gap: 12px;
    margin-top: 20px;
}
.modal-actions button {
    flex: 1;
}

@media (max-width: 900px) {
    .page {
        flex-direction: column;
    }
    .settings-nav {
        width: 100%;
        flex-direction: row;
        flex-wrap: wrap;
    }
    .preference-item {
        grid-template-columns: 1fr;
    }
}
@media (max-width: 700px) {
    .page {
        padding: 18px 16px;
    }
    .form-row {
        grid-template-columns: 1fr;
    }
    .hdr {
        flex-direction: column;
        align-items: flex-start;
    }
    .hdr-right {
        width: 100%;
    }
}
</style>

<!-- HEADER -->
<header class="hdr">
    <div class="hdr-left">
        <h1>⚙️ Paramètres</h1>
        <p>Personnalise ton expérience</p>
    </div>
</header>

<!-- PAGE -->
<div class="page">
    <!-- SIDEBAR NAV -->
    <nav class="settings-nav fu fu1">
        <button wire:click="$set('activeSection', 'account')"
            class="nav-item {{ $activeSection === 'account' ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                <circle cx="12" cy="7" r="4" />
            </svg>
            Compte
        </button>
        <button wire:click="$set('activeSection', 'notifications')"
            class="nav-item {{ $activeSection === 'notifications' ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round">
                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                <path d="M13.73 21a2 2 0 0 1-3.46 0" />
            </svg>
            Notifications
        </button>
        <button wire:click="$set('activeSection', 'security')"
            class="nav-item {{ $activeSection === 'security' ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                <path d="M7 11V7a5 5 0 0 1 10 0v4" />
            </svg>
            Sécurité
        </button>
    </nav>

    <!-- MAIN -->
    <div class="settings-main">

        <!-- ACCOUNT SECTION -->
        @if ($activeSection === 'account')
            <div class="settings-section fu fu2">
                <div class="section-title">Informations du Compte</div>
                <div class="section-desc">Mets à jour tes informations personnelles</div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Prénom</label>
                        <input type="text" wire:model.live="firstName" placeholder="Ton prénom" />
                        @error('firstName')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Nom</label>
                        <input type="text" wire:model.live="lastName" placeholder="Ton nom" />
                        @error('lastName')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" wire:model.live="email" placeholder="ton@email.com" />
                        @error('email')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Téléphone</label>
                        <input type="tel" wire:model.live="phone" placeholder="+212 6XX XXX XXX" />
                    </div>
                </div>

                

                <div class="form-group full">
                    <label>Bio</label>
                    <textarea wire:model.live="bio" placeholder="Parle-nous de toi..."></textarea>
                </div>

                <!-- Subscription Plan -->
                <div class="plan-card">
                    <h3>Plan d'abonnement</h3>
                    <p>Plan actuel: <strong>{{ ucfirst($subscriptionPlan) }}</strong></p>
                    @if ($subscriptionExpiresAt)
                        <p>Expire le: {{ $subscriptionExpiresAt }}</p>
                    @endif
                    @if ($subscriptionPlan === 'free')
                        <button wire:click="openUpgradeModal" class="btn-secondary" style="margin-top: 12px;">
                            ⭐ Passer en Premium
                        </button>
                    @endif
                </div>

                <!-- Export Data Button -->
                <div class="form-actions">
                    <button wire:click="requestDataExport" wire:loading.attr="disabled" class="btn-secondary">
                        📥 Exporter mes données
                    </button>
                </div>
            </div>

        <!-- NOTIFICATIONS SECTION -->
        @elseif ($activeSection === 'notifications')
            <div class="settings-section fu fu3">
                <div class="section-title">Préférences de Notification</div>
                <div class="section-desc">Gère tes préférences de notification</div>

                <div class="toggle-row">
                    <div class="toggle-info">
                        <div class="toggle-label">Notifications par email</div>
                        <div class="toggle-desc">Reçois les mises à jour importantes par email</div>
                    </div>
                    <label class="toggle">
                        <input type="checkbox" wire:model.live="email_notifications" />
                        <span class="toggle-slider"></span>
                    </label>
                </div>

                <div class="toggle-row">
                    <div class="toggle-info">
                        <div class="toggle-label">Rappels de cours</div>
                        <div class="toggle-desc">Rappels pour continuer tes cours en cours</div>
                    </div>
                    <label class="toggle">
                        <input type="checkbox" wire:model.live="course_reminders" />
                        <span class="toggle-slider"></span>
                    </label>
                </div>

                <div class="toggle-row">
                    <div class="toggle-info">
                        <div class="toggle-label">Annonces et promotions</div>
                        <div class="toggle-desc">Nouveaux cours et offres spéciales</div>
                    </div>
                    <label class="toggle">
                        <input type="checkbox" wire:model.live="announcements" />
                        <span class="toggle-slider"></span>
                    </label>
                </div>

                <div class="toggle-row">
                    <div class="toggle-info">
                        <div class="toggle-label">Messages du forum</div>
                        <div class="toggle-desc">Réponses et mentions dans le forum</div>
                    </div>
                    <label class="toggle">
                        <input type="checkbox" wire:model.live="forum_messages" />
                        <span class="toggle-slider"></span>
                    </label>
                </div>
            </div>

        <!-- SECURITY SECTION -->
        @elseif ($activeSection === 'security')
            <div class="settings-section fu fu4">
                <div class="section-title">Sécurité de ton Compte</div>
                <div class="section-desc">Gère tes paramètres de sécurité</div>

                <!-- Password Change -->
                <div class="subsection">
                    <h3>Changer le mot de passe</h3>

                    <div class="form-row">
                        <div class="form-group full">
                            <label>Mot de passe actuel</label>
                            <div class="password-input-group">
                                <input type="{{ $showCurrentPassword ? 'text' : 'password' }}"
                                    wire:model.live="currentPassword"
                                    placeholder="Mot de passe actuel" />
                                <button type="button" wire:click="toggleCurrentPassword" class="eye-icon">
                                    @if ($showCurrentPassword)
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                                    @endif
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Nouveau mot de passe</label>
                            <div class="password-input-group">
                                <input type="{{ $showNewPassword ? 'text' : 'password' }}"
                                    wire:model.live="newPassword"
                                    placeholder="Nouveau mot de passe (min. 8 caractères)" />
                                <button type="button" wire:click="toggleNewPassword" class="eye-icon">
                                    @if ($showNewPassword)
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                                    @endif
                                </button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Confirmer le mot de passe</label>
                            <div class="password-input-group">
                                <input type="{{ $showPasswordConfirmation ? 'text' : 'password' }}"
                                    wire:model.live="newPassword_confirmation"
                                    placeholder="Confirmer" />
                                <button type="button" wire:click="togglePasswordConfirmation" class="eye-icon">
                                    @if ($showPasswordConfirmation)
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                                    @endif
                                </button>
                            </div>
                        </div>
                    </div>

                    @if ($passwordChangeError)
                        <span class="form-error" style="margin-bottom: 12px; display: block;">{{ $passwordChangeError }}
                        </span>
                    @endif

                    @if ($passwordChangeSuccess)
                        <span class="form-success" style="margin-bottom: 12px; display: block;">{{ $passwordChangeSuccess }}
                        </span>
                    @endif

                    <div class="form-actions">
                        <button wire:click="changePassword" class="btn-save">
                            Mettre à jour le mot de passe
                        </button>
                    </div>
                </div>

                <!-- 2FA Section -->
                <div class="subsection">
                    <h3>Authentification à Deux Facteurs (2FA)</h3>

                    @if (!$twoFactorEnabled)
                        <p style="color: #666; margin-bottom: 12px;">2FA n'est pas activée. Activez-la pour
                            sécuriser votre compte.</p>
                        <div class="form-actions">
                            <button wire:click="initiateTwoFactorSetup" class="btn-secondary">
                                🔐 Activer 2FA
                            </button>
                        </div>
                    @else
                        <p style="color: #10b981; margin-bottom: 12px;"><strong>✓ 2FA est activée</strong></p>
                        <div class="form-actions">
                            <button wire:click="regenerateRecoveryCodes" class="btn-secondary">
                                🔄 Régénérer les codes
                            </button>
                            <button wire:click="disableTwoFactor" class="btn-danger">
                                Désactiver 2FA
                            </button>
                        </div>
                    @endif
                </div>

                <!-- Recovery Codes Display -->
                @if (!empty($recoveryCodesList))
                    <div class="recovery-codes-box">
                        <h4>⚠️ Codes de Récupération</h4>
                        <p>Sauvegardez ces codes dans un endroit sûr. Vous en aurez besoin si vous perdez l'accès à
                            votre appareil 2FA:</p>
                        <ul>
                            @foreach ($recoveryCodesList as $code)
                                <li>{{ $code }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        @endif

        <!-- DANGER ZONE (Always visible) -->
        <div class="settings-section danger-zone fu fu-danger">
            <div class="section-title" style="color: #DC2626;">⚠️ Zone de Danger</div>
            <div class="section-desc">Actions irréversibles sur ton compte</div>
            <div class="form-actions">
                <button wire:click="openDeleteModal" class="btn-danger">
                    🗑️ Supprimer mon compte
                </button>
            </div>
        </div>
    </div>

    <!-- Delete Account Modal -->
@if ($showDeleteModal)
    <div class="modal-backdrop">
        <div class="modal">
            <h2>⚠️ Supprimer le Compte</h2>
            <p>Cette action est <strong>irréversible</strong>. Toutes vos données seront supprimées.</p>
            <p style="font-size: 12px; color: var(--muted); margin-bottom: 16px;">Pour confirmer, veuillez taper
                votre adresse email:</p>
            <input type="text" wire:model.live="deleteConfirmationText"
                placeholder="{{ auth()->user()->email }}" />
            <div class="modal-actions">
                <button wire:click="deleteAccount"
                    :disabled="deleteConfirmationText !== '{{ auth()->user()->email }}'"
                    class="btn-danger"
                    style="flex: 1; margin: 0;">
                    Supprimer définitivement
                </button>
                <button wire:click="$set('showDeleteModal', false)" class="btn-ghost" style="flex: 1; margin: 0;">
                    Annuler
                </button>
            </div>
        </div>
    </div>
@endif

<!-- 2FA Setup Modal -->
@if ($show2FASetupModal)
    <div class="modal-backdrop">
        <div class="modal">
            <h2>Configuration 2FA</h2>
            <p>Scannez ce code QR avec votre application d'authentification (Google Authenticator, Authy, etc.):</p>
            {!! $twoFactorQrCode !!}
            <p style="font-size: 12px; color: var(--muted); text-align: center;">Puis entrez le code à 6 chiffres:</p>
            <input type="text" wire:model.live="twoFactorOtpInput" placeholder="000000"
                inputmode="numeric" maxlength="6" />
            @if ($twoFactorError)
                <span class="form-error" style="display: block; margin-bottom: 12px;">{{ $twoFactorError }}</span>
            @endif
            <div class="modal-actions">
                <button wire:click="confirmTwoFactorSetup" class="btn-save" style="flex: 1; margin: 0;">
                    Confirmer
                </button>
                <button wire:click="$set('show2FASetupModal', false)" class="btn-ghost"
                    style="flex: 1; margin: 0;">
                    Annuler
                </button>
            </div>
        </div>
    </div>
@endif

<!-- Upgrade Plan Modal -->
@if ($showUpgradeModal)
    <div class="modal-backdrop">
        <div class="modal" style="max-width: 600px;">
            <h2>⭐ Choisir un Plan d'Abonnement</h2>
            <p style="margin-bottom: 20px;">Sélectionnez le plan qui vous convient le mieux:</p>

            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin-bottom: 20px;">
                <!-- Premium Plan -->
                <div style="border: 2px {{ $selectedPlan === 'premium' ? 'var(--v)' : 'var(--border)' }}; border-radius: var(--r); padding: 16px; cursor: pointer; transition: all .2s;"
                    wire:click="$set('selectedPlan', 'premium')">
                    <h3 style="font-size: 16px; font-weight: 700; color: var(--txt); margin-bottom: 8px;">Premium</h3>
                    <p style="font-size: 24px; font-weight: 700; color: var(--v); margin-bottom: 8px;">99 DH</p>
                    <p style="font-size: 12px; color: var(--muted); margin-bottom: 12px;">/30 jours</p>
                    <ul style="font-size: 12px; color: var(--txt); list-style: none; line-height: 1.6;">
                        <li>✓ Tous les cours</li>
                        <li>✓ Certificats</li>
                        <li>✓ Support email</li>
                    </ul>
                </div>

                <!-- Pro Plan -->
                <div style="border: 2px {{ $selectedPlan === 'pro' ? 'var(--v)' : 'var(--border)' }}; border-radius: var(--r); padding: 16px; cursor: pointer; transition: all .2s; background: rgba(167, 139, 250, 0.05);"
                    wire:click="$set('selectedPlan', 'pro')">
                    <div style="background: var(--vgrad); color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: 700; width: fit-content; margin-bottom: 8px;">POPULAIRE</div>
                    <h3 style="font-size: 16px; font-weight: 700; color: var(--txt); margin-bottom: 8px;">Pro</h3>
                    <p style="font-size: 24px; font-weight: 700; color: var(--v); margin-bottom: 8px;">249 DH</p>
                    <p style="font-size: 12px; color: var(--muted); margin-bottom: 12px;">/90 jours</p>
                    <ul style="font-size: 12px; color: var(--txt); list-style: none; line-height: 1.6;">
                        <li>✓ Premium +</li>
                        <li>✓ Mentorat</li>
                        <li>✓ Support prioritaire</li>
                    </ul>
                </div>

                <!-- Enterprise Plan -->
                <div style="border: 2px {{ $selectedPlan === 'enterprise' ? 'var(--v)' : 'var(--border)' }}; border-radius: var(--r); padding: 16px; cursor: pointer; transition: all .2s;"
                    wire:click="$set('selectedPlan', 'enterprise')">
                    <h3 style="font-size: 16px; font-weight: 700; color: var(--txt); margin-bottom: 8px;">Enterprise</h3>
                    <p style="font-size: 24px; font-weight: 700; color: var(--v); margin-bottom: 8px;">999 DH</p>
                    <p style="font-size: 12px; color: var(--muted); margin-bottom: 12px;">/365 jours</p>
                    <ul style="font-size: 12px; color: var(--txt); list-style: none; line-height: 1.6;">
                        <li>✓ Pro +</li>
                        <li>✓ Accès illimité</li>
                        <li>✓ Support 24/7</li>
                    </ul>
                </div>
            </div>

            <div class="modal-actions">
                <button wire:click="upgradePlan" class="btn-save" style="flex: 1; margin: 0;">
                    ✓ Activer le plan {{ ucfirst($selectedPlan) }}
                </button>
                <button wire:click="$set('showUpgradeModal', false)" class="btn-ghost" style="flex: 1; margin: 0;">
                    Annuler
                </button>
            </div>
        </div>
    </div>
@endif

</div>
