
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

    <!--get value of json query-->
    <?php 
            $rt = $transaction_query;
            $rt_v = json_decode($rt, true);

            //for subtract
            $f_rt = $rt_v[0]['running_total'];

            //for view
            $run_total =  number_format($f_rt, 2, '.', ',');
       ?>

      <?php 
        //for vatable and vat
        $vtble = $transac_q2;
        $vatable = json_decode($vtble, true);
        $f_vatable = $vatable[0]['vatable'];
        $f_vat = $vatable[0]['vat'];

        //for add
        $add_vatable =  number_format((float)$f_vatable, 2, '.', '');
        //for view
        $vatable_f =  number_format($add_vatable, 2, '.', ',');

         //for add
        $add_vat =  number_format((float)$f_vat, 2, '.', '');
        //for view
        $vat_f = number_format($add_vat, 2, '.', ',');


        //for vatexempt
        $vat_e = $transac_q3;
        $vat_exempt = json_decode($vat_e, true);
        $f_vat_exempt = $vat_exempt[0]['vat_exempt'];

        //for add
        $add_vat_exempt =  number_format((float)$f_vat_exempt, 2, '.', '');
        //for view
        $vat_exempt_f =  number_format($add_vat_exempt, 2, '.', ',');


        //for zero rated
        $zero = $transac_q4;
        $zero_r = json_decode($zero, true);
        $f_zero_rated = $zero_r[0]['zero_rated'];

        //for add
        $add_zero_rated =  number_format((float)$f_zero_rated, 2, '.', '');
        //for view
        $zero_rated_f =  number_format($add_zero_rated, 2, '.', ',');

        //for sales amount
        $sales = $add_vatable + $add_vat + $add_vat_exempt + $add_zero_rated;
        $f_sales =  number_format($sales, 2, '.', ',');

       ?>

        <div class="modal-body col-sm-12">
       <form method="post" action="z_reading/post">
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
                <input class="text-center" type="text" name="end_date" value="<?php echo $format_date_last; ?>" readonly>
              </div>
            </div>

            <div class="form-group col-sm-12">
              <div class="col-sm-2"> 
              </div>
              <div class="col-sm-4">
                <label>Starting invoice # :</label>
              </div>
              <div class="col-sm-6" style="margin-left: -50px;">
                <input class="text-center" type="text" name="starting_invoice" value="<?php echo $t_q->invoice_no; ?>" readonly>
              </div>
            </div>

            <div class="form-group col-sm-12">
              <div class="col-sm-2"> 
              </div>
              <div class="col-sm-4">
                <label>Ending invoice # :</label>
              </div>
              <div class="col-sm-6" style="margin-left: -50px;">
                <input class="text-center" type="text" name="ending_invoice" value="<?php echo $t_q2->invoice_no; ?>" readonly>
              </div>
            </div>

            <div class="form-group col-sm-12">
              <div class="col-sm-2"> 
              </div>
              <div class="col-sm-4">
                <label>Total invoices :</label>
              </div>
              <div class="col-sm-6" style="margin-left: -50px;">
                <input class="text-center" type="text" name="total_invoices" value="<?php echo ($transactionCount + $voidCount); ?>" readonly>
              </div>
            </div>

            <div class="form-group col-sm-12">
              <div class="col-sm-2"> 
              </div>
              <div class="col-sm-4">
                <label>Successfull Transactions :</label>
              </div>
              <div class="col-sm-6" style="margin-left: -50px;">
                <input class="text-center" type="text" name="success_transactions" value="<?php echo $transactionCount; ?>" readonly>
              </div>
            </div>

            <div class="form-group col-sm-12">
              <div class="col-sm-2"> 
              </div>
              <div class="col-sm-4">
                <label>Void Transaction :</label>
              </div>
              <div class="col-sm-6" style="margin-left: -50px;">
                <input class="text-center" type="text" name="void_transactions" value="<?php echo $voidCount; ?>" readonly>
              </div>
            </div>

            <div class="form-group col-sm-12">
              <div class="col-sm-2"> 
              </div>
              <div class="col-sm-4">
                <label>Sales Amount :</label>
              </div>
              <div class="col-sm-6" style="margin-left: -50px;">
                <input class="text-center" type="text" name="sales_amout" value="<?php echo $run_total; ?>" readonly>
              </div>
            </div>

            <div class="form-group col-sm-12">
              <div class="col-sm-2"> 
              </div>
              <div class="col-sm-4">
                <label>Vatable Amount :</label>
              </div>
              <div class="col-sm-6" style="margin-left: -50px;">
                <input class="text-center" type="text" name="vatable_amount" value="<?php echo  $vatable_f; ?>" readonly>
              </div>
            </div>

            <div class="form-group col-sm-12">
              <div class="col-sm-2"> 
              </div>
              <div class="col-sm-4">
                <label>Vat exempt :</label>
              </div>
              <div class="col-sm-6" style="margin-left: -50px;">
                <input class="text-center" type="text" name="vat_exempt" value="<?php echo  $vat_exempt_f; ?>" readonly>
              </div>
            </div>

            <div class="form-group col-sm-12">
              <div class="col-sm-2"> 
              </div>
              <div class="col-sm-4">
                <label>Zero Rated :</label>
              </div>
              <div class="col-sm-6" style="margin-left: -50px;">
                <input class="text-center" type="text" name="zero_rated" value="<?php echo  $zero_rated_f; ?>" readonly>
              </div>
            </div>
            
            <div class="form-group col-sm-12">
              <div class="col-sm-2"> 
              </div>
              <div class="col-sm-4">
                <label>Total Vat :</label>
              </div>
              <div class="col-sm-6" style="margin-left: -50px;">
                <input class="text-center" type="text" name="total_vat" value="<?php echo  $vat_f; ?>" readonly>
              </div>
            </div>

            <div class="form-group col-sm-12">
              <div class="col-sm-2"> 
              </div>
              <div class="col-sm-4">
                <label>Previous Reading :</label>
              </div>
              <div class="col-sm-6" style="margin-left: -50px;">
                <input class="text-center" type="text" name="previous_reading" value="<?php echo  ($f_rt - $f_rt); ?>" readonly>
              </div>
            </div>

            <div class="form-group col-sm-12">
              <div class="col-sm-2"> 
              </div>
              <div class="col-sm-4">
                <label>Current Sales :</label>
              </div>
              <div class="col-sm-6" style="margin-left: -50px;">
                <input class="text-center" type="text" name="current_sales" value="<?php echo  $run_total; ?>" readonly>
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
                <button type="submit" class="btn btn-primary col-sm-12">@lang( 'messages.save' )</button>
            </div>

            </form>
    </div>

   

    

  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</body>
</html>

<!-- /.content -->
