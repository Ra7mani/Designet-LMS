<x-layouts::auth.enhanced :title="__('Connexion')">
    <x-auth-header-themed
        :title="__('Bienvenue')"
        :description="__('Connectez-vous pour accéder à votre tableau de bord')"
        icon="👤"
    />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-10">
        @csrf

        <!-- Email Address -->
        <flux:input
            name="email"
            :label="__('Adresse email')"
            :value="old('email')"
            type="email"
            required
            autofocus
            autocomplete="email"
            placeholder="email@example.com"
            class="mb-8"
        /> <br>

        <!-- Password -->
        <div class="relative mb-8">
            <flux:input
                name="password"
                :label="__('Mot de passe')"
                type="password"
                required
                autocomplete="current-password"
                :placeholder="__('Entrez votre mot de passe')"
                viewable
            />

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" wire:navigate class="absolute top-0 text-xs font-semibold end-0 text-purple-600 hover:text-purple-700 dark:text-purple-400">
                    {{ __('Mot de passe oublié ?') }}
                </a>
            @endif
        </div><br>

        <!-- Remember Me -->
        <flux:checkbox name="remember" :label="__('Se souvenir de moi')" :checked="old('remember')" class="mb-4" />
<br>
        <flux:button variant="primary" type="submit" class="w-full mt-2">
            {{ __('Se connecter') }}
        </flux:button>
    </form>

    <div class="auth-footer">
        @if (Route::has('register'))
            <p class="auth-footer-text">
                {{ __('Pas encore de compte ?') }}
                <a href="{{ route('register') }}" wire:navigate>{{ __('Créer un compte') }}</a>
            </p>
        @endif
    </div>
</x-layouts::auth.enhanced>
