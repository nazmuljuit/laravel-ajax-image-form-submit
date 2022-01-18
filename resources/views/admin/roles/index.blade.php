@extends('layouts.app')
@section('title','Roles List')
@section('mainContent')
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

                         <div class="row">
                            <div class="col-sm-6">
                                <div class="card-body d-flex flex-row justify-content-start">
                                    <h5>Role List</h5>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="card-body flex-row text-right">
                                    <a href="{{route('role.create')}}" class="btn btn-sm btn-secondary my-2" style="line-height: 1.5 !important;">Add New User</a>

                                </div>
                            </div>
                        </div>

        <!-- /.row -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Role List</h3>

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
                      <th>Role Name</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                                @php $i = ($roles->currentpage() - 1) * $roles->perpage() + 1; @endphp
                                @foreach($roles as $role)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            <a href="{{ URL::to('role/edit/'.$role->id) }}" class="btn btn-sm btn-warning">
                                                Role Edit
                                            </a>
                                            <a href="{{ URL::to('permission/assign/'.$role->id) }}"
                                               class="btn btn-sm btn-secondary">
                                                Permission Assign
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach

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