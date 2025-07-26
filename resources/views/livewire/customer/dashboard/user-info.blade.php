<div class="card">
    <div class="card-header">
        Informasi Pengguna
    </div>
    <div class="card-body">
        <div class="mb-3">
            <label for="name" class=" text-[15px] font-medium text-gray-500 mb-1">Nama</label>
            <p class="font-bold">{{ $user->name }}</p>
        </div>
        <div class="mb-3">
            <label for="name" class=" text-[15px] font-medium text-gray-500 mb-1">Email</label>
            <p class="font-bold">{{ $user->email }}</p>
        </div>
        <div class="mb-3">
            <label for="name" class=" text-[15px] font-medium text-gray-500 mb-1">Bergabung Pada</label>
            <p class="font-bold">{{ $user->created_at->translatedFormat('l, d F Y') }}</p>
        </div>
        <div class="mb-3">
            <label for="name" class=" text-[15px] font-medium text-gray-500 mb-1">
                Alamat
            </label>
            <p class="font-bold">{{ $user->customer->address ?? '-' }}</p>
        </div>
        <div class="mb-3">
            <label for="name" class=" text-[15px] font-medium text-gray-500 mb-1">
                Tarif
            </label>
            <p class="font-bold">{{ $user->customer->tarif?->format_tarif }}</p>
        </div>
        <div class="mb-0">
            <label for="name" class=" text-[15px] font-medium text-gray-500 mb-1">Peran</label>
            <p class="font-bold mb-1">{{ ucfirst($user->role->name) }}</p>
        </div>
    </div>
</div>
