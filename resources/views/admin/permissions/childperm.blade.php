@extends('layouts.app')
@section('mainContent')
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <h3>Edit Child Permission</h3>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <!-- general form elements -->
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">Edit Child Permission</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form action="{{ route('childpermission.save') }}" class="p-2" method="post">
                                @csrf
                                <div class="form-group row">
                                    <label for="name" class="col-12 col-form-label">Permission Name *</label>
                                    <div class="col-12">
                                        @if(isset($getchild->id) && $getchild->id != null)
                                            <input type="hidden" name="permissionId" value="{{ $getchild->id }}">
                                            {{ $getchild->name }}
                                            <input class="form-control custom-focus @error('name') is-invalid @enderror" placeholder="Permission name" id="name" name="name" type="hidden" value="{{ $getchild->name }}">

{{--                                            <input class="form-control custom-focus @error('name') is-invalid @enderror" placeholder="Permission name" id="editname" name="editname" type="hidden" value="{{ old('name') }}">--}}
                                       @endif
                                    </div>
                                    @error('name')
                                    <span class="text-success ml-3 mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group row">
                                    <label for="name" class="col-12 col-form-label">Parent</label>
                                    <div class="col-12">
                                        @if(isset($getchild->id) && $getchild->id != null)
                                            <select class="form-control select2" id="child_id" name="child_id" style="width: 100%;" required="required">
                                                <option value="0">Root</option>
                                                @foreach($getpermission as $perm)
                                                    @if($perm->id == $getperm->id)
                                                        <option value="{{ $perm->id }}" selected>{{ $perm->name  }}</option>
                                                    @else
                                                        <option value="{{ $perm->id }}">{{ $perm->name  }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <input type="hidden" name="oldchild_id" value="{{$getperm->id}}">
                                          {{--  <select class="form-control select2" id="oldchild_id" name="oldchild_id" style="width: 100%;" required="required" type="hidden">
                                                @foreach($getpermission as $perm)
                                                    @if($perm->id == $getchild->id)
                                                        <option value="{{ $perm->id }}" selected>{{ $perm->name  }}</option>
                                                    @endif
                                                @endforeach
                                            </select>--}}
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
