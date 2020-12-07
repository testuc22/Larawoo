@extends('front.layouts.default')
@section('title','My Account')
@section('content')
<div class="my-account-page">
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<ul class="nav nav-tabs">
					<li class="nav-item">
						<a href="{{route('getaddress')}}" class="nav-link">My Addresses</a>
					</li>
				</ul>
			</div>
			<div class="col-md-8">
				<h3>User Dashboard</h3>
			</div>
		</div>
	</div>
</div>
@endsection