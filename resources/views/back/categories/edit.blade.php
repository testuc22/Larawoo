@extends('back.layouts.default')
@section('title','Edit Category')
@section('content')
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Category</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Edit Category</li>
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
              <div class="card-header">
                <h3 class="card-title">Edit Category</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="{{route('updatecategory',$category->id)}}" method="POST" enctype="multipart/form-data">
                  {{@csrf_field()}}
                  {{@method_field('PUT')}}
                <div class="card-body">
                  <div class="form-group">
                    @if($errors->has('category_name'))
                      @component('back.components.error')
                        {{$errors->first('category_name')}}
                      @endcomponent
                    @endif
                      <label>Name</label>
                      <input type="text" class="form-control" placeholder="Category Name" name="category_name" value="{{$category->category_name}}" required="true">
                    </div>
                    <div class="form-group">
                     @if($errors->has('logo'))
                      @component('back.components.error')
                        {{$errors->first('logo')}}
                      @endcomponent
                        @endif
                    <label for="exampleInputFile">Bank Logo</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="exampleInputFile" name="logo">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text" id="">Upload</span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                      @if($errors->has('description'))
                      @component('back.components.error')
                        {{$errors->first('description')}}
                      @endcomponent
                        @endif
                      <label>Description</label>
                      <div class="mb-3">
                      <textarea class="textarea" placeholder="Description"
                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" name="description" value="" required="true">{{$category->description}}</textarea>
                      </div>
                    </div>
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="is_valid" {{$category->status==1 ? 'checked' :''}}>
                    <label class="form-check-label" for="exampleCheck1">Valid</label>
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
