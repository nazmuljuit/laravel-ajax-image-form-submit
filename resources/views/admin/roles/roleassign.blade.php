@extends('layouts.app')
@section('mainContent')
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
          <div class="row">
            <h3>Role Assign</h3>
          </div>
            <div class="row">
              <div class="col-md-12">
                          <!-- general form elements -->
                      <div class="card card-secondary">
                        <div class="card-header">
                          <h3 class="card-title">Role Assign to {{ $admin->name }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                            <form action="{{ URL::to('assign/role') }}" class="p-2" method="post">
                                @csrf
                                <input type="hidden" name="adminId" value="{{ $admin->id }}">
                                <div class="row">
                                    @if(isset($roles))
                                        @foreach($roles AS $list)
                                            @if(isset($list->model_id) && !empty($list->model_id))
                                                <div class="form-check col-md-2 ml-3 mb-2">
                                                    <input class="form-check-input" type="radio" name="roleId" checked value="{{ $list->id }}" id="roleId_{{ $list->id }}" required>
                                                    <label class="form-check-label" for="roleId_{{ $list->id }}">{{ $list->name }}</label>
                                                </div>
                                            @else
                                                <div class="form-check col-md-2 ml-3 mb-2">
                                                    <input class="form-check-input" type="radio" name="roleId" value="{{ $list->id }}" id="roleId_{{ $list->id }}" required>
                                                    <label class="form-check-label" for="roleId_{{ $list->id }}">{{ $list->name }}</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>

                                <div class="form-group row">
                                    <div class="col-12 mt-3 mb-2 text-right">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                        <a href="{{ route('admin.list') }}" class="btn btn-secondary">Go To Back</a>
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
