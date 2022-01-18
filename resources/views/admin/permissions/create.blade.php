@extends('layouts.app')
@section('mainContent')
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
          <div class="row">
              @if(isset($getperm->id) && $getperm->id != null)
                  <h3>Edit Permission</h3>
              @else
                  <h3>Add New Permission</h3>
              @endif
          </div>
            <div class="row">
              <div class="col-md-12">
                          <!-- general form elements -->
                      <div class="card card-secondary">
                        <div class="card-header">
                          <h3 class="card-title">Permission</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                            <form action="{{ route('permission.save') }}" class="p-2" method="post">
                                @csrf
                                <div class="form-group row">
                                    <label for="name" class="col-12 col-form-label">Permission Name <span class="text-danger">*</span></label>
                                    <div class="col-12">
                                        @if(isset($getperm->id) && $getperm->id != null)
                                            <input type="hidden" name="permissionId" value="{{ $getperm->id }}">
                                             {{ $getperm->name }}
                               <input class="form-control custom-focus @error('name') is-invalid @enderror" placeholder="Permission name" id="name" name="name" type="hidden" value="{{ $getperm->name }}" required>
                                        @else
                                            <input class="form-control custom-focus @error('name') is-invalid @enderror" placeholder="Permission name" id="name" name="name" type="text" value="{{ old('name') }}" required>
                                        @endif
                                    </div>
                                    @error('name')
                                        <span class="text-success ml-3 mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group row">
                                    <label for="name" class="col-12 col-form-label">parent <span class="text-danger">*</span></label>
                                    <div class="col-12">
                                        @if(isset($getperm->id) && $getperm->id != null)
                                            <select class="form-control select2" id="parent_id" name="parent_id" style="width: 100%;" required="required">
                                                <option value="0">Root</option>
                                                @foreach($getpermission as $perm)
                                                    @if($perm->id == $getperm->parent_id)
                                                        <option value="{{ $perm->id }}" selected>{{ $perm->name  }}</option>
                                                    @else
                                                        <option value="{{ $perm->id }}">{{ $perm->name  }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        @else
                                            <select class="form-control select2" id="parent_id" name="parent_id" style="width: 100%;" required="required">
                                                <option value="0">Root</option>
                                                @foreach($getpermission as $perm)
                                                    <option value="{{ $perm->id }}">{{ $perm->name }}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12 mt-3 mb-2 text-right">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                        <a href="{{ route('admin.permission') }}" class="btn btn-secondary">Go To Back</a>
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
