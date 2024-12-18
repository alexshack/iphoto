<!DOCTYPE html>
<html lang="ru" dir="ltr">
    <head>

        <!-- Meta data -->
        <meta charset="UTF-8">
        <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
        <meta content="" name="description">
        <meta content="" name="author">
        <meta name="keywords" content=""/>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Title Фамилия Имя текущего юзера-->
        <title>Админов Админ - Я Фотограф</title>

        @include('layouts.verticalmenu.styles')

    </head>

    <body class="app sidebar-mini" id="index1">

        <!---Global-loader-->
        <div id="global-loader" >
            <img src="{{URL::asset('assets/images/svgs/loader.svg')}}" alt="loader">
        </div>

        <div class="page">
            <div class="page-main">
                <!-- В зависимости от роли пользователя грузится соответствующее меню-->
                @widget('sidebars.admin')

                <div class="app-content main-content">
                    <div class="side-app">

                        @include('layouts.verticalmenu.header')
                        @if(Session::has('message'))
                            <div class='alert alert-success mt-1'>
                                {{ Session::get('message') }}
                            </div>
                        @endif
                        @yield('content')
                    </div>
                </div><!-- end app-content-->
            </div>

            @include('layouts.components.footer')

            @yield('modals')

        </div>

        @include('layouts.verticalmenu.scripts')

    </body>
</html>
