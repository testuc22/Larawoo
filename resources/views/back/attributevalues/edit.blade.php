@extends('back.layouts.default')
@section('title','Edit Attribute Values')
@section('content')
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Attribute Values</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Edit Attribute Values</li>
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
                <h3 class="card-title">Edit Attribute Values</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="{{route('updateattributevalue',$attributeValue->id)}}" method="POST" enctype="multipart/form-data">
                  {{@csrf_field()}}
                  {{@method_field('PUT')}}
                  <input type="hidden" name="attribute_id" value="{{$id}}">
                <div class="card-body">
                  <div class="form-group">
                    @if($errors->has('attribute_value'))
                      @component('back.components.error')
                        {{$errors->first('attribute_value')}}
                      @endcomponent
                    @endif
                      <label>Attribute Value</label>
                      <input type="text" class="form-control" placeholder="Attribute Value" name="attribute_value" value="{{$attributeValue->value}}" required="true">
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
