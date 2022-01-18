@extends('layouts.app')
@push('custom_css')
  <!-- fullCalendar -->
  <link rel="stylesheet" href="{{ asset('plugins/fullcalendar/main.css') }}">
@endpush
@section('mainContent')
<div class="content-wrapper">
    <!-- Main content -->

    <!-- calender -->
        <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-12">
                    
                        
                
                        <h1 style="text-align:center;">Welcome to ShampanIT</h1>
                            
                        
                    
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('custom_js')
  <!-- fullCalendar 2.2.5 -->
  <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
  <script src="{{ asset('plugins/fullcalendar/main.js') }}"></script>
  <!-- Page specific script -->
<script>

</script>
@endpush




