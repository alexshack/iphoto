@if ($item)
    <li class="slide">
        <a class="side-menu__item" href="{{ $item->url }}">
            <i class="feather {{ $item->icon }} sidemenu_icon"></i>
            <span class="side-menu__label">{{ $item->caption }}</span>
        </a>
    </li>
@endif
