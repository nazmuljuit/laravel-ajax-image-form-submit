@extends('layouts.registerApp')
@section('mainContent')
  
        <section class="content">
            <div class="container-fluid">
                <div class="row justify-content-md-center">
                    <h3>Add Register</h3>
                </div>
                <div class="row justify-content-md-center">
                    <div class="col-md-10">
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">Add Register</h3>
                                <div class="alert alert-success" role="alert" id="successMsg" style="display: none" >
                              Thank you for registration! 
                            </div>
                            </div>
                            <form id="SubmitForm" class="p-2"  enctype="multipart/form-data">
                                @csrf

                                <div class="form-group row">
                                    <div class="col-6">
                                    <label for="name" class="col-12 col-form-label">Applicant Name *</label>
                                    <div class="col-12">
                                       
                                            <input class="form-control custom-focus @error('applicant_name') is-invalid @enderror" placeholder="Applicant Name" id="applicant_name" name="applicant_name" type="text" value="{{ old('applicant_name') }}" required="required">
                                        
                                    </div>
                                    @error('applicant_name')
                                    <span class="text-success ml-3 mt-1" id="nameErrorMsg"></span>
                                   
                                    @enderror
                                    </div>
                                    <div class="col-6">
                                        <label for="email" class="col-12 col-form-label"> Email*</label>
                                        <div class="col-12">
                                            
                                                <input class="form-control custom-focus @error('email') is-invalid @enderror" placeholder="Email" id="email" name="email" type="email" value="{{ old('email') }}" required="required">
                                            
                                        </div>
                                        @error('email')
                                        <span class="text-success ml-3 mt-1" id="emailErrorMsg">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>






                                <div class="form-group row">
                                    <div class="col-12">
                                    <label for="mailing_address" class="col-12 col-form-label">Mailing Address</label>
                                    <div class="col-12">
                                        
                                            <textarea class="form-control custom-focus @error('mailing_address') is-invalid @enderror" placeholder="Present Address" id="mailing_address" name="mailing_address" type="text"  >{{ old('mailing_address') }}</textarea>
                                        
                                    </div>
                                    @error('mailing_address')
                                    <span class="text-success ml-3 mt-1">{{ $message }}</span>
                                    @enderror
                                    </div>


                                </div>
                                <!-- end -->
                                <!-- start -->
                                Address<hr>

                                <div class="form-group row">

                                    
                                    <div class="col-md-4">
                                        <select class="form-control select2" id="divisionPresent" name="division_id" style="width: 100%;" >
                                            <option value="">Select Division</option>
                                            @foreach($divisions as $division)
                                                <option value="{{$division->id}}">{{$division->division_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select class="form-control select2" id="districtPresent" name="district_id" style="width: 100%;" >
                                            <option value="">Select District</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select class="form-control select2" id="thanaPresent" name="ps_id" style="width: 100%;" >
                                            <option value="">Select Thana</option>
                                        </select>
                                    </div>

                                    @error('pressent_address')
                                    <span class="text-success ml-3 mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- end -->
                                 <div class="form-group row">
                                    <div class="col-12">
                                    <label for="address_details" class="col-12 col-form-label">Address Details</label>
                                    <div class="col-12">
                                       
                                            <textarea class="form-control custom-focus @error('address_details') is-invalid @enderror" placeholder="Address Details" id="address_details" name="address_details" type="text"  >{{ old('address_details') }}</textarea>
                                        
                                    </div>
                                    @error('address_details')
                                    <span class="text-success ml-3 mt-1">{{ $message }}</span>
                                    @enderror
                                    </div>


                                </div>
                                <!-- end -->

                                <!-- start language preferance -->
                                Check  language<hr>
                                 <div class="form-group row">
                                    <div class="col-4">
                                       
                                    <div class="form-check">
                                       
                                            <input class="form-check-input" type="checkbox" id="flexCheckChecked" value="1" name="language[]">
                                            <label class="form-check-label" for="flexCheckChecked"></label>
                                       
                                        Bangla
                                    </div>
                                    </div>
                                    <div class="col-4">
                                    
                                    <div class="form-check">
                                        
                                            <input class="form-check-input" type="checkbox" id="flexCheckChecked" value="2" name="language[]">
                                            <label class="form-check-label" for="flexCheckChecked"></label>
                                        
                                        English
                                    </div>
                                    </div>
                                    <div class="col-4">
                                    
                                    <div class="form-check">
                                        
                                            <input class="form-check-input" type="checkbox" id="flexCheckChecked" value="3" name="language[]">
                                            <label class="form-check-label" for="flexCheckChecked"></label>
                                        
                                        French
                                    </div>
                                    </div>

                                </div>
                                <!-- end language preferance -->
                                <!-- select education -->
                                Education 
                                <hr>
                                <div class="form-group row">
                                    <table class="table" id="itemTable">
                                        <thead>
                                            <tr>
                                            <th>Exam Name</th>
                                            <th>University</th>
                                            <th>Board</th>
                                            <th>Result</th>
                                            <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <select class="form-control" name="exam_id[]">
                                                    <option>Select Exam</option>
                                                    @foreach($exam_name as $val)
                                                    <option value="{{$val->id}}">{{$val->name}}</option>
                                                    @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="form-control" name="university_id[]">
                                                    <option>Select University</option>
                                                    @foreach($university as $val)
                                                    <option value="{{$val->id}}">{{$val->name}}</option>
                                                    @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="form-control" name="board_id[]">
                                                    <option>Select Board</option>
                                                    @foreach($board as $val)
                                                    <option value="{{$val->id}}">{{$val->name}}</option>
                                                    @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" name="result[]" class="form-control">
                                                </td>
                                                <td>
                                                    <button type="button" id="divAdd">Add</button>
                                                </td>
                                            </tr>

                                            
                                        </tbody>
                                        
                                    </table>

                                </div>
                                <!-- select training -->
                                Training 
                                <hr>
                                <div>
                                    <table class="table">
                                        <tr>
                                            <th><input type="radio" name="check" id="yes">Yes</th>
                                            <th><input type="radio" name="check" id="no">No</th>
                                        </tr>
                                        
                                    </table>
                                </div>
                                <hr>
                                <div class="form-group row">
                                    <table class="table" id="training">

                                        
                                    </table>

                                </div>

                                <div class="form-group row">
                                    <div class="col-4">
                                    <label for="photo" class="col-12 col-form-label">Photo</label>
                                    <div class="col-12">
                                        @if(isset($emp->id) && $emp->id != null)
                                            <input class="form-control custom-focus @error('photo') is-invalid @enderror"  id="photo" name="photo" type="file" value="{{ $emp->photo }}" >
                                        @else
                                            <input class="form-control custom-focus @error('photo') is-invalid @enderror"  id="photo" name="photo" type="file" value="{{ old('photo') }}" >
                                        @endif
                                    </div>
                                    @error('photo')
                                    <span class="text-success ml-3 mt-1">{{ $message }}</span>
                                    @enderror
                                    </div>

                                    <div class="col-4">
                                    <label for="cv" class="col-12 col-form-label">CV</label>
                                    <div class="col-12">
                                        @if(isset($emp->id) && $emp->id != null)
                                            <input class="form-control custom-focus @error('cv') is-invalid @enderror"  id="cv" name="cv" type="file" value="{{ $emp->cv }}" >
                                        @else
                                            <input class="form-control custom-focus @error('cv') is-invalid @enderror"  id="cv" name="cv" type="file" value="{{ old('cv') }}" >
                                        @endif
                                    </div>
                                    @error('cv')
                                    <span class="text-success ml-3 mt-1">{{ $message }}</span>
                                    @enderror
                                    </div>

                                    
                                </div>
                                <div class="form-group row">
                                    <div class="col-12 mt-3 mb-2 text-right">
                                   <button type="submit" id="regSubmit" class="btn btn-primary">Register</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    
@endsection
@push('custom_js')
<script type="text/javascript">
    //=============add new row of education================
        $('#divAdd').click(function(){
            var rowCount = $('#itemTable tr').length;
            var lastIndex = rowCount - 1;
            //alert(lastIndex);
            $('#itemTable  tr:eq('+lastIndex+')').after('<tr><td><select class="form-control" name="exam_id[]"><option>Select Exam</option>@foreach($exam_name as $val)<option value="{{$val->id}}">{{$val->name}}</option>@endforeach</select></td><td><select class="form-control" name="university_id[]"><option>Select University</option>@foreach($university as $val)<option value="{{$val->id}}">{{$val->name}}</option>@endforeach</select></td><td><select class="form-control" name="board_id[]"><option>Select Board</option>@foreach($board as $val)<option value="{{$val->id}}">{{$val->name}}</option>@endforeach</select></td><td><input type="number" name="result[]" class="form-control"></td><td><button type="button" class="btn-xs btn-danger itemRemove" >DEL</button></td></tr>');
        });
    //================remove row for education============  

        $(document).on('click','.itemRemove',function(e) {
          $(this).closest('tr').remove();
        });
    //==============yes button click====
            $('#yes').click(function(){
            //alert(lastIndex);
            $('#training').append('<tr><th>Traing Name</th><th>Traing Details</th><th>Action</th></tr><tr><td><input type="text" class="form-control" name="training_name[]"></td><td><input type="text" class="form-control" name="training_details[]"></td><td><button type="button" class="btn-xs btn-default trainingadd"  >Add</button></td></tr>');
        });
        //================no button click event============  

        $(document).on('click','#no',function(e) {
          $('#training').empty();
        });
            //=============add new row of training================



        $(document).on('click', '.trainingadd', function (e) {
            console.log('this is the click');
            e.preventDefault();

            var rowCount = $('#training tr').length;
            var lastIndex = rowCount - 1;
            //alert(lastIndex);
            $('#training  tr:eq('+lastIndex+')').after('<tr><td><input type="text" class="form-control" name="training_name[]"></td><td><input type="text" class="form-control" name="training_details[]"></td><td><button type="button" class="btn-xs btn-danger itemRemove" >DEL</button></td></tr>');
        });





</script>

<script type="text/javascript">

$.ajaxSetup({
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});

$('#SubmitForm').on('submit',function(e){
    e.preventDefault();

    var formData = new FormData(this);
     var url = '{{ url('/') }}';
    $.ajax({
      url: url + "/submit-form",
      type:"POST",
        data: formData,
        cache:false,
        contentType: false,
        processData: false,
      success:function(response){
        $('#successMsg').show();
        console.log(response);
      },
      error: function(response) {
        $('#nameErrorMsg').text(response.responseJSON.errors.applicant_name);
        $('#emailErrorMsg').text(response.responseJSON.errors.email);
      },
      });
    });
  </script>
@endpush
