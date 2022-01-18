@extends('layouts.app')
@section('mainContent')
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
          <div class="row">
              @if(isset($admin->id) && $admin->id != null)
                  <h3>Edit User</h3>
              @else
                  <h3>Add New User</h3>
              @endif
          </div>
            <div class="row">
              <div class="col-md-8">
                          <!-- general form elements -->
                      <div class="card card-secondary">
                        <div class="card-header">
                          <h3 class="card-title">User Information</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('admin.save') }}" method="post" enctype="multipart/form-data">

                          @csrf
                          <div class="card-body">


                              <div class="form-group row">
                                    <label for="name" class="col-12 col-form-label">Admin Name <span class="m-l-5"> *</span></label>
                                    <div class="col-12">
                                        @if(isset($admin->id) && $admin->id != null)
                                            <input type="hidden" name="adminId" value="{{$admin->id}}">
                                            <input class="form-control custom-focus @error('name') is-invalid @enderror" placeholder="Admin name" id="name" name="name" type="text" value="{{ $admin->name }}">
                                        @else
                                            <input class="form-control custom-focus @error('name') is-invalid @enderror" placeholder="Admin name" id="name" name="name" type="text" value="{{ old('name') }}">
                                        @endif
                                    </div>
                                    @error('name')
                                        <span class="text-success ml-3 mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="control-label" for="name">Admin Email <span class="m-l-5"> *</span></label>
                                    @if(isset($admin->id) && $admin->id != null)
                                        <input class="form-control custom-focus @error('email') is-invalid @enderror" placeholder="Admin email" id="email" name="email" type="text" value="{{ $admin->email }}" required="required">
                                    @else
                                        <input class="form-control custom-focus @error('email') is-invalid @enderror" placeholder="Email" id="email" name="email" type="text" value="{{ old('email') }}" required="required">
                                    @endif
                                    @error('email')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="control-label" for="name">Admin Image <span class="m-l-5"> </span></label>
                                    @if(isset($admin->id) && $admin->id != null)
                                        <input class="form-control custom-focus " placeholder="Admin image" id="image" name="image" type="file"  >
                                    @else
                                        <input class="form-control custom-focus" placeholder="Image" id="image" name="image" type="file"  >
                                    @endif
                                    @error('image')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    @if(isset($admin->id) && $admin->id != null)
                                    <label class="control-label" for="name">Admin Password <span class="m-l-5"> </span></label>
                                    @else
                                    <label class="control-label" for="name">Admin Password <span class="m-l-5"> *</span></label>
                                    @endif
                                    @if(isset($admin->id) && $admin->id != null)
                                        <input class="form-control custom-focus @error('password') is-invalid @enderror" placeholder="Admin password" id="password" name="password" type="text" >
                                    @else
                                        <input class="form-control custom-focus @error('password') is-invalid @enderror" placeholder="password" id="password" name="password" type="text" required="required">
                                    @endif
                                    @error('password')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>


                          </div>
                          <!-- /.card-body -->

                          <div class="card-footer">
                            <button type="submit" class="btn btn-secondary">Submit</button>
                          </div>
                        </form>
                      </div>
            </div>
          </div>

      </div>
    </section>
  </div>

        @endsection
