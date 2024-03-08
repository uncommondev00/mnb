<?php //already have z reading ?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="UTF-8">
  
  <title>Leap - POS Z-Reading</title>

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
#invoice-POS h2 {
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
            $t_head = $header;
            $thead = json_decode($t_head, true);
            $t_header = $thead[0]['name'];
            $l1_header = $thead[0]['city'];
            $l2_header = $thead[0]['state'];
            $l3_header = $thead[0]['zip_code'];
            $l4_header = $thead[0]['country'];
            $l5_header = $thead[0]['mobile'];
            $l6_header = $thead[0]['website']; 
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

        <h4 >Z Reading</h4>
      </div><!--End Info-->
    </center><!--End InvoiceTop-->
    
    <div id="mid">
      <div class="info">
        <p> 
            <b>Start date :</b> <?php echo $z_print['start_date']; ?> <br>
            <b>End Date   :</b> <?php echo $z_print['end_date']; ?> <br>
        </p>
        <p> 
            <b>Starting invoice # :</b> <?php echo $z_print['starting_invoice']; ?> <br>
            <b>Ending invoice #   :</b> <?php echo $z_print['ending_invoice']; ?> <br>
            <b>Total invoices     :</b> <?php echo $z_print['total_invoices']; ?> <br>
        </p>
        <p> 
            <b>Successfull Transactions :</b> <?php echo $z_print['success_transactions']; ?> <br>
            <b>Void Transaction         :</b> <?php echo $z_print['void_transactions']; ?> <br>
        </p>
        <p> 
            <b>Sales Amount   :</b><?php echo $z_print['sales_amout']; ?> <br>
            <b>Vatable Amount :</b><?php echo $z_print['vatable_amount']; ?> <br>
            <b>Vat exempt     :</b><?php echo $z_print['vat_exempt']; ?> <br>
            <b>Vat Zero Rated :</b><?php echo $z_print['zero_rated']; ?> <br>
            <b>Total Vat      :</b><?php echo $z_print['total_vat']; ?> <br>
        </p>
         <p> 
            <b>Previous Reading :</b><?php echo $z_print['previous_reading']; ?> <br>
            <b>Current Sales    :</b><?php echo $z_print['current_sales']; ?> <br>
            <b>Running Total    :</b><?php echo $z_print['running_total']; ?> <br>
        </p>
      </div>
    </div><!--End Invoice Mid-->
  </div>

<iframe id="ztextfile" src="{{action('XZReportController@print_this') }}" style="display: none;"></iframe>
</body>
</html>

<script type="text/javascript">
  function printer() {
    var ziframe = document.getElementById('ztextfile');
    ziframe.contentWindow.print();
    var routeUrl = "<?php echo url('home'); ?>"
    document.location.href=routeUrl;
}
</script>

