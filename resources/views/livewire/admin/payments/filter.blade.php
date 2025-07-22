<div class="flex justify-between gap-2 mb-3">
    <div class="flex items-center gap-2">
        <select class="w-[80px] form-select" wire:model.change="perPage">
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>

        <select class="form-select" wire:model.change="filterStatus">
            <option value="">Semua</option>
            <option value="0">Menunggu Konfirmasi</option>
            <option value="1">Diterima</option>
            <option value="2">Ditolak</option>
        </select>
    </div>

    <div>
        <input type="text" class="w-[300px] form-control" placeholder="Cari Pembayaran..."
            wire:model.live.debounce.500ms="search">
    </div>
</div>
