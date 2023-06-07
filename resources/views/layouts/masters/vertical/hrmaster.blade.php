<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>

		<!-- Meta data -->
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta content="" name="description">
		<meta content="" name="author">
		<meta name="keywords" content=""/>

		<!-- Title -->
		<title>Я - Фотограф</title>

        @include('layouts.verticalmenu.styles')

	</head>

	<body class="app sidebar-mini" id="index1">

		<!---Global-loader-->
		<div id="global-loader" >
			<img src="{{URL::asset('assets/images/svgs/loader.svg')}}" alt="loader">
		</div>

		<div class="page">
			<div class="page-main">

                @include('layouts.verticalmenu.sidebars.hr-sidebar')

				<div class="app-content main-content">
					<div class="side-app">

                        @include('layouts.verticalmenu.app-header')

                        @yield('content')

					</div>
				</div><!-- end app-content-->
			</div>

            @include('layouts.components.footer')

            @include('layouts.components.right-sidebar')

            @yield('modals')

		</div>

        @include('layouts.verticalmenu.scripts')

	</body>
</html>
