@extends('back.layouts.default')
@section('title','Add Tag')
@section('content')
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add New Tag</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add New Tag</li>
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
                <h3 class="card-title">Create Tag</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="{{ route('createtag') }}" method="POST" enctype="multipart/form-data">
                {{@csrf_field()}}
                <div class="card-body">
                  <div class="form-group">
                    @if($errors->has('tag_title'))
                      @component('back.components.error')
                        {{$errors->first('tag_title')}}
                      @endcomponent
                    @endif
                      <label>Title</label>
                      <input type="text" class="form-control" placeholder="Title" name="tag_title" value="{{old('tag_title')}}" required="true">
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
                      @if($errors->has('content'))
                      @component('back.components.error')
                        {{$errors->first('content')}}
                      @endcomponent
                        @endif
                      <label>Content</label>
                      <div class="mb-3">
                      <textarea class="textarea" placeholder="Content"
                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" name="content" value="{{old('content')}}" required="true"></textarea>
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
