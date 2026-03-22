<x-layouts::auth.enhanced :title="__('Inscription')">
    <x-auth-header-themed
        :title="__('Commencez à apprendre')"
        :description="__('Créez votre compte en quelques secondes et rejoignez notre communauté')"
        icon="✨"
    />

    <x-auth-session-status class="text-center" :status="session('status')" />

    <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-4">
        @csrf

        <flux:input
            name="name"
            :label="__('Nom complet')"
            :value="old('name')"
            type="text"
            required
            autofocus
            autocomplete="name"
            :placeholder="__('Votre nom complet')"
        />

        <flux:input
            name="email"
            :label="__('Adresse email')"
            :value="old('email')"
            type="email"
            required
            autocomplete="email"
            placeholder="email@example.com"
        />

        <flux:input
            name="password"
            :label="__('Mot de passe')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Minimum 8 caractères')"
            viewable
        />

        <flux:input
            name="password_confirmation"
            :label="__('Confirmer le mot de passe')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Confirmez votre mot de passe')"
            viewable
        />

        <!-- Role Selection -->
        <div class="flex flex-col gap-3 pt-2">
            <flux:label>{{ __('Je suis') }}</flux:label>
            <div class="grid grid-cols-2 gap-3">
                @foreach(['etudiant' => '👨‍🎓 Étudiant', 'formateur' => '👨‍🏫 Formateur'] as $value => $label)
                    <label class="role-option {{ old('role', 'etudiant') == $value ? 'selected' : '' }}">
                        <input type="radio" name="role" value="{{ $value }}"
                            {{ old('role', 'etudiant') == $value ? 'checked' : '' }}
                            class="sr-only peer" />
                        <span class="role-option-text">{{ $label }}</span>
                    </label>
                @endforeach
            </div>
            @error('role')
                <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
            @enderror
        </div>

        <flux:button type="submit" variant="primary" class="w-full mt-2">
            {{ __('Créer mon compte') }}
        </flux:button>
    </form>

    <div class="auth-footer">
        <p class="auth-footer-text">
            {{ __('Vous avez déjà un compte ?') }}
            <a href="{{ route('login') }}" wire:navigate>{{ __('Se connecter') }}</a>
        </p>
    </div>

    <style>
        .role-option {
            position: relative;
            cursor: pointer;
        }

        .role-option input[type="radio"]:checked ~ .role-option-text {
            background: linear-gradient(135deg, var(--v), var(--va));
            color: white;
            border-color: var(--v);
        }

        .role-option-text {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 12px 16px;
            border: 1.5px solid var(--border);
            border-radius: var(--rp);
            background: #fff;
            color: var(--txt);
            font-size: 13px;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        html.dark .role-option-text {
            background: rgba(255, 255, 255, 0.05);
            border-color: var(--border);
        }

        .role-option input[type="radio"]:checked ~ .role-option-text {
            box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
        }

        .role-option-text:hover {
            border-color: var(--v);
            background: var(--vxl);
        }
    </style>
</x-layouts::auth.enhanced>