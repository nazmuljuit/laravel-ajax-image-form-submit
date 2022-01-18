@extends('layouts.app')
@section('mainContent')
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    @if(isset($role->id) && $role->id != null)
                        <h3>Edit Role</h3>
                    @else
                        <h3>Add New Role</h3>
                    @endif
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">Permission assign to {{ $role->name }}</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form action="{{ route('assign.permission') }}" class="p-2" method="post">
                                @csrf
                                <input type="hidden" name="role_id" value="{{ $role->id }}">
                                <div class="row">
                                    <div class="form-check col-md-2 ml-3 mb-2">
                                        <input class="form-check-input top_check_permission"  type="checkbox"
                                               name="" id="top_check_permission">
                                        <label class="form-check-label" for="top_check_permission"><b>All Name</b></label>
                                    </div>
                                    {{--Parent Menu--}}
                                    @foreach($permissionList AS $k => $permission)
                                        <div class="form-check col-md-12 ml-3 mb-2">
                                            @if($permission->parent_id == 0)
                                              &nbsp;&nbsp;
                                              @php
                                                $parent_id = $permission->id;
                                              @endphp
                                            @elseif($permission->parent_id == $parent_id)
                                              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            @else
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                            @endif
                                            <input class="form-check-input check_permission" type="checkbox"
                                                   name="permission_id[]"
                                                   @if(old('permission_id',isset($permission->permission_id)?$permission->permission_id:null) == $permission->id) checked
                                                   @endif value="{{ $permission->id }}"
                                                   id="permission_id_{{ $permission->id }}">
                                            <label class="form-check-label"
                                                   for="permission_id_{{ $permission->id }}"><b>{{ $permission->name }}</b></label><br>

                                        </div>
                                    @endforeach
                                </div>
                                <div class="form-group row">
                                    <div class="col-12 mt-3 mb-2 text-right">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                        <a href="{{ route('admin.role') }}" class="btn btn-secondary">Go To Back</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('custom_js')
    <script>
        $(function () {
            $('.top_check_permission').click(function (event) {
                if (this.checked) {
                    $(':checkbox').each(function () {
                        this.checked = true;
                    });
                } else {
                    $(':checkbox').each(function () {
                        this.checked = false;
                    });
                }
            });
        });
    </script>
@endpush
