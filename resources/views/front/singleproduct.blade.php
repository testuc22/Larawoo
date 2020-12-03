@extends('front.layouts.default')
@section('title','Single Product')
@section('content')
<div class="page-head_agile_info_w3l">
</div>
<div class="services-breadcrumb">
	<div class="agile_inner_breadcrumb">
		<div class="container">
			<ul class="w3_short">
				<li>
					<a href="{{route('home')}}">Home</a>
					<i>|</i>
				</li>
				<li>{{$product->title}}</li>
			</ul>
		</div>
	</div>
</div>
<div class="banner-bootom-w3-agileits py-5">
	<div class="container py-xl-4 py-lg-2">
		<!-- tittle heading -->
		<h3 class="tittle-w3l text-center mb-lg-5 mb-sm-4 mb-3">
			<span>S</span>ingle
			<span>P</span>age</h3>
		<!-- //tittle heading -->
		<div class="row">
			<div class="col-lg-5 col-md-8 single-right-left ">
				<div class="grid images_3_of_2">
					<div class="flexslider">
						<ul class="slides">
							@if(count($product->productVariants)>0)
							@foreach($product->productVariants[0]->productVariantImages as $image)
							<li data-thumb="{{asset('/product-images/'.$image->image)}}">
								<div class="thumb-image">
									<img src="{{asset('/product-images/'.$image->image)}}" {{-- data-imagezoom="true"  --}}class="img-fluid" alt=""> </div>
							</li>
							@endforeach
							@else
							@foreach($product->productImages as $image)
							<li data-thumb="{{asset('/product-images/'.$image->image)}}">
								<div class="thumb-image">
									<img src="{{asset('/product-images/'.$image->image)}}" {{-- data-imagezoom="true" --}} class="img-fluid" alt=""> </div>
							</li>
							@endforeach
							@endif
						</ul>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>

			<div class="col-lg-7 single-right-left simpleCart_shelfItem">
				<h3 class="mb-3 product-title">{{count($product->productVariants)>0 ? $product->title.' '.getProductVariantsNames($product->productVariants[0]->variantAttributes):$product->title }}</h3>
				<p class="mb-3 product-price">
					<span class="item_price">₹{{count($product->productVariants)>0 ? $product->productVariants[0]->discountedPrice :$product->discountedPrice}}</span>
					<del class="mx-2 font-weight-light">₹{{count($product->productVariants)>0 ? $product->productVariants[0]->price : $product->price}}</del>
					<label>Free delivery</label>
				</p>
				<div class="single-infoagile">
					<ul>
						<li class="mb-3">
							Cash on Delivery Eligible.
						</li>
						<li class="mb-3">
							Shipping Speed to Delivery.
						</li>
						<li class="mb-3">
							EMIs from $655/month.
						</li>
						<li class="mb-3">
							Bank OfferExtra 5% off* with Axis Bank Buzz Credit CardT&C
						</li>
					</ul>
				</div>
				<div class="product-single-w3l">
					<p class="my-3">
						<i class="far fa-hand-point-right mr-2"></i>
						<label>1 Year</label>Manufacturer Warranty</p>
					<ul>
						<li class="mb-1">
							3 GB RAM | 16 GB ROM | Expandable Upto 256 GB
						</li>
						<li class="mb-1">
							5.5 inch Full HD Display
						</li>
						<li class="mb-1">
							13MP Rear Camera | 8MP Front Camera
						</li>
						<li class="mb-1">
							3300 mAh Battery
						</li>
						<li class="mb-1">
							Exynos 7870 Octa Core 1.6GHz Processor
						</li>
					</ul>
					<p class="my-sm-4 my-3">
						<i class="fas fa-retweet mr-3"></i>Net banking & Credit/ Debit/ ATM card
					</p>
				</div>
				<div class="occasion-cart">
					<div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
						<form action="{{route('add-to-cart')}}" method="post">
							@csrf
							@if(count($productVariants) > 0)
							<select name="productVariant" class="custom-select mb-5 productVariant">
								@foreach($productVariants as $productVariant)
								<option value="{{$productVariant->id}}">{{getProductVariantsNames($productVariant->variantAttributes)}}</option>
								@endforeach
							</select>
							@endif
							<fieldset>
								<input type="hidden" name="product" value="{{$product->id}}" />
								<input type="hidden" name="product_title" class="product_title" value="{{$product->title}}" />
								<input type="hidden" name="image_path" class="image_path" value="{{asset('/product-images/')}}" />
								<input type="submit" name="submit" value="Add to cart" class="button" />
							</fieldset>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
{{-- <script src="https://code.jquery.com/jquery-migrate-3.0.0.min.js"></script> --}}
{{-- <script src="{{asset('front/js/imagezoom.js')}}"></script> --}}
<script src="{{asset('front/js/jquery.flexslider.js')}}"></script>
<script>
jQuery(document).ready(function($) {
	function flexSlider () {
		console.log('ss')
		$('.flexslider').flexslider({
			animation: "slide",
			controlNav: "thumbnails"
		});
	}
	flexSlider();
	$(document).on('change', '.productVariant', function(event) {
		let productVariant=$(this).children('option:selected').val();
		let variantText=$(this).children('option:selected').text();
		let productTitle=$(".product_title").val();
		let imagePath=$(".image_path").val();
		$.ajax({
			url: '{{route('get-product-variant',$product->id)}}',
			type: 'POST',
			data: {productVariant: productVariant,'_token':'{{csrf_token()}}'},
			 success:function(result){
				console.log(result)
				$(".product-title").text(productTitle+' '+variantText)
				$(".product-price").html(`<span class="item_price">₹${result.discountedPrice}</span><del class="mx-2 font-weight-light">${result.price}</del>`)
				let imagesList='';
				result.product_variant_images.forEach( function(element, index) {
					imagesList+=`<li data-thumb="${imagePath+'/'+element.image}">
									<div class="thumb-image">
										<img src="${imagePath+'/'+element.image}"class="img-fluid" alt=""> </div>
								</li>`
				});
				$(".slides").html(imagesList)
				 setTimeout(()=>{flexSlider()},1000)
				 
			}
		})
		
	});

});
</script>
@endsection