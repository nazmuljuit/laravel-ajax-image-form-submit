@extends('layouts.app')
@section('mainContent')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card-body d-flex flex-row justify-content-start">
                            <h5>User Log Report</h5>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">User Log Report</h3>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered table-striped" id="logreports">
                                    <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Event </th>
                                        <th>Log Details</th>
                                        <th>Date </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(isset($report))
                                        <?php $i = 1 ?>
                                        @foreach($report as $reportlist)
                                            <tr id="gid{{ $reportlist->id }}">
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $reportlist->event }}</td>
                                                <td>{{ $reportlist->details }}</td>
                                                <td>{{ $reportlist->created_at }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td><h4>No Data Found!</h4></td>
                                        </tr>
                                    @endif
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
            $("#logreports").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#logreports_wrapper .col-md-6:eq(0)');
        });
    </script>

@endpush

