<div>
    @if($has_pending_payment)
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-circle me-1"></i>
            Salah satu pembayaran pelanggan masih berstatus pending dan belum Anda verifikasi. Silakan lakukan verifikasi terlebih dahulu.
        </div>
    @endif

    <div class="row g-3 mb-3">
        @include('livewire.admin.dashboard.widget')
    </div>

    <div class="row g-3">
        <div class="col-lg-6">
            @livewire('admin.dashboard.payment-pending')
        </div>

        <div class="col-lg-6">
            @livewire('admin.dashboard.new-customer')
        </div>
    </div>
</div>
