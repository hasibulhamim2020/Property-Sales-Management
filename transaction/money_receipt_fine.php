<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once SERVER_CORE."routing/layout.top.php";

$proj_id=$_SESSION['proj_id'];
$user_id=$_SESSION['user']['id'];
$title='Money Receipt';


/*function find1($sql){
	
	$res=@db_query($sql);
	$count=@mysqli_num_rows($res);
	if($count>0)
	{
	$data=@mysql_fetch_row($res);
	return $data[0];
	}
	else
	return NULL;
	}*/




if($_POST['flat']>0){
$flat=$_POST['flat'];
$_SESSION["fid"] = $flat;
$sql="select a.*,b.team_leader,b.sr_executive,b.group_leader,b.others,b.non_insentive,b.payment_type 
from tbl_flat_info a,tbl_party_info b where a.party_code=b.party_code and fid=".$flat." limit 1";

$q=db_query($sql);

if(mysqli_num_rows($q)>0)
$data=mysqli_fetch_object($q);
$flat_no=$data->flat_no;
}
do_calander('#c_date');




if(isset($_POST['save'])){

$building		=$_REQUEST['building'];
$flat			=$_REQUEST['flat'];
$flat_no		=$_REQUEST['flat_no'];
$rec_date		=$_SESSION['rec_date']	=$_REQUEST['rec_date'];
$amount			=$_REQUEST['amount'];
$rec_date		=$_REQUEST['rec_date'];
$party_code		=$_REQUEST['party_code'];
$pay_mode		=$_REQUEST['pay_mode'];
$cheq_no		=$_REQUEST['c_no'];
$cheq_date		=$_REQUEST['c_date'];
$bank_name		=$_REQUEST['bank'];
$branch			=$_REQUEST['branch'];
$manual_no		=$_REQUEST['manual_no'];
$remarks		=$_REQUEST['remarks'];

$get_mode		=$_REQUEST['get_mode'];
$pay_code		=$_REQUEST['pay_code'];
$inst_no		=$_REQUEST['inst_no'];


$entry_by=$_SESSION['user']['id'];
$rec_no=next_value('rec_no','tbl_fine');


$sql="INSERT INTO tbl_fine 
(rec_no,manual_no,fid,rec_date,party_code,pay_code,inst_no,narration,get_mode,pay_mode,cheq_no,cheq_date,bank_name,branch,amount,entry_by) 
VALUES 
('$rec_no','$manual_no','$flat', '$rec_date', '$party_code', '$pay_code', '$inst_no','$remarks','$get_mode','$pay_mode','$cheq_no','$cheq_date', '$bank_name', '$branch', '$amount', '$entry_by')";
db_query($sql);


} // end save



?>

<script type="text/javascript" src="../../js/receipt_install.js"></script>





<style>
.datagtable
{
border-bottom:1px solid #CCC;
}
.datagtable td
{
border-left:1px solid #CCC;
}
.datagtable input
{
border:0;	
}
.deleted, .deleted input
{
background:#F00;
color:#FFF;
}
img
{border:0px;}
</style>
<div class="form-container">

<form id="form1" name="form1" method="post" action="">

  <table width="100%" border="0" cellpadding="0" cellspacing="0">

    <tr>

      <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

          <tr>

            <td><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

                <tr>

                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

                    <tr>

                      <td valign="top">

						<fieldset>

						<legend>Project Details</legend>

						<div>

						<label>Project : </label>

						<select name="proj_code" id="proj_code" onchange="getData2('../../common/section_option_mhafuz.php', 'bld', document.getElementById('proj_code').value,this.value);">

						<? if(isset($_REQUEST['proj_code'])) $proj_code=$_REQUEST['proj_code'];

						foreign_relation('tbl_project_info','proj_code','proj_name',$proj_code);?>
						</select>
						</div>

					   <div>

                                          <label for="email">Section : </label>

											<span id="bld">

											<select name="section_name" id="section_name" onchange="getData2('../../common/flat_option_mhafuz.php', 'fid', document.getElementById('proj_code').value,this.value);">

											<? if(isset($_REQUEST['section_name'])) $section_name=$_REQUEST['section_name'];

											foreign_relation('add_section','section_id','section_name',$section_name);

											

											?>
											</select>
											</span> </div>

						   <div>

                                          <label for="fname">Allotment. : </label>

                                          <span id="fid">

                                         

										  <?

										  if($_POST['flat']>0){

										  

										  ?>

                                          <select name="flat" id="flat">

                                            <? foreign_relation('tbl_flat_info','fid','CONCAT("RN :", road_no ,"/", "PN ", flat_no)',$flat);?>
                                          </select>

										  

										  <? }else{

										  ?>

										  <select name="flat" id="flat">

                                            <option value=""></option>
                                          </select>

										  <?

										  } ?>
                                        </span></div>

						<div class="buttonrow">

						<input name="search" type="submit" class="btn1" id="search" value="Search details " />

						<input  name="flat_no" type="hidden" id="flat_no" readonly="readonly" value="<?=$flat_no?>"/>
						</div>
						</fieldset>



							<fieldset style="background-color:#99CCCC">

                                        <legend>Client Details</legend>

                                        <div><span id="bld">



                                        <span class="style3" style="font-size:14px; color:#FF6600">

                                        <?

if(isset($data->party_code)&&$data->party_code!=''){

$sql="select a.* from tbl_party_info a where a.party_code=".$data->party_code." limit 1";

$i=db_query($sql);

if(mysqli_num_rows($i)>0){

$info=mysqli_fetch_object($i);

echo $client_info=$info->party_name.'<br />'.$info->pre_house.'<br/>'.$info->ah_mobile_tel;}

}

?>
                                        </span>   

<input name="party_code" type="hidden" id="party_code" value="<?=$data->party_code?>"  />

										</span>                                        </div>
                                        </fieldset>					 </td>

                      <td valign="top">

						<fieldset>

						<legend>Receipt Details</legend>

						<div>

						<label>Receipt No. : </label>

						<input  name="receipt_no" type="text" id="receipt_no" value="<?=next_value('rec_no','tbl_fine')?>"/>
						</div>
						
						
						<div>

						<label>Manual No. : </label> 

						<input  name="manual_no" type="text" id="manual_no" value=""/>
						</div>

						<div>

						<label for="email">Receipt Date :  </label>

						<input  name="rec_date" type="text" id="rec_date" value="<?=($_SESSION['rec_date']=='')?date('Y-m-d'):$_SESSION['rec_date'];?>"/>
						</div>
						</fieldset>

					  <br />

						<fieldset>

						<legend>Receipt Details</legend>

						

						<div>

						<table width="100%" border="0" cellspacing="0" cellpadding="0">

						<tr>

						<td align="right">Payment Mode: </td>

<td><select name="pay_mode" id="pay_mode" required style="width: 89px;">
<option value="1">Cheque/PO</option>
<option value="0">Cash</option>
<option value="2">Bank Transfer</option>
<option value="3">Discount</option>

</select>                                </td>
						</tr>

						<tr>

						<td><div align="right">Cheque/PO No. :</div></td>

						<td><input  name="c_no" type="text" id="c_no" value=""/></td>
						</tr>

						<tr>

						<td><div align="right">Cheque Date :</div></td>

						<td><input  name="c_date" type="text" id="c_date" value=""/></td>
						</tr>

						<tr>

						<td><div align="right">Bank Name :</div></td>

						<td>

						<select name="bank" id="bank" style="width: 89px;">

						<?

						foreign_relation('tbl_bank','bank','bank','bank');

						?>
						</select>								</td>
						</tr>

						<tr>

						<td><div align="right">Branch :</div></td>

						<td><input  name="branch" type="text" id="branch" value=""/></td>
						</tr>
						<tr>

						<td><div align="right">Remarks : </div></td>

						<td><textarea name="remarks" id="remarks" style="width: 83px; height: 30px;"></textarea></td>
						</tr>
						</table>
						</div>
						</fieldset>					  </td>

                      <td valign="top">

					  <div class="tabledesign1">

						                               <table cellspacing="0" cellpadding="0" width="100%">

                                <tr>

                                  <th>No</th>

                                  <th>Type</th>
                                  <th>Amount</th>

                                  <th>Print</th>
                                </tr> <?

if(isset($flat)){
$sql1="select b.rec_no,b.get_mode,b.amount 
from tbl_fine b, tbl_flat_info c 
where  b.fid=c.fid and c.fid=".$flat." 
order by rec_no desc limit 5";

$query1=db_query($sql1);
if(mysqli_num_rows($query1)>0){
while($report=mysqli_fetch_object($query1)){
?>
<tr class="alt">
<td><?=$report->rec_no;?></td>
<td><?=$report->get_mode;?></td>
<td><?=$report->amount;?></td>

<td><a href="../../common/voucher_print.php?rec_no=<?= $payable[0];?>&fid=<?=$flat?>&rec_date=<?=$payable[2]?>" target="_blank">
<img src="../../images/print.png" width="16" height="16" border="0"></a></td>
</tr>
<? }}}?>
</table>

</div></td>
</tr>
<tr width="100%">
<td valign="top" colspan="2">
<tr>

<td valign="top">	</td>
<td valign="top">	 </td>
<td valign="top">	 </td>
</tr>
</table></td>

                </tr>

                <tr>

                  <td>&nbsp;</td>

                </tr>

                <tr>

                  <td>  

				  <table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">

                      <tr>

                        <td align="center">Payment Head </td>
                          <td align="center">Installment No. </td>
                          <td align="center">Type</td>
                          <td align="center">Receive Amount</td>
</tr>
<tr>

<td align="center"><select name="pay_code" id="pay_code" class="input3" style="width:200px;" 
onchange="getData2('ajax_ins.php', 'inst_no', this.value,  this.value)">
<? 
$sql='select distinct a.pay_code,a.pay_desc
from tbl_payment_head a, tbl_flat_cost_installment b,tbl_flat_info c 
where 
a.pay_code=b.pay_code 
and b.fid=c.fid and c.fid='.$flat;
join_relation($sql,'');?>
</select></td>

<td align="center">
<span id="inst_no">
<select name="inst_no" id="inst_no">
</select>
</span></td>
<td align="center"><select name="get_mode" id="get_mode" required="required" style="width: 89px;">
  <option>Weaver</option>
  <option>Receive</option>
</select></td>
<td align="center"><input name="amount" type="text" id="amount" tabindex="11" class="input3" style="width:100px;"/></td>
</tr>
</table></td>
</tr>
<tr>

<td>&nbsp;</td>
</tr>
<tr>
<td>

<table width="200" border="0" cellspacing="0" cellpadding="0" align="center">

					  <tr>

						<td>

<div class="button">
<input name="save" type="submit" class="btn" id="save" value="Submit" />

</div>

						</td>

					  </tr>

					</table>



				  </td>

                </tr>

            </table></td>

          </tr>

      </table></td>

    </tr>

  </table>

</form>

</div>




<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>

