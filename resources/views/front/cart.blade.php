@extends('front.layouts.default')
@section('title','Cart Details')
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
<div class="privacy py-sm-5 py-4">
	<div class="container py-xl-4 py-lg-2">
		<!-- tittle heading -->
		<h3 class="tittle-w3l text-center mb-lg-5 mb-sm-4 mb-3">
			<span>C</span>heckout
		</h3>
		<!-- //tittle heading -->
		<div class="checkout-right">
			<h4 class="mb-sm-4 mb-3">Your shopping cart contains:
				<span>{{count($userCart->cartItems)}} Products</span>
			</h4>
			<div class="table-responsive">
				<table class="timetable_sub">
					<thead>
						<tr>
							<th>SL No.</th>
							<th>Product</th>
							<th>Quantity</th>
							<th>Product Name</th>

							<th>Price</th>
							<th>Remove</th>
						</tr>
					</thead>
					<tbody>
						@php
						$price=0;
						@endphp
						@if($userCart->cartItems()->exists())
						@foreach($userCart->cartItems as $cartItem)
						{{-- {{dump($cartItem->cartItemProduct->title)}} --}}
						@php
						$price=$cartItem->price+$price;
						@endphp
						<tr class="rem1">
							<td class="invert">{{$loop->iteration}}</td>
							<td class="invert-image">
								@if($cartItem->cartItemProductVariant()->exists())
								<a href="{{route('single-product',[$cartItem->product_id,$cartItem->cartItemProductVariant->id])}}">
									<img src="{{asset('/product-images/'.getProductVariantImages($cartItem->cartItemProductVariant)[0])}}" alt=" " class="img-responsive">
								</a>
								@else 
								<a href="{{route('single-product',$cartItem->product_id)}}">
									<img src="{{asset('/product-images/'.$cartItem->cartItemProduct->productImages[0]->image)}}" alt=" " class="img-responsive">
								</a>
								@endif
							</td>
							<td class="invert plusminuswrap">
								<div class="quantity">
									<div class="quantity-select">
										<div class="entry value-minus" data-cartitem="{{$cartItem->id}}" data-producttype="{{$cartItem->cartItemProductVariant()->exists() ? 'Variant' :'Simple'}}">&nbsp;</div>
										<div class="entry value">
											<span>{{$cartItem->quantity}}</span>
										</div>
										<div class="entry value-plus active" data-cartitem="{{$cartItem->id}}" data-producttype="{{$cartItem->cartItemProductVariant()->exists() ? 'Variant' :'Simple'}}">&nbsp;</div>
									</div>
								</div>
							</td>
							@if($cartItem->cartItemProductVariant()->exists())
							<td class="invert">{{$cartItem->cartItemProduct->title.' '.getProductVariantsNames($cartItem->cartItemProductVariant->variantAttributes)}}</td>
							@else
							<td class="invert">{{$cartItem->cartItemProduct->title}}</td>
							@endif
							<td class="invert item-price">₹{{$cartItem->price}}</td>
							<td class="invert">
								<div class="rem">
									<div class="close1" data-cartitem="{{$cartItem->id}}" data-producttype="{{$cartItem->cartItemProductVariant()->exists() ? 'Variant' :'Simple'}}"> </div>
								</div>
							</td>
						</tr>
						@endforeach
						@endif
					</tbody>
				</table>
			</div>
		</div>
		{{-- <div class="checkout-left">
			<div class="address_form_agile mt-sm-5 mt-4">
				<h4 class="mb-sm-4 mb-3">Add a new Details</h4>
				<form action="payment.html" method="post" class="creditly-card-form agileinfo_form">
					<div class="creditly-wrapper wthree, w3_agileits_wrapper">
						<div class="information-wrapper">
							<div class="first-row">
								<div class="controls form-group">
									<input class="billing-address-name form-control" type="text" name="name" placeholder="Full Name" required="">
								</div>
								<div class="w3_agileits_card_number_grids">
									<div class="w3_agileits_card_number_grid_left form-group">
										<div class="controls">
											<input type="text" class="form-control" placeholder="Mobile Number" name="number" required="">
										</div>
									</div>
									<div class="w3_agileits_card_number_grid_right form-group">
										<div class="controls">
											<input type="text" class="form-control" placeholder="Landmark" name="landmark" required="">
										</div>
									</div>
								</div>
								<div class="controls form-group">
									<input type="text" class="form-control" placeholder="Town/City" name="city" required="">
								</div>
								<div class="controls form-group">
									<select class="option-w3ls">
										<option>Select Address type</option>
										<option>Office</option>
										<option>Home</option>
										<option>Commercial</option>

									</select>
								</div>
							</div>
							<button class="submit check_out btn">Delivery to this Address</button>
						</div>
					</div>
				</form>
				<div class="checkout-right-basket">
					<a href="payment.html">Make a Payment
						<span class="far fa-hand-point-right"></span>
					</a>
				</div>
			</div>
		</div> --}}
		<div class="row">
			<div class="col-md-8"></div>
			<div class="col-md-4 mt-3">
				<h3>Total</h3>
				<div class="cart-item-total">
					<span>₹<span class="totalprice">{{$price}}</span></span>
				</div>
				<a href="{{route('checkout')}}" class="btn btn-info">Proceed To Checkout</a>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script>
	jQuery(document).ready(function($) {
		$('.value-plus').on('click', function () {
			var divUpd = $(this).parent().find('.value'),
				newVal = parseInt(divUpd.text(), 10) + 1,
				cartItem=$(this).data('cartitem')
			divUpd.text(newVal);
			let type='plus';
			updateCart(newVal,cartItem,$(this),type)
		});

		$('.value-minus').on('click', function () {
			var divUpd = $(this).parent().find('.value'),
				newVal = parseInt(divUpd.text(), 10) - 1,
				cartItem=$(this).data('cartitem')
			if (newVal >= 1){
				divUpd.text(newVal);
				let type='minus';
				updateCart(newVal,cartItem,$(this),type)	
			} 
		});

		$('.close1').on('click', function (c) {
			let _parent=$(this).parents('tr')
			let cartItem=$(this).data('cartitem');
			let productType=$(this).data('producttype');
			$.ajax({
				url: '{{route('remove-cart-item')}}',
				type: 'DELETE',
				data: {cartItem:cartItem,'_token':'{{csrf_token()}}',productType:productType},
				success:function(result){
					console.log(result)
					_parent.fadeOut('slow', function (c) {
						_parent.remove();
					});
				}
			})
			
		});

		function updateCart(value,cartItem,_this,type)
		{
			let productType=_this.data('producttype')
			$.ajax({
				url: '{{route('update-cart')}}',
				type: 'PUT',
				data: {value:value,cartItem:cartItem,'_token':'{{csrf_token()}}',type:type,productType:productType},
				success:function(result){
					console.log(result)
					_this.parents('.plusminuswrap').siblings('.item-price').text('₹'+result.price)
					let totalPrice=parseFloat($(".cart-item-total").find('.totalprice').text())
					switch (type) {
						case 'plus':
							totalPrice=totalPrice+result.originalPrice				
							break;
						case 'minus':
							totalPrice=totalPrice-result.originalPrice	
							break;
					}
					$(".cart-item-total").find('.totalprice').text(totalPrice)
				}
			})
			
		}
	});
</script>
@endsection