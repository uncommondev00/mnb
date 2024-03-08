<?php //already have z reading ?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="UTF-8">
  
  <title>Leap - POS X-Reading</title>

  <style>
@media print {
    .page-break { display: block; page-break-before: always; }
}
      #invoice-POS {
  padding: 2mm;
  margin: 0 auto;
  width: 46mm;
  background: #FFF;
}
#invoice-POS ::selection {
  background: #f31544;
  color: #FFF;
}
#invoice-POS ::moz-selection {
  background: #f31544;
  color: #FFF;
}
#invoice-POS h1 {
  font-size: 1.5em;
  color: #222;
}
#invoice-POS h2 {
  font-size: .9em;
}
#invoice-POS h3 {
  font-size: 1.2em;
  font-weight: 300;
  line-height: 2em;
}
#invoice-POS h4 {
  font-size: .8em;
}
#invoice-POS p {
  font-size: .7em;
  color: #000000;
  line-height: 1.2em;
}
#invoice-POS #top, #invoice-POS #mid, #invoice-POS #bot {
  /* Targets all id with 'col-' */
  border-bottom: 1px solid #000000;
}
#invoice-POS #top {
  min-height: 50px;
}
#invoice-POS #mid {
  min-height: 80px;
}
#invoice-POS #bot {
  min-height: 50px;
}

#invoice-POS .info {
  display: block;
  margin-left: 0;
}
#invoice-POS .title {
  float: right;
}
#invoice-POS .title p {
  text-align: right;
  font-size: .5em;
}

#invoice-POS p {
  color: black;
  font-size: .8em;
}

#invoice-POS table {
  width: 100%;
  border-collapse: collapse;
}
#invoice-POS .tabletitle {
  font-size: .5em;
  background: #EEE;
}
#invoice-POS .service {
  border-bottom: 1px solid #EEE;
}
#invoice-POS .item {
  width: 24mm;
}
#invoice-POS .itemtext {
  font-size: .5em;
}
#invoice-POS #legalcopy {
  margin-top: 5mm;
}

    </style>


</head>
    
<body translate="no" onclick="printer();" onkeypress="printer();">

  <div id="invoice-POS">
    <?php  
    //header
            $t_head = $header;
            $thead = json_decode($t_head, true);
            $t_header = $thead[0]['name'];
            $l1_header = $thead[0]['city'];
            $l2_header = $thead[0]['state'];
            $l3_header = $thead[0]['zip_code'];
            $l4_header = $thead[0]['country'];
            $l5_header = $thead[0]['mobile'];
            $l6_header = $thead[0]['website']; 
    //x reading data
            $x_data = $x_print;
            $x_read = json_decode($x_data, true);
            $x_d = $x_read[0]['date'];
            $x_si = $x_read[0]['starting_invoice'];
            $x_ei = $x_read[0]['ending_invoice'];
            $x_ti = $x_read[0]['total_invoices'];
            $x_st = $x_read[0]['success_transactions'];
            $x_vt = $x_read[0]['void_transactions'];
            $x_sa = $x_read[0]['sales_amout'];
            $x_va = $x_read[0]['vatable_amount'];
            $x_ve = $x_read[0]['vat_exempt'];
            $x_zr = $x_read[0]['zero_rated'];
            $x_tv = $x_read[0]['total_vat'];
            $x_pr = $x_read[0]['previous_reading'];
            $x_cs = $x_read[0]['current_sales'];
            $x_rt = $x_read[0]['running_total'];
    ?>
    <center id="top">
      <div class="info"> 
        <h2 ><?php echo $t_header; ?></h2>
        <p> 
          <?php echo $l1_header; ?>,<?php echo $l2_header; ?><br>
          <?php echo $l3_header; ?>,<?php echo $l4_header; ?><br>
          <?php echo $l5_header; ?><br>
          <?php echo $l6_header; ?><br>
        </p>

        <h4 >X Reading</h4>
      </div><!--End Info-->
    </center><!--End InvoiceTop-->
    
    <div id="mid">
      <div class="info">
        <p> 
            <b>Date :</b> <?php echo $x_d; ?> <br>
        </p>
        <p> 
            <b>Starting invoice # :</b> <?php echo $x_si; ?> <br>
            <b>Ending invoice #   :</b> <?php echo $x_ei; ?> <br>
            <b>Total invoices     :</b> <?php echo $x_ti; ?> <br>
        </p>
        <p> 
            <b>Successfull Transactions :</b> <?php echo $x_st; ?> <br>
            <b>Void Transaction         :</b> <?php echo $x_vt; ?> <br>
        </p>
        <p> 
            <b>Sales Amount   :</b><?php echo $x_sa; ?> <br>
            <b>Vatable Amount :</b><?php echo $x_va; ?> <br>
            <b>Vat exempt     :</b><?php echo $x_ve; ?> <br>
            <b>Vat Zero Rated :</b><?php echo $x_zr; ?> <br>
            <b>Total Vat      :</b><?php echo $x_tv; ?> <br>
        </p>
         <p> 
            <b>Previous Reading :</b><?php echo $x_pr; ?> <br>
            <b>Current Sales    :</b><?php echo $x_cs; ?> <br>
            <b>Running Total    :</b><?php echo $x_rt; ?> <br>
        </p>
      </div>
    </div><!--End Invoice Mid-->
  </div>

<iframe id="xtextfile" src="{{action('XZReportController@print_this2') }}" style="display: none;"></iframe>
</body>
</html>

<script type="text/javascript">
  function printer() {
    var xiframe = document.getElementById('xtextfile');
    xiframe.contentWindow.print();
    var routeUrl = "<?php echo url('home'); ?>"
    document.location.href=routeUrl;
}
</script>

