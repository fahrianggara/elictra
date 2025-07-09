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
        <x-dash.nav-item href="admin.dashboard" icon="fas fa-tachometer-alt">
            Dashboard
        </x-dash.nav-item>

        <li class="nav-title mt-0">Master</li>
        <x-dash.nav-item href="#" icon="fas fa-users">Pelanggan</x-dash.nav-item>
        <x-dash.nav-item href="#" icon="fas fa-bolt">Tarif Listrik</x-dash.nav-item>
        <x-dash.nav-item href="#" icon="fas fa-money-bill">Metode Pembayaran</x-dash.nav-item>
        <x-dash.nav-item href="#" icon="fas fa-user">Pengguna</x-dash.nav-item>
        <x-dash.nav-item href="#" icon="fas fa-user-shield">Peran Pengguna</x-dash.nav-item>

        <li class="nav-title">Manajemen</li>
        <x-dash.nav-item href="#" icon="fas fa-file-invoice">Tagihan</x-dash.nav-item>
        <x-dash.nav-item href="#" icon="fas fa-credit-card">Pembayaran</x-dash.nav-item>
        <x-dash.nav-item href="#" icon="fas fa-ban">Pelanggan Diblokir</x-dash.nav-item>

        <li class="nav-title">Laporan</li>
        <x-dash.nav-item href="#" icon="fas fa-chart-line">Laporan</x-dash.nav-item>

        <li class="nav-title">Pengaturan</li>
        <x-dash.nav-item href="#" icon="fas fa-cogs">Pengaturan</x-dash.nav-item>
        <x-dash.nav-item href="#" icon="fas fa-history">Log Aktivitas</x-dash.nav-item>
    </ul>
</aside>
