<!--aside open-->
<aside class="app-sidebar">
    <div class="app-sidebar__logo">
        <a class="header-brand" href="{{url('/')}} ">
            <img src="{{URL::asset('assets/images/brand/logo.png')}}" class="header-brand-img desktop-lgo" alt="Dayonelogo">
            <img src="{{URL::asset('assets/images/brand/logo-white.png')}}" class="header-brand-img dark-logo" alt="Dayonelogo">
            <img src="{{URL::asset('assets/images/brand/favicon.png')}}" class="header-brand-img mobile-logo" alt="Dayonelogo">
            <img src="{{URL::asset('assets/images/brand/favicon1.png')}}" class="header-brand-img darkmobile-logo" alt="Dayonelogo">
        </a>
    </div>
    <div class="app-sidebar3">
        <div class="app-sidebar__user">
            <div class="dropdown user-pro-body text-center">
                <div class="user-pic">
                    <!-- фото из профиля -->
                    <img src="{{ Auth::guard()->user()->{ \App\Contracts\UserContract::FIELD_PHOTO } ?? URL::asset('assets/images/users/16.jpg')}}" alt="user-img" class="avatar-xxl rounded-circle mb-1">
                </div>
                <div class="user-info">
                    <h5 class=" mb-2">{{ Auth::user()->getFullName() }}</h5>
                    <span class="text-muted app-sidebar__user-name text-sm">{{ Auth::user()->role->{ \App\Contracts\UserRoleContract::FIELD_NAME } }}</span>
                </div>
            </div>
        </div>

        @if (isset($bar))
            <ul class="side-menu">
                @foreach ($bar as $item)
                    
                    @switch($item->type)
                        @case( \App\Components\AdminSidebar\Interfaces\IAdminSidebar::ITEM_TYPE_CAPTION )
                            @include('widgets.sidebars.menu-item_caption', ['item' => $item])
                            @break
                        @case( \App\Components\AdminSidebar\Interfaces\IAdminSidebar::ITEM_TYPE_LINK )
                            @include('widgets.sidebars.menu-item_link', ['item' => $item])
                            @break
                        @case( \App\Components\AdminSidebar\Interfaces\IAdminSidebar::ITEM_TYPE_TREE )
                            @include('widgets.sidebars.menu-item_tree', ['item' => $item])
                            @break
                            
                    @endswitch

                @endforeach
            </ul>
        @endif

    </div>
</aside>
<!--aside closed-->