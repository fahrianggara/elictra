<div>
    <div class="row g-3 mb-3">
        @include('livewire.admin.dashboard.widget')
    </div>

    <div class="row g-3">
        <div class="col-lg-6">
            @livewire('admin.dashboard.payment-pending')
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    Pelanggan Terbaru dalam 7 Hari
                </div>
            </div>
        </div>
    </div>
</div>
