<x-layouts::auth.enhanced :title="__('Authentification à deux facteurs')">
    <div class="relative w-full h-auto" x-cloak x-data="{
        showRecoveryInput: @js($errors->has('recovery_code')),
        code: '',
        recovery_code: '',
        toggleInput() {
            this.showRecoveryInput = !this.showRecoveryInput;
            this.code = '';
            this.recovery_code = '';
            $dispatch('clear-2fa-auth-code');
            $nextTick(() => {
                this.showRecoveryInput
                    ? this.$refs.recovery_code?.focus()
                    : $dispatch('focus-2fa-auth-code');
            });
        },
    }">
        <div x-show="!showRecoveryInput">
            <x-auth-header-themed
                :title="__('Authentification à deux facteurs')"
                :description="__('Entrez le code de vérification de votre application d\'authentification')"
                icon="🔑"
            />
        </div>

        <div x-show="showRecoveryInput">
            <x-auth-header-themed
                :title="__('Code de récupération')"
                :description="__('Utilisez l\'un de vos codes de récupération d\'urgence pour accéder à votre compte')"
                icon="🛟"
            />
        </div>

        <form method="POST" action="{{ route('two-factor.login.store') }}" class="flex flex-col gap-5 mt-6">
            @csrf

            <div x-show="!showRecoveryInput">
                <div class="flex items-center justify-center">
                    <flux:otp
                        x-model="code"
                        length="6"
                        name="code"
                        label="Code OTP"
                        label:sr-only
                        class="mx-auto"
                    />
                </div>
            </div>

            <div x-show="showRecoveryInput">
                <flux:input
                    type="text"
                    name="recovery_code"
                    x-ref="recovery_code"
                    x-bind:required="showRecoveryInput"
                    autocomplete="one-time-code"
                    x-model="recovery_code"
                    :label="__('Code de récupération')"
                    :placeholder="__('XXXX-XXXX-XXXX')"
                />

                @error('recovery_code')
                    <p class="text-sm text-red-500 mt-2 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18.101 12.93a1 1 0 00-1.414-1.414L10 15.586l-6.687-6.687a1 1 0 00-1.414 1.414l8 8a1 1 0 001.414 0l10-10z" clip-rule="evenodd"></path></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <flux:button
                variant="primary"
                type="submit"
                class="w-full mt-2"
            >
                {{ __('Continuer') }}
            </flux:button>

            <div class="pt-2">
                <button
                    type="button"
                    @click="toggleInput()"
                    class="text-sm text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300 font-medium text-center w-full"
                >
                    <span x-show="!showRecoveryInput">{{ __('ou utiliser un code de récupération') }}</span>
                    <span x-show="showRecoveryInput">{{ __('ou utiliser un code d\'authentification') }}</span>
                </button>
            </div>
        </form>
    </div>
</x-layouts::auth.enhanced>
