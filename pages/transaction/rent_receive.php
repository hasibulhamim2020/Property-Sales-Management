<?php
session_start();
ob_start();
require "../../support/inc.all.php";
if(isset($_POST['submit']))
{
$sql="select rec_no from tbl_receipt where pay_mode=1  and check_realize_status<1 limit 20 ";
$query=mysql_query($sql);
while($data=mysql_fetch_row($query))
{
$v=$data[0];
if($_POST[$v]>0)
{ 
$res="UPDATE `tbl_receipt` SET `check_realize_reason` = '".$_POST[$v.'R']."',`check_realize_status` = '".$_POST[$v]."' WHERE `rec_no` ='".$v."' LIMIT 1";
mysql_query($res);
}

}
}


?>
<script>

function getXMLHTTP() { //fuction to return the xml http object

		var xmlhttp=false;	

		try{

			xmlhttp=new XMLHttpRequest();

		}

		catch(e)	{		

			try{			

				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");

			}

			catch(e){

				try{

				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");

				}

				catch(e1){

					xmlhttp=false;

				}

			}

		}

		 	

		return xmlhttp;

    }

	function add_all(id)

	{

	if(isNaN(document.getElementById('r_'+id).value))

{

alert("Please re-enter.");

document.getElementById('r_'+id).value='';

document.getElementById('r_'+id).focus();

}

else

{

var mark1=document.getElementById('r_'+id).value;

}

if(isNaN(document.getElementById('e_'+id).value))

{

alert("Please re-enter.");

document.getElementById('e_'+id).value='';

document.getElementById('e_'+id).focus();

}

else

{

var mark2=document.getElementById('e_'+id).value;

}

if(isNaN(document.getElementById('w_'+id).value))

{

alert("Please re-enter.");

document.getElementById('w_'+id).value='';

document.getElementById('w_'+id).focus();

}

else

{

var mark3=document.getElementById('w_'+id).value;

}

if(isNaN(document.getElementById('g_'+id).value))

{

alert("Please re-enter.");

document.getElementById('g_'+id).value='';

document.getElementById('g_'+id).focus();

}

else

{

var mark4=document.getElementById('g_'+id).value;

}

if(isNaN(document.getElementById('o_'+id).value))

{

alert("Please re-enter.");

document.getElementById('o_'+id).value='';

document.getElementById('o_'+id).focus();

}

else

{

var mark5=document.getElementById('o_'+id).value;

}

document.getElementById('t_'+id).value=(mark1*1)+(mark2*1)+(mark3*1)+(mark4*1)+(mark5*1);

	}

function update_value(id)

{

if(isNaN(document.getElementById('r_'+id).value))

{

alert("Please re-enter.");

document.getElementById('r_'+id).value='';

document.getElementById('r_'+id).focus();

}

else

{

var mark1=document.getElementById('r_'+id).value;

}

if(isNaN(document.getElementById('e_'+id).value))

{

alert("Please re-enter.");

document.getElementById('e_'+id).value='';

document.getElementById('e_'+id).focus();

}

else

{

var mark2=document.getElementById('e_'+id).value;

}

if(isNaN(document.getElementById('w_'+id).value))

{

alert("Please re-enter.");

document.getElementById('w_'+id).value='';

document.getElementById('w_'+id).focus();

}

else

{

var mark3=document.getElementById('w_'+id).value;

}

if(isNaN(document.getElementById('g_'+id).value))

{

alert("Please re-enter.");

document.getElementById('g_'+id).value='';

document.getElementById('g_'+id).focus();

}

else

{

var mark4=document.getElementById('g_'+id).value;

}
if(isNaN(document.getElementById('o_'+id).value))

{

alert("Please re-enter.");

document.getElementById('o_'+id).value='';

document.getElementById('o_'+id).focus();

}

else

{

var mark5=document.getElementById('o_'+id).value;

}


var mark6=document.getElementById('t_'+id).value;

var mark7=document.getElementById('p_'+id).value;

var mark8=document.getElementById('proj_code').value;

var mark9=document.getElementById('period').value;

var mark10=document.getElementById('f_'+id).value;

var strURL="../../common/receive.php?rent_id="+id+"&a1="+mark1+"&a2="+mark2+"&a3="+mark3+"&a4="+mark4+"&a5="+mark5+"&a6="+mark6+"&a7="+mark7+"&a8="+mark8+"&a9="+mark9+"&a10="+mark10;

		var req = getXMLHTTP();

		if (req) {

			req.onreadystatechange = function() {

			

				if (req.readyState == 4) {

					// only if "OK"

					if (req.status == 200) {						

						document.getElementById('divi_'+id).style.display='inline';

						document.getElementById('divi_'+id).innerHTML=req.responseText;						

					} else {

						alert("There was a problem while using XMLHTTP:\n" + req.statusText);

					}

				}				

			}

			

						

			req.open("GET", strURL, true);

			req.send(null);

		}	

}


</script>
<form id="form1" name="form1" method="post" action="">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#3f590a" bgcolor="#c7eb8e" style="border:1px solid #3f590a; border-collapse:collapse; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px; color:#000000;">
      <tr bgcolor="#679435">
        <td align="center" bgcolor="#679435" style="padding:3px; font-weight:bold;  font-size:13px; color:#FFFFFF;">Rent Receive </td>
      </tr>
      <tr bgcolor="#679435">
        <td width="100%" align="center" bgcolor="#679435" style="padding:3px; font-weight:bold;  font-size:13px; color:#FFFFFF;"><table width="291" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="131">Project Code:</td>
            <td width="96"><select name="proj_code" id="proj_code">
                <? foreign_relation('tbl_project_info','proj_code','proj_name',$_POST['proj_code']);?>
              </select>            </td>
          </tr>
          <tr>
            <td>Month:</td>
            <td><select name="mon">
              <option>
                <?=$_POST['mon']?>
                </option>
              <option value="01">01</option>
              <option value="02">02</option>
              <option value="03">03</option>
              <option value="04">04</option>
              <option value="05">05</option>
              <option value="06">06</option>
              <option value="07">07</option>
              <option value="08">08</option>
              <option value="09">09</option>
              <option value="10">10</option>
              <option value="11">11</option>
              <option value="12">12</option>
            </select></td>
          </tr>
          <tr>
            <td>Year:</td>
            <td><select name="yr">
			  <option><?=$_POST['yr']?></option>
			<option value="2011">2011</option>
			<option value="2012">2012</option>
			<option value="2013">2013</option>
			<option value="2014">2014</option>
			<option value="2015">2015</option>
              </select></td>
          </tr>
          
        </table>
          
          <table width="10%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><input name="show" type="submit" id="show" value="Show" /></td>
            </tr>
          </table></td>
      </tr>
      
    </table>
	  <div align="center">
	  <table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr bgcolor="#99CC99">
            <td><strong>Flat No </strong></td>
            <td><strong>Party Name </strong></td>
            <td><strong>Rent Amt </strong></td>
            <td><strong>Elec Bill </strong></td>
            <td><strong>Wasa Bill </strong></td>
            <td><strong>Gas Bill </strong></td>
            <td><strong>Other Bill </strong></td>
            <td><strong>Total Amt </strong></td>
            <td><strong>Action</strong></td>
          </tr>
<?
if($_POST['show'])
{
$yr=$_POST['yr'];
$mon=$_POST['mon'];
$proj_code=$_POST['proj_code'];
$start_date=$yr.'-'.$mon.'-'.'01';
$period=$yr.$mon;
$sql="select * from tbl_rent_info where proj_code='$proj_code'";
$query=mysql_query($sql);
while($data=mysql_fetch_object($query))
{
$x=$data->rent_id;
$f=$data->flat_no;
$p=$data->party_code;
$party_name=find_a_field('tbl_party_info','party_name','party_code='.$data->party_code);
$res="select * from tbl_rent_receive where proj_code='$proj_code' and rent_id='$data->rent_id' and mon='$period' limit 1";
$ress=mysql_query($res);
if(mysql_num_rows($ress)>0){
$status='Update';
while($info=mysql_fetch_object($ress))
{
$e=$info->electricity_bill;
$w=$info->wasa_bill;
$g=$info->gas_bill;
$o=$info->other_bill;
$r=$info->rent_amt;
$t=$info->total_amt;
}
}
else
{
$status='Save';
$e=$data->electricity_bill;
$w=$data->wasa_bill;
$g=$data->gas_bill;
$o=$data->other_bill;
$r=$data->monthly_rent;
$t=$data->electricity_bill+$data->wasa_bill+$data->gas_bill+$data->other_bill+$data->monthly_rent;
}
?>
<tr bgcolor="#CCCCCC">
            <td><?=$f?></td>
            <td><input name="p_<?=$x?>" type="hidden" id="p_<?=$x?>" value="<?=$p?>" size="8" />
              <input name="f_<?=$x?>" type="hidden" id="f_<?=$x?>" value="<?=$f?>" size="8" />
              <?=$party_name?></td>
            <td><input name="r_<?=$x?>" type="text" id="r_<?=$x?>" value="<?=$r?>" size="8" onchange="add_all(<?=$x?>)"/></td>
            <td><input name="e_<?=$x?>" type="text" id="e_<?=$x?>" value="<?=$e?>" size="8" onchange="add_all(<?=$x?>)"/></td>
            <td><input name="w_<?=$x?>" type="text" id="w_<?=$x?>" value="<?=$w?>" size="8" onchange="add_all(<?=$x?>)"/></td>
            <td><input name="g_<?=$x?>" type="text" id="g_<?=$x?>" value="<?=$g?>" size="8" onchange="add_all(<?=$x?>)"/></td>
            <td><input name="o_<?=$x?>" type="text" id="o_<?=$x?>" value="<?=$o?>" size="8" onchange="add_all(<?=$x?>)"/></td>
            <td><input name="t_<?=$x?>" type="text" id="t_<?=$x?>" value="<?=$t?>" size="8" readonly /></td>
            <td>
              <div align="center">
			  <span id="divi_<?=$x?>">
                <input type="button" name="Button" value="<?=$status?>"  onclick="update_value(<?=$x?>)"/>
              </span> </div></td>
          </tr>
<?
}
}
?>
        </table>
	  <input name="period" type="hidden" id="period" value="<?=$period?>" />
	  </div></td>
  </tr>
</table>

</form>
<?
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout1.php");
?>