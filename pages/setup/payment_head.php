<?php
session_start();
ob_start();
require "../../support/inc.all.php";
$title='Payment Head';
$unique='pay_code';

$table='tbl_payment_head';
$page="payment_head.php";

$crud      =new crud($table);
$pay_code = $_GET['pay_code'];
if(isset($_POST['pay_desc']))
{
$pay_code = $_POST['pay_code'];
if(isset($_POST['insert']))
{
	$pay_desc=$_POST['pay_desc'];
	if(!reduncancy_check($table,'pay_desc',$pay_desc))
	{		$crud->insert();
		unset($_POST);
		unset($$unique);
		$type=1;
		$msg='New Entry Successfully Inserted.';
	}
}


//for Modify..................................

if(isset($_POST['update']))
{
		$crud->update('pay_code');
		$type=1;
		$msg='Successfully Updated.';
}
//for Delete..................................

if(isset($_POST['delete']))
{		$condition="pay_code=".$pay_code;		$crud->delete($condition);
		unset($$unique);
		$type=1;
		$msg='Successfully Deleted.';
}
}


if(isset($pay_code))
{
$condition="pay_code=".$pay_code;
$data=db_fetch_object($table,$condition);
while (list($key, $value)=each($data))
{ $$key=$value;}
}
?>
<script type="text/javascript"> function DoNav(lk){document.location.href = '<?=$page?>?pay_code='+lk;}</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div class="left">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">

								  <tr>
																		<td>
									<div class="tabledesign">
							<? $res='select pay_code,pay_code,pay_desc from '.$table;
							echo $crud->link_report($res,'payment_head.php?pay_code=');?>
									</div>
							<?=paging(15);?></td>
								  </tr>
								</table>

							</div></td>
    <td><div class="right"><form id="form2" name="form2" method="post" action="">
							  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td><div class="box">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                     
                                     
                                     <tr>
                                        <td>Payment Code:</td>
										<? if(!isset($pay_code)) $pay_code=db_last_insert_id($table,'pay_code')?>
                                        <td><input readonly name="pay_code" type="text" id="pay_code" value="<?=$pay_code?>" />
                                        </td>
									  </tr>
                                      
                                     
                                     
                                      
                                       <tr>
                                        <td>Description</td>
                                        <td><textarea name="pay_desc" id="pay_desc" rows="" cols=""><?=$pay_desc?></textarea>
                                        </td>
									  </tr>
                                      
                                      
                                    </table>
                                  </div></td>
                                </tr>
                                
                              
                                
                                 
                                
                                
                                
                                <tr>
                                  <td> 
								  <div class="form-container">
								   <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td>
									  <div class="button">
                                        <? if(!isset($_GET[$unique])){?>
                                       <!-- <input name="insert" type="submit" id="insert" value="Save" class="btn" />-->
                                        <? }?>   
									  </div>									  </td>
                                      <td>
									  <div class="button">
                                        <? if(isset($_GET[$unique])){?>
                                        <input name="update" type="submit" id="update" value="Update" class="btn" />
                                        <? }?>     
									  </div>									  </td>
                                      <td>
									  <div class="button">
									  <input name="reset" type="button" class="btn" id="reset" value="Reset" onclick="parent.location='<?=$page?>'" />
									  </div>									  </td>
                                      <td>
									  <div class="button">
									 <!-- <input class="btn" name="delete" type="submit" id="delete" value="Delete"/>-->
									  </div>									  </td>
                                    </tr>
                                    </table>
							      </div>
									</td></tr>
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