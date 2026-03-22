<x-layouts::auth.enhanced :title="__('Confirmer le mot de passe')">
    <x-auth-header-themed
        :title="__('Vérifier votre identité')"
        :description="__('Ceci est une zone sécurisée. Veuillez confirmer votre mot de passe pour continuer')"
        icon="🔐"
    />

    <x-auth-session-status class="text-center" :status="session('status')" />

    <form method="POST" action="{{ route('password.confirm.store') }}" class="flex flex-col gap-5">
        @csrf

        <flux:input
            name="password"
            :label="__('Mot de passe')"
            type="password"
            required
            autocomplete="current-password"
            :placeholder="__('Entrez votre mot de passe')"
            viewable
        />

        <flux:button variant="primary" type="submit" class="w-full mt-2">
            {{ __('Confirmer') }}
        </flux:button>
    </form>

    <div class="auth-footer">
        <p class="auth-footer-text">
            {{ __('Retour au') }}
            <a href="{{ route('dashboard') }}" wire:navigate>{{ __('tableau de bord') }}</a>
        </p>
    </div>
</x-layouts::auth.enhanced>
