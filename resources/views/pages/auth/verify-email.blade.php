<x-layouts::auth.enhanced :title="__('Vérification de l\'email')">
    <x-auth-header-themed
        :title="__('Vérifiez votre email')"
        :description="__('Cliquez sur le lien dans l\'email que nous avons envoyé pour activer votre compte')"
        icon="📧"
    />

    <div class="flex flex-col gap-4 mt-6">
        @if (session('status') == 'verification-link-sent')
            <div class="flex items-center gap-3 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                <svg class="w-5 h-5 text-green-600 dark:text-green-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                <p class="text-sm font-medium text-green-800 dark:text-green-300">
                    {{ __('Un nouveau lien de vérification a été envoyé à votre email') }}
                </p>
            </div>
        @endif

        <p class="text-sm text-center text-muted py-2">
            {{ __('Veuillez vérifier votre adresse email en cliquant sur le lien que nous venons d\'envoyer') }}
        </p>

        <form method="POST" action="{{ route('verification.send') }}" class="flex flex-col gap-3">
            @csrf
            <flux:button type="submit" variant="primary" class="w-full">
                {{ __('Renvoyer l\'email de vérification') }}
            </flux:button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <flux:button variant="ghost" type="submit" class="w-full text-sm">
                {{ __('Se déconnecter') }}
            </flux:button>
        </form>
    </div>
</x-layouts::auth.enhanced>
