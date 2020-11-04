@extends('back.layouts.default')

@section('title','Attribute Values List')

@section('content')

    <section class="content-header">

      <div class="container-fluid">

        <div class="row mb-2">

          <div class="col-sm-6">

            <h1>Attribute Values List</h1>

          </div>

          <div class="col-sm-6">

            <ol class="breadcrumb float-sm-right">

              <li class="breadcrumb-item"><a href="#">Home</a></li>

              <li class="breadcrumb-item active">Attribute Values List</li>

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

              <a href="{{ route('addattributevalue',$id) }}" class="btn  bg-gradient-info" >Add New Attribute Value</a>

            </div>

            <!-- /.card-header -->

            <div class="card-body">

              <table id="example1" class="table table-bordered table-striped">

                <thead>

                <tr>

                  <th>Attribute Value</th>
                  <th>Edit/Delete</th>
                </tr>

                </thead>

                <tbody>

                    @foreach($attributeValues as $attributeValue)

                <tr>

                  <td>{{$attributeValue->value}}</td>

              
                  <td><a href="{{route('editattribute',$attributeValue->id)}}"><i class="fas fa-edit fa-2x"></i></a>

                    <a href="javascript:void(0)" style="margin-left: 15px;"><i class="fas fa-trash-alt fa-2x" style="color: red;"

                    onclick="

                    if(confirm('Are you sure to Delete Attribute')){

                    document.getElementById('{{$attributeValue->id}}').submit(); return false;

                    }

                    else{

                        event.preventDefault();

                    }

                    "></i></a>

                    <form action="{{route('deleteattribute',$attributeValue->id)}}" method="post" id="{{$attributeValue->id}}">

                        {{@csrf_field()}}

                        {{@method_field('DELETE')}}

                    </form></td>
                </tr>

                @endforeach

                </tbody>

                <tfoot>

                <tr>

                  <th>Attribute</th>
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

