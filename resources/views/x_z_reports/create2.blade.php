
<!DOCTYPE html>
<html>

<head>
    <title>Z Reading</title>
    @include('layouts.partials.css')
</head>
<body>
   <div class="modal-dialog" role="document">
  <div class="modal-content">

   
    <div class="modal-header">
      <b><h4 class="modal-title text-center">@lang( 'Z Reading' )</h4></b>
    </div>

    <!--get value of running total-->
       <?php
            $ztr = $transaction_running;
            $zftr = json_decode($ztr, true);
            $z_runningtotal = $zftr[0]['running_total'];

            $run_total =  number_format($z_runningtotal, 2, '.', ',');
       ?>

       <!--get value of current total-->
       <?php
            $ztc = $t_cur;
            $zftc = json_decode($ztc, true);
            $z_currenttotal = $zftc[0]['current_sales'];

            $current_total =  number_format($z_currenttotal, 2, '.', ',');
       ?>

       <!--get value of vatable and vat-->
       <?php
            $vat_vatable = $tq1;
            $d_vat_vatable = json_decode($vat_vatable, true);

            $vatable_val = $d_vat_vatable[0]['vatable'];

            $vat_val = $d_vat_vatable[0]['vat'];

            //for add
            $add_vatable =  number_format((float)$vatable_val, 2, '.', '');
            //for view
            $vatable_f =  number_format($vatable_val, 2, '.', ',');

            //for add
            $add_vat =  number_format((float)$vat_val, 2, '.', '');
            //for view
            $vat_f =  number_format($vat_val, 2, '.', ',');

       ?>

       <!--get value of vat exempt-->
       <?php
            $vat_ex = $tq2;
            $d_vat_ex = json_decode($vat_ex, true);

            $vat_exempt = $d_vat_ex[0]['vat_exempt'];
            
            //for add
            $add_vat_exempt =  number_format((float)$vat_exempt, 2, '.', '');
            //for view
            $vat_exempt_f =  number_format($vat_exempt, 2, '.', ',');

       ?>

        <!--get value of zero rated-->
       <?php
            $zero_rate = $tq3;
            $d_zero_rate = json_decode($zero_rate, true);

            $zero_rated = $d_zero_rate[0]['zero_rated'];

            //for add
            $add_zero_rated =  number_format((float)$zero_rated, 2, '.', '');
            //for view
            $zero_rated_f =  number_format($zero_rated, 2, '.', ',');


            //sales ammount
            $sales = $vatable_val + $vat_val + $vat_exempt + $zero_rated;
            $f_sales =  number_format($sales, 2, '.', ',');

            //previous reading
            $p_read = $z_runningtotal - $z_currenttotal;
            $previous_reading = number_format($p_read, 2, '.', ',');

       ?>

    <div class="modal-body col-sm-12">
       <form  id="submit_print" method="post" action="z_reading/post">
        {{ csrf_field() }}
            <div class="form-group col-sm-12">
              <input class="text-center" type="text" name="mac_address" value="<?php echo $macAddr; ?>" hidden>
              <div class="col-sm-2"> 
              </div>
              <div class="col-sm-4">
                <label>Start Date:</label>
              </div>
              <div class="col-sm-6 " style="margin-left: -50px;">
                <input class="text-center" type="text" name="start_date" value="<?php echo $format_date; ?>" readonly>
              </div>
            </div>

             <div class="form-group col-sm-12">
              <div class="col-sm-2"> 
              </div>
              <div class="col-sm-4">
                <label>End Date:</label>
              </div>
              <div class="col-sm-6" style="margin-left: -50px;">
                <input class="text-center" type="text" name="end_date" value="<?php echo $format_date_end; ?>" readonly>
              </div>
            </div>

            <div class="form-group col-sm-12">
              <div class="col-sm-2"> 
              </div>
              <div class="col-sm-4">
                <label>Starting invoice # :</label>
              </div>
              <div class="col-sm-6" style="margin-left: -50px;">
                <input class="text-center" type="text" name="starting_invoice" value="<?php echo $trans2['invoice_no']; ?>" readonly>
              </div>
            </div>

            <div class="form-group col-sm-12">
              <div class="col-sm-2"> 
              </div>
              <div class="col-sm-4">
                <label>Ending invoice # :</label>
              </div>
              <div class="col-sm-6" style="margin-left: -50px;">
                <input class="text-center" type="text" name="ending_invoice" value="<?php echo $trans3['invoice_no']; ?>" readonly>
              </div>
            </div>

            <div class="form-group col-sm-12">
              <div class="col-sm-2"> 
              </div>
              <div class="col-sm-4">
                <label>Total invoices :</label>
              </div>
              <div class="col-sm-6" style="margin-left: -50px;">
                <input class="text-center" type="text" name="total_invoices" value="<?php echo $z_trancount + $vcount; ?>" readonly>
              </div>
            </div>

            <div class="form-group col-sm-12">
              <div class="col-sm-2"> 
              </div>
              <div class="col-sm-4">
                <label>Successfull Transactions :</label>
              </div>
              <div class="col-sm-6" style="margin-left: -50px;">
                <input class="text-center" type="text" name="success_transactions" value="<?php echo $z_trancount; ?>" readonly>
              </div>
            </div>

            <div class="form-group col-sm-12">
              <div class="col-sm-2"> 
              </div>
              <div class="col-sm-4">
                <label>Void Transaction :</label>
              </div>
              <div class="col-sm-6" style="margin-left: -50px;">
                <input class="text-center" type="text" name="void_transactions" value="<?php echo $vcount; ?>" readonly>
              </div>
            </div>

            <div class="form-group col-sm-12">
              <div class="col-sm-2"> 
              </div>
              <div class="col-sm-4">
                <label>Sales Amount :</label>
              </div>
              <div class="col-sm-6" style="margin-left: -50px;">
                <input class="text-center" type="text" name="sales_amout" value="<?php echo $current_total; ?>" readonly>
              </div>
            </div>

            <div class="form-group col-sm-12">
              <div class="col-sm-2"> 
              </div>
              <div class="col-sm-4">
                <label>Vatable Amount :</label>
              </div>
              <div class="col-sm-6" style="margin-left: -50px;">
                <input class="text-center" type="text" name="vatable_amount" value="<?php echo $vatable_f; ?>" readonly>
              </div>
            </div>

            <div class="form-group col-sm-12">
              <div class="col-sm-2"> 
              </div>
              <div class="col-sm-4">
                <label>Vat exempt :</label>
              </div>
              <div class="col-sm-6" style="margin-left: -50px;">
                <input class="text-center" type="text" name="vat_exempt" value="<?php echo $vat_exempt_f; ?>" readonly>
              </div>
            </div>

            <div class="form-group col-sm-12">
              <div class="col-sm-2"> 
              </div>
              <div class="col-sm-4">
                <label>Zero Rated :</label>
              </div>
              <div class="col-sm-6" style="margin-left: -50px;">
                <input class="text-center" type="text" name="zero_rated" value="<?php echo $zero_rated_f; ?>" readonly>
              </div>
            </div>
            
            <div class="form-group col-sm-12">
              <div class="col-sm-2"> 
              </div>
              <div class="col-sm-4">
                <label>Total Vat :</label>
              </div>
              <div class="col-sm-6" style="margin-left: -50px;">
                <input class="text-center" type="text" name="total_vat" value="<?php echo $vat_f; ?>" readonly>
              </div>
            </div>

            <div class="form-group col-sm-12">
              <div class="col-sm-2"> 
              </div>
              <div class="col-sm-4">
                <label>Previous Reading :</label>
              </div>
              <div class="col-sm-6" style="margin-left: -50px;">
                <input class="text-center" type="text" name="previous_reading" value="<?php echo $previous_reading; ?>" readonly>
              </div>
            </div>

            <div class="form-group col-sm-12">
              <div class="col-sm-2"> 
              </div>
              <div class="col-sm-4">
                <label>Current Sales :</label>
              </div>
              <div class="col-sm-6" style="margin-left: -50px;">
                <input class="text-center" type="text" name="current_sales" value="<?php echo $current_total; ?>" readonly>
              </div>
            </div>

            <div class="form-group col-sm-12">
              <div class="col-sm-2"> 
              </div>
              <div class="col-sm-4">
                <label>Running Total :</label>
              </div>
              <div class="col-sm-6" style="margin-left: -50px;">
                <input class="text-center" type="text" name="running_total" value="<?php echo $run_total; ?>" readonly>
              </div>
            </div>

             <div class="text-center ">
                <button  type="button" class="btn btn-primary col-sm-12" onclick="printer()">@lang( 'messages.save' )</button>
            </div>

            </form>
    </div>

   

    

  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</body>
</html>

<script type="text/javascript">
  function printer() {
    document.getElementById("submit_print").submit();
}
</script>

<!-- /.content -->
