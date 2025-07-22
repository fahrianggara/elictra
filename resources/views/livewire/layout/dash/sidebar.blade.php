<aside class="sidebar bg-white sidebar-fixed border-end" id="sidebar">
    <div class="sidebar-header border-bottom px-[2rem]">
        <div class="sidebar-brand">
            <a href="#" class="d-flex align-items-center text-decoration-none">
                <img src="{{ asset('favicon/logo-text.png') }}" alt="Logo" class="sidebar-brand-full" width="119">
                <img src="{{ asset('favicon/logo.png') }}" alt="Logo" class="sidebar-brand-narrow" width="30">
            </a>
        </div>
        <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
        <button class="btn-close d-lg-none" type="button" data-coreui-dismiss="offcanvas" aria-label="Close"
            onclick="coreui.Sidebar.getInstance(document.querySelector(&quot;#sidebar&quot;)).toggle()">
        </button>
    </div>

    <ul class="sidebar-nav">
        @if(auth()->user()->role->name == 'admin')
            @include('components.sidebar.admin')
        @elseif(auth()->user()->role->name == 'pelanggan')
            @include('components.sidebar.customer')
        @elseif(auth()->user()->role->name == 'petugas')
            @include('components.sidebar.officer')
        @endif
    </ul>
</aside>
