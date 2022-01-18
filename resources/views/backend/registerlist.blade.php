@extends('layouts.app')
@section('mainContent')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card-body d-flex flex-row justify-content-start">
                            <h5>Applicant List</h5>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card-body flex-row text-right">
                            
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Applicant List</h3>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered" id="services">
                                    <thead>
                                        <th>SL</th>
                                        <th>Applicant Name</th>
                                        <th>Email</th>
                                        <th>Division</th>
                                        <th>District</th>
                                        <th>Upozila/Thana</th>
                                        <th>Inserted date</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                        @foreach($regList as $k=>$val)
                                            <tr>
                                                <td>{{$k + 1}}</td>
                                                <td>{{$val->applicant_name}}</td>
                                                <td>{{$val->email}}</td>
                                                <td>{{$val->division_name}}</td>
                                                
                                                <td>{{$val->district_name}}</td>
                                                <td>{{$val->ps_name}}</td>
                                                <td>{{$val->created_at}}</td>
                                                
                                                <td>
                                                   
                                                   
                                                    <a href="#" class="btn btn-sm btn-warning my-2" title="Edit">
                                                        <i class="fas fa-edit" aria-hidden="true"></i>
                                                    </a>

                                                   
                                                    
                                                    
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('custom_js')
    <!-- Page specific script -->
    <script>
        $(function () {
            $("#services").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#branch_wrapper .col-md-6:eq(0)');
        });
        <!-- delete -->
        function deleteServices(id) {
            var token = $("meta[name='csrf-token']").attr("content");
            if (confirm("Do you really want to delete this record")) {
                var url = '{{ url('/') }}';
                $.ajax({
                    url: url+'/service/delete/' + id,
                    type: 'get',
                    data: {
                        "id": id,
                        "_token": token,
                    },
                    success: function (status){
                        console.log(status);
                        if(status.status==1){
                            window.location.reload();
                        }
                        else{
                            window.location.reload();
                        }
                    }
                })
            }
        }
    </script>
@endpush

