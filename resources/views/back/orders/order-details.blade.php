@extends('back.layouts.default')
@section('title','Order Details')
@section('content')
<section class="content-header">

      <div class="container-fluid">

        <div class="row mb-2">

          <div class="col-sm-6">

            <h1>Order Details</h1>

          </div>

          <div class="col-sm-6">

            <ol class="breadcrumb float-sm-right">

              <li class="breadcrumb-item"><a href="#">Home</a></li>

              <li class="breadcrumb-item active">Order Details</li>

            </ol>

          </div>

        </div>

      </div><!-- /.container-fluid -->

    </section>
<section class="content">

      <div class="row">

        <div class="col-12">

            <div class="card">

            <div class="card-header">

              {{-- <h3 class="card-title">All Categories</h3> --}}
              <div>
              	<div class="order-status-text">
              	<h1 class="badge badge-pill {{$orderStatus[$order->status]['color']}}">{{$orderStatus[$order->status]['text']}}</h1>
              	</div>
              	<div class="form-group">
		              <select class="custom-select order-status">
		              	@foreach($orderStatus as $key=>$status)
		              	<option value="{{$key}}" {{$key==$order->status ? 'selected' :''}}>{{$status['text']}}</option>
		              	@endforeach
		              </select>
              	</div>
              </div>

            </div>

            <!-- /.card-header -->

            <div class="card-body">

              <table id="order-details" class="table table-bordered table-striped">

                <tr>

                  <th>Order ID</th>
                  <td>{{$order->id}}</td>
              	</tr>
              	<tr>
                  <th>User</th>
                  <td>{{$order->firstName.' '.$order->lastName}}</td>
              </tr>
              	<tr>
                  <th>Created At</th>
                  <td>{{date('d-m-Y',strtotime($order->created_at))}}</td>
              </tr>
              <tr>
                  <th>Total</th>
                  <td>{{$order->total}}</td>
              </tr>
              <tr>
                  <th>Email</th>
                  <td>{{$order->email}}</td>
                </tr>
                <tr>
                	<th>Address</th>
                	<td>{{$order->line1.' '.$order->line2}}</td>
                </tr>
                <tr>
                	<th>City/State/Country</th>
                	<td>{{$order->city.'/'.$order->state.'/'.$order->country}}</td>
                </tr>
              </table>
              <h3 class="card-title mt-3 mb-1">Order Items</h3>
            <table class="table table-bordered table-striped">
            	<tr>
	            	<th>Product</th>
	            	<th>Price</th>
	            	<th>Discount</th>
	            	<th>Quantity</th>
            	</tr>
            	@foreach($order->orderItems as $orderItem)
            	<tr>
            		@if($orderItem->productVariantOrderItem()->exists())
            		<td>{{$orderItem->productOrderItem->title.' '.getProductVariantsNames($orderItem->productVariantOrderItem->variantAttributes)}}
            		</td>
            		@else
            		<td>
            			{{$orderItem->productOrderItem->title}}
            		</td>
            		@endif
            		<td>{{$orderItem->price}}</td>
            		<td>{{$orderItem->discount}}%</td>
            		<td>{{$orderItem->quantity}}</td>
            	</tr>
            	@endforeach
            </table>  
            </div>

            <!-- /.card-body -->

          </div>

        </div>

    </div>

</section>    

@endsection
@section('script')
<script>
	jQuery(document).ready(function($) {
		let orderStatus=@json($orderStatus);
		$(document).on('change', '.order-status', function(event) {
			let status=$(this).children('option:selected').val();
			$.ajax({
				url: '{{route('change-order-status',$order->id)}}',
				type: 'PUT',
				data: {status: status,'_token':'{{csrf_token()}}'},
				success:function (result) {
					$(".order-status-text").html(`<h1 class="badge badge-pill ${orderStatus[result.status]['color']}">${orderStatus[result.status]['text']}</h1>`)
				}
			})
			
		});
	});
</script>
@endsection