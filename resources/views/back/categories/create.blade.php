@extends('back.layouts.default')
@section('title','Add Category')
@section('content')
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add New Category</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add New Category</li>
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
                <h3 class="card-title">Create Category</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="{{ route('createcategory') }}" method="POST" enctype="multipart/form-data">
                {{@csrf_field()}}
                <div class="card-body">
                  <div class="form-group">
                    @if($errors->has('title'))
                      @component('back.components.error')
                        {{$errors->first('title')}}
                      @endcomponent
                    @endif
                      <label>Category Name</label>
                      <input type="text" class="form-control" placeholder="Category Name" name="title" value="{{old('title')}}" required="true">
                    </div>
                    <div class="form-group">
                      <label>Parent Category</label>
                      <select class="form-control" name="parent_category">
                        <option value="0" selected>Select Parent Category</option>
                        @foreach($categories as $category)
                          <option value="{{$category->id}}">{{$category->title}}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                    @if($errors->has('meta_title'))
                      @component('back.components.error')
                        {{$errors->first('meta_title')}}
                      @endcomponent
                    @endif
                      <label>Meta Title</label>
                      <input type="text" class="form-control" placeholder="Meta Title" name="meta_title" value="{{old('meta_title')}}" required="true">
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
                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" name="description" value="{{old('description')}}" required="true"></textarea>
                      </div>
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
