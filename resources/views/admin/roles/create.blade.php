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
                          <h3 class="card-title">Role</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                            <form action="{{ route('role.save') }}" class="p-2" method="post">
                                @csrf
                                <div class="form-group row">
                                    <label for="name" class="col-12 col-form-label">Role Name <span class="text-danger">*</span></label>
                                    <div class="col-12">
                                        @if(isset($role->id) && $role->id != null)
                                            <input type="hidden" name="roleId" value="{{$role->id}}">
                                            <input class="form-control custom-focus @error('name') is-invalid @enderror" placeholder="Role name" id="name" name="name" type="text" value="{{ $role->name }}" required>
                                        @else
                                            <input class="form-control custom-focus @error('name') is-invalid @enderror" placeholder="Role name" id="name" name="name" type="text" value="{{ old('name') }}" required>
                                        @endif
                                    </div>
                                    @error('name')
                                        <span class="text-success ml-3 mt-1">{{ $message }}</span>
                                    @enderror
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
