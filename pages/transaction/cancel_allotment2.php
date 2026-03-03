<?php
session_start();
ob_start();
require "../../support/inc.all.php";
if(isset($_POST['submit']))
{
echo $proj_code_t=$_POST['flat_no_f'].'C';
$proj_code_f=$_POST['proj_code_f'];
$category_f=$_POST['category_f'];
$flat_no_f=$_POST['flat_no_f'];
$party_code=$_POST['party_code'];
$booked_on=$_POST['booked_on'];


$sql=mysql_query("update tbl_flat_info set party_code='',booked_on='',status='' where proj_code='$proj_code_f' and build_code='$category_f' and flat_no='$flat_no_f'");//Free the flat

$sql=mysql_query("update tbl_receipt set proj_code='$proj_code_f', build_code='$category_f' ,flat_no='$flat_no_t' where proj_code='$proj_code_f' and build_code='$category_f' and flat_no='$flat_no_f'");// update receive

$sql=mysql_query("update tbl_flat_cost_installment set set proj_code='$proj_code_f', build_code='$category_f' ,flat_no='$flat_no_t'  where proj_code='$proj_code_f' and build_code='$category_f' and flat_no='$flat_no_f'");// update installment
}


$sql='select a.* from tbl_party_info a,tbl_flat_info b where a.party_code=b.party_code and b.fid='.$_POST['flat_no_from'].' limit 1';
$query=mysql_query($sql);
if(mysql_num_rows($query))
{
$data=mysql_fetch_object($query);
}

echo $sql1='select a.proj_name,b.status,b.flat_no,b.booked_on from tbl_project_info a,tbl_flat_info b where a.proj_code=b.proj_code and b.fid='.$_POST['flat_no_from'].' limit 1';
$query1=mysql_query($sql1);
if(mysql_num_rows($query1))
{
$data1=mysql_fetch_object($query1);
}
//var_dump($_SESSION['booked']);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#3f590a" bgcolor="#c7eb8e" style="border:1px solid #3f590a; border-collapse:collapse; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px; color:#000000;">
      <tr bgcolor="#679435">
        <td colspan="2" align="center" bgcolor="#679435" style="padding:3px; font-weight:bold;  font-size:13px; color:#FFFFFF;">Party Information </td>
      </tr>
      <tr bgcolor="#ffffff">
        <td width="39%" align="right" style="padding:5px;">Party Code : </td>
        <td width="61%" align="left"><?=$data->party_code?>&nbsp;</td>
      </tr>
      <tr>
        <td align="right" style="padding:5px;">Party Name : </td>
        <td align="left"><?=$data->party_name?></td>
      </tr>
      <tr bgcolor="#ffffff">
        <td style="padding:5px;" align="right">Party Address : </td>
        <td align="left"><?=$data->per_add?></td>
      </tr>
      <tr>
        <td style="padding:5px;" align="right">Party Contact No. : </td>
        <td align="left"><?=$data->per_tel?></td>
      </tr>
      <tr bgcolor="#ffffff">
        <td style="padding:5px;" align="right">Party Telephone (Off) : </td>
        <td align="left"><?=$data->pre_tel_of?></td>
      </tr>
      <tr bgcolor="#f8fbc1">
        <td colspan="2" align="center" bgcolor="#679435" style="padding:5px;"><span style="padding:3px; font-weight:bold;  font-size:13px; color:#FFFFFF;">Flat Information To Be Cancel </span></td>
      </tr>
      <tr bgcolor="#ffffff">
        <td style="padding:5px;" align="right">Project Code : </td>
        <td align="left"><?=$data1->proj_name?></td>
      </tr>
      
      <tr bgcolor="#ffffff">
        <td style="padding:5px;" align="right">Flat No : </td>
        <td align="left"><?=$data1->flat_no?></td>
      </tr>
    </table></td>
  </tr>
</table>
  <div class="form-container_large">
<form id="form1" name="form1" method="post" action="">
  <table width="30%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
	<? 
	if(isset($_POST['submit'])){?>
	<td class="blue"> <div align="center">Cancelation Completed</div></td>
	<? }else{
	if($data1->status!=''){?>
      <td>
	  <div class="button">
	  <input type="submit" name="submit" value="Confirm Tansfer!!!" />
	  </div>
	  
        <input name="proj_code_f" type="hidden" id="proj_code_f" value="<?=$_POST['proj_code_from']?>" />
        <input name="category_f" type="hidden" id="category_f"  value="<?=$_POST['category_from']?>"/>
        <input name="flat_no_f" type="hidden" id="flat_no_f"  value="<?=$data1->flat_no?>"/>
        <input name="proj_code_t" type="hidden" id="proj_code_t"  value="<?=$_POST['proj_code_to']?>"/>
        <input name="category_t" type="hidden" id="category_t"  value="<?=$_POST['category_to']?>"/>
        <input name="flat_no_t" type="hidden" id="flat_no_t"  value="<?=$data2->flat_no?>"/>
	    <input name="flat_no_to" type="hidden" id="flat_no_to" value="<?=$_POST['flat_no_to']?>" />
      	<input name="flat_no_from" type="hidden" id="flat_no_from" value="<?=$_POST['flat_no_from']?>" />
      	<input name="party_code" type="hidden" id="party_code" value="<?=$data->party_code?>" />
      	<input name="booked_on" type="hidden" id="booked_on" value="<?=$data1->booked_on?>" /></td>
		<? }else{?>
		      <td class="red"> <div align="center">Flat Cannot be Canceled</div></td>
		<? }}?>
    </tr>
  </table>
</form>
</div>
<?
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout.php");
?>