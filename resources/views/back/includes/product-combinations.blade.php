<div>
	<div class="row">
		<div class="col-md-8">
			<form method="post">
				<div class="card-body">
					<div class="form-group">
						<input type="text" name="product_combinations" id="product_combinations" class="form-control">
					</div>
					<div class="form-group">
						<div id="success-msg" style="display: none">
							{{-- @component('back.components.success')
		                        Tags Attached To Product Successfully
		                      @endcomponent --}}
						</div>
						{{-- <x-product-combinations :product="$product"/> --}}
		                    <div id="accordion">
		                    	@foreach($variants as $variant)
		                    	<div class="card">
								    <div class="card-header">
								      <a class="card-link" data-toggle="collapse" href="#collapseOne_{{$variant->id}}">
								        {{getProductVariantsNames($variant->variantAttributes)}}
								      </a>
								    </div>
								    <div id="collapseOne_{{$variant->id}}" class="collapse " data-parent="#accordion">
								      <div class="card-body">
								      	<form method="post">
									        <div class="form-group">
									        	<label>Quantity</label>
									        	<input type="text" name="quantity" class="form-control" placeholder="Quantity" value="{{$variant->quantity}}">
									        </div>
									        <div class="form-group">
									        	<label>Price</label>
									        	<input type="text" name="price" class="form-control" placeholder="Price" value="{{$variant->price}}">
									        </div>
												<button type="button" class="btn btn-warning save_variation">Save</button>
										</form>
								      </div>
								    </div>
								  </div>
								@endforeach  
		                    </div>  
					</div>
				</div>
				<div class="card-footer">
					<button type="button" class="btn btn-primary generate_combinations">Save</button>
				</div>
			</form>
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