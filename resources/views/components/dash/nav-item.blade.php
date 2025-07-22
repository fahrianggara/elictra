<li class="nav-item">
    <a href="{{ $isRoute ? route(trim(explode(',', $href)[0])) : trim(explode(',', $href)[0]) }}"
        class="nav-link {{ $active }}">
        <i class="nav-icon {{ $icon }}"></i>
        {{ $slot }}
    </a>
</li>
