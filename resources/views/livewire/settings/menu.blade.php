<div class="card-body" wire:ignore>
    <div class="list-group list-group-transparent">
        @if(auth()->user()->role->name != 'pelanggan')
            <a href="{{ route('settings') }}"
                class="list-group-item list-group-item-action d-flex align-items-center
                    {{ request()->routeIs('settings') ? 'active' : '' }}">
                Akun Saya
            </a>
        @endif

        <a href="{{ route('settings.security') }}" class="list-group-item list-group-item-action d-flex align-items-center
            {{ request()->routeIs('settings.security') ? 'active' : '' }}">
            Keamanan
        </a>
    </div>
</div>
