@props([
    'color' => 'primary',
    'count' => 0,
    'title' => '',
    'subSize' => '2xl',
])

<div class="card">
    <div class="card-body p-3 d-flex align-items-center">
        <div class="bg-{{ $color }} text-white p-3 me-3 rounded-md">
            {{ $slot }}
        </div>
        <div>
            <div class="fw-semibold text-{{ $color }} text-{{ $subSize }}">
                {{ $count }}
            </div>
            <div class=" text-uppercase fw-semibold small">
                {{ $title }}
            </div>
        </div>
    </div>
</div>
