
		<!--Favicon -->
		<link rel="icon" href="{{URL::asset('assets/images/brand/favicon.png')}}" type="image/x-icon"/>

		<!-- Bootstrap css -->
		<link href="{{URL::asset('assets/plugins/bootstrap/css/bootstrap.css')}}" rel="stylesheet" />

		<!-- Style css -->
		<link href="{{URL::asset('assets/css/style.css')}}" rel="stylesheet" />
		<link href="{{URL::asset('assets/css/dark.css')}}" rel="stylesheet" />
		<link href="{{URL::asset('assets/css/skin-modes.css')}}" rel="stylesheet" />

		<!-- Animate css -->
		<link href="{{URL::asset('assets/plugins/animated/animated.css')}}" rel="stylesheet" />

		<!--Sidemenu css -->
        <link  href="{{URL::asset('assets/css/sidemenu.css')}}" rel="stylesheet">

		<!-- P-scroll bar css-->
		<link href="{{URL::asset('assets/plugins/p-scrollbar/p-scrollbar.css')}}" rel="stylesheet" />

		<!---Icons css-->
		<link href="{{URL::asset('assets/plugins/icons/icons.css')}}" rel="stylesheet" />


		<!-- Select2 css -->
		<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />

        <link rel="stylesheet" href="{{URL::asset('assets/plugins/sweet-alert/sweetalert.css')}}">
        <link rel="stylesheet" href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}">

        @livewireStyles

        <style>
            [data-select-init="true"] + span {
                width: 100% !important;
            }
        </style>
        @yield('styles')
