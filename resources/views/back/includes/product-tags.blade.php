<div class="product-tags">
	<form method="post">
		<div class="card-body">
			<div class="form-group">
				<input type="text" name="product_tags" id="product_tags" class="form-control">
			</div>
			<div class="form-group">
				@foreach($tags as $tag)
					<div class="single-product-tag">
						<a href="javascript:;" class="add-tag-product" data-tag="{{$tag->id}}">{{$tag->title}}</a>
					</div>
				@endforeach
			</div>
		</div>
		<div class="card-footer">
			<button type="button" class="btn btn-primary save_tags">Save</button>
		</div>
	</form>
</div>