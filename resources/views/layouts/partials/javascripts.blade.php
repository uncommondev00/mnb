<script type="text/javascript">
    base_path = "{{url('/')}}";
</script>

<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js?v=$asset_v"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js?v=$asset_v"></script>
<![endif]-->

<script src="{{ asset('AdminLTE/plugins/pace/pace.min.js?v=' . $asset_v) }}"></script>

<!-- jQuery 2.2.3 -->
<script src="{{ asset('AdminLTE/plugins/jQuery/jquery-2.2.3.min.js?v=' . $asset_v) }}"></script>
<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js?v=' . $asset_v) }}"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{{ asset('bootstrap/js/bootstrap.min.js?v=' . $asset_v) }}"></script>
<!-- iCheck -->
<script src="{{ asset('AdminLTE/plugins/iCheck/icheck.min.js?v=' . $asset_v) }}"></script>
<!-- Select2 -->
<script src="{{ asset('AdminLTE/plugins/select2/select2.full.min.js?v=' . $asset_v) }}"></script>
<!-- Add language file for select2 -->
<script src="{{ asset('AdminLTE/plugins/select2/lang/' . session()->get('user.language', config('app.locale') ) . '.js?v=' . $asset_v) }}"></script>
<!-- bootstrap datepicker -->
<script src="{{ asset('AdminLTE/plugins/datepicker/bootstrap-datepicker.min.js?v=' . $asset_v) }}"></script>
<!-- DataTables -->
<script src="{{ asset('AdminLTE/plugins/DataTables/datatables.min.js?v=' . $asset_v) }}"></script>
<script src="{{ asset('AdminLTE/plugins/DataTables/pdfmake-0.1.32/pdfmake.min.js?v=' . $asset_v) }}"></script>
<script src="{{ asset('AdminLTE/plugins/DataTables/pdfmake-0.1.32/vfs_fonts.js?v=' . $asset_v) }}"></script>

<!-- jQuery Validator -->
<script src="{{ asset('js/jquery-validation-1.16.0/dist/jquery.validate.min.js?v=' . $asset_v) }}"></script>
<script src="{{ asset('js/jquery-validation-1.16.0/dist/additional-methods.min.js?v=' . $asset_v) }}"></script>
@php
    $validation_lang_file = 'messages_' . session()->get('user.language', config('app.locale') ) . '.js';
@endphp
@if(file_exists(public_path() . '/js/jquery-validation-1.16.0/src/localization/' . $validation_lang_file))
    <script src="{{ asset('js/jquery-validation-1.16.0/src/localization/' . $validation_lang_file . '?v=' . $asset_v) }}"></script>
@endif

<!-- Toastr -->
<script src="{{ asset('plugins/toastr/toastr.min.js?v=' . $asset_v) }}"></script>
<!-- Bootstrap file input -->
<script src="{{ asset('plugins/bootstrap-fileinput/fileinput.min.js?v=' . $asset_v) }}"></script>
<!--accounting js-->
<script src="{{ asset('plugins/accounting.min.js?v=' . $asset_v) }}"></script>

<script src="{{ asset('AdminLTE/plugins/daterangepicker/moment.min.js?v=' . $asset_v) }}"></script>

<script src="{{ asset('plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js?v=' . $asset_v) }}"></script>

<script src="{{ asset('AdminLTE/plugins/daterangepicker/daterangepicker.js?v=' . $asset_v) }}"></script>

<script src="{{ asset('AdminLTE/plugins/ckeditor/ckeditor.js?v=' . $asset_v) }}"></script>

<script src="{{ asset('plugins/sweetalert/sweetalert.min.js?v=' . $asset_v) }}"></script>

<script src="{{ asset('plugins/bootstrap-tour/bootstrap-tour.min.js?v=' . $asset_v) }}"></script>

<script src="{{ asset('plugins/printThis.js?v=' . $asset_v) }}"></script>

<script src="{{ asset('plugins/screenfull.min.js?v=' . $asset_v) }}""></script>

<script src="{{ asset('plugins/moment-timezone-with-data.min.js?v=' . $asset_v) }}"></script>
@php
    $business_date_format = session('business.date_format');
    $datepicker_date_format = str_replace('d', 'dd', $business_date_format);
    $datepicker_date_format = str_replace('m', 'mm', $datepicker_date_format);
    $datepicker_date_format = str_replace('Y', 'yyyy', $datepicker_date_format);

    $moment_date_format = str_replace('d', 'DD', $business_date_format);
    $moment_date_format = str_replace('m', 'MM', $moment_date_format);
    $moment_date_format = str_replace('Y', 'YYYY', $moment_date_format);

    $business_time_format = session('business.time_format');
    $moment_time_format = 'HH:mm';
    if($business_time_format == 12){
        $moment_time_format = 'hh:mm A';
    }

@endphp
<script>
    moment.tz.setDefault('{{ Session::get("business.time_zone") }}');
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        @if(config('app.debug') == false)
            $.fn.dataTable.ext.errMode = 'throw';
        @endif
    });
    
    var financial_year = {
    	start: moment('{{ Session::get("financial_year.start") }}'),
    	end: moment('{{ Session::get("financial_year.end") }}'),
    }
    //Default setting for select2
    $.fn.select2.defaults.set("language", "{{session()->get('user.language', config('app.locale'))}}");

    var datepicker_date_format = "{{$datepicker_date_format}}";
    var moment_date_format = "{{$moment_date_format}}";
    var moment_time_format = "{{$moment_time_format}}";

    var app_locale = "{{session()->get('user.language', config('app.locale'))}}";
    var non_utf8_languages = [
        @foreach(config('constants.non_utf8_languages') as $const)
        "{{$const}}",
        @endforeach
    ];
</script>

<!-- Scripts -->
<script src="{{ asset('js/AdminLTE-app.js?v=' . $asset_v) }}"></script>

@if(file_exists(public_path('js/lang/' . session()->get('user.language', config('app.locale')) . '.js')))
    <script src="{{ asset('js/lang/' . session()->get('user.language', config('app.locale') ) . '.js?v=' . $asset_v) }}"></script>
@else
    <script src="{{ asset('js/lang/en.js?v=' . $asset_v) }}"></script>
@endif

<script src="{{ asset('js/functions.js?v=' . $asset_v) }}"></script>
<script src="{{ asset('js/common.js?v=' . $asset_v) }}"></script>
<script src="{{ asset('js/app.js?v=' . $asset_v) }}"></script>
<script src="{{ asset('js/help-tour.js?v=' . $asset_v) }}"></script>
<script src="{{ asset('plugins/calculator/calculator.js?v=' . $asset_v) }}"></script>


<script type="text/javascript">
  //var suspend = document.getElementById("suspend_sale").innerHTML;

    // if(suspend > 0){
    //   document.getElementById("view_z_reading").disabled = true;
    //   document.getElementById("view_x_reading").disabled = true;
    // }
</script>
<!--z reading-->
 <script type="text/javascript">
    

    $(document).on('shown.bs.modal', function () {
              $('#input_zreading_PIN').focus();

        

               $("#submit_zbtn").click(function(){

               document.getElementById("input_zreading_PIN").value = "";
               
            });
          });

     var pins = ["{{config('app.security')}}"];


      function pincode(pin) {
        return pin == document.getElementById("input_zreading_PIN").value;
      }


        function myZPin() {
        if (document.getElementById("Check_zreading_PIN").innerHTML = pins.find(pincode) == undefined){
              document.getElementById("Check_zreading_PIN").innerHTML = "Incorrect Pincode!";
              document.getElementById("input_zreading_PIN").value = "";

         }else{
           document.getElementById("Check_zreading_PIN").innerHTML = "";
           var routeUrl = "<?php echo url('/z_reading'); ?>"
          document.location.href=routeUrl;
            
          }
      }
</script>

<!--for unit sell security-->
<script type="text/javascript">

   $('li#veri').click(function() {
        $('#security_modal').modal('show');
    });

      $(document).on('shown.bs.modal', function () {
              $('#input_uSec_PIN').focus();
          });

    var vers = ["{{config('app.security')}}"];


      function pincode1(ver) {
        return ver == document.getElementById("input_uSec_PIN").value;
      }


        function mySecPin() {
        if (document.getElementById("Check_uSec_PIN").innerHTML = vers.find(pincode1) == undefined){
              document.getElementById("Check_uSec_PIN").innerHTML = "Incorrect Pincode!";
              document.getElementById("input_uSec_PIN").value = "";

         }else{
           document.getElementById("Check_uSec_PIN").innerHTML = "";
          document.location.href="{{action('UnitSellController@index')}}";
          }
      }

</script>

<!--x reading-->
<script type="text/javascript">




    $(document).on('shown.bs.modal', function () {
              $('#input_xreading_PIN').focus();

        

               $("#submit_xbtn").click(function(){

               document.getElementById("input_xreading_PIN").value = "";
               
            });
          });

     var securs = ["{{config('app.security')}}"];


      function pincode2(secur) {
        return secur == document.getElementById("input_xreading_PIN").value;
      }


        function myXPin() {
        if (document.getElementById("Check_xreading_PIN").innerHTML = securs.find(pincode2) == undefined){
              document.getElementById("Check_xreading_PIN").innerHTML = "Incorrect Pincode!";
              document.getElementById("input_xreading_PIN").value = "";

         }else{
           document.getElementById("Check_xreading_PIN").innerHTML = "";
           var routeUrl2 = "<?php echo url('/x_reading'); ?>"
          document.location.href=routeUrl2;
          }
      }

       $(document).ready( function(){
        $('.dataTables_filter input[type="search"]').val('asd');
       });
</script>

@yield('javascript')