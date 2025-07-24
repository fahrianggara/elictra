@php
    // Define the step variables in an array
    $steps = [
        1 => $step_1 ?? false,
        2 => $step_2 ?? false,
        3 => $step_3 ?? false,
    ];

    $title = [
        1 => 'Metode Pembayaran',
        2 => 'Detail Tagihan',
        3 => 'Upload Bukti',
    ];
@endphp

<div class="card-body">
    <div class="flex items-center justify-between mb-0">
        @foreach($steps as $step => $isActive)
            <div class="flex-1 text-center">
                <div class="w-8 h-8 mx-auto rounded-full
                    {{ $step_current === $step ? 'bg-[#5856d6] text-white' : 'bg-gray-300 text-gray-600' }}
                    flex items-center justify-center">
                    {{ $step }}
                </div>
                <p class="text-sm mt-2 mb-0">{{ $title[$step] }}</p>
            </div>

            {{-- Divider line between steps --}}
            @if($step < count($steps))
                <div class="flex-1 h-px bg-gray-300 mx-2"></div>
            @endif
        @endforeach
    </div>
</div>
