var xmlHttp
var count = 1;

function calculate_payable()
{
document.getElementById('payable_price').value=((document.getElementById('unit_price').value)*1)-((document.getElementById('disc_price').value)*1);
}


function total_price_count()
{
document.getElementById('total_price').value=((document.getElementById('utility_price').value)*1)+((document.getElementById('oth_price').value)*1)+((document.getElementById('payable_price').value)*1)+((document.getElementById('park_price').value)*1);
}
function calculate_unitprice()
{
document.getElementById('unit_price').value=((document.getElementById('flat_size').value)*1)*((document.getElementById('sqft_price').value)*1);
}
function set_from_conf()
{
document.getElementById('amt').value=((document.getElementById('total_price').value)*1)-((document.getElementById('conf_amt').value)*1);
document.getElementById('duration').value=1;
document.getElementById('no_inst').value=1;
document.getElementById('inst_amt').value=document.getElementById('amt').value;
}
function set_inst_amt()
{
document.getElementById('inst_amt').value=((document.getElementById('amt').value)*1)*((document.getElementById('no_inst').value)*1);
}

function check_ability()
{
	if(((document.getElementById('total_price').value)*1)==((document.getElementById('conf_amt').value)*1))
	{
		document.form.submit();
	}
	else
	{
		
		alert('Installment Configration is not acceptable.');
		return false;
	}
}

$(document).ready(function(){

	$(function() {
		$("#b_date").datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'yy-mm-dd'
		});
	});

});

$(document).ready(function(){

	$(function() {
		$("#rec_date").datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'yy-mm-dd'
		});
	});

});
function check()
{
	if (((document.getElementById('amt').value)*1)<1) 
	{
		alert('Insert all required Data.');
		return false;
	}
	if (((document.getElementById('duration').value)*1)<1) 
	{
		alert('Insert all required Data.');
		return false;
	}
	if (((document.getElementById('inst_amt').value)*1)<1) 
	{
		alert('Insert all required Data.');
		return false;
	}
	if (((document.getElementById('no_inst').value)*1)<1) 
	{
		alert('Insert all required Data.');
		return false;
	}
	if (document.getElementById('b_date').value=='') 
	{
		alert('Insert all required Data.');
		return false;
	}
		if (document.getElementById('pay_code').value=='') 
	{
		alert('Insert all required Data.');
		return false;
	}
	if ((((document.getElementById("conf_amt").value)*1)+((document.getElementById("inst_amt").value)*1))>((document.getElementById("total_price").value)*1)) 
	{
		alert('Configaration Amount Overflow.');
		return false;
	}
	else
	{	

document.getElementById("conf_amt").value = ((document.getElementById("conf_amt").value)*1)+((document.getElementById("inst_amt").value)*1);

			var a=document.getElementById("pay_code").value;
			var b=document.getElementById("amt").value;
			var c=document.getElementById("duration").value;
			var d=document.getElementById("no_inst").value;
			var e=document.getElementById("inst_amt").value;
			var f=document.getElementById("b_date").value;
			var count=document.getElementById("count").value;
		
		$.ajax({
		  url: '../../common/price_inst_grid.php',
		  data: "a="+a+"&b="+b+"&c="+c+"&d="+d+"&e="+e+"&f="+f+"&count="+count,
		  success: function(data) {						
				$('#tbl').append(data);	
			 }
		});
		
	$('#pay_code').val('');
	$('#amt').val('');
	$('#duration').val('');
	$('#no_inst').val('');
	$('#inst_amt').val('');
	$('#b_date').val('');
	document.getElementById("count").value = ((document.getElementById("count").value)*1)+1;
	}
return true;
}
//---------------------------------------------------------------------------------
function getflatData()
{
	var b=document.getElementById('building').value;
	var a=document.getElementById('proj_code').value;
			$.ajax({
		  url: '../../common/flat_option_new.php',
		  data: "a="+a+"&b="+b,
		  success: function(data) {						
				$('#fid').html(data);	
			 }
		});
}

//---------------------------------------------------------------------------------
function GetXmlHttpObject()
{
var xmlHttp=null;
try
 {
 // Firefox, Opera 8.0+, Safari
 xmlHttp=new XMLHttpRequest();
 }
catch (e)
 {
 // Internet Explorer
 try
  {
  xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
  }
 catch (e)
  {
  xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
 }
return xmlHttp;
}
