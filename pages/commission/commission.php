<?php
session_start();
ob_start();
require "../../support/inc.all.php";
$title='Investment Setup';
$table='tbl_money_invest_commission';
$page="commission.php";
$unique='invest_code';
$unique2='investor_code';
do_calander('#date');

$crud      =new crud($table);
if(isset($_GET[$unique])) $$unique = $_GET[$unique];

if(isset($_POST[$unique2]))
{
$$unique = $_POST[$unique];
if(isset($_POST['insert']))
{
	
	if($_POST['commission1']>0)
	$_POST['commission_amount1']=($_POST['commission1']*.01)*$_POST['ammount'];
	
	if($_POST['commission2']>0)
	$_POST['commission_amount2']=($_POST['commission2']*.01)*$_POST['ammount'];
	
	if($_POST['commission3']>0)
	$_POST['commission_amount3']=($_POST['commission3']*.01)*$_POST['ammount'];
	
	if($_POST['commission4']>0)
	$_POST['commission_amount4']=($_POST['commission4']*.01)*$_POST['ammount'];
	
	$$unique2 = $_POST[$unique2];
	$$unique3 = $_POST[$unique3];
	$con='where '.$unique.'='.$$unique;
	if(!reduncancy_check2($table,$con))
	{	$crud->insert();
		unset($_POST);
		unset($$unique);
		$type=1;
		$msg='New Entry Successfully Inserted.';
	}
	else
	{
		$type=0;
		$msg='This Investment Information is already added.';
	}
}


//for Modify..................................

if(isset($_POST['update']))
{
	if($_POST['commission1']>0)
	$_POST['commission_amount1']=($_POST['commission1']*.01)*$_POST['ammount'];
	
	if($_POST['commission2']>0)
	$_POST['commission_amount2']=($_POST['commission2']*.01)*$_POST['ammount'];
	
	if($_POST['commission3']>0)
	$_POST['commission_amount3']=($_POST['commission3']*.01)*$_POST['ammount'];
	
	if($_POST['commission4']>0)
	$_POST['commission_amount4']=($_POST['commission4']*.01)*$_POST['ammount'];
		$crud->update($unique);
		unset($_POST);
		$type=1;
		$msg='Successfully Updated.';
}
//for Delete..................................

if(isset($_POST['delete']))
{		$condition=$unique."=".$$unique;		$crud->delete($condition);
		unset($$unique);
		$type=1;
		$msg='Successfully Deleted.';
}
}


if(isset($$unique))
{
$condition=$unique."=".$$unique;
$data=db_fetch_object($table,$condition);
while (list($key, $value)=each($data))
{ $$key=$value;}
}
?>
<script type="text/javascript"> function DoNav(lk){document.location.href = '<?=$page?>?<?=$unique?>='+lk;}</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div class="left">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								  
								  <tr>
									<td>
									<div class="tabledesign">
							<? 

$res='select a.invest_code,b.party_name,a.amount from tbl_money_invest_commission a, tbl_party_provider b where a.investor_code=b.party_code';

							echo $crud->link_report($res,'');?>
									</div>
							<?=paging(9);?></td>
								  </tr>
								</table>

							</div></td>
    <td><div class="right">
      <form method="post" name="form2" id="form2">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><div class="box">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                     
                                     
                                     <tr>
                                        <td>Code No :</td>
										<? if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique)?>
                                        <td>
										<input readonly name="<?=$unique?>" type="text" id="<?=$unique?>" value="<?=$$unique?>" />                                        </td>
				    </tr>
                                      
                                     
                                     
                                      
                                       <tr>
                                         <td>Investor Name:</td>
                                         <td>							 <select name="<?=$unique2?>">
							 <? foreign_relation('tbl_party_provider','party_code','party_name',$$unique2);?>
							 </select>                                         </td>
                                       </tr>
                                       <tr>
                                         <td>Date of Invest: </td>
                                         <td><input name="date" type="text" id="date"  value="<?=$date?>"/></td>
                                       </tr>
                                       <tr>
                                         <td>Invest Amount:</td>
                                         <td><input name="amount" type="text" id="amount"  value="<?=$amount?>"/></td>
                                       </tr>
                                       <tr>
                                         <td>Agent Name(Level 1) :</td>
                                         <td><select name="agent1">
                                             <? foreign_relation('tbl_employee_info','emp_id','emp_name',$agent1);?>
                                           </select>
                                         </td>
                                       </tr>
                                       <tr>
                                         <td>Agent Commission(%):</td>
                                         <td><input name="commission1" type="text" id="commission1"  value="<?=$commission1?>"/>
                                         %</td>
                                       </tr>
                                       <tr>
                                         <td>Agent Name(Level 2):</td>
                                         <td><select name="agent2">
                                             <? foreign_relation('tbl_employee_info','emp_id','emp_name',$agent2);?>
                                           </select>                                         </td>
                                       </tr>
                                       <tr>
                                         <td>Agent Commission(%):</td>
                                         <td><input name="commission2" type="text" id="commission2"  value="<?=$commission2?>"/>
                                         %</td>
                                       </tr>
                                       <tr>
                                         <td>Agent Name(Level 3):</td>
                                         <td><select name="agent3">
                                             <? foreign_relation('tbl_employee_info','emp_id','emp_name',$agent3);?>
                                           </select>                                         </td>
                                       </tr>
                                       <tr>
                                         <td>Agent Commission(%):</td>
                                         <td><input name="commission3" type="text" id="commission3" value="<?=$commission3?>" />
                                         %</td>
                                       </tr>
                                       <tr>
                                         <td>Agent Name(Level 4):</td>
                                         <td><select name="agent4">
                                             <? foreign_relation('tbl_employee_info','emp_id','emp_name',$agent4);?>
                                           </select>                                         </td>
                                       </tr>
                                       <tr>
                                        <td>Agent Commission(%):</td>
                                        <td><input name="commission4" type="text" id="commission4" value="<?=$commission4?>" /> 
                                         % </td>
									  </tr>
                                    </table>
            </div></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>								  <div class="box">
								    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td>
										<? if(!isset($_GET[$unique])){?>
										<input name="insert" type="submit" id="insert" value="Save" class="btn" />
										<? }?>
										</td>
                                        <td>
										<? if(isset($_GET[$unique])){?>
										<input name="update" type="submit" id="update" value="Update" class="btn" />
										<? }?>
										</td>
                                        <td><input name="reset" type="button" class="btn" id="reset" value="Reset" onclick="parent.location='<?=$page?>'" /></td>
                                        <td><input class="btn" name="delete" type="submit" id="delete" value="Delete"/></td>
                                      </tr>
                                    </table>
								  </div></td>
          </tr>
        </table>
      </form>
    </div></td>
  </tr>
</table>

<?
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout.php");
?>