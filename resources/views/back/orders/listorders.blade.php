@extends('back.layouts.default')
@section('title','Order List')
@section('content')
<section class="content-header">

      <div class="container-fluid">

        <div class="row mb-2">

          <div class="col-sm-6">

            <h1>Order List</h1>

          </div>

          <div class="col-sm-6">

            <ol class="breadcrumb float-sm-right">

              <li class="breadcrumb-item"><a href="#">Home</a></li>

              <li class="breadcrumb-item active">Order List</li>

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

                  <th>Order ID</th>
                  <th>User</th>
                  <th>Created At</th>
                  <th>Total</th>
                  <th>Details</th>
                </tr>

                </thead>

                <tbody>

                    @foreach($orders as $order)

                <tr>

                  <td>{{$order->id}}</td>
              
                  <td>{{$order->firstName.' '.$order->lastName}}</td>
                    <td>
                    	{{date('d-m-Y',strtotime($order->created_at))}}
                    </td>
                    <td>{{$order->total}}</td>
                    <td>
                    	<a href="" class="btn  btn-info" >Details</a>
                    </td>
                </tr>

                @endforeach

                </tbody>

                <tfoot>

                <tr>

                  <th>Order ID</th>
                  <th>User</th>
                  <th>Created At</th>
                  <th>Total</th>
                  <th>Details</th>
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