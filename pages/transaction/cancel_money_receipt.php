<?php
session_start();
ob_start();
require "../../support/inc.all.php";
$title='Cancle Allotment';

//echo $proj_id;


if(isset($_POST['view'])){
$m_r_no = $_POST['m_r_no'];
$select = 'select * from tbl_receipt where rec_no='.$_POST['m_r_no'];
$query = mysql_query($select);
$row = mysql_fetch_object($query);
}

// ------------------ delete

if(isset($_POST['cancel'])){
	$m_r_no = $_POST['m_r_no'];
	
	$select = 'select * from tbl_receipt_details where rec_no='.$_POST['m_r_no'];
	$query = mysql_query($select);
	//$row = mysql_fetch_object($query);
	
	
while($row= mysql_fetch_object($query)){

		$s_u = "insert into  delete_money_receipt_log (money_r_no,fid,rcv_amount,user_id)
		values('".$m_r_no."','".$row->fid."','".$row->rec_amount."','".$_SESSION['user']['id']."')";
		mysql_query($s_u);
		
	$select = 'update tbl_flat_cost_installment 
		 set rcv_status="0",rcv_date="",rcv_amount=rcv_amount-'.$row->rec_amount.',
		 non_insentive=(non_insentive-'.$row->non_insentive_commission.'),
		 sr_executive_commission=(sr_executive_commission-'.$row->sr_executive_commission.'),
		 team_leader_commission=(team_leader_commission-'.$row->team_leader_commission.'),
		 group_leader_commission=(group_leader_commission-'.$row->group_leader_commission.'),
		 other_commission=(other_commission-'.$row->other_commission.') 
		
		where fid="'.$row->fid.'" and pay_code="'.$row->pay_code.'" and inst_no="'.$row->inst_no.'" ';
		mysql_query($select);
		
		
// log insert
$log_in = 'insert into tbl_receipt_history(
rec_no, manual_no, fid, rec_date, manual_date, party_code, proj_code, build_code, 
flat_no, narration, pay_mode, cheq_no, cheq_date, bank_name, branch, rec_amount, 
entry_by, entry_date, edit_by, edit_date, stat, 
check_realize_reason, check_realize_status, remarks
) 
select *
from tbl_receipt 
where rec_no="'.$m_r_no.'"
';
mysql_query($log_in);
// end log		
		
		
		$s = "DELETE FROM `tbl_receipt` WHERE `tbl_receipt`.`rec_no` =".$m_r_no;
		mysql_query($s);
		
		
		$s = "DELETE FROM `tbl_receipt_details` WHERE `tbl_receipt_details`.`rec_no`=".$m_r_no;
		mysql_query($s);
		
		$s = "DELETE FROM secondary_journal WHERE tr_from='Collection' and tr_no=".$m_r_no;
		mysql_query($s);
		
		$s = "DELETE FROM journal WHERE tr_from='Collection' and tr_no=".$m_r_no;
		mysql_query($s);
				
		
} // while

$success = "Canceled Money Receipt Successfully !!";

}





?>
<style type="text/css">
<!--
.style1 {color: #000000}
-->
</style>

  
  <script type = "text/javascript">
    var GB_ROOT_DIR = "../../greybox/";
  </script>
  <script type = "text/javascript" src = "../../greybox/AJS.js"></script>
  <script type = "text/javascript" src = "../../greybox/AJS_fx.js"></script>
  <script type = "text/javascript" src = "../../greybox/gb_scripts.js"></script>
  <link href = "../../greybox/gb_styles.css" rel = "stylesheet" type = "text/css" media = "all"/>
  
  <div class="form-container_large">
  <form id="form1" name="form1" method="post" action=""  onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td align="center"> 
					<fieldset>
					<legend>Cancle Money Receipt</legend>
				  <div>

                                          <label>Money Receipt No : </label>

<input type="number" name="m_r_no"  value="<?=$m_r_no?>"/>

                                  </div>

					   
					  
					
					<div class="buttonrow">
					<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
					<tr>
					<td width="12%">&nbsp;</td>
					<td>
					<input name="view" type="submit" id="view" value="View"/><br>
					<input name="cancel" type="submit" id="transfer" value="Delete"/>
					
					
					</td>
					<td width="20%">&nbsp;</td>
					</tr>
					
					
					
					</table>
					</div>
					</fieldset>	  </td>
    </tr>
    <tr>
      <td align="center">&nbsp;</td>
    </tr>
    <tr>
	
			
<? if($success){?>
<tr>
<td colspan="3">
<div align="center">
<input type="submit"  name="test" value="<?=$success?>" style="width: 300px; background: red; margin-left: 220px; height: 40px; color: white; font-weight:bold; "/>			
</div></td>
</tr>
<? } ?>


<? if(isset($_POST['view'])){ ?>
<table width="100%" border="1">
  <tr>
    <th scope="col">Date</th>
    <th scope="col">Money Rec NO</th>
    <th scope="col">Flat Info</th>
    <th scope="col">Client Name</th>
    <th scope="col">Amount</th>
  </tr>
  <tr>
    <td><?=$row->rec_date?></td>
    <td><?=$m_r_no?></td>
    <td><?=$row->flat_no?></td>
    <td><?=find_a_field('tbl_party_info','party_name','id="'.$row->party_code.'"');?></td>
    <td><?=$row->rec_amount?></td>
  </tr>
</table>

<? } ?>

			
					
      <td></td>
    </tr>
  </table>
  <label>
  <div align="center"></div>
  </label>
  </form>
  </div>
  <?
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout.php");
?>
