@extends('back.layouts.default')

@section('title','Attributes List')

@section('content')

    <section class="content-header">

      <div class="container-fluid">

        <div class="row mb-2">

          <div class="col-sm-6">

            <h1>Attributes List</h1>

          </div>

          <div class="col-sm-6">

            <ol class="breadcrumb float-sm-right">

              <li class="breadcrumb-item"><a href="#">Home</a></li>

              <li class="breadcrumb-item active">Attributes List</li>

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

              <a href="{{ route('addattribute') }}" class="btn  bg-gradient-info" >Add New Attribute</a>

            </div>

            <!-- /.card-header -->

            <div class="card-body">

              <table id="example1" class="table table-bordered table-striped">

                <thead>

                <tr>

                  <th>Attribute</th>
                  <th>Edit/Delete</th>
                  <th>View</th>
                </tr>

                </thead>

                <tbody>

                    @foreach($attributes as $attribute)

                <tr>

                  <td>{{$attribute->name}}</td>

              
                  <td><a href="{{route('editattribute',$attribute->id)}}"><i class="fas fa-edit fa-2x"></i></a>

                    <a href="javascript:void(0)" style="margin-left: 15px;"><i class="fas fa-trash-alt fa-2x" style="color: red;"

                    onclick="

                    if(confirm('Are you sure to Delete Attribute')){

                    document.getElementById('{{$attribute->id}}').submit(); return false;

                    }

                    else{

                        event.preventDefault();

                    }

                    "></i></a>

                    <form action="{{route('deleteattribute',$attribute->id)}}" method="post" id="{{$attribute->id}}">

                        {{@csrf_field()}}

                        {{@method_field('DELETE')}}

                    </form></td>
                    <td><a href="{{route('showattributevalues',$attribute->id)}}" style="margin-left: 15px;"><i class="fas fa-eye fa-2x" style="color: green;"></i></a></td>
                </tr>

                @endforeach

                </tbody>

                <tfoot>

                <tr>

                  <th>Attribute</th>
                  <th>Edit/Delete</th>
                  <th>View</th>
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

