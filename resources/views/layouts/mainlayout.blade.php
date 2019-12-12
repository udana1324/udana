<!DOCTYPE html>
<html>
<head>
	@if(isset(Auth::user()->user_name))
	@include('layouts.partials.head')
</head>
<body>

@include('layouts.partials.nav')
<div class="page-content">
	@include('layouts.partials.sidenav')
	<div class="content-wrapper">
		@yield('content')
		@include('layouts.partials.footer')
	</div>
</div>
</body>
@yield('scripts')
@else
    <script>window.location = "/main";</script>
 @endif
</html>