@extends('front.layouts.default')
@section('title','Thank You for Order')
@section('content')
<div class="thankyou-page">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="card mt-5">
					<div class="card-body">
						<h3>Thank You for your Order</h3>
						<p>Your order No is {{$order->id}}</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection