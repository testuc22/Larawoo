@extends('back.layouts.default')
@section('title','Add Product')
@section('content')


<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="text-red">Add New Product</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add New Product</li>
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
              <div class="card-header bg-warning text-white">
                <h3 class="card-title">Create Product</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="{{ route('createproduct') }}" method="POST" enctype="multipart/form-data">
                {{@csrf_field()}}
                <div class="card-body">
                  <div class="form-group">
                    @if($errors->has('product_title'))
                      @component('back.components.error')
                        {{$errors->first('product_title')}}
                      @endcomponent
                    @endif
                      <label>Title</label>
                      <input type="text" class="form-control" placeholder="Title" name="product_title" value="{{old('product_title')}}" required="true">
                    </div>
                    <div class="form-group">
                      <label>Select Category</label>
                      <select class="custom-select" name="category">
                        @foreach($categories as $category)
                        @php
                        $html='';
                        @endphp
                        @if(isset($category['childs']))
                        @php
                        foreach (array_reverse($category['childs']) as $child) {
                            $html.=$child['title']." >> ";
                        }
                        @endphp
                        @endif
                        <option value="{{$category['id']}}">{{$html.$category['title']}}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                    @if($errors->has('brand'))
                      @component('back.components.error')
                        {{$errors->first('brand')}}
                      @endcomponent
                    @endif
                      <label>Select Brand</label>
                      <select name="brand" class="custom-select">
                      @foreach($brands as $brand)
                      <option value="{{$brand->id}}">{{$brand->brandName}}</option>
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
                    @if($errors->has('sku'))
                      @component('back.components.error')
                        {{$errors->first('sku')}}
                      @endcomponent
                    @endif
                      <label>Sku</label>
                      <input type="text" class="form-control" placeholder="Sku" name="sku" value="{{old('sku')}}" required="true">
                    </div>
                    <div class="form-group">
                    @if($errors->has('discount'))
                      @component('back.components.error')
                        {{$errors->first('discount')}}
                      @endcomponent
                    @endif
                      <label>Discount</label>
                      <input type="text" class="form-control" placeholder="Discount" name="discount" value="{{old('discount')}}" required="true">
                    </div>
                    <div class="form-group">
                    @if($errors->has('price'))
                      @component('back.components.error')
                        {{$errors->first('price')}}
                      @endcomponent
                    @endif
                      <label>Price</label>
                      <input type="text" class="form-control" placeholder="price" name="price" value="{{old('price')}}" required="true">
                    </div>
                    <div class="form-group">
                    @if($errors->has('quantity'))
                      @component('back.components.error')
                        {{$errors->first('quantity')}}
                      @endcomponent
                    @endif
                      <label>Quantity</label>
                      <input type="text" class="form-control" placeholder="quantity" name="quantity" value="{{old('quantity')}}" required="true">
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
                    <div class="form-group">
                        <label>Published At:</label>
                        <div class="input-group date" id="publishedAt" data-target-input="nearest" style="width: 50%;">
                        <input type="text" class="form-control datetimepicker-input" data-target="#publishedAt" name="publishedAt"/>
                        <div class="input-group-append" data-target="#publishedAt" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                  <label>Start At/End At</label>

                  <div class="input-group" style="width: 50%;">
                    <div class="input-group-prepend" data-target="#start_end" data-toggle="datetimepicker">
                      <span class="input-group-text"><i class="far fa-clock"></i></span>
                    </div>
                    <input type="text" class="form-control float-right" id="start_end" name="start_end">
                  </div>
                  <!-- /.input group -->
                </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-warning">Save</button>
                  <a href="{{URL::previous()}}" class="btn  bg-gradient-danger">Back</a>
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
        $("#publishedAt").datetimepicker({
            format: 'L'
        });
        $("#start_end").datetimepicker();
        /*$("#start_end").daterangepicker({
              timePicker: true,
              timePickerIncrement: 30,
              locale: {
                format: 'DD/MM/YYYY hh:mm A'
              }
            })*/
    });
</script>
@endsection
