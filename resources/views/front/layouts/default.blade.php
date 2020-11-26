<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
	@include('front.includes.head')
	<title>@yield('title')</title>
	@yield('css')
</head>
<body class="single-page">
		@include('front.includes.header')
		
		
			@yield('content')
	
		@include('front.includes.footer')
	
	@include('front.includes.footer_js')
	@yield('scripts')	
</body>
</html>