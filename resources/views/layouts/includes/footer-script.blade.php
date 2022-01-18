<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
<script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist/js/demo.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>

<!-- DataTables  & Plugins -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>
<script type="text/javascript">
        $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
        });
</script>
@stack('custom_js')


<script type="text/javascript">
        // Load District for present address
    $('#divisionPresent').change(function () {
        var divisionID = $(this).val();
        var httpHost = "<?php request()->getHost(); ?>";
        var url = '{{ url('/') }}';
        if(divisionID)
        {
            $.ajax({
                url: url + '/get-districts/' + divisionID,
                method: 'get',
                success: function (data) {
                    var districtsData = data;
                    if(districtsData){
                        $('#districtPresent').empty();
                        $('#districtPresent').append('<option value="">Select District</option>');
                        districtsData.forEach(function (districtsData) {
                            $('#districtPresent').append('<option value="'+districtsData.id+'">' +
                                districtsData.district_name+
                                '</option>');
                        })
                    }
                    else{
                        $('#districtPresent').empty();
                        $('#districtPresent').append('<option value="">Select District</option>');
                    }
                }
            });
        }
        else{
            $('#districtPresent').empty();
            $('#districtPresent').append('<option value="">Select District</option>');
            $('#thanaPresent').empty();
            $('#thanaPresent').append('<option value="">Select Thana</option>');
        }
    });
    // Load Thana for present address
    $('#districtPresent').change(function () {
        var districtID = $(this).val();
        var url = '{{ url('/') }}';
        if(districtID)
        {
            $.ajax({
                url: url + '/get-thanas/' + districtID,
                method: 'get',
                success: function (data) {
                    var thanasData = data;
                    if(thanasData){
                        $('#thanaPresent').empty();
                        $('#thanaPresent').append('<option value="">Select Thana</option>');
                        thanasData.forEach(function (thanasData) {
                            $('#thanaPresent').append('<option value="'+thanasData.id+'">' +
                                thanasData.ps_name+
                                '</option>');
                        })
                    }
                    else{
                        $('#thanaPresent').empty();
                        $('#thanaPresent').append('<option value="">Select Thana</option>');
                    }
                }
            });
        }
        else{
            $('#thanaPresent').empty();
            $('#thanaPresent').append('<option value="">Select Thana</option>');
        }
    });
    // Load District for permanent address
    $('#divisionPermanent').change(function () {
        var divisionID = $(this).val();
        var url = '{{ url('/') }}';
        if(divisionID)
        {
            $.ajax({
                url: url + '/get-districts/' + divisionID,
                method: 'get',
                success: function (data) {
                    var districtsData = data;
                    if(districtsData){
                        $('#districtPermanent').empty();
                        $('#districtPermanent').append('<option value="">Select District</option>');
                        districtsData.forEach(function (districtsData) {
                            $('#districtPermanent').append('<option value="'+districtsData.id+'">' +
                                districtsData.district_name+
                                '</option>');
                        })
                    }
                    else{
                        $('#districtPermanent').empty();
                        $('#districtPermanent').append('<option value="">Select District</option>');
                    }
                }
            });
        }
        else{
            $('#districtPermanent').empty();
            $('#districtPermanent').append('<option value="">Select District</option>');
            $('#thanaPermanent').empty();
            $('#thanaPermanent').append('<option value="">Select Thana</option>');
        }
    });
    // Load Thana for permanent address
    $('#districtPermanent').change(function () {
        var districtID = $(this).val();
        var url = '{{ url('/') }}';
        if(districtID)
        {
            $.ajax({
                url: url + '/get-thanas/' + districtID,
                method: 'get',
                success: function (data) {
                    var thanasData = data;
                    if(thanasData){
                        $('#thanaPermanent').empty();
                        $('#thanaPermanent').append('<option value="">Select Thana</option>');
                        thanasData.forEach(function (thanasData) {
                            $('#thanaPermanent').append('<option value="'+thanasData.id+'">' +
                                thanasData.ps_name+
                                '</option>');
                        })
                    }
                    else{
                        $('#thanaPermanent').empty();
                        $('#thanaPermanent').append('<option value="">Select Thana</option>');
                    }
                }
            });
        }
        else{
            $('#thanaPermanent').empty();
            $('#thanaPermanent').append('<option value="">Select Thana</option>');
        }
    });
</script>
</body>
</html>


