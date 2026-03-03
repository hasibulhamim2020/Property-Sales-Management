<?php
session_start();
ob_start();
require "../../support/inc.all.php";
$title='Rent Info';

//echo $proj_id;

$table='tbl_rent_info';
$page="rent_info.php";
$unique='rent_id';
if(isset($_GET['proj_code'])) $proj_code=$_GET['proj_code'];

$crud      =new crud($table);

if(isset($_GET[$unique])) $$unique = $_GET[$unique];
if(isset($_POST['flat_no']))
{
$$unique = $_POST[$unique];
if(isset($_POST['insert']))
{
		$ledger_id=$_POST['rent_id'];
		$party_code=$_POST['party_code'];
		$party_name=find_a_field('tbl_party_info','party_name','party_code='.$party_code);
		$ledger_name=$party_name.'-'.$_POST['rent_id'];
		$sql="INSERT INTO `accounts_ledger` (
											`ledger_id`,
											`ledger_name` ,
											`ledger_group_id` ,
											`opening_balance` ,
											`balance_type` ,
											`depreciation_rate` ,
											`credit_limit` ,
											`opening_balance_on` ,
											`proj_id`)
											VALUES ('$ledger_id','$ledger_name', 5, '', 'Both', '', '', '','Asset')";
											mysql_query($sql);		$crud->insert();
		unset($_POST);
		unset($$unique);
		$type=1;
		$msg='New Entry Successfully Inserted.';

}


//for Modify..................................

if(isset($_POST['update']))
{

		$crud->update($unique);
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
if($data){
while (list($key, $value)=each($data))
{ $$key=$value;}
}}




if(isset($_GET['party_code'])){
$party_code=$_GET['party_code'];
$ddd="select * from tbl_rent_info where  flat_id='$party_code'";
$data=mysql_fetch_array(mysql_query($ddd));}
do_calander('#expire_date');
do_calander('#effective_date');
?>
<script type="text/javascript">

function DoNav(theUrl)
{
         document.location.href = '<?=$page?>?<?=$unique?>='+theUrl;
}
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="31%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" >
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td width="170">
                <div class="tabledesign">
                  <? $res='select a.rent_id,b.proj_name,a.flat_no,a.party_code from tbl_rent_info a,tbl_project_info b where a.proj_code=b.proj_code';
					echo $crud->link_report($res,'project_info.php?proj_code=');?>
                  </div>
						  <?=paging(15);?></td>
              </tr>
          </table></td>
          <td width="69%" valign="top">
		  <div class="form-container">
		  <form id="form1" name="form1" method="post" action="">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td>
					  <fieldset>
                                        <legend>Project Details</legend>
                                    <div>
                                          <label>Project Code:</label>
										<select name="proj_code" id="proj_code" onchange="getData('../../common/flat_option23.php', 'fid', this.value);">
										<? foreign_relation('tbl_project_info','proj_code','proj_name',$proj_code);?>
										</select>
										<? if(!isset($rent_id)) $rent_id=db_last_insert_id('accounts_ledger','ledger_id');?>
										<input name="rent_id" type="hidden" id="rent_id" value="<?=$rent_id?>" /> 
                            </div>
                                        <div>
                                          <label>Flat NO: </label>
										<span id="fid">
										<?
										if(isset($proj_code))	$con="select a.flat_no,a.flat_no from tbl_flat_info a where a.build_code='1' and a.proj_code='".$proj_code."'";
										?>
										<select name="flat_no" id="flat_no">
										<?
										join_relation($con,$flat_no);?>
										</select>
										</span>									</div>
                            <div></div>
										<div class="buttonrow"></div>
										
									<div>
                                          <label>Party 2nd:</label>                                          
                                          <input type="text" name="party_2nd" id="party_2nd"  value="<?=$party_2nd?>" />
							</div>
										<div>
                                          <label>Party 3rd:</label>
                                          
                                          <input type="text" name="party_3rd" id="party_3rd" value="<?=$party_3rd?>">
                                        </div>
									<div>
                                          <label>Monthly Rent:</label>
                                          <input  name="monthly_rent" id="monthly_rent" type="text" value="<?=$monthly_rent?>"/>
							</div>
										<div>
                                          <label>Expire Date:</label>
                                          <input  name="expire_date" id="expire_date" type="text" value="<?=$expire_date?>"/>
                                        </div>
										<div>
                                          <label>Pay Description:</label>
                                          <input  name="pay_description" id="pay_description" type="text" value="<?=$pay_description?>"/>
                                        </div>
										<div>
                                          <label>Discontinue term:</label>
                                          <input  name="discontinue_term" id="discontinue_term" type="text" value="<?=$discontinue_term?>"/>
                                        </div>
										<div>
                                          <label>Electricity Bill :</label>
                                          <input  name="electricity_bill" id="electricity_bill" type="text" value="<?=$electricity_bill?>"/>
                                        </div>
										<div>
                                          <label>Wasa Bill :</label>
                                          <input  name="wasa_bill" id="wasa_bill" type="text" value="<?=$wasa_bill?>"/>
                                        </div>
										<div>
                                          <label>Witness1 Name:</label>
                                          <input  name="witness1" id="witness1" type="text" value="<?=$witness1?>"/>
                                        </div>
										<div>
                                          <label>Witness2 Name:</label>
                                          <input  name="witness2" id="witness2" type="text" value="<?=$witness2?>"/>
                                        </div>
							</fieldset>					  </td>
                      <td valign="top">
					  <fieldset>
                                        <legend>Flat Details</legend>
                                    <div>
                                          <label>Flat ID:</label>
                                          <input type="text" name="flat_id" id="flat_id" value="<?=$flat_id?>" />
                            </div>
                                        <div>
                                          <label>Party Code: </label>
										<select name="party_code" id="party_code">
                            <option value=""></option>
                            <?php $items = mysql_query("select * from tbl_party_info");
	 									 while($itemname = mysql_fetch_row($items))
	  									{
	  										if($party_code==$itemname[1]) 
	  										{
	  										echo "<option value=\"$itemname[1]\" selected>$itemname[1]: $itemname[2]</option>";
											}
	  										else
											{
												echo "<option value=\"$itemname[1]\">$itemname[1]: $itemname[2]</option>";
											}
	  									}
	  									?>
                          </select>                                     
									</div>
                            <div></div>
										<div class="buttonrow"></div>
										
									<div>
                                          <label>Party 2nd Add.:</label>                                          
                                          <input type="text" name="party_2nd_addr" id="party_2nd_addr"  value="<?=$party_2nd_addr?>" />
							</div>
										<div>
                                          <label>Party 3rd Add.:</label>                                          
                                          <input type="text" name="party_3rd_addr" id="party_3rd_addr"  value="<?=$party_3rd_addr?>" />
                                        </div>
									<div>
                                          <label>Effective Date:</label>
                                          <input  name="effective_date" id="effective_date" type="text" value="<?=$effective_date?>"/>
							</div>
										<div>
                                          <label>Security Money:</label>
                                          <input  name="security_money" id="security_money" type="text" value="<?=$security_money?>"/>
                                        </div>
										<div>
                                          <label>Notice Period:</label>
                                          <input  name="notice_period" id="notice_period" type="text" value="<?=$notice_period?>"/>
                                        </div>
										<div>
                                          <label>Increasing rate:</label>
                                          <input  name="increasing_rate"  id="increasing_rate" type="text" value="<?=$increasing_rate?>"/>
                                        </div>
										<div>
                                          <label>Gas Bill:</label>
                                          <input  name="gas_bill" id="gas_bill" type="text" value="<?=$gas_bill?>"/>
                                        </div>
										<div>
                                          <label>Others Bill:</label>
                                          <input  name="other_bill" id="other_bill" type="text" value="<?=$other_bill?>"/>
                                        </div>
										<div>
                                          <label>Witness1 Add.:</label>
                                          <input  name="witness1_address" id="witness1_address" type="text" value="<?=$witness1_address?>"/>
                                        </div>
										<div>
                                          <label>Witness1 Add.:</label>
                                          <input  name="witness2_address" id="witness2_address" type="text" value="<?=$witness2_address?>"/>
                                        </div>
							</fieldset>					  </td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>                    <table width="90%" height="26" border="0" cellpadding="0" cellspacing="0" align="center">
                      <tr>
                        <td>
						<div class="button">
						<? if(!isset($proj_code)){?>
                          <input name="insert" type="submit" id="insert" value="Save" class="btn" />
                          <? }?>
						  </div>
						   </td>
                          <td>
						  <div class="button">
						  <? if(isset($proj_code)){?>
                            <input name="update" type="submit" id="update" value="Update" class="btn" />
                          <? }?> 
						  </div>                        
						  </td>
                          <td>
						  <div class="button">
						  <input name="reset" type="button" class="btn" id="reset" value="Reset" onclick="parent.location='<?=$page?>'" />
						  </div>
						  </td>
                          <td>
						  <div class="button">
						  <input class="btn" name="delete" type="submit" id="delete" value="Delete"/>
						  </div>
						  </td>
                        </tr>
                    </table></td>
                </tr>
              </table>
              </form>         
		 </div>
		  </td>
        </tr>
      </table></td></tr>
</table>
<?
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout.php");
?>
