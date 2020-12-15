@extends('back.layouts.default')

@section('title','User List')

@section('content')

    <section class="content-header">

      <div class="container-fluid">

        <div class="row mb-2">

          <div class="col-sm-6">

            <h1>User List</h1>

          </div>

          <div class="col-sm-6">

            <ol class="breadcrumb float-sm-right">

              <li class="breadcrumb-item"><a href="#">Home</a></li>

              <li class="breadcrumb-item active">User List</li>

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

              

            </div>

            <!-- /.card-header -->

            <div class="card-body">

              <table id="example1" class="table table-bordered table-striped">

                <thead>

                <tr>

                  <th>User</th>
                  <th>Edit/Delete</th>
                  <th>Action</th>
                </tr>

                </thead>

                <tbody>

                    @foreach($users as $user)

                <tr>

                  <td>{{$user->firstName}}</td>

              
                  <td><a href="{{-- {{route('editcategory',$user->id)}} --}}"><i class="fas fa-edit fa-2x"></i></a>

                    <a href="javascript:void(0)" style="margin-left: 15px;"><i class="fas fa-trash-alt fa-2x" style="color: red;"

                    onclick="

                    if(confirm('Are you sure to Delete User')){

                    document.getElementById('{{$user->id}}').submit(); return false;

                    }

                    else{

                        event.preventDefault();

                    }

                    "></i></a>

                    <form action="{{-- {{route('deletecategory',$user->id)}} --}}" method="post" id="{{$user->id}}">

                        {{@csrf_field()}}

                        {{@method_field('DELETE')}}

                    </form></td>
                    <td>
                    	<a href="{{route('login-user-by-admin',$user->id)}}" class="btn btn-warning">Login</a>
                    </td>
                </tr>

                @endforeach

                </tbody>

                <tfoot>

                <tr>

                  <th>User</th>
                  <th>Edit/Delete</th>
                  <th>Action</th>
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
@section('script')
<script type="text/javascript">
 
</script>
@endsection
