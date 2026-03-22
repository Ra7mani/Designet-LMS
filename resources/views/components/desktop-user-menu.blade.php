<flux:dropdown position="bottom" align="start">
    <div class="flex items-center gap-3 rounded-lg px-3 py-2 hover:bg-zinc-100 dark:hover:bg-zinc-800 cursor-pointer transition-colors" data-test="sidebar-menu-button">
        @if(auth()->user()->avatar_path)
            <img src="{{ asset('storage/' . auth()->user()->avatar_path) }}" alt="{{ auth()->user()->name }}" class="w-8 h-8 rounded-full object-cover">
        @else
            <div class="w-8 h-8 rounded-full bg-purple-500 flex items-center justify-center text-white text-sm font-semibold">
                {{ auth()->user()->initials() }}
            </div>
        @endif
        <div class="flex-1 min-w-0">
            <div class="truncate text-sm font-medium">{{ auth()->user()->name }}</div>
            <div class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ auth()->user()->initials() }}</div>
        </div>
        <flux:icon icon="chevrons-up-down" class="w-4 h-4 text-gray-400" />
    </div>

    <flux:menu>
        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
            @if(auth()->user()->avatar_path)
                <img src="{{ asset('storage/' . auth()->user()->avatar_path) }}" alt="{{ auth()->user()->name }}" class="w-10 h-10 rounded-full object-cover">
            @else
                <flux:avatar
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                />
            @endif
            <div class="grid flex-1 text-start text-sm leading-tight">
                <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
            </div>
        </div>
        <flux:menu.separator />
        <flux:menu.radio.group>
            @if(auth()->user()->isEtudiant())
                <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                    {{ __('Settings') }}
                </flux:menu.item>
            @endif
            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <flux:menu.item
                    as="button"
                    type="submit"
                    icon="arrow-right-start-on-rectangle"
                    class="w-full cursor-pointer"
                    data-test="logout-button"
                >
                    {{ __('Log out') }}
                </flux:menu.item>
            </form>
        </flux:menu.radio.group>
    </flux:menu>
</flux:dropdown>
