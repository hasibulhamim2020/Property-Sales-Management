<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once SERVER_CORE."routing/layout.top.php";

$proj_id=$_SESSION['proj_id'];
$user_id=$_SESSION['user']['id'];
$title='Money Receipt';







if($_POST['flat']>0){
$flat=$_POST['flat'];
$sql="select a.*,b.team_leader,b.sr_executive,b.group_leader,b.others,b.non_insentive,b.payment_type 
from tbl_flat_info a,tbl_party_info b where a.party_code=b.party_code and fid=".$flat." limit 1";

$q=db_query($sql);

if(mysqli_num_rows($q)>0)
$data=mysqli_fetch_object($q);
$flat_no=$data->flat_no;
}
do_calander('#c_date');


if(isset($_POST['save'])&&$_REQUEST['count']>0){

$c 			=$_REQUEST['count'];
$proj_code	=$_REQUEST['proj_code'];
$building	=$_REQUEST['building'];
$flat		=$_REQUEST['flat'];
$flat_no	=$_REQUEST['flat_no'];
$rec_date	=$_SESSION['rec_date']=$_REQUEST['rec_date'];
$total_amount=$_REQUEST['total_amount'];
$rec_date=$_REQUEST['rec_date'];
$party_code=$_REQUEST['party_code'];
$pay_mode=$_REQUEST['pay_mode'];
$cheq_no=$_REQUEST['c_no'];
$cheq_date=$_REQUEST['c_date'];
$bank_name=$_REQUEST['bank'];
$branch=$_REQUEST['branch'];
$manual_no=$_REQUEST['manual_no'];
$remarks=$_REQUEST['remarks'];
$non_insentive=0;
$group_leader_commission=0;
$team_leader_commission=0;
$sr_executive_commission=0;
$other_commission=0;

$msql = 'select * from tbl_party_info where party_code='.$party_code;
$mquery = db_query($msql);
$party = mysqli_fetch_object($mquery);

if($party->group_leader>0&&$party->team_leader>0&&$party->sr_executive>0){
$non_insentive_per='0';
$group_leader_per='0.0010';
$team_leader_per='0.0010';
$sr_executive_per='0.0065';
$other_per='0.0015';
}
elseif($party->group_leader>0&&$party->team_leader>0&&$party->sr_executive<1){
$non_insentive_per='0';
$group_leader_per='0.0010';
$team_leader_per='0.0075';
$sr_executive_per='0.00';
$other_per='0.0015';
}
elseif($party->group_leader>0&&$party->team_leader<1&&$party->sr_executive<1){
$non_insentive_per='0';
$group_leader_per='0.0085';
$team_leader_per='0';
$sr_executive_per='0';
$other_per='0.0015';
}
elseif($party->group_leader<1&&$party->team_leader<1&&$party->sr_executive<1){
$non_insentive_per='0';
$group_leader_per='0';
$team_leader_per='0';
$sr_executive_per='0';
$other_per='0.0015';
}

$p_by=$_SESSION['user']['id'];
$rec_no=next_value('rec_no','tbl_receipt');
for($j=1; $j <= $c; $j++)  //data insert loop
{
if($_REQUEST['deleted'.$j] == 'no')
{

			$pay_code 	= $_REQUEST['a'.$j];		

			$desc	= $_REQUEST['b'.$j];	

			$no_inst	= $_REQUEST['c'.$j];

			$inst_amt 	= $_REQUEST['d'.$j];		

			$rec_amount	= $_REQUEST['e'.$j];

			$fid	= $_REQUEST['f'.$j];

if($pay_code==98)
{$non_insentive_commission=0;
$group_leader_commission=0;
$team_leader_commission=0;
$sr_executive_commission=0;
$other_commission=0;}
else

{$non_insentive_commission=$rec_amount*$non_insentive_per;
$group_leader_commission=$rec_amount*$group_leader_per;
$team_leader_commission=$rec_amount*$team_leader_per;
$sr_executive_commission=$rec_amount*$sr_executive_per;
$other_commission=$rec_amount*$other_per;}

$sql2="INSERT INTO `tbl_receipt_details` (`rec_no`, 
`pay_code`, 
`inst_no`,
`fid`,  
`inst_amount`, 
`rec_amount`,`p_by`,`remarks`,
non_insentive_commission  ,
sr_executive_commission ,
team_leader_commission ,
group_leader_commission ,
other_commission  
) VALUES ('$rec_no','$pay_code', '$no_inst','$flat', '$inst_amt', '$rec_amount','$p_by','$remarks',
'".$non_insentive_commission."' ,
'".$sr_executive_commission."' ,
'".$team_leader_commission."' ,
'".$group_leader_commission."' ,
'".$other_commission."'
)";
db_query($sql2);

if($inst_amt==$rec_amount) 
{$add_sql=", rcv_status = 1 ";} 

$sql3="UPDATE `tbl_flat_cost_installment` SET `rec_no` = '".$rec_no."',`rcv_date` = '".$rec_date."', rcv_amount = (rcv_amount + '".$rec_amount."') ,
non_insentive = (non_insentive + '".$non_insentive."') ,
  sr_executive_commission = (sr_executive_commission + '".$sr_executive_commission."') ,
  team_leader_commission = (team_leader_commission + '".$team_leader_commission."') ,
  group_leader_commission = (group_leader_commission + '".$group_leader_commission."') ,
  other_commission = (other_commission + '".$other_commission."') 
".$add_sql."
WHERE `fid` = ".$flat." AND  `pay_code` = ".$pay_code." AND `inst_no` = ".$no_inst." LIMIT 1";
db_query($sql3);
}
}

$sql="INSERT INTO `tbl_receipt` 
(proj_code,`rec_no`, `rec_date`, `party_code`, `flat_no`, `narration`, `pay_mode`, `cheq_no`,`fid`, `cheq_date`, `bank_name`, `branch`, `rec_amount`,`manual_no`,
`remarks`) VALUES 
('$proj_code','$rec_no', '$rec_date', '$party_code','$flat_no', '$desc', '$pay_mode', '$cheq_no','$flat', '$cheq_date', '$bank_name', '$branch', '$total_amount', '$manual_no','$remarks')";
db_query($sql);
$now=time();

$select  = "select fid, sum(inst_amount) as total_p, sum(rcv_amount) as total_r, (sum(inst_amount)-sum(rcv_amount)) as total_due_amt from tbl_flat_cost_installment where fid='".$flat."' group by fid";
$q = db_query($select);
$r = mysqli_fetch_object($q);
if($r->total_due_amt<=0){
$select = "update tbl_flat_info set status='Sold' where fid='".$flat."'";
db_query($select);
}
 $t_twintyfive_percentage = (($r->total_p/100)*25);
 $t_nintynine_percentage = (($r->total_p/100)*99);

if($r->total_r<$t_twintyfive_percentage){
$status = "update tbl_flat_info set sr_status='BOOKING' where fid='".$flat."'";
db_query($status);
}elseif($r->total_r<$t_nintynine_percentage){
$status = "update tbl_flat_info set sr_status='AGREEMENT' where fid='".$flat."'";
db_query($status);
}else{
$status = "update tbl_flat_info set sr_status='SOLD' where fid='".$flat."'";
db_query($status);
}





// start sec journal 
$jv_no = next_journal_sec_voucher_id33();
$flat_info = find_all_field('tbl_flat_info','*','fid='.$flat);

$party_acc = $flat_info->acc_no;
$party_code = $flat_info->party_code;
$party_name = find_a_field('tbl_party_info','party_name','party_code='.$party_code);
$cc_code = find1('select p.proj_cc from tbl_project_info p, tbl_flat_info f where p.proj_code=f.proj_code and f.fid="'.$flat.'"');

if ($pay_mode=='0'){ // Cash
$dr_head = '1145000100040000'; 
$narration_dr = 'Received From '.$party_name.',Against:'.$flat_no;
$narration_cr = 'MR no:'.$rec_no.' Against:'.$flat_no.'.MMR:'.$manual_no;

}elseif ($pay_mode=='4'){ // Adjustment
$dr_head = '4081000100170000'; 
$narration_dr = 'Adjustment For '.$party_name.',Against:'.$flat_no;
$narration_cr = 'MR no:'.$rec_no.' Against:'.$flat_no.'.MMR:'.$manual_no;

}elseif ($pay_mode=='3'){ // Discount
$dr_head = '4082000100560000'; 
$narration_dr = 'Discount For '.$party_name.',Against:'.$flat_no;
$narration_cr = 'MR no:'.$rec_no.' Against:'.$flat_no.'.MMR:'.$manual_no;
}else { 
$dr_head ='1147000200020000'; // cheque and others
$narration_dr = 'Received From '.$party_name.',Against:'.$flat_no.'.CQ No:'.$cheq_no.'.CQ Date:'.$cheq_date.'.Bank: '.$bank_name;
$narration_cr = 'MR no:'.$rec_no.' Against:'.$flat_no.'.MMR:'.$manual_no.'.CQ No:'.$cheq_no.'.CQ Date:'.$cheq_date.'.Bank: '.$bank_name;
}
$page_for='Collection';
$oi_no=$rec_no;

add_to_sec_journal33($proj_id, $jv_no, strtotime($rec_date), $dr_head , $narration_dr, $total_amount, 0, $page_for, $oi_no,'','',$cc_code);
add_to_sec_journal33($proj_id, $jv_no, strtotime($rec_date), $party_acc, $narration_cr, 0, $total_amount, $page_for, $oi_no,'','',$cc_code);

// end sec journal




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

										

                                        </fieldset>	

					

					 </td>

                      <td valign="top">

						<fieldset>

						<legend>Receipt Details</legend>

						<div>

						<label>Receipt No. : </label>

						<input  name="receipt_no" type="text" id="receipt_no" value="<?=next_value('rec_no','tbl_receipt')?>"/>

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
<option value="4">Adjustment</option>
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
                          <td><div align="right">Total Amount : </div></td>
						  <td><input  name="total_amount" type="text" id="total_amount" value="" readonly="readonly"/></td>
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

                                  <th>Last 3 Receipt No</th>

                                  <th>Rec Amount</th>

                                  <th>Print</th>

                                </tr> <?

						  if(isset($flat)){

$sql1="select b.rec_no,sum(b.rec_amount),b.rec_date from tbl_receipt b,tbl_flat_info c where  b.fid=c.fid and c.fid=".$flat." group by rec_no order by rec_no desc limit 3";

$query1=db_query($sql1);

						  if(mysqli_num_rows($query1)>0)

						  {

while($payable=mysql_fetch_row($query1)){

						  ?>

                               

                                <tr class="alt">

                                  <td><?=$payable[0]?></td>

                                  <td><?=$payable[1]?></td>

<td><a href="../../common/voucher_print.php?rec_no=<?= $payable[0];?>&fid=<?=$flat?>&rec_date=<?=$payable[2]?>" target="_blank"><img src="../../images/print.png" width="16" height="16" border="0"></a></td>

                                </tr>

							 <? }}}?>

                              </table>
<? if(isset($flat)){

$sql1="select sum(b.inst_amount),sum(b.rcv_amount) from tbl_flat_cost_installment b,tbl_flat_info c where  b.fid=c.fid and c.fid=".$flat;

$query1=db_query($sql1);

						  if(mysqli_num_rows($query1)>0)

						  {

$payable=mysql_fetch_row($query1);

						  ?>

						   <table cellspacing="0" cellpadding="0" width="100%">

                                <tr>

                                  <th width="114">Descriprion</th>

                                  <th>Amount</th>

                                </tr>

                                <tr class="alt">

                                  <td>Total Payable </td>

                                  <td><?=$payable[0]?></td>

                                </tr>

                                <tr>

                                  <td>Total Paid </td>

                                  <td><?=$payable[1]?></td>

                                </tr>

                                <tr class="alt">

                                  <td>Total Due </td>

                                  <td><?=($payable[0]-$payable[1])?></td>

                                </tr>

                          </table>

							 <? }}?>

                          </div>					  </td>

                    </tr>

					<tr width="100%">

									 <td valign="top" colspan="2">

                                        <legend>Commission Detail</legend>

										
                                                
										<input type="hidden" value="<?=$data->sr_executive_commission?>" name="sr_executive_commission1" id="sr_executive_commission1" />

										<input type="hidden" value="<?=$data->non_insentive?>" name="non_insentive1" id="non_insentive1" />

										<input type="hidden" value="<?=$data->team_leader_commission?>" name="team_leader_commission1" id="team_leader_commission1" />

										<input type="hidden" value="<?=$data->group_leader_commission?>" name="group_leader_commission1" id="group_leader_commission1" />

										<input type="hidden" value="<?=$data->other_commission?>" name="other_commission1" id="other_commission1" />
<tr>

										<td>Sr Executive :</td>

										<td>

										<select name="sr_executive" id="sr_executive">

                                           <? foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME',$data->sr_executive);?>

										   </select>

										   </td>

										<td>
										
										<input  name="sr_executive_commission" type="text" id="sr_executive_commission" value="" />
                                      
							</td>
										</tr>

										<tr width="20px;">

										<td>Non Insentive :</td>

										<td>

										<select name="non_insentive" id="non_insentive">

                                           <? foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME',$data->non_insentive);?>

										   </select>

										</td>

										<td>

										

						<input  name="non_insentive_commission" type="text" id="non_insentive_commission" value="" />
						

										</td>

										</tr>


										<tr>

										<td>

										Team Leader :

										</td>

										<td>
										 <select name="team_leader" id="team_leader">

                                             <? foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME',$data->team_leader);?>

											 </select>

										</td>

										<td>
												<input  name="team_leader_commission" type="text" style=" margin-left:auto" id="team_leader_commission" value=""/>
								</td>
										</tr>

										<tr>
										<td>
										Group Leader :
										</td>
										<td>
										 <select name="group_leader" id="group_leader">
                                              <? foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME',$data->group_leader);?>
											  </select>
										</td>

										<td>
										<input  name="group_leader_commission" type="text" id="group_leader_commission" value="" />
										</td>

										</tr>

										<tr>

										<td>Others :</td>

										<td>

										<select name="others" id="others">

                                            <option>Others</option></select>

											</td>
										<td>
                                          <input  name="other_commission" type="text" id="other_commission" value="" />

										 							

										</td>

										</tr>


                    <tr>

                      <td valign="top">					  					  </td>

                      <td valign="top">					  					  </td>

                      <td valign="top">					  					  </td>

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

                          <td align="center">Installment Date </td>

                          <td align="center">Installment Amount</td>

                          <td align="center">Receive Amount</td>

                          <td  rowspan="2" align="center">

						  <div class="button">

						  <input name="add" type="button" id="add" value="ADD" tabindex="12" class="update" onclick="check();"/>                       
</div></td>
</tr>
<tr>

<td align="center"><select name="pay_code" id="pay_code" class="input3" style="width:200px;" onchange="set_install(<?=$flat?>,this.value);">
<? 
echo $sql='select distinct a.pay_code,a.pay_desc 
from tbl_payment_head a, tbl_flat_cost_installment b,tbl_flat_info c 
where 
a.pay_code=b.pay_code 
and b.fid=c.fid and c.fid='.$flat;
join_relation($sql,'');?>
</select></td>
<td align="center">
<span id="inst_no">
<input name="installment_no" type="text" id="installment_no" style="width:100px;"  tabindex="9" class="input3"/>
</span></td>
<td> 
<span id="inst_date">                      
<input name="desc" type="text" class="input3" id="desc"  maxlength="100" style="width:100px;" readonly="readonly"/>
</span>						  </td>
 <td align="center">

<span id="inst_amt">

<input name="installment_amt" type="text" id="installment_amt"  tabindex="10" class="input3" style="width:100px;" readonly /> 

</span>                          </td>

						 

						  

<td align="center"><input name="receive_amt" type="text" id="receive_amt" tabindex="11" class="input3" style="width:100px;"/></td>

                        </tr>

                      <tr>

                        <td colspan="6" align="left"><span id="tbl">

<table id="rowid<?=$count;?>" class="table_normal1" width="97%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #C1DAD7;" cellpadding="2" cellspacing="2">

<tr align="left" id="rowid<?=$count;?>" height="30">

<td>&nbsp;</td>

<td>&nbsp;</td>

<td>&nbsp;</td>

<td>&nbsp;</td>

<td>&nbsp;</td>

<td width="100"></tr>		

</table>

                          </span> </td>

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

<input name="count" id="count" type="hidden" value="<? if(isset($count)&&$count>0) echo $count;?>" />

<input name="save" type="submit" class="btn" id="save" value="Update All Information" onclick="check_ability()" />

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

