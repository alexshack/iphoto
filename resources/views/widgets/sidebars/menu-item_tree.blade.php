@if ($item)
    <li class="slide">
        <a class="side-menu__item" data-toggle="slide" href="#">
            <i class="feather {{ $item->icon }} sidemenu_icon"></i>
            <span class="side-menu__label">{{ $item->caption }}</span><i class="angle fa fa-angle-right"></i>
        </a>

        @if (!empty($item->childs))
            <ul class="slide-menu">
                @foreach ($item->childs as $childItem)

                    @if (empty($childItem->childs))
                        <li><a href="{{ $childItem->url ?? '#' }}" class="slide-item">{{ $childItem->caption }}</a></li>
                    @else

                        <li class="sub-slide">
                            <a class="sub-side-menu__item" data-toggle="sub-slide" href="#">
                                <span class="sub-side-menu__label">{{ $childItem->caption }}</span>
                                <i class="sub-angle fa fa-angle-right"></i>
                            </a>

                            <ul class="sub-slide-menu">
                                @foreach ($childItem->childs as $subChild)
                                    <li>
                                        <a class="sub-slide-item" href="{{ $subChild->url }}">{{ $subChild->caption }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>

                    @endif

                @endforeach
            </ul>
        @endif
        
    </li>
@endif