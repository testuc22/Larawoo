@extends('back.layouts.default')
@section('title','Edit Brand')
@section('content')
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Brand</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Edit Brand</li>
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
                <h3 class="card-title">Edit Brand</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="{{route('updatebrand',$brand->id)}}" method="POST" enctype="multipart/form-data">
                  {{@csrf_field()}}
                  {{@method_field('PUT')}}
                <div class="card-body">
                  <div class="form-group">
                    @if($errors->has('brand_name'))
                      @component('back.components.error')
                        {{$errors->first('brand_name')}}
                      @endcomponent
                    @endif
                      <label>Brand Name</label>
                      <input type="text" class="form-control" placeholder="Brand Name" name="brand_name" value="{{$brand->brandName}}" required="true">
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <a href="{{URL::previous()}}" class="btn  bg-gradient-success">Back</a>
                </div>
              </form>
            </div>
          </div>
        </div>
    </div>
</section>
@endsection
