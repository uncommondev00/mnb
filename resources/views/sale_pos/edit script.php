	<script type="text/javascript">

		$(document).ready(function() {

		        $('div#posAddDiscountModal').modal('show');
		        $("#add_discount_section_1").hide();
		        $("button#btn_ok").hide();
		        $("button#btn_cancel").hide();
		        $("#customer_id").hide();

			});

		//var tst = document.getElementById("sample").innerHTML;

		//var ggg = "discount_suspend_" + tst;

		//document.getElementById("sample2").innerHTML = tst;
		var id = "<?php echo $transaction->s_id; ?>"
		var name1 = "<?php echo $transaction->s_name; ?>"
		var addr = "<?php echo $transaction->s_addr; ?>"

		if(id == "" || name1 == "" || addr == "" ){
			document.getElementById("s_id").value = "";
	    	document.getElementById("s_name").value = "";
	    	document.getElementById("s_addr").value = "";
		}else{
			document.getElementById("s_id").value = id;
	    	document.getElementById("s_name").value = name1;
	    	document.getElementById("s_addr").value = addr;
		}

		var coc = "<?php echo $transaction->additional_note; ?>"
		
		//document.write(coc);
		if(coc == "no discount"){
			document.getElementById("total_discount_val").innerHTML = 0;
			document.getElementById("discount_value_modal").value = 0;
		}else{
			document.getElementById("total_discount_val").innerHTML = coc;
			document.getElementById("discount_value_modal").value = coc;
		}

		
		//document.write(tst);


		function setCookie(cname, cvalue, exdays) {
			  var d = new Date();
			  d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
			  var expires = "expires="+d.toUTCString();
			  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
			}

			function getCookie(cname) {
			  var name = cname + "=";
			  var ca = document.cookie.split(';');
			  for(var i = 0; i < ca.length; i++) {
			    var c = ca[i];
			    while (c.charAt(0) == ' ') {
			      c = c.substring(1);
			    }
			    if (c.indexOf(name) == 0) {
			      return c.substring(name.length, c.length);
			    }	
			  }
			  return "";
			}

			function checkCookie() {
				
			  var disc = getCookie("discount");
			  if (disc != "") {
			    //alert("Your Discount is " + disc);
			    disc = document.getElementById("discount_value_modal").value;
			    document.getElementById("total_discount_val").innerHTML = disc;
			    if (disc != "" && disc != null) {
			      setCookie("discount", disc, 999);
			    }
			   
			  } else {
			    disc = document.getElementById("discount_value_modal").value;
			    document.getElementById("total_discount_val").innerHTML = disc;
			    if (disc != "" && disc != null) {
			      setCookie("discount", disc, 999 );
			    }
			  }

			   if(document.getElementById("discount_value_modal").value == ""){
			  	document.getElementById("total_discount_val").innerHTML = 0;
			  }
			}

			function delete_cookie() {
    			setCookie("discount", 0, 999);
    			document.getElementById("total_discount_val").innerHTML = 0;
				};

				function delete_cookie_final() {
    			setCookie("discount", 0, 999);
    			document.getElementById("total_discount_val").innerHTML = 0;
				};
	</script>

	<script type="text/javascript">


			function setCookie2(cname2, cvalue2, exdays2) {
			  var d2 = new Date();
			  d2.setTime(d2.getTime() + (exdays2 * 24 * 60 * 60 * 1000));
			  var expires2 = "expires2="+d2.toUTCString();
			  document.cookie = cname2 + "=" + cvalue2 + ";" + expires2 + ";path=/";
			}

			function getCookie2(cname2) {
			  var name2 = cname2 + "=";
			  var ca2 = document.cookie.split(';');
			  for(var i = 0; i < ca2.length; i++) {
			    var c2 = ca2[i];
			    while (c2.charAt(0) == ' ') {
			      c2 = c2.substring(1);
			    }
			    if (c2.indexOf(name2) == 0) {
			      return c2.substring(name2.length, c2.length);
			    }
			  }
			  return "";
			}

			function checkCookie2() {
				disc25 = document.getElementById("cookie_note").value;
			  var disc2 = getCookie2(disc25);
			  if (disc2 != "") {
			    //alert("Your Discount is " + disc);
			    
			    var vd = getCookie("discount");
			    document.getElementById("total_discount_val").innerHTML = vd;
			    if (disc2 != "" && disc2 != null) {
			      setCookie2(disc2, vd, 999 );
			      setCookie2("discount", 0, 999);
			      document.getElementById("total_discount_val").innerHTML = 0;
			    }
			   
			  } else {
			    disc2 = document.getElementById("cookie_note").value;
			    var vd = getCookie("discount");
			    document.getElementById("total_discount_val").innerHTML = vd;
			    if (disc2 != "" && disc2 != null) {
			      setCookie2( disc2, vd, 999 );
			      setCookie2("discount", 0, 999);
			      document.getElementById("total_discount_val").innerHTML = 0;
			    }
			  }
			}

			function delete_cookie() {
    			setCookie("discount", 0, 999);
    			document.getElementById("total_discount_val").innerHTML = 0;
				};
			
			
	</script>