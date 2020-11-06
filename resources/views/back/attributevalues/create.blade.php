@extends('back.layouts.default')
@section('title','Add Attribute Value')
@section('content')
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add New Attribute Value</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add New Attribute Value</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-primary">
              <div class="card-header bg-info text-white">
                <h3 class="card-title">Create Attribute Value</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="{{ route('createattributevalue') }}" method="POST" enctype="multipart/form-data">
                {{@csrf_field()}}
                <input type="hidden" name="attribute_id" value="{{$id}}">
                <div class="card-body">
                  <div class="form-group attribute_value_wrapper">
                    @if($errors->has('attribute_value'))
                      @component('back.components.error')
                        {{$errors->first('attribute_value')}}
                      @endcomponent
                    @endif
                    <div class="attribute_value">
                      <label>Attribute Value</label>
                      <input type="text" class="form-control attribute-box" placeholder="Attribute Value" name="attribute_value[]" value="{{old('attribute_value')}}" required="true" style="width: 50%;">
                      <a href="javascript:;" class="remove-attr-val"><i class="fas fa-minus-circle fa-2x"></i></a>
                    </div>
                    </div>
                    <div class="add-more-attr">
                    <a href="javascript:;" class="add-more-attr-btn"><i class="fas fa-plus-circle fa-2x" style="color: #17a2b8;"></i></a>
                      
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-success">Save</button>
                  <a href="{{URL::previous()}}" class="btn  bg-gradient-info">Back</a>
                </div>
              </form>
            </div>
          </div>
        </div>
    </div>
</section>
@endsection
@section('script')
<script type="text/javascript">
    jQuery(document).ready(function($) {
        var clonedAttribute=`<div class="attribute_value">
                      <label>Attribute Value</label>
                      <input type="text" class="form-control attribute-box" placeholder="Attribute Value" name="attribute_value[]" value="{{old('attribute_value')}}" required="true" style="width: 50%;">
                      <a href="javascript:;" class="remove-attr-val"><i class="fas fa-minus-circle fa-2x"></i></a>
                    </div>`
        $(document).on('click', '.add-more-attr-btn', function(event) {
            $(".attribute_value_wrapper").append(clonedAttribute)
        });

        $(document).on('click', '.remove-attr-val', function(event) {
            $(this).parents('.attribute_value').remove()
        });
    });
</script>
@endsection
