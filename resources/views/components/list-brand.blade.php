<div class="search-hotel border-bottom py-2">
	<h3 class="agileits-sear-head mb-3">Brand</h3>
	{{-- <form action="#" method="post">
		<input type="search" placeholder="Search Brand..." name="search" required="">
		<input type="submit" value=" ">
	</form> --}}
	<div class="left-side py-2">
		<ul>
			@foreach($brands as $brand)
			<li>
				<input type="checkbox" class="checked product-brand" data-brand="{{$brand->id}}">
				<span class="span">{{$brand->brandName}}</span>
			</li>
			@endforeach
		</ul>
	</div>
</div>