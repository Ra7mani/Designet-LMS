<x-layouts::auth :title="__('Register')">
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Créer un compte')" :description="__('Entrez vos informations pour créer votre compte')" />

        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-6">
            @csrf

            <flux:input
                name="name"
                :label="__('Nom complet')"
                :value="old('name')"
                type="text"
                required
                autofocus
                autocomplete="name"
                :placeholder="__('Nom complet')"
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
                :placeholder="__('Mot de passe')"
                viewable
            />

            <flux:input
                name="password_confirmation"
                :label="__('Confirmer le mot de passe')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('Confirmer le mot de passe')"
                viewable
            />

            <!-- Rôle -->
            <div class="flex flex-col gap-2">
                <flux:label>{{ __('Je suis') }}</flux:label>
                <div class="flex gap-4">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="role" value="etudiant"
                            {{ old('role', 'etudiant') == 'etudiant' ? 'checked' : '' }}
                            class="accent-zinc-800 dark:accent-white" />
                        <span class="text-sm text-zinc-700 dark:text-zinc-300">Étudiant</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="role" value="formateur"
                            {{ old('role') == 'formateur' ? 'checked' : '' }}
                            class="accent-zinc-800 dark:accent-white" />
                        <span class="text-sm text-zinc-700 dark:text-zinc-300">Formateur</span>
                    </label>
                </div>
                @error('role')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex items-center justify-end">
                <flux:button type="submit" variant="primary" class="w-full">
                    {{ __('Créer mon compte') }}
                </flux:button>
            </div>
        </form>

        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
            <span>{{ __('Vous avez déjà un compte ?') }}</span>
            <flux:link :href="route('login')" wire:navigate>{{ __('Se connecter') }}</flux:link>
        </div>
    </div>
</x-layouts::auth>