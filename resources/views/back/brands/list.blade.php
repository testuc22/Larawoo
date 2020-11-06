@extends('back.layouts.default')

@section('title','Brand List')

@section('content')

    <section class="content-header">

      <div class="container-fluid">

        <div class="row mb-2">

          <div class="col-sm-6">

            <h1>Brand List</h1>

          </div>

          <div class="col-sm-6">

            <ol class="breadcrumb float-sm-right">

              <li class="breadcrumb-item"><a href="#">Home</a></li>

              <li class="breadcrumb-item active">Brand List</li>

            </ol>

          </div>

        </div>

      </div><!-- /.container-fluid -->

    </section>

<section class="content">

      <div class="row">

        <div class="col-12">

            <div class="card">

            <div class="card-header">

              {{-- <h3 class="card-title">All Categories</h3> --}}

              <a href="{{ route('addbrand') }}" class="btn  bg-gradient-info" >Add New Brand</a>

            </div>

            <!-- /.card-header -->

            <div class="card-body">

              <table id="example1" class="table table-bordered table-striped">

                <thead>

                <tr>

                  <th>Brand</th>
                  <th>Edit/Delete</th>
                </tr>

                </thead>

                <tbody>

                    @foreach($brands as $brand)

                <tr>

                  <td>{{$brand->brandName}}</td>

              
                  <td><a href="{{route('editbrand',$brand->id)}}"><i class="fas fa-edit fa-2x"></i></a>

                    <a href="javascript:void(0)" style="margin-left: 15px;"><i class="fas fa-trash-alt fa-2x" style="color: red;"

                    onclick="

                    if(confirm('Are you sure to Delete Attribute')){

                    document.getElementById('{{$brand->id}}').submit(); return false;

                    }

                    else{

                        event.preventDefault();

                    }

                    "></i></a>

                    <form action="{{route('deletebrand',$brand->id)}}" method="post" id="{{$brand->id}}">

                        {{@csrf_field()}}

                        {{@method_field('DELETE')}}

                    </form></td>
                </tr>

                @endforeach

                </tbody>

                <tfoot>

                <tr>

                  <th>Brand</th>
                  <th>Edit/Delete</th>
                </tr>

                </tfoot>

              </table>

            </div>

            <!-- /.card-body -->

          </div>

        </div>

    </div>

</section>

@endsection

