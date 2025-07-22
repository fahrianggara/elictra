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
            <option value="waiting">Menunggu Konfirmasi</option>
            <option value="unpaid">Belum Dibayar</option>
            <option value="paid">Lunas</option>
        </select>
    </div>

    <div>
        <input type="text" class="w-[300px] form-control" placeholder="Cari Tagihan..."
            wire:model.live.debounce.500ms="search">
    </div>
</div>
