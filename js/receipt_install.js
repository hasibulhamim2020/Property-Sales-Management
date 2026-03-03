var xmlHttp
var count = 1;

function calculate_payable()
{
document.getElementById('payable_price').value=((document.getElementById('unit_price').value)*1)-((document.getElementById('disc_price').value)*1);
}
function total_price_count()
{
document.getElementById('total_price').value=((document.getElementById('payable_price').value)*1)+((document.getElementById('park_price').value)*1);
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
document.getElementById('inst_amt').value=((document.getElementById('amt').value)*1)/((document.getElementById('no_inst').value)*1);
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
 if (((document.getElementById('pay_code').value)*1)<1) 
 {
  alert('Insert all required Data.');
  return false;
 }
 if (((document.getElementById('installment_no').value)*1)<1) 
 {
  alert('Insert all required Data.');
  return false;
 }
 if (((document.getElementById('installment_amt').value)*1)<((document.getElementById('receive_amt').value)*1)) 
 {
  alert('Receipt Is not Possible.');
  return false;
 }

 else
 { 

document.getElementById("total_amount").value = ((document.getElementById("total_amount").value)*1)+((document.getElementById("receive_amt").value)*1);
   
   var a=document.getElementById("pay_code").value;
   var b=document.getElementById("desc").value;
   var c=document.getElementById("installment_no").value;
   var d=document.getElementById("installment_amt").value;
   var e=document.getElementById("receive_amt").value;
   var f=document.getElementById("flat").value;
   var count=document.getElementById("count").value;
   
   
   
   var com=((document.getElementById('receive_amt').value)*1)/100;
   var team_leader = ((document.getElementById("team_leader_commission1").value)*1);

   var non_insentive = ((document.getElementById("non_insentive1").value)*1);

   var sr_exe = ((document.getElementById("sr_executive_commission1").value)*1);

   var group_leader = ((document.getElementById("group_leader_commission1").value)*1);

   var other = ((document.getElementById("other_commission1").value)*1);
   
   if(a==98){
	   
	   document.getElementById("team_leader_commission").value =((document.getElementById("team_leader_commission").value)*1);
   document.getElementById("non_insentive_commission").value = ((document.getElementById("non_insentive_commission").value)*1);

   document.getElementById("sr_executive_commission").value =((document.getElementById("sr_executive_commission").value)*1);

   document.getElementById("group_leader_commission").value = ((document.getElementById("group_leader_commission").value)*1) ;

   document.getElementById("other_commission").value = ((document.getElementById("other_commission").value)*1);

  
   } else if(a==97){
   document.getElementById("team_leader_commission").value =((document.getElementById("team_leader_commission").value)*1);
   document.getElementById("non_insentive_commission").value = ((document.getElementById("non_insentive_commission").value)*1);
   document.getElementById("sr_executive_commission").value =((document.getElementById("sr_executive_commission").value)*1);
   document.getElementById("group_leader_commission").value = ((document.getElementById("group_leader_commission").value)*1) ;
   document.getElementById("other_commission").value = ((document.getElementById("other_commission").value)*1);


    
	   
	   
	   }else{
document.getElementById("team_leader_commission").value =((document.getElementById("team_leader_commission").value)*1)+((com*team_leader)/100);
document.getElementById("non_insentive_commission").value = ((document.getElementById("non_insentive_commission").value)*1)+ ((com*non_insentive)/100);
document.getElementById("sr_executive_commission").value =((document.getElementById("sr_executive_commission").value)*1)+ ((com*sr_exe)/100);
document.getElementById("group_leader_commission").value = ((document.getElementById("group_leader_commission").value)*1) + ((com*group_leader)/100);
document.getElementById("other_commission").value = ((document.getElementById("other_commission").value)*1) + ((com*other)/100);
		   }
	   
   
   
   
   
     
   
 document.getElementById("count").value = ((document.getElementById("count").value)*1)+1;
  $.ajax({
    url: '../../common/receive_inst_grid.php',
    data: "a="+a+"&b="+b+"&c="+c+"&d="+d+"&e="+e+"&f="+f+"&count="+count,
    success: function(data) {      
    $('#tbl').append(data); 
    }
  });
  
 $('#desc').val('');
 $('#amt').val('');
 $('#installment_amt').val('');
 $('#receive_amt').val('');

 }
return true;
}

function set_install(fid,pcode)
{
   $.ajax({
    url: '../../common/install_no.php',
    data: "fid="+fid+"&pcode="+pcode,
    success: function(data) {      
    $('#inst_no').html(data); 
    }
  });

}
function set_install_amt(fid)
{
 var pcode=document.getElementById('pay_code').value;
 var in_no=document.getElementById('installment_no').value;

   $.ajax({
    url: '../../common/install_amt.php',
    data: "fid="+fid+"&pcode="+pcode+"&in_no="+in_no,
    success: function(data) {      
    $('#inst_amt').html(data); 
    }
  });
   
   $.ajax({
    url: '../../common/install_date.php',
    data: "fid="+fid+"&pcode="+pcode+"&in_no="+in_no,
    success: function(data) {      
    $('#inst_date').html(data); 
    }
  });
   
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