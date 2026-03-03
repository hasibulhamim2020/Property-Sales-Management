<?php
session_start();
ob_start();
require "../../support/inc.all.php";
$title='Money Receipt View';
if($_POST['del']&&$_POST['del_rec_no']>0)
{
$del_rec_no=$_POST['del_rec_no'];
$sql="select a.pay_code,a.inst_no,a.inst_amount,a.rec_amount,b.proj_code,b.build_code,b.flat_no from tbl_receipt_details a,tbl_receipt b where a.rec_no=".$del_rec_no." and a.rec_no=b.rec_no";

$query=mysql_query($sql);
	if(mysql_num_rows($query)>0)
	{
		while($data=mysql_fetch_object($query))
		{
		$pay_code=$data->pay_code;
		$inst_no=$data->inst_no;
		$inst_amount=$data->inst_amount;
		$rec_amount=(int)$data->rec_amount;
		$proj_code=$data->proj_code;
		$build_code=$data->build_code;
		$flat_no=$data->flat_no;
		$sql_old="select b.rec_no,b.rec_date from tbl_receipt_details a,tbl_receipt b where a.pay_code='$pay_code' and  a.inst_no='$inst_no' and b.proj_code='$proj_code' and  b.build_code='$build_code' and  b.flat_no='$flat_no' and a.rec_no<".$del_rec_no." and a.rec_no=b.rec_no order by a.rec_no desc limit 1";
		$query_old=mysql_query($sql_old);
		if(mysql_num_rows($query_old)>0)
		$data_old=mysql_fetch_object($query_old);
		else $data_old=NULL;
			if($data_old)
			$old_rec_info="rcv_date='".$data_old->rec_date."', rec_no='".$data_old->rec_no."'";
			else
			$old_rec_info="rcv_date='0000-00-00', rec_no='0'";
$update_tbl_flat_cost_installment="update tbl_flat_cost_installment set rcv_amount=(rcv_amount-".$rec_amount."),rcv_status='0' , ".$old_rec_info." where  proj_code='$proj_code' and  build_code='$build_code' and  flat_no='$flat_no' and  pay_code='$pay_code' and  inst_no='$inst_no' limit 1";

mysql_query($update_tbl_flat_cost_installment);
		}
	}
$delete_tbl_receipt="delete from tbl_receipt where rec_no='".$del_rec_no."'";
$delete_tbl_receipt_detail="delete from tbl_receipt_detail where rec_no='".$del_rec_no."'";
mysql_query($delete_tbl_receipt);
mysql_query($delete_tbl_receipt_detail);
}
?>
<style type="text/css">
<!--
.style1 {
	color: #000000;
	font-size: 12px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
}
-->
</style>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td>
	  <div class="form-container_large">       
	  <form id="form1" name="form1" method="post" action="">
        <table width="88%" border="0" cellspacing="0" cellpadding="0" align="center">
          <tr>
            <td>
				<fieldset>
				<legend>Project Details</legend>
				<div>
				<label>Project : </label>
				<select name="proj_code" id="proj_code">
				<? if(isset($_REQUEST['proj_code'])) $proj_code=$_REQUEST['proj_code'];
				foreign_relation('tbl_project_info','proj_code','proj_name',$proj_code);?>
				</select>
				</div>
				<div>
				<label for="email">Section: </label>
				<span id="bld">
				<select name="section_name" id="section_name" onchange="getData2('../../common/flat_option_mhafuz.php', 'fid', document.getElementById('proj_code').value,this.value);">
											<? 
											foreign_relation('add_section','section_id','section_name',$section_name);
											
											?>
											</select>
				</span>                                        </div>
				<div>
				<label for="fname">Plot no. : </label>
				<? if(isset($_REQUEST['flat'])) $flat=$_REQUEST['flat'];
if(isset($_REQUEST['proj_code'])) $con='proj_code='.$_REQUEST['proj_code'];
?>
				<span id="fid">
                    <select name="flat" id="flat">
                      <? foreign_relation('tbl_flat_info','fid','flat_no',$flat,$con);?>
                    </select>
                  </span>                                        </div>
				<div class="buttonrow" style="margin-left:154px;">
				<input name="payment" type="button" class="btn" id="payment" value="Payment" onclick="getData('../../common/search_client1.php', 'nid', document.getElementById('flat').value);" /></div>
				</fieldset>		  </td>
				<td valign="top" align="right"><fieldset>
                <legend>Client Details</legend>
                <div>
                  <label>Name : </label>
                  <?
if(isset($_POST['payment']))
{
$flat=$_POST['flat'];
$sql="select * from tbl_flat_info where fid=".$flat." limit 1";
$q=mysql_query($sql);
if(mysql_num_rows($q)>0)
$data=mysql_fetch_object($q);


$sql="select a.* from tbl_party_info a where a.party_code=".$data->party_code." limit 1";
$i=mysql_query($sql);
if(mysql_num_rows($i)>0){
$info=mysql_fetch_object($i);
$client_info=$info->party_name;
$address=$info->per_house.', '.$info->per_road .', '.$info->per_village .', '.$info->per_postoffice 	.', '.$info->per_district;
$mobile=$info->ah_mobile_tel;
}
}
?>
                  <input  name="Input" type="text" id="Input" value="<?=$client_info?>"/>
                </div>
                <div>
                  <label for="email">Address : </label>
                  <span id="bld">
                  <textarea name="textarea" id="Input"><?=$address?>
                </textarea>
                </span> </div>
                <div>
                  <label for="fname">Mobile no. : </label>
                  <span id="fid">
                  <input  name="Input" type="text" id="Input" value="<?=$mobile?>"/>
                </span> </div>
				</fieldset></td>
		  </tr>
        </table>
        </form>
	  </div>
		</td></tr>

  <tr>
    <td>      
	<table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
		<tr>
		<td>&nbsp;</td>
		</tr>
        <tr>
          <td valign="top"><span id="nid"></span></td>
        </tr>
      </table></td></tr>

  <tr>
    <td>      
	<table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr><td>&nbsp;</td>
	</tr>
        <tr>
          <td><div class="tabledesign2">
            <span id="iid"></span>
          </div></td>
        </tr>
      </table></td></tr>
</table>
<?
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout.php");
?>