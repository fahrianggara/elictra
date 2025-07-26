<x-select label="Pelanggan" wire:model.change="customer_id" :required="$required" placeholder="Pilih pelanggan"
    :error="$errors->first('customer_id')" :options="$customers" />

@if ($customerInfo)
    <div class="alert alert-info mb-{{ $customerInfo->last_bill ? '3' : '0' }}">
        Pelanggan ini menggunakan Tarif <b>{{ $customerInfo->tarif->format_tarif }}</b> dengan harga per kWh
        <b>{{ rupiah($customerInfo->tarif->price_per_kwh) }}</b>.
        @if ($customerInfo->last_bill)
            dan terakhir memiliki tagihan pada periode
            <b>{{ formatPeriod($customerInfo->last_bill->period) }}</b>.
        @else
            dan belum memiliki tagihan sebelumnya.
        @endif
    </div>

    @if (!$customerInfo->last_bill)
        <p class='text-[15px] text-gray-500 mt-1 mb-3'>Note: Angka meteran bulan lalu akan otomatis diisi
            dengan meter awal yang tercatat pada data pelanggan.</p>
    @endif
@endif

<x-input label="Invoice" wire:model="invoice" type="text" readonly placeholder="Automatis di buat" :error="$errors->first('invoice')" />

<x-input label="Meteran Bulan Lalu/Awal" wire:model="meter_start" type="number" readonly
    placeholder="Auto isi dari tagihan sebelumnya" :error="$errors->first('meter_start')" min="0" />

<x-input label="Pemakaian" wire:model.change="usage" type="number" :required="$required"
    placeholder="Masukkan pemakaian listrik bulan ini" :error="$errors->first('usage')" min="0"
    :disabled="!$customerInfo" append="kWh"
    margin="mb-0" />

<p class="text-[14px] text-gray-500 mt-1 mb-3">
    Note: Minimal 10 kWh untuk pemakaian listrik.
</p>

<x-input label="Periode" wire:model.change="period" type="month" :required="$required" placeholder="Pilih periode"
    :error="$errors->first('period')" :disabled="!$customerInfo" :readonly="$customerInfo && !$customerInfo->last_bill"
    :margin="$customerInfo && !$customerInfo->last_bill ? 'mb-0' : 'mb-3'" min="{{ now()->format('Y-m') }}"
    max="{{ now()->addMonth()->format('Y-m') }}" />

@if ($customerInfo && !$customerInfo->last_bill)
    <p class="text-[15px] text-gray-500 mt-1 mb-3">
        Note: Periode tagihan ini akan otomatis diisi jika pelanggan belum memiliki tagihan sebelumnya.
    </p>
@endif

<x-input label="Jatuh Tempo" wire:model.blur="due_date" type="date" margin="mb-0" placeholder="Pilih jatuh tempo"
    :error="$errors->first('due_date')" :disabled="!$customerInfo || !$period" min="{{ now()->format('Y-m-d') }}"
    max="{{ now()->addMonth(2)->format('Y-m-d') }}" />

<p class="text-[15px] text-gray-500 mt-1 mb-3">
    Note: Jatuh tempo otomatis diatur ke tanggal 20 pada bulan berikutnya dari periode tagihan.
    Sesuaikan jika diperlukan.
</p>

@if ($total_bill)
    <div class="alert alert-info mb-1">
        Total biaya tagihan untuk periode <strong>{{ formatPeriod($period) }}</strong> adalah
        <strong>{{ rupiah($total_bill) }}</strong>
    </div>

    <p class="mb-0 text-[15px]">Rumus: <strong>(Meter Awal - Meter Akhir) x Tarif</strong></p>
@endif
