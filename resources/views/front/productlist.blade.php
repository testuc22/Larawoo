@extends('front.layouts.default')
@section('title','Product List')
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
				<li>Electronics</li>
			</ul>
		</div>
	</div>
</div>
<div class="ads-grid py-sm-5 py-4">
		<div class="container py-xl-4 py-lg-2">
			<!-- tittle heading -->
			<h3 class="tittle-w3l text-center mb-lg-5 mb-sm-4 mb-3">
				<span>M</span>obiles
				<span>&</span>
				<span>C</span>omputers</h3>
			<!-- //title heading -->
			<div class="row">
				<!-- product left -->
				<div class="agileinfo-ads-display col-lg-9">
					<div class="wrapper">
						<!-- first section mt-md-0 mt-5-->
						<div class="product-sec1 px-sm-4 px-3 py-sm-5  py-3 mb-4">
							<div class="row">
								@foreach($products as $product)
								@if(count($product->variantList) > 0)
								@foreach($product->variantList as $variant)
								<div class="col-md-4 product-men">
									<div class="men-pro-item simpleCart_shelfItem">
										<div class="men-thumb-item text-center">
											<img src="{{asset('/product-images/'.$variant->variantImage[0])}}" alt="" height="150">
											<div class="men-cart-pro">
												<div class="inner-men-cart-pro">
													<a href="single.html" class="link-product-add-cart">Quick View</a>
												</div>
											</div>
										</div>
										<div class="item-info-product text-center border-top mt-4">
											<h4 class="pt-1">
												<a href="single.html">{{$product->title}}{{$variant->variantName}}</a>
											</h4>
											<div class="info-product-price my-2">
												<span class="item_price">₹{{$variant->discountPrice}}</span>
												@if($product->discount!=NULL)
												<del>₹{{$variant->price}}</del>
												@endif
											</div>
											<div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
												<form action="#" method="post">
													<fieldset>
														<input type="hidden" name="cmd" value="_cart" />
														<input type="hidden" name="add" value="1" />
														<input type="hidden" name="business" value=" " />
														<input type="hidden" name="item_name" value="Samsung Galaxy J7" />
														<input type="hidden" name="amount" value="200.00" />
														<input type="hidden" name="discount_amount" value="1.00" />
														<input type="hidden" name="currency_code" value="USD" />
														<input type="hidden" name="return" value=" " />
														<input type="hidden" name="cancel_return" value=" " />
														<input type="submit" name="submit" value="Add to cart" class="button btn" />
													</fieldset>
												</form>
											</div>

										</div>
									</div>
								</div>
								@endforeach
								@else
								<div class="col-md-4 product-men">
									<div class="men-pro-item simpleCart_shelfItem">
										<div class="men-thumb-item text-center">
											<img src="{{asset('/product-images/'.$product->productImage->image)}}" alt="" height="150">
											<div class="men-cart-pro">
												<div class="inner-men-cart-pro">
													<a href="single.html" class="link-product-add-cart">Quick View</a>
												</div>
											</div>
										</div>
										<div class="item-info-product text-center border-top mt-4">
											<h4 class="pt-1">
												<a href="single.html">{{$product->title}}</a>
											</h4>
											<div class="info-product-price my-2">
												<span class="item_price">₹{{$product->discountPrice}}</span>
												@if($product->discount!=NULL)
												<del>₹{{$product->price}}</del>
												@endif
											</div>
											<div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
												<form action="#" method="post">
													<fieldset>
														<input type="hidden" name="cmd" value="_cart" />
														<input type="hidden" name="add" value="1" />
														<input type="hidden" name="business" value=" " />
														<input type="hidden" name="item_name" value="Samsung Galaxy J7" />
														<input type="hidden" name="amount" value="200.00" />
														<input type="hidden" name="discount_amount" value="1.00" />
														<input type="hidden" name="currency_code" value="USD" />
														<input type="hidden" name="return" value=" " />
														<input type="hidden" name="cancel_return" value=" " />
														<input type="submit" name="submit" value="Add to cart" class="button btn" />
													</fieldset>
												</form>
											</div>

										</div>
									</div>
								</div>
								@endif
								@endforeach
							</div>
						</div>
						<div class="pagination-wrapper">
							{{$products->render()}}
						</div>
						<!-- //first section -->
					</div>
				</div>
				<!-- //product left -->
				<!-- product right -->
				<div class="col-lg-3 mt-lg-0 mt-4 p-lg-0">
					<div class="side-bar p-sm-4 p-3">
						<x-list-brand/>
						<!-- ram -->
						@foreach($attributes as $attribute)
						<div class="left-side border-bottom py-2">
							<h3 class="agileits-sear-head mb-3">{{$attribute->name}}</h3>
							<ul>
								@foreach($attribute->attributeValues as $attributeValue)
								<li>
									<input type="checkbox" class="checked product-attribute" data-attributevalue="{{$attributeValue->id}}">
									<span class="span">{{$attributeValue->value}}</span>
								</li>
								@endforeach
							</ul>
						</div>
						@endforeach
						<!-- //ram -->
						<!-- price -->
						<div class="range border-bottom py-2">
							<h3 class="agileits-sear-head mb-3">Price</h3>
							<div class="w3l-range">
								<ul>
									<li>
										<a href="javascript:;" data-price="1-999" class="product-price">Under $1,000</a>
									</li>
									<li class="my-1">
										<a href="javascript:;" data-price="1000-5000" class="product-price">$1,000 - $5,000</a>
									</li>
									<li>
										<a href="javascript:;" data-price="5000-10000" class="product-price">$5,000 - $10,000</a>
									</li>
									<li class="my-1">
										<a href="javascript:;" data-price="10000-20000" class="product-price">$10,000 - $20,000</a>
									</li>
									<li>
										<a href="javascript:;" data-price="20000-30000" class="product-price">$20,000 $30,000</a>
									</li>
									<li class="mt-1">
										<a href="javascript:;" data-price="30000-500000" class="product-price">Over $30,000</a>
									</li>
								</ul>
							</div>
						</div>
						<!-- //price -->
						<!-- discounts -->
						<div class="left-side border-bottom py-2">
							<h3 class="agileits-sear-head mb-3">Discount</h3>
							<ul>
								<li>
									<input type="checkbox" class="checked product-discount" data-discount="5">
									<span class="span">5% or More</span>
								</li>
								<li>
									<input type="checkbox" class="checked product-discount" data-discount="10">
									<span class="span">10% or More</span>
								</li>
								<li>
									<input type="checkbox" class="checked product-discount" data-discount="20">
									<span class="span">20% or More</span>
								</li>
								<li>
									<input type="checkbox" class="checked product-discount" data-discount="30">
									<span class="span">30% or More</span>
								</li>
								<li>
									<input type="checkbox" class="checked product-discount" data-discount="50">
									<span class="span">50% or More</span>
								</li>
								<li>
									<input type="checkbox" class="checked product-discount" data-discount="60">
									<span class="span">60% or More</span>
								</li>
							</ul>
						</div>
						<!-- //discounts -->
						<!-- offers -->
						<div class="left-side border-bottom py-2">
							<h3 class="agileits-sear-head mb-3">Offers</h3>
							<ul>
								<li>
									<input type="checkbox" class="checked">
									<span class="span">Exchange Offer</span>
								</li>
								<li>
									<input type="checkbox" class="checked">
									<span class="span">No Cost EMI</span>
								</li>
								<li>
									<input type="checkbox" class="checked">
									<span class="span">Special Price</span>
								</li>
							</ul>
						</div>
						<!-- //offers -->
						<!-- delivery -->
						<div class="left-side border-bottom py-2">
							<h3 class="agileits-sear-head mb-3">Cash On Delivery</h3>
							<ul>
								<li>
									<input type="checkbox" class="checked">
									<span class="span">Eligible for Cash On Delivery</span>
								</li>
							</ul>
						</div>
						<!-- //delivery -->
						<!-- arrivals -->
						<div class="left-side border-bottom py-2">
							<h3 class="agileits-sear-head mb-3">New Arrivals</h3>
							<ul>
								<li>
									<input type="checkbox" class="checked">
									<span class="span">Last 30 days</span>
								</li>
								<li>
									<input type="checkbox" class="checked">
									<span class="span">Last 90 days</span>
								</li>
							</ul>
						</div>
						<div class="left-side py-2">
							<h3 class="agileits-sear-head mb-3">Availability</h3>
							<ul>
								<li>
									<input type="checkbox" class="checked">
									<span class="span">Exclude Out of Stock</span>
								</li>
							</ul>
						</div>
						<!-- //arrivals -->
					</div>
					<!-- //product right -->
				</div>
			</div>
		</div>
	</div>
@endsection
@section('scripts')
<script>
	jQuery(document).ready(function($) {
		var productList={
			el:{
				wrapper:false,
				productSection:false,
				productBrand:false,
				productAttribute:false,
				productPrice:false,
				productDiscount:false,
			},
			filterValues:{
				brands:[],
				attributes:[],
				price:false,
				discount:[]
			},
			categories:[],
			init:function() {
				this.initVars();
			},
			initVars:function() {
				this.el.wrapper=$(".wrapper");
				this.el.productSection=$(".product-sec1");
				this.el.productBrand=$(".product-brand");
				this.el.productAttribute=$(".product-attribute");
				this.el.productPrice=$(".product-price");
				this.el.productDiscount=$(".product-discount");
				this.categories=@json($categories);
				this.initEvents();
				console.log(this.categories)
			},
			initEvents:function() {
				this.el.productBrand.on("click",(ev)=>{this.toggleBrand(ev)})
				this.el.productAttribute.on("click",(ev)=>{this.toggleAttribute(ev)})
				this.el.productPrice.on("click",(ev)=>{this.togglePrice(ev)})
				this.el.productDiscount.on("click",(ev)=>{this.toggleDiscount(ev)})
			},
			toggleBrand:function(event) {
				let target=$(event.target)
				let data=target.data('brand');
				let type='brands';
				this.filterObjectValue(target,data,type)
			},
			toggleAttribute:function(event) {
				let target=$(event.target)
				let data=target.data('attributevalue');
				let type='attributes';
				this.filterObjectValue(target,data,type)
			},
			togglePrice:function(event) {
				let target=$(event.target)
				let data=target.data('price');
				this.filterValues.price=data;
				const url = new URL(window.location);
				url.searchParams.set('price', data);
				window.history.replaceState({}, '', url);
				this.filterProducts();
			},
			toggleDiscount:function(event) {
				let target=$(event.target)
				let data=target.data('discount');
				let type='discount';
				this.filterObjectValue(target,data,type)
			},
			filterObjectValue:function(target,data,type) {
				const url = new URL(window.location);
				if (target.is(':checked')) {
					this.filterValues[type].push(data)
					url.searchParams.set(type, this.filterValues[type].join(","));
					window.history.replaceState({}, '', url);
					this.filterProducts();
				}
				else {
					let index=this.filterValues[type].findIndex(brand=>brand==data);
					this.filterValues[type].splice(index, 1);
					url.searchParams.set(type, this.filterValues[type].join(","));
					window.history.replaceState({}, '', url);
					this.filterProducts();	
				}
				console.log(this.filterValues)
			},
			filterProducts:function() {
				let categories=this.categories;
				let filterValues=this.filterValues;
				$.ajax({
			        url: '{{route('filter-products')}}',
			        type: 'POST',
			        data: {categories:categories,filterValues:filterValues,'_token':'{{csrf_token()}}'},
			        success:function(result){
			            console.log(result)
			            let productHtml='';
			            result.data.forEach( function(element, index) {
			            	if (element.hasOwnProperty('variants')) {
			            		let variants=element.variants;
			            		for (variant in variants) {
					            	productHtml+=`<div class="col-md-4 product-men">
											<div class="men-pro-item simpleCart_shelfItem">
												<div class="men-thumb-item text-center">
													<img src="${variants[variant].variantImage}" alt="" height="150">
													<div class="men-cart-pro">
														<div class="inner-men-cart-pro">
															<a href="single.html" class="link-product-add-cart">Quick View</a>
														</div>
													</div>
												</div>
												<div class="item-info-product text-center border-top mt-4">
													<h4 class="pt-1">
														<a href="single.html">${element.title}${variants[variant].variantName}</a>
													</h4>
													<div class="info-product-price my-2">
														<span class="item_price">₹${variants[variant].discountPrice}</span>
														
														<del>₹${element.discount!=null ? variants[variant].price : ''}</del>
														
													</div>
													<div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
														<form action="#" method="post">
															<fieldset>
																<input type="hidden" name="cancel_return" value=" " />
																<input type="submit" name="submit" value="Add to cart" class="button btn" />
															</fieldset>
														</form>
													</div>

												</div>
											</div>
										</div>`;
			            			
			            		}

			            	}
			            });
			            let paginationHtml='<nav><ul class="pagination">';
			            result.links.forEach( function(element, index) {
			            	paginationHtml+=`<li class="page-item ${element.active==false && element.url==null ? 'disabled' : (element.active==true ? 'active' : '')} ">
			            	${(element.active==true && element.url!=null)||(element.active==false && element.url==null) ? `<span class="page-link">${element.label}</span>` : `<a href="${element.url}" class="page-link">${element.label}</a>`}
			            	</li>`;
			            });
			            paginationHtml+='</ul></nav>';
			            $(".pagination-wrapper").html(paginationHtml)
			            $(".product-sec1 .row").html(productHtml)
			        }
			    });
			}
		}
		productList.init();
	});
</script>
@endsection