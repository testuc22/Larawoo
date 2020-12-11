@extends('front.layouts.default')
@section('title','Checkout')
@section('content')
<div class="page-head_agile_info_w3l">
</div>
<div class="services-breadcrumb">
	<div class="agile_inner_breadcrumb">
		<div class="container">
			<ul class="w3_short">
				<li>
					<a href="index.html">Home</a>
					<i>|</i>
				</li>
				<li>Checkout</li>
			</ul>
		</div>
	</div>
</div>
<div class="checkout-page">
	<div class="container">
			<form id="checkout-form" action="{{route('save-order')}}" method="post">
				@csrf
		<div class="row">
			<div class="col-md-6">
				
				    <div class="form-group">
				    	<label>Line1</label>
				  		<input type="text" class="form-control" placeholder="Line1" name="line1" value="{{$userAddress->line1}}" required="true" id="line1">
				    </div>
				    <div class="form-group">
				    	<label>Line2</label>
				  		<input type="text" class="form-control" placeholder="Line2" name="line2" value="{{$userAddress->line2}}" required="true" id="line2">
				    </div>
				    <div class="form-group">
				    	<label>City</label>
				  		<input type="text" class="form-control" placeholder="City" name="city" value="{{$userAddress->city}}" required="true" id="city">
				    </div>
				    <div class="form-group">
				    	<label>State</label>
				  		<input type="text" class="form-control" placeholder="State" name="state" value="{{$userAddress->state}}" required="true" id="state">
				    </div>
				    <div class="form-group">
				    	<label>Country</label>
				  		<input type="text" class="form-control" placeholder="Country" name="country" value="{{$userAddress->country}}" required="true" id="country">
				    </div>
				    {{-- <div class="form-group">
				    	<label>Pincode</label>
				  		<input type="text" class="form-control" placeholder="Pincode" name="pincode" value="{{$userAddress->pincode}}" required="true" id="pincode">
				    </div>
				    <div class="form-group">
				    	<label>Phone</label>
				  		<input type="text" class="form-control" placeholder="Phone" name="phone" value="{{$userAddress->phone}}" required="true" id="phone">
				    </div> --}}
				
			</div>
			<div class="col-md-6">
				@php
					$price=0;
				@endphp
				@if($userCart->cartItems()->exists())
					@foreach($userCart->cartItems as $cartItem)
						@php
							$price=$cartItem->price+$price;
						@endphp
					@endforeach
				@endif
				<div class="mt-2">
					<h3>Total</h3>
					<div class="cart-item-total">
						<span>₹<span class="totalprice">{{$price}}</span></span>
						<input type="hidden" name="totalprice" value="{{$price}}">
					</div>
					<div class="payment-method mt-3">
						<h4>Payment Method</h4>
						<label><input type="checkbox" class="checked payment" name="Cash On Delivery">
						<span class="span">Cash On Delivery</span></label>
					</div>
					<div class="submit-form mt-3">
						<input type="submit" name="submitForm" value="Order Now" class="btn btn-danger">
					</div>
				</div>
			</div>
		</div>
			</form>
	</div>
</div>
@endsection