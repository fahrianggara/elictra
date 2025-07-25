<div class="row g-3">
    <div class="col-12 col-sm-6 col-xl-4 col-xxl-3">
        <x-widget color="primary" :count="$count_bills" title="Total Tagihan">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                <path d="M9 7l1 0" />
                <path d="M9 13l6 0" />
                <path d="M13 17l2 0" />
            </svg>
        </x-widget>
    </div>

    <div class="col-12 col-sm-6 col-xl-4 col-xxl-3">
        <x-widget color="warning" :count="$count_bills_waiting" title="Menunggu Verifikasi">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                <path d="M12 17v.01" />
                <path d="M12 14a1.5 1.5 0 1 0 -1.14 -2.474" />
            </svg>
        </x-widget>
    </div>

    <div class="col-12 col-sm-6 col-xl-4 col-xxl-3">
        <x-widget color="danger" :count="$count_bills_unpaid" title="Belum Dibayar">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                <path d="M12 17l.01 0" />
                <path d="M12 11l0 3" />
            </svg>
        </x-widget>
    </div>

    <div class="col-12 col-sm-6 col-xl-4 col-xxl-3">
        <x-widget color="success" :count="$count_bills_paid" title="Lunas">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                <path d="M9 15l2 2l4 -4" />
            </svg>
        </x-widget>
    </div>
</div>
