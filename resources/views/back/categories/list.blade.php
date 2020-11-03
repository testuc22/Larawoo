@extends('back.layouts.default')

@section('title','Category List')

@section('content')

    <section class="content-header">

      <div class="container-fluid">

        <div class="row mb-2">

          <div class="col-sm-6">

            <h1>Category List</h1>

          </div>

          <div class="col-sm-6">

            <ol class="breadcrumb float-sm-right">

              <li class="breadcrumb-item"><a href="#">Home</a></li>

              <li class="breadcrumb-item active">Category List</li>

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

              <a href="{{ route('addcategory') }}" class="btn  bg-gradient-info" >Add New Category</a>

            </div>

            <!-- /.card-header -->

            <div class="card-body">

              <table id="example1" class="table table-bordered table-striped">

                <thead>

                <tr>

                  <th>Category</th>
                  <th>Edit/Delete</th>

                </tr>

                </thead>

                <tbody>

                    @foreach($categories as $category)

                <tr>

                  <td>{{$category->title}}</td>

              
                  <td><a href="{{-- {{route('editcategory',$category->id)}} --}}"><i class="fas fa-edit fa-2x"></i></a>

                    <a href="javascript:void(0)" style="margin-left: 15px;"><i class="fas fa-trash-alt fa-2x" style="color: red;"

                    onclick="

                    if(confirm('Are you sure to Delete Category')){

                    document.getElementById('{{$category->id}}').submit(); return false;

                    }

                    else{

                        event.preventDefault();

                    }

                    "></i></a>

                    <form action="{{-- {{route('deletecategory',$category->id)}} --}}" method="post" id="{{$category->id}}">

                        {{@csrf_field()}}

                        {{@method_field('DELETE')}}

                    </form></td>

                </tr>

                @endforeach

                </tbody>

                <tfoot>

                <tr>

                  <th>Category</th>
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

