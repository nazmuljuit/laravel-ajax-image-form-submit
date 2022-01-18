@extends('layouts.app')
@section('mainContent')
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-sm-6">
                        <div class="card-body d-flex flex-row justify-content-start">
                            <h5>Permission List</h5>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card-body flex-row text-right">
                            <a href="{{route('permission.create')}}" class="btn btn-sm btn-secondary my-2"
                               style="line-height: 1.5 !important;">Add New Permission</a>

                        </div>
                    </div>
                </div>

                <!-- /.row -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Permission List</h3>
                                <div class="card-tools">
                                    <div class="input-group input-group-sm" style="width: 150px;">
                                        <input type="text" name="table_search" class="form-control float-right"
                                               placeholder="Search">
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
                                        <th scope="col">SL</th>
                                        <th scope="col">Permission Name</th>
                                        <th scope="col">Edit</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = 1; ?>
                                    @foreach($permissions as $permission)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td><b>{{ $permission->name }}</b><br>
                                                @foreach($perm as $adminperm)
                                                    @if($adminperm->parent_id == $permission->id)
                                                        <i style="color: #4f43ff;font-size: 14px">{{ $adminperm->name }}</i>
                                                        <a href="{{URL::to('childperm/edit/'.$adminperm->parent_id.'/'.$adminperm->id)}}"
                                                           class="btn btn-sm btn-warning my-2" title="Edit">
                                                            <i class="fas fa-edit" aria-hidden="true"></i>
                                                        </a><br>
                                                        @foreach($getchildperm as $getperm)
                                                            @if($getperm->parent_id == $adminperm->id)
                                                                <i style="color: #4f43ff;font-size: 12px">{{ $getperm->name }}</i>
                                                                <a href="{{URL::to('childperm/edit/'.$adminperm->parent_id.'/'.$adminperm->id)}}"
                                                                   class="btn btn-sm btn-warning my-2" title="Edit">
                                                                    <i class="fas fa-edit" aria-hidden="true"></i>
                                                                </a><br>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td><a href="{{URL::to('permission/edit/'.$permission->id)}}"
                                                   class="btn btn-sm btn-warning my-2" title="Edit">
                                                    <i class="fas fa-edit" aria-hidden="true"></i>
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
