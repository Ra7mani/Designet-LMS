<div>
<style>
/* HEADER */
.params-header {
    padding: 30px;
    background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
    color: white;
    border-radius: 8px;
    margin-bottom: 30px;
}
.params-header h1 {
    font-size: 24px;
    font-weight: 700;
    margin: 0;
    font-family: 'Poppins', sans-serif;
}
.params-header p {
    font-size: 13px;
    opacity: 0.9;
    margin: 4px 0 0 0;
}

/* TABS LAYOUT */
.params-tabs {
    display: grid;
    grid-template-columns: 200px 1fr;
    gap: 24px;
}

/* TAB NAV */
.params-nav {
    display: flex;
    flex-direction: column;
    gap: 6px;
}
.params-nav button {
    background: none;
    border: none;
    padding: 12px 16px;
    border-radius: 8px;
    text-align: left;
    cursor: pointer;
    font-size: 14px;
    font-weight: 500;
    color: #6b7280;
    display: flex;
    align-items: center;
    gap: 10px;
    transition: all .2s;
}
.params-nav button:hover {
    background: #f3f4f6;
    color: #374151;
}
.params-nav button.active {
    background: linear-gradient(135deg, rgba(124, 58, 237, 0.1), rgba(109, 40, 217, 0.05));
    color: #7c3aed;
    border-left: 3px solid #7c3aed;
    padding-left: 13px;
}

/* PARAMS CONTENT */
.params-content {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

/* CARD */
.params-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 24px;
}
.params-card-title {
    font-size: 16px;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 6px;
    font-family: 'Poppins', sans-serif;
}
.params-card-desc {
    font-size: 13px;
    color: #6b7280;
    margin-bottom: 20px;
}

/* FORM */
.form-row {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
    margin-bottom: 16px;
}
.form-row.full {
    grid-template-columns: 1fr;
}
.form-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
}
.form-group label {
    font-size: 12px;
    font-weight: 600;
    color: #1f2937;
}
.form-group input,
.form-group select,
.form-group textarea {
    padding: 10px 12px;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-size: 13px;
    font-family: 'DM Sans', sans-serif;
    color: #1f2937;
    transition: all .2s;
}
.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #7c3aed;
    box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
}
.form-group textarea {
    resize: vertical;
    min-height: 100px;
}

/* TOGGLE */
.toggle-group {
    padding: 16px 0;
    border-bottom: 1px solid #e5e7eb;
}
.toggle-group:last-child {
    border-bottom: none;
}
.toggle-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.toggle-info h4 {
    font-size: 14px;
    font-weight: 600;
    color: #1f2937;
    margin: 0 0 2px 0;
}
.toggle-info p {
    font-size: 12px;
    color: #6b7280;
}
.toggle-switch {
    position: relative;
    width: 44px;
    height: 24px;
}
.toggle-switch input {
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
    background: #d1d5db;
    border-radius: 12px;
    transition: all .3s;
}
.toggle-slider::before {
    content: '';
    position: absolute;
    height: 18px;
    width: 18px;
    left: 3px;
    bottom: 3px;
    background: white;
    border-radius: 50%;
    transition: all .3s;
}
.toggle-switch input:checked + .toggle-slider {
    background: #7c3aed;
}
.toggle-switch input:checked + .toggle-slider::before {
    transform: translateX(20px);
}

/* PASSWORD GROUP */
.password-group {
    position: relative;
}
.password-group input {
    padding-right: 40px !important;
}
.eye-btn {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    cursor: pointer;
    color: #9ca3af;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 24px;
    height: 24px;
}
.eye-btn svg {
    width: 16px;
    height: 16px;
    stroke: currentColor;
}

/* BUTTONS */
.btn-group {
    display: flex;
    gap: 12px;
    margin-top: 20px;
}
.btn {
    padding: 10px 20px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all .2s;
    font-family: 'DM Sans', sans-serif;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.btn-primary {
    background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(124, 58, 237, .25);
}
.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(124, 58, 237, .35);
}
.btn-danger {
    background: white;
    color: #dc2626;
    border: 1.5px solid #fca5a5;
}
.btn-danger:hover {
    background: #fca5a5;
    color: white;
}
.btn-ghost {
    background: #f3f4f6;
    color: #6b7280;
    border: 1px solid #e5e7eb;
}
.btn-ghost:hover {
    background: #e5e7eb;
    color: #374151;
}

/* ERROR/SUCCESS */
.form-error {
    font-size: 12px;
    color: #dc2626;
    margin-top: 4px;
}
.form-success {
    font-size: 12px;
    color: #10b981;
    margin-top: 4px;
    font-weight: 600;
}

/* MODAL */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, .5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 100;
}
.modal-content {
    background: white;
    border-radius: 12px;
    padding: 28px;
    max-width: 450px;
    width: 90%;
    box-shadow: 0 20px 60px rgba(0, 0, 0, .3);
}
.modal-content h2 {
    font-size: 18px;
    font-weight: 700;
    margin: 0 0 12px 0;
    color: #1f2937;
    font-family: 'Poppins', sans-serif;
}
.modal-content p {
    font-size: 14px;
    color: #6b7280;
    margin: 0 0 16px 0;
}
.modal-content input {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-size: 13px;
    margin-bottom: 16px;
    box-sizing: border-box;
}

/* DANGER ZONE */
.danger-card {
    border-color: #fca5a5 !important;
}
.danger-card .params-card-title {
    color: #dc2626;
}

@media (max-width: 768px) {
    .params-tabs {
        grid-template-columns: 1fr;
    }
    .params-nav {
        flex-direction: row;
        flex-wrap: wrap;
    }
    .form-row {
        grid-template-columns: 1fr;
    }
}
</style>

<!-- HEADER -->
<div class="params-header">
    <h1>⚙️ Paramètres</h1>
    <p>Gère ton compte et tes préférences</p>
</div>

<!-- CONTENT -->
<div class="params-tabs">
    <!-- NAV -->
    <nav class="params-nav">
        <button type="button" wire:click="$set('activeSection', 'account')" class="@if($activeSection === 'account') active @endif">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            Compte
        </button>
        <button type="button" wire:click="$set('activeSection', 'notifications')" class="@if($activeSection === 'notifications') active @endif">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
            Notifications
        </button>
        <button type="button" wire:click="$set('activeSection', 'security')" class="@if($activeSection === 'security') active @endif">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            Sécurité
        </button>
    </nav>

    <!-- CONTENT -->
    <div class="params-content">
        <!-- ACCOUNT TAB -->
        @if($activeSection === 'account')
            <div class="params-card">
                <div class="params-card-title">Informations du Compte</div>
                <div class="params-card-desc">Mets à jour tes informations personnelles</div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Prénom</label>
                        <input type="text" wire:model.live="firstName" placeholder="Ton prénom" />
                        @error('firstName') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Nom</label>
                        <input type="text" wire:model.live="lastName" placeholder="Ton nom" />
                        @error('lastName') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" wire:model.live="email" placeholder="ton@email.com" />
                        @error('email') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Téléphone</label>
                        <input type="tel" wire:model.live="phone" placeholder="+212 6XX XXX XXX" />
                    </div>
                </div>

                <div class="form-row full">
                    <div class="form-group">
                        <label>Bio/À propos</label>
                        <textarea wire:model.live="bio" placeholder="Présente-toi et partage ton expérience..."></textarea>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Langue</label>
                        <select wire:model.live="language">
                            <option value="fr">Français</option>
                            <option value="en">English</option>
                            <option value="ar">العربية</option>
                        </select>
                    </div>
                </div>
            </div>

        <!-- NOTIFICATIONS TAB -->
        @elseif($activeSection === 'notifications')
            <div class="params-card">
                <div class="params-card-title">Préférences de Notification</div>
                <div class="params-card-desc">Configure comment tu veux être notifié</div>

                <div class="toggle-group">
                    <div class="toggle-row">
                        <div class="toggle-info">
                            <h4>Notifications par email</h4>
                            <p>Reçois les mises à jour importantes</p>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" wire:model.live="email_notifications" />
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                </div>

                <div class="toggle-group">
                    <div class="toggle-row">
                        <div class="toggle-info">
                            <h4>Rappels de cours</h4>
                            <p>Rappels pour gérer tes cours</p>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" wire:model.live="course_reminders" />
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                </div>

                <div class="toggle-group">
                    <div class="toggle-row">
                        <div class="toggle-info">
                            <h4>Messages des étudiants</h4>
                            <p>Sois notifié des messages reçus</p>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" wire:model.live="student_messages" />
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                </div>
            </div>

        <!-- SECURITY TAB -->
        @elseif($activeSection === 'security')
            <div class="params-card">
                <div class="params-card-title">Sécurité du Compte</div>
                <div class="params-card-desc">Gère tes paramètres de sécurité</div>

                <h4 style="font-size: 14px; font-weight: 600; color: #1f2937; margin-top: 20px; margin-bottom: 16px;">Changer le mot de passe</h4>

                <div class="form-row full">
                    <div class="form-group">
                        <label>Mot de passe actuel</label>
                        <div class="password-group">
                            <input type="{{ $showCurrentPassword ? 'text' : 'password' }}" wire:model.live="currentPassword" placeholder="Mot de passe actuel" />
                            <button type="button" wire:click="toggleCurrentPassword" class="eye-btn" tabindex="-1">
                                @if($showCurrentPassword)
                                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                @else
                                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                                @endif
                            </button>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Nouveau mot de passe</label>
                        <div class="password-group">
                            <input type="{{ $showNewPassword ? 'text' : 'password' }}" wire:model.live="newPassword" placeholder="Min. 8 caractères" />
                            <button type="button" wire:click="toggleNewPassword" class="eye-btn" tabindex="-1">
                                @if($showNewPassword)
                                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                @else
                                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                                @endif
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Confirmer le mot de passe</label>
                        <div class="password-group">
                            <input type="{{ $showPasswordConfirmation ? 'text' : 'password' }}" wire:model.live="newPassword_confirmation" placeholder="Confirmer" />
                            <button type="button" wire:click="togglePasswordConfirmation" class="eye-btn" tabindex="-1">
                                @if($showPasswordConfirmation)
                                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                @else
                                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                                @endif
                            </button>
                        </div>
                    </div>
                </div>

                @if($passwordChangeError)
                    <div style="margin: 16px 0 0 0;"><span class="form-error">{{ $passwordChangeError }}</span></div>
                @endif

                @if($passwordChangeSuccess)
                    <div style="margin: 16px 0 0 0;"><span class="form-success">{{ $passwordChangeSuccess }}</span></div>
                @endif

                <div class="btn-group">
                    <button type="button" wire:click="changePassword" class="btn btn-primary">
                        🔒 Mettre à jour le mot de passe
                    </button>
                </div>
            </div>
        @endif

        <!-- DANGER ZONE -->
        <div class="params-card danger-card">
            <div class="params-card-title">⚠️ Zone de Danger</div>
            <div class="params-card-desc">Actions irréversibles sur ton compte</div>
            <div class="btn-group">
                <button type="button" wire:click="openDeleteModal" class="btn btn-danger">
                    🗑️ Supprimer mon compte
                </button>
            </div>
        </div>
    </div>
</div>

<!-- DELETE MODAL -->
@if($showDeleteModal)
    <div class="modal-overlay">
        <div class="modal-content">
            <h2>⚠️ Supprimer le Compte</h2>
            <p>Cette action est <strong>irréversible</strong>. Toutes vos données seront supprimées.</p>
            <p style="font-size: 12px; color: #6b7280; margin-bottom: 16px;">Pour confirmer, veuillez taper votre adresse email:</p>
            <input type="text" wire:model.live="deleteConfirmationText" placeholder="{{ auth()->user()->email }}" />
            <div class="btn-group" style="margin-top: 16px;">
                <button type="button" wire:click="deleteAccount" :disabled="deleteConfirmationText !== '{{ auth()->user()->email }}'" class="btn btn-danger" style="flex: 1;">
                    Supprimer définitivement
                </button>
                <button type="button" wire:click="$set('showDeleteModal', false)" class="btn btn-ghost" style="flex: 1;">
                    Annuler
                </button>
            </div>
        </div>
    </div>
@endif

</div>
