<x-layouts::auth.enhanced :title="__('Réinitialiser le mot de passe')">
    <x-auth-header-themed
        :title="__('Récupérer votre compte')"
        :description="__('Nous vous enverrons un lien pour réinitialiser votre mot de passe')"
        icon="🔒"
    />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="flex flex-col gap-10">
        @csrf

        <!-- Email Address -->
        <div class="flex flex-col gap-2 mb-8">
            <flux:label>{{ __('Adresse email') }}</flux:label>
            <flux:input
                name="email"
                type="email"
                required
                autofocus
                placeholder="email@example.com"
                :value="old('email')"
            />
            @error('email')
                <span class="text-sm text-red-500 flex items-center gap-1 mt-1">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18.101 12.93a1 1 0 00-1.414-1.414L10 15.586l-6.687-6.687a1 1 0 00-1.414 1.414l8 8a1 1 0 001.414 0l10-10z" clip-rule="evenodd"></path></svg>
                    {{ $message }}
                </span>
            @enderror
        </div>
<br>
        <flux:button variant="primary" type="submit" class="w-full mt-2">
            {{ __('Envoyer le lien') }}
        </flux:button>
    </form>

    <div class="auth-footer">
        <p class="auth-footer-text">
            {{ __('Vous vous souvenez de votre mot de passe ?') }}
            <a href="{{ route('login') }}" wire:navigate>{{ __('Se connecter') }}</a>
        </p>
    </div>
</x-layouts::auth.enhanced>
