
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="UTF-8">
  
  <title>Leap - POS X-Reading</title>

  <style>
@media print {
    .page-break { display: block; page-break-before: always; }
}
      #invoicePOS {
  padding: 2mm;
  margin: 0 auto;
  width: 46mm;
  background: #FFF;
}
#invoicePOS ::selection {
  background: #f31544;
  color: #FFF;
}
#invoicePOS ::moz-selection {
  background: #f31544;
  color: #FFF;
}
#invoicePOS h1 {
  font-size: 1.5em;
  color: #222;
}
#invoicePOS h2 {
  font-size: .9em;
}
#invoicePOS h3 {
  font-size: 1.2em;
  font-weight: 300;
  line-height: 2em;
}
#invoicePOS h4 {
  font-size: .8em;
}
#invoicePOS p {
  font-size: .7em;
  color: #000000;
  line-height: 1.2em;
}
#invoicePOS #top, #invoicePOS #mid, #invoicePOS #bot {
  /* Targets all id with 'col-' */
  border-bottom: 1px solid #000000;
}
#invoicePOS #top {
  min-height: 50px;
}
#invoicePOS #mid {
  min-height: 80px;
}
#invoicePOS #bot {
  min-height: 50px;
}

#invoicePOS .info {
  display: block;
  margin-left: 0;
}
#invoicePOS .title {
  float: right;
}
#invoicePOS .title p {
  text-align: right;
  font-size: .5em;
}

#invoicePOS p {
  color: black;
  font-size: .8em;
}

#invoicePOS table {
  width: 100%;
  border-collapse: collapse;
}
#invoicePOS .tabletitle {
  font-size: .5em;
  background: #EEE;
}
#invoicePOS .service {
  border-bottom: 1px solid #EEE;
}
#invoicePOS .item {
  width: 24mm;
}
#invoicePOS .itemtext {
  font-size: .5em;
}
#invoicePOS #legalcopy {
  margin-top: 5mm;
}

    </style>


</head>
    
<body translate="no" onclick="printElem();" onkeypress="printElem();">

  <div id="invoicePOS">
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
            $x_data = $re_print;
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

<iframe id="xtextfile" src="{{action('XZReportController@print_again') }}" style="display: none;"></iframe>
</body>
</html>

<script type="text/javascript">
function printElem() {
    var content = document.getElementById('invoicePOS').innerHTML;
    var mywindow = window.open('', 'Print', 'height=600,width=800');

    mywindow.document.write('<html><head><title>Print</title>');
    mywindow.document.write('</head><body >');
    mywindow.document.write(content);
    mywindow.document.write('</body></html>');

    mywindow.document.close();
    mywindow.focus()
    mywindow.print();
    mywindow.close();
    var routeUrl = "<?php echo url('home'); ?>"
    document.location.href=routeUrl;
}
</script>