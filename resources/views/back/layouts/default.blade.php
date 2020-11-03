<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
	@include('back.includes.head')
	@yield('css')
	<title>@yield('title') -LaraCommerce</title>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
	<div class="wrapper">
		@include('back.includes.header')
		@include('back.includes.sidebar')
		<div class="content-wrapper">
			@yield('content')
		</div>
		@include('back.includes.footer')
	</div>
	@include('back.includes.footer_js')
	@yield('script')	
</body>
</html>