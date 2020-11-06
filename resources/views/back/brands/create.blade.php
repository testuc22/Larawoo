@extends('back.layouts.default')
@section('title','Add Brand')
@section('content')
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add New Brand</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add New Brand</li>
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
                <h3 class="card-title">Create Brand</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="{{ route('createbrand') }}" method="POST" enctype="multipart/form-data">
                {{@csrf_field()}}
                <div class="card-body">
                  <div class="form-group">
                    @if($errors->has('brand_name'))
                      @component('back.components.error')
                        {{$errors->first('brand_name')}}
                      @endcomponent
                    @endif
                      <label>Brand Name</label>
                      <input type="text" class="form-control" placeholder="Brand Name" name="brand_name" value="{{old('brand_name')}}" required="true">
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
