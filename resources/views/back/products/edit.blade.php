@extends('back.layouts.default')
@section('title','Edit Product')
@section('css')
<link rel="stylesheet" href="{{asset('admin/bootstrap-tagsinput.css')}}">
@endsection
@section('content')
@include('back.includes.tabs')
<div class="tab-content">
    <div class="tab-pane container active " id="updateProduct">
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Product</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Edit Product</li>
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
                <h3 class="card-title">Edit Product</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="{{route('updateproduct',$product->id)}}" method="POST" enctype="multipart/form-data">
                  {{@csrf_field()}}
                  {{@method_field('PUT')}}
                <div class="card-body">
                  <div class="form-group">
                    @if($errors->has('product_title'))
                      @component('back.components.error')
                        {{$errors->first('product_title')}}
                      @endcomponent
                    @endif
                      <label>Title</label>
                      <input type="text" class="form-control" placeholder="Title" name="product_title" value="{{$product->title}}" required="true">
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
                        <option value="{{$category['id']}}" {{$category['id']==$product->productCategory->category_id ? 'selected' : '' }}>{{$html.$category['title']}}</option>
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
                      <option value="{{$brand->id}}" {{$brand->id==$product->productBrand->brand_id ? 'selected' : ''}}>{{$brand->brandName}}</option>
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
                      <input type="text" class="form-control" placeholder="Meta Title" name="meta_title" value="{{$product->metaTitle}}" required="true">
                    </div>
                    <div class="form-group">
                    @if($errors->has('sku'))
                      @component('back.components.error')
                        {{$errors->first('sku')}}
                      @endcomponent
                    @endif
                      <label>Sku</label>
                      <input type="text" class="form-control" placeholder="Sku" name="sku" value="{{$product->sku}}" required="true">
                    </div>
                    <div class="form-group">
                    @if($errors->has('discount'))
                      @component('back.components.error')
                        {{$errors->first('discount')}}
                      @endcomponent
                    @endif
                      <label>Discount</label>
                      <input type="text" class="form-control" placeholder="Discount" name="discount" value="{{$product->discount}}" required="true">
                    </div>
                    <div class="form-group">
                    @if($errors->has('price'))
                      @component('back.components.error')
                        {{$errors->first('price')}}
                      @endcomponent
                    @endif
                      <label>Price</label>
                      <input type="text" class="form-control" placeholder="price" name="price" value="{{$product->price}}" required="true">
                    </div>
                    <div class="form-group">
                    @if($errors->has('quantity'))
                      @component('back.components.error')
                        {{$errors->first('quantity')}}
                      @endcomponent
                    @endif
                      <label>Quantity</label>
                      <input type="text" class="form-control" placeholder="quantity" name="quantity" value="{{$product->quantity}}" required="true">
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
                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" name="content" value="{{old('content')}}" required="true">{{$product->description}}</textarea>
                      </div>
                    </div>
                    <div class="form-group">
                        <label>Published At:</label>
                        <div class="input-group date" id="publishedAt" data-target-input="nearest" style="width: 50%;">
                        <input type="text" class="form-control datetimepicker-input" data-target="#publishedAt" name="publishedAt" value="{{date('d/m/Y',strtotime($product->publishedAt))}}" />
                        <div class="input-group-append" data-target="#publishedAt" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                  <label>Start At</label>

                  <div class="input-group" style="width: 50%;">
                    <div class="input-group-prepend" data-target="#start_end" data-toggle="datetimepicker">
                      <span class="input-group-text"><i class="far fa-clock"></i></span>
                    </div>
                    <input type="text" class="form-control float-right" id="start_end" name="start_end" value="{{date('d/m/Y H:i A',strtotime($product->startsAt))}}">
                  </div>
                  <!-- /.input group -->
                </div>
                </div>

                <div class="card-footer">
                  <button type="submit" class="btn btn-warning">Submit</button>
                  <a href="{{URL::previous()}}" class="btn  bg-gradient-success">Back</a>
                </div>
              </form>
            </div>
          </div>
        </div>
    </div>
</section>
</div>
<div class="tab-pane container fade" id="productimages">
@include('back.includes.product-images')
</div>
<div class="tab-pane container fade" id="producttags">
@include('back.includes.product-tags')   
</div>
<div class="tab-pane container fade" id="combinations">
@include('back.includes.product-combinations')    
</div>
</div>
@endsection
@section('script')
<script src="{{asset('admin/bootstrap-tagsinput.js')}}"></script>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $("#publishedAt").datetimepicker({
            format: 'L'
        });
        $("#start_end").datetimepicker();

    var plupload=$("#uploader").plupload({
        // General settings
        runtimes : 'html5,flash,silverlight,html4',
        url : '{{route('upload-product-images',$product->id)}}',

        // User can upload no more then 20 files in one go (sets multiple_queues to false)
        max_file_count: 20,
        
        

        // Resize images on clientside if we can
        /*resize : {
            width : 200, 
            height : 200, 
            quality : 90,
            crop: true // crop to exact dimensions
        }*/
        
        filters : {
            // Maximum file size
            max_file_size : '10mb',
            // Specify what files to browse for
            mime_types: [
                {title : "Image files", extensions : "jpg,jpeg,png"}
            ]
        },

        // Rename files by clicking on their titles
        rename: true,
        
        // Sort files
        sortable: true,

        // Enable ability to drag'n'drop files onto the widget (currently only HTML5 supports that)
        dragdrop: true,

        // Views to activate
        views: {
            list: true,
            thumbs: true, // Show thumbs
            active: 'thumbs'
        },

        // Flash settings
        flash_swf_url : '{{asset('admin/Moxie.swf')}}',

        // Silverlight settings
        silverlight_xap_url : '{{asset('admin/Moxie.xap')}}',
        multipart_params:{
            '_token':'{{csrf_token()}}',
            'model':'Product'
        },
        init:{
            FilesAdded:function(up,files){
                $('#uploader').plupload('start');
            },
            FileUploaded:function(up,file,result){
                let thumbId=file.id;
                $(`#${thumbId}`).attr('data-thumb', result.response)
                $(`#${thumbId}`).find('.plupload_action_icon').attr('data-thumb', thumbId)
                // console.log(result,file)
            }
        }
        
    });
plupload.init();

let productImages=@json($images);
let imagesHtml='';
productImages.forEach((element,index)=>{
    imagesHtml+=`<li class="plupload_done ui-state-default plupload_file" id="image_${element.id}" style="width:100px;" data-thumb="${element.id}">
    <div class="plupload_file_thumb plupload_thumb_embedded" style="width: 100px; height: 60px;" data-image="${element.imageUrl}">
        <div class="plupload_file_dummy ui-widget-content" style="line-height: 60px;">
            <span class="ui-state-disabled">png </span>
        </div>
        <canvas width="100" height="60" class="uid_1emm3lh1p7h97q1d2611shfjte_canvas"></canvas>
    </div>
        <div class="plupload_file_status">
            <div class="plupload_file_progress ui-widget-header" style="width: 100%;">
             </div>
            <span class="plupload_file_percent">100%</span>
        </div>
    <div class="plupload_file_name" title="${element.image}">
        <span class="plupload_file_name_wrapper">${element.image} </span>
    </div>
    <div class="plupload_file_action">
        <div class="plupload_action_icon ui-icon ui-icon-circle-check" data-thumb="image_${element.id}"> 
        </div>
    </div>
    <div class="plupload_file_size">4 kb</div>
    <div class="plupload_file_fields">
        <input type="hidden" name="uploader_0_name" value="${element.imageUrl}"><input type="hidden" name="uploader_0_status" value="done">
    </div>
</li>`
})
console.log(productImages)
// $("#uploader_filelist").html(imagesHtml)
$(".uid_1emm3lh1p7h97q1d2611shfjte_canvas").each(function(index, el) {
        // var c=$(this);
       var ctx = el.getContext("2d");
       var image=  new Image()
           image.src=$(this).parents(".plupload_file_thumb").data('image');
           image.onload= function(){
              ctx.drawImage(image, 0, 0);
           }
        
});
$(document).on('click', '.plupload_action_icon,.delete-product-image', function(event) {
    let _data=$(this).data('thumb')
    let _thumbId=$(this).parents(`#${_data}`).data('thumb')
    $.ajax({
        url: '{{route('delete-product-image')}}',
        type: 'GET',
        data: {image: _thumbId},
        success:function(result){
            $(`#${_data}`).remove()
        }
    });
    
});

$("#product_tags").tagsinput({
    itemValue: 'id',
    itemText:'tag'
});

$("#product_combinations").tagsinput({
    itemValue: 'id',
    itemText:'attribute'
});

$(document).on('click', '.add-tag-product', function(event) {
    let tagId=$(this).data('tag');
    let tag=$(this).text()
    $("#product_tags").tagsinput('add',{id:tagId,tag:tag})
});

$(document).on('click', '.save_tags', function(event) {
    let productTags=$("#product_tags").val();
    if (productTags.trim()!="") {
        $.ajax({
            url: '{{route('assign-product-tags',$product->id)}}',
            type: 'POST',
            data: {productTags: productTags,'_token':'{{csrf_token()}}'},
            success:function(result){
                $("#success-msg").fadeIn('400').fadeOut('slow');
            }
        });             
    }
}); 
let productTags=JSON.parse('{!!json_encode($productTags)!!}');
    console.log(productTags)
if (productTags.length) {
    productTags.forEach( function(element, index) {
        $("#product_tags").tagsinput('add',{'id':element.id,'tag':element.tag})        
    });
}
var proComb=[];
$(document).on('change', '.single_attribute', function(event) {
    let attributId=$(this).data('attributeid');
    let attributValue=$(this).data('label');
    let attributGroup=$(this).data('group');
    if ($(this).is(':checked')) {
        $("#product_combinations").tagsinput('add',{id:attributId,attribute:attributValue})
        let aIndex=-1;
        /*proComb.forEach( function(element, index) {
            element.forEach( function(element2, index2) {
                if (element2.group==attributGroup) {
                    aIndex=element2.id;
                }
            });
        });*/
        proComb.push({[attributGroup]:attributId})
        /*if (aIndex!=-1) {
            proComb[aIndex].push({[attributGroup]:attributId})
        }
        else {
            proComb[attributId]=[{[attributGroup]:attributId}]
        }*/
    }
    else {
        $("#product_combinations").tagsinput('remove',{id:attributId,attribute:attributValue})
        let index;
        proComb.forEach( function(element, index) {
            element.forEach( function(element2, index2) {
                if (element2.id==attributId) {
                    proComb[index].splice(index2, 1)
                    proComb.splice(index,1);
                }
            });
        });
        
    }
    console.log(proComb)
});

$(document).on('click', '.generate_combinations', function(event) {
    let productCombinations=$("#product_combinations").val();
    proComb=proComb.filter(Boolean);
    if (productCombinations.trim()!="") {
        $.ajax({
            url: '{{route('generate-product-combinations',$product->id)}}',
            type: 'POST',
            data: {proComb: proComb,'_token':'{{csrf_token()}}'},
            success:function(result){
                //$("#success-msg").fadeIn('400').fadeOut('slow');
                console.log(result)
            }
        });             
    }
});

$("#product_combinations").on('itemRemoved',(event)=>{
    
        proComb.forEach( function(element, index) {
            element.forEach( function(element2, index2) {
                if (element2.id==event.item.id) {
                console.log(index2)
                    proComb[index].splice(index2, 1)
                    proComb.splice(index,1);
                }
            });
        });
    let checkBox=event.item.id;
    $(`[data-attributeid="${checkBox}"]`).prop('checked', false);
});
});
</script>
@endsection
