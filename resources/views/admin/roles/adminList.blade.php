@extends('layouts.app')
@section('mainContent')
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

                         <div class="row">
                            <div class="col-sm-6">
                                <div class="card-body d-flex flex-row justify-content-start">
                                    <h5>Admin List</h5>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="card-body flex-row text-right">
                                    <a href="{{route('admin.create')}}" class="btn btn-sm btn-secondary my-2" style="line-height: 1.5 !important;">Add New Admin</a>

                                </div>
                            </div>
                        </div>

        <!-- /.row -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Admin List</h3>

                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>SL</th>
                      <th>Admin Name</th>
                      <th>Image</th>
                      <th>Email</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                                @php $i = ($paginateData->currentpage() - 1) * $paginateData->perpage() + 1; @endphp
                                @if(isset($paginateData))
                                    @foreach($paginateData as $k => $v)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $v->name }}</td>
                                           
                                            <td>
                                                <img src="{{ asset('images/'.$v->image)}}" style="width:50px;height:50px;">
                                            </td>
                                             <td>{{ $v->email }}</td>

                                            <td>
                                                <a href="{{URL::to('admin/edit/'.$v->id)}}" class="btn btn-sm btn-warning my-2" title="Edit">
                                                    <i class="fas fa-edit" aria-hidden="true"></i>
                                                </a>

                                                
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <h1>No Data Found!</h1>
                                @endif

                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->

      </div>
    </section>
  </div>

        @endsection