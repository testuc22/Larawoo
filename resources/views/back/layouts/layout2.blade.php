<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
	@include('back.includes.head')
	@yield('css')
	<title>@yield('title')</title>
</head>
<body class="hold-transition sidebar-mini layout-fixed banker">
	<div class="wrapper">
		@auth
		{{-- @include('back.includes.header') --}}
		@endauth
		@include('back.includes.sidebar2')
		<div class="content-wrapper">
			@yield('content')
		</div>
		@include('back.includes.footer')
	</div>
	@include('back.includes.footer_js')
	@yield('script')	
</body>
</html>