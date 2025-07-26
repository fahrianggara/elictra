<div>
    @if($has_rejected_bill)
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-circle me-1"></i>
            Salah satu pembayaran Anda ditolak. Silakan periksa kembali dan unggah bukti pembayaran yang valid.
            <a href="{{ route('customer.bills.history') }}" class="btn btn-sm btn-warning ms-2">
                Cek Pembayaran <i class="fas fa-external-link-alt ms-1"></i>
            </a>
        </div>
    @endif

    @if($has_unpaid_bill)
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-circle me-1"></i>
            Salah satu tagihan Anda belum dibayar. Silakan periksa kembali dan lakukan pembayaran.
            <a href="{{ route('customer.bills') }}" class="btn btn-sm btn-warning ms-2">
                Cek Tagihan <i class="fas fa-external-link-alt ms-1"></i>
            </a>
        </div>
    @endif

    <div class="row g-3 mb-3">
        @include('livewire.customer.dashboard.widget')
    </div>

    <div class="row g-3">
        <div class="col-lg-4">
            @include('livewire.customer.dashboard.user-info')
        </div>

        <div class="col-lg-8">
            {{-- @livewire('admin.dashboard.new-customer') --}}
        </div>
    </div>
</div>
