@extends('front.layouts.default')
@section('title','My Addresses')
@section('content')
<div class="my-address-page">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="card mt-5">
				  	<div class="card-header">
				  		 <div class="btn-group">
						  <a href="" class="btn btn-warning"  data-toggle="modal" data-target="#myModal">Add New Address</a>
						</div> 
				  	</div>
				  	<div class="card-body">
				  		<div id="accordion">

						  <div class="card">
						    <div class="card-header">
						      <a class="card-link" data-toggle="collapse" href="#collapseOne">
						        Collapsible Group Item #1
						      </a>
						    </div>
						    <div id="collapseOne" class="collapse show" data-parent="#accordion">
						      <div class="card-body">
						        Lorem ipsum..
						      </div>
						    </div>
						  </div>
						</div>
				  	</div>
				  	<div class="card-footer">Footer</div>
				</div>
			</div>
		</div>
	</div>
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add New Address</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
      	<form id="address-form">
        <div class="form-group">
        	<label>Line1</label>
      		<input type="text" class="form-control" placeholder="Line1" name="line1" value="" required="true" id="line1">
        </div>
        <div class="form-group">
        	<label>Line2</label>
      		<input type="text" class="form-control" placeholder="Line2" name="line2" value="" required="true" id="line2">
        </div>
        <div class="form-group">
        	<label>City</label>
      		<input type="text" class="form-control" placeholder="City" name="city" value="" required="true" id="city">
        </div>
        <div class="form-group">
        	<label>State</label>
      		<input type="text" class="form-control" placeholder="State" name="state" value="" required="true" id="state">
        </div>
        <div class="form-group">
        	<label>Country</label>
      		<input type="text" class="form-control" placeholder="Country" name="country" value="" required="true" id="country">
        </div>
        <div class="form-group">
        	<label>Pincode</label>
      		<input type="text" class="form-control" placeholder="Pincode" name="pincode" value="" required="true" id="pincode">
        </div>
        <div class="form-group">
        	<label>Phone</label>
      		<input type="text" class="form-control" placeholder="Phone" name="phone" value="" required="true" id="phone">
        </div>
    </form>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-success save-address">Save</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>	
</div>
@endsection
@section('scripts')
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(document).on('click', '.save-address', function(event) {
			let form={
				line1:$("#line1").val(),
				line2:$("#line2").val(),
				city:$("#city").val(),
				state:$("#state").val(),
				country:$("#country").val(),
				pincode:$("#pincode").val(),
				phone:$("#phone").val()
			}
			$.ajax({
				url: '{{route('save-address')}}',
				type: 'POST',
				data: {form:$("#address-form").serialize(),'_token':'{{csrf_token()}}'},
				success:function(result){

				}
			})
			
		});
	});
</script>
@endsection