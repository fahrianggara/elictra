<aside class="sidebar bg-white sidebar-fixed border-end " id="sidebar">
    <div class="sidebar-header border-bottom p-[12px] px-[1.3rem]">
        <div class="sidebar-brand">
            <a href="#" class="d-flex align-items-center text-decoration-none">
                <img src="{{ asset('favicon/logo-text.png') }}" alt="Logo" class="sidebar-brand-full" width="150">
                <img src="{{ asset('favicon/logo.png') }}" alt="Logo" class="sidebar-brand-narrow" width="38">
            </a>
        </div>
        <button class="btn-close d-lg-none" type="button" data-coreui-dismiss="offcanvas" aria-label="Close"
            onclick="coreui.Sidebar.getInstance(document.querySelector(&quot;#sidebar&quot;)).toggle()">
        </button>
    </div>

    <ul class="sidebar-nav">
        <li class="nav-title mt-0">Menu</li>

        <li class="nav-item">
            <a href="#" class="nav-link ">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                Dashboard
            </a>
        </li>
    </ul>
</aside>
