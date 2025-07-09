<header class="header header-sticky p-0 ">
    <div class="container-lg px-4">
        <button class="header-toggler" type="button"
            onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()"
            style="margin-inline-start: -14px;" fdprocessedid="swrzrq">
            <i class="fas fa-bars"></i>
        </button>

        {{-- <x-button id="logoutButton" loading="Loading..."
            class="btn-danger text-white"
            wire:click="$dispatchTo('admin.logout', 'modal:logout')">
            <i class="fi fi-rr-power position-relative" style="top: 2px;"></i>
        </x-button> --}}
    </div>
</header>
