<div>
	<div class="row">
		<div class="col-md-8">
				<div class="card-body">
					<form method="post">
					<div class="form-group">
						<input type="text" name="product_combinations" id="product_combinations" class="form-control" placeholder="Create Combinations">
					</div>
					<div class="card-footer">
							<button type="button" class="btn btn-warning generate_combinations">Save</button>
					</div>
					</form>
					<div class="form-group">
						<div id="success-msg" style="display: none">
							@component('back.components.success')
		                        Combinations Generated Successfully
		                      @endcomponent
						</div>
						<div id="error-msg" style="display: none">
							@component('back.components.error')
		                        Combinations Already Exist
		                      @endcomponent
						</div>
						{{-- <x-product-combinations :product="$product"/> --}}
		                    <div id="accordion">
		                    	@foreach($variants as $variant)
		                    	@php
		                    	$variantImages=getProductVariantImages($variant);
		                    	@endphp
		                    	<div class="card">
								    <div class="card-header">
								      <a class="card-link" data-toggle="collapse" href="#collapseOne_{{$variant->id}}">
								        {{getProductVariantsNames($variant->variantAttributes)}}
								      </a>
								      <div class="del-comb-wrap">
								      	<a href="javascript:;" class="del-comb-btn" data-variant="{{$variant->id}}"><i class="fas fa-times-circle fa-2x"></i></a>
								      </div>
								    </div>
								    <div id="collapseOne_{{$variant->id}}" class="collapse " data-parent="#accordion">
								      <div class="card-body">
								      	<form method="post" class="variant_form">
								      		<input type="hidden" name="variant" value="{{$variant->id}}" class="variant-id-class">
									        <div class="form-group">
									        	<label>Quantity</label>
									        	<input type="text" name="quantity" class="form-control quantity" placeholder="Quantity" value="{{$variant->quantity}}">
									        </div>
									        <div class="form-group">
									        	<label>Price</label>
									        	<input type="text" name="price" class="form-control price" placeholder="Price" value="{{$variant->price}}">
									        </div>
												<button type="button" class="btn btn-warning save_variation">Save</button>
										</form>
										<div class="variant-images">
											<h3>Images</h3>
											<span>Select Images Of this Combination</span>
											<span class="comb-images">{{count($variantImages) }}</span>/
											<span class="product-total-images">{{count($images)}}</span>
											<div class="row mt-5">
									        @foreach($images as $image)
									        <a href="javascript:;" class="variant_image" >
										        <div class="col-md-2 mb-3 variant-img">
										            <div class="product-image">
										                <img src="{{$image->imageUrl}}" height="50" width="70" class="{{in_array($image->image, $variantImages) ? 'image-border':''}}" data-thumb="{{$image->image}}" data-variant="{{$variant->id}}">
										            </div>
										        </div>
									    	</a>
									        @endforeach
									    </div>
									    <button type="button" class="btn btn-info save_variation_image">Save Images</button>
										</div>
								      </div>
								    </div>
								  </div>
								@endforeach  
		                    </div>  
					</div>
				</div>
				
		</div>
		<div class="col-md-4">
			@foreach($attributes as $attribute)
			<h3>{{$attribute->name}}</h3>
			@foreach($attribute->attributeValues as $attributeValue)
			<div class="form-check">
                <input type="checkbox" class="form-check-input single_attribute" id="attr{{$attributeValue->id}}" data-label="{{$attribute->name.':'.$attributeValue->value}}" data-attributeid="{{$attributeValue->id}}" data-group="{{$attribute->id}}">
                <label class="form-check-label" for="attr{{$attributeValue->id}}">{{$attributeValue->value}}</label>
            </div>
            @endforeach
			@endforeach
		</div>
	</div>
</div>