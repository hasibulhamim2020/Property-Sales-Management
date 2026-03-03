<?php
session_start();
require "../../support/inc.all.php";
do_calander('#booked_on');

if(isset($_POST['submit']))
{
echo $_SESSION['booked']['type'];
$booked_on=$_POST['booked_on'];

$sql="UPDATE tbl_flat_info SET 
status = '".$_SESSION['booked']['type']."', 
booked_on = '$booked_on', 
party_code = '".$_SESSION['booked']['party_code']."' ,
sales_person = '".$_POST['sales_person']."'
WHERE fid = '".$_SESSION['booked']['fid']."' ";
$booked=mysql_query($sql);
}

if(isset($_GET['type'])&&$_GET['type']==2)
$_SESSION['booked']['type']= 'Reserve';

if(isset($_GET['type'])&&$_GET['type']==1)
$_SESSION['booked']['type']= 'Booked';

if($_GET['party_code'])
{
$sql='select * from tbl_party_info where party_code='.$_GET['party_code'].' limit 1';
$query=mysql_query($sql);
if(mysql_num_rows($query))
{
$data=mysql_fetch_object($query);
}
}
if(isset($_SESSION['booked']))
$_SESSION['booked']['party_code']= $_GET['party_code'];

//var_dump($_SESSION['booked']);
?>
<script type="text/javascript">

function closeGreybox() {
    parent.parent.GB_hide();
    window.top.location.reload();
}
</script>
<table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#3f590a" bgcolor="#c7eb8e" style="border:1px solid #3f590a; border-collapse:collapse; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px; color:#000000;">
  <tr bgcolor="#679435">
    <td colspan="2" align="center" bgcolor="#679435" style="padding:3px; font-weight:bold;  font-size:13px; color:#FFFFFF;">Party Information </td>
  </tr>
  <tr bgcolor="#f8fbc1">
    <td width="39%" align="right" style="padding:5px;">Party Code : </td>
    <td width="61%" align="left"><?=$data->party_code?>&nbsp;</td>
  </tr>
  <tr>
    <td align="right" style="padding:5px;">Party Name : </td>
    <td align="left"><?=$data->party_name?></td>
  </tr>
  <tr bgcolor="#f8fbc1">
    <td style="padding:5px;" align="right">Party Address : </td>
    <td align="left"><?=$data->per_house?></td>
  </tr>
  <tr>
    <td style="padding:5px;" align="right">Party Contact No. : </td>
    <td align="left"><?=$data->ah_mobile_tel?></td>
  </tr>
  <tr bgcolor="#f8fbc1">
    <td style="padding:5px;" align="right">Party Telephone (Off) : </td>
    <td align="left"><?=$data->pre_tel_of?></td>
  </tr>
  
  
  
  <tr bgcolor="#f8fbc1">
    <td colspan="2" align="center" bgcolor="#679435" style="padding:5px;"><span style="padding:3px; font-weight:bold;  font-size:13px; color:#FFFFFF;">Plot Information </span></td>
  </tr>
  <tr bgcolor="#f8fbc1">
    <td style="padding:5px;" align="right">Project Code : </td>
    <td align="left"><?=$_SESSION['booked']['proj_code']?></td>
  </tr>
  <tr bgcolor="#f8fbc1">
    <td style="padding:5px;" align="right">Section Name : </td>
    <td align="left"><?=$_SESSION['booked']['section_no']?></td>
  </tr>
  <tr bgcolor="#f8fbc1">
    <td style="padding:5px;" align="right">Plot No : </td>
    <td align="left"><?=$_SESSION['booked']['flat_no']?></td>
  </tr>
 
 

  
  
</table>

<? if(isset($booked)){?>
<table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#3f590a" bgcolor="#c7eb8e" style="border:1px solid #3f590a; border-collapse:collapse; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px; color:#000000;">
  <tr bgcolor="#679435">
    <td width="100%" align="center" bgcolor="#FF3300" style="padding:3px; font-weight:bold;  font-size:13px; color:#FFFFFF;">Congratulation!!! Your Flat is <?=$_SESSION['booked']['type']?>!!! </td>
  </tr>
</table>
<? }else{?>
<form id="form1" name="form1" method="post" action="">
   <tr bgcolor="#f8fbc1">
    <td style="padding:5px;" align="right">Booking Date  : </td>
    <td align="left"><input name="booked_on" id="booked_on" type="date" value="<?=$_POST['booked_on'];?>"/>
</td>
  </tr> 
  
  <tr bgcolor="#f8fbc1">
    <td style="padding:5px;" align="right">Sales Person  : </td>
    <td align="left"><select name="sales_person" id="sales_person">
      <? foreign_relation('personnel_basic_info','PBI_ID','concat(PBI_ID,"-",PBI_NAME)',$sales_person,'PBI_ORG="5" 
				and PBI_JOB_STATUS="In Service" order by PBI_ID'); ?>
    </select></td>
  </tr>
  <input name="submit" type="submit" id="submit" value="Confirm <?=$_SESSION['booked']['type']?>!!!" />
</form>
<? }?>
