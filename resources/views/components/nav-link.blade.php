@props(['active' => false, 'href' => '', 'label' => ''])
<li class="nav-item">
    <a class="nav-link {{ $active ? 'active' : '' }}" href="{{ $href }}">
        <span class="nav-link-icon d-md-none d-lg-inline-block">
            {{ $slot }}
        </span>
        <span class="nav-link-title">
            {{ $label }}
        </span>
    </a>
</li>