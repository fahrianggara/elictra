<div class="card">
    <div class="card-header">
        Pilih Metode Pembayaran
    </div>

    <div class="card-body">
        <p class="text-gray-500">
            Silakan pilih metode pembayaran yang Anda inginkan untuk menyelesaikan transaksi ini. Pastikan Anda memilih
            metode yang sesuai dengan preferensi Anda.
        </p>

        @if($paymentMethods->isEmpty())
            <div class="alert alert-warning mt-3 mb-0">
                Saat ini tidak ada metode pembayaran yang tersedia. Silakan hubungi
                administrator untuk informasi lebih lanjut.
            </div>
        @else
            <div class="row g-3">
                @foreach ($paymentMethods as $type => $methods)
                    <div class="col-lg-6">
                        <div class="card border ">
                            <div class="card-header bg-light fw-semibold text-capitalize">
                                {{ $type === 'bank_transfer' ? 'Transfer Bank' : 'Dompet Digital' }}
                            </div>
                            <div class="card-body d-flex flex-column gap-3">
                                @foreach ($methods as $method)
                                    <div class="form-check d-flex align-items-center gap-3">
                                        <input
                                            class="form-check-input"
                                            type="radio"
                                            name="payment_method_id"
                                            id="method_{{ $method->id }}"
                                            value="{{ $method->id }}"
                                            wire:model="payment_method_id"
                                            style="position: relative; bottom: 2px;">

                                        <label
                                            class="form-check-label d-flex align-items-center cursor-pointer w-100"
                                            for="method_{{ $method->id }}">
                                            <img
                                                src="{{ asset('storage/' . $method->logo) }}"
                                                alt="{{ $method->name }}"
                                                width="50"
                                                class="me-3">
                                            <div>
                                                <div class="fw-semibold">{{ $method->name }}</div>
                                                <small class="text-muted">
                                                    {{ $method->label }}: {{ $method->number }}
                                                </small>
                                            </div>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="card-footer flex justify-end">
        <x-button color="primary" action="nextStep" target="nextStep">
            Lanjutkan
        </x-button>
    </div>
</div>
