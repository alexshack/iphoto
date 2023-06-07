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

        @include('layouts.components.auth-styles')

	</head>

	<body>

        @yield('content')

        @include('layouts.components.auth-scripts')

	</body>
</html>
