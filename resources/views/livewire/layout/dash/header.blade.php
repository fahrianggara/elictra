<header class="header header-sticky p-0 h-[63px] mb-5">
    <div class="container-fluid px-4 border-boottom">
        <button class="header-toggler" type="button"
            onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()"
            style="margin-inline-start: -14px;" fdprocessedid="swrzrq">
            <i class="fas fa-bars"></i>
        </button>

        <div class="ms-auto">
            <button type="button" class="btn btn-danger text-white"
                wire:click="$dispatch('logout:show')">
                <i class="fas fa-sign-out-alt me-1"></i> {{ __('Logout') }}
            </button>
        </div>
    </div>
    <div class="container-fluid breadcrumb-container pl-[270px] bg-white py-[10px] absolute top-[63px] border-bottom">
        {{ Breadcrumbs::render() }}
    </div>
</header>
