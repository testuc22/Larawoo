@extends('back.layouts.default')

@section('title','Tag List')

@section('content')

    <section class="content-header">

      <div class="container-fluid">

        <div class="row mb-2">

          <div class="col-sm-6">

            <h1>Tag List</h1>

          </div>

          <div class="col-sm-6">

            <ol class="breadcrumb float-sm-right">

              <li class="breadcrumb-item"><a href="#">Home</a></li>

              <li class="breadcrumb-item active">Tag List</li>

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

              <a href="{{ route('addtag') }}" class="btn  bg-gradient-info" >Add New Tag</a>

            </div>

            <!-- /.card-header -->

            <div class="card-body">

              <table id="example1" class="table table-bordered table-striped">

                <thead>

                <tr>

                  <th>Tag</th>
                  <th>Edit/Delete</th>
                </tr>

                </thead>

                <tbody>

                    @foreach($tags as $tag)

                <tr>

                  <td>{{$tag->title}}</td>

              
                  <td><a href="{{route('edittag',$tag->id)}}"><i class="fas fa-edit fa-2x"></i></a>

                    <a href="javascript:void(0)" style="margin-left: 15px;"><i class="fas fa-trash-alt fa-2x" style="color: red;"

                    onclick="

                    if(confirm('Are you sure to Delete Tag')){

                    document.getElementById('{{$tag->id}}').submit(); return false;

                    }

                    else{

                        event.preventDefault();

                    }

                    "></i></a>

                    <form action="{{route('deletetag',$tag->id)}}" method="post" id="{{$tag->id}}">

                        {{@csrf_field()}}

                        {{@method_field('DELETE')}}

                    </form></td>
                </tr>

                @endforeach

                </tbody>

                <tfoot>

                <tr>

                  <th>Tag</th>
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

