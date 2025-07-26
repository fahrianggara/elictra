<x-input label="Nama Pelanggan" wire:model="customer_name" type="text" disabled placeholder="Automatis di buat" />

<x-input label="Invoice" wire:model="invoice" type="text" disabled placeholder="Automatis di buat" />

<x-input label="Meteran Bulan Lalu/Awal" wire:model="meter_start" type="number" disabled
    placeholder="Auto isi dari tagihan sebelumnya" />

<x-input label="Pemakaian" wire:model.change="usage" type="number" :required="$required"
    placeholder="Masukkan pemakaian listrik bulan ini" :error="$errors->first('usage')" min="0" append="kWh" margin="mb-0" />

<p class="text-[14px] text-gray-500 mt-1 mb-3">
    Note: Minimal 10 kWh untuk pemakaian listrik.
</p>

<x-input label="Periode" wire:model.change="period" type="month" :required="$required" placeholder="Pilih periode"
    :error="$errors->first('period')" min="{{ now()->format('Y-m') }}" max="{{ now()->addMonth()->format('Y-m') }}" />

<x-input label="Jatuh Tempo" wire:model.blur="due_date" type="date" margin="mb-0" placeholder="Pilih jatuh tempo"
    :error="$errors->first('due_date')" max="{{ now()->addMonth(2)->format('Y-m-d') }}" />

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
