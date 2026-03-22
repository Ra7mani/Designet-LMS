<x-layouts::auth.enhanced :title="__('Réinitialiser le mot de passe')">
    <x-auth-header-themed
        :title="__('Créer un nouveau mot de passe')"
        :description="__('Entrez un mot de passe fort pour sécuriser votre compte')"
        icon="🔑"
    />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form method="POST" action="{{ route('password.update') }}" class="flex flex-col gap-4">
        @csrf
        <!-- Token -->
        <input type="hidden" name="token" value="{{ request()->route('token') }}">

        <!-- Email Address -->
        <flux:input
            name="email"
            value="{{ request('email') }}"
            :label="__('Email')"
            type="email"
            required
            autocomplete="email"
        />

        <!-- Password -->
        <flux:input
            name="password"
            :label="__('Nouveau mot de passe')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Minimum 8 caractères')"
            viewable
        />

        <!-- Confirm Password -->
        <flux:input
            name="password_confirmation"
            :label="__('Confirmer le mot de passe')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Confirmez votre mot de passe')"
            viewable
        />

        <flux:button type="submit" variant="primary" class="w-full mt-2">
            {{ __('Réinitialiser le mot de passe') }}
        </flux:button>
    </form>

    <div class="auth-footer">
        <p class="auth-footer-text">
            {{ __('Retour à') }}
            <a href="{{ route('login') }}" wire:navigate>{{ __('la connexion') }}</a>
        </p>
    </div>
</x-layouts::auth.enhanced>
