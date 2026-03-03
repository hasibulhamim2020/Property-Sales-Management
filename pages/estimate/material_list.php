<?php
session_start();
ob_start();
require "../../support/inc.all.php";
$title='Item Unit Add';
$unique='id';
$unique2='material';
$unique3='unit';
$table='tbl_material';
$page="material_list.php";

$crud      =new crud($table);
if(isset($_GET[$unique])) $$unique = $_GET[$unique];

if(isset($_POST[$unique2]))
{
$$unique = $_POST[$unique];
if(isset($_POST['insert']))
{
	$$unique2 = $_POST[$unique2];
	if(!reduncancy_check($table,$unique2,$$unique2))
	{	$crud->insert();
		unset($_POST);
		unset($$unique);
		$type=1;
		$msg='New Entry Successfully Inserted.';
	}
}


//for Modify..................................

if(isset($_POST['update']))
{
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
							<? $res='select '.$unique.','.$unique.','.$unique2.','.$unique3.' from '.$table;
							echo $crud->link_report($res,$page.'?'.$unique.'='.$$unique);?>
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
                                        <td>Material Id:</td>
										<? if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique)?>
                                        <td>
										<input readonly name="<?=$unique?>" type="text" id="<?=$unique?>" value="<?=$$unique?>" />                                        </td>
									  </tr>
                                      
                                     
                                     
                                      
                                       <tr>
                                         <td>Material Name:</td>
                                         <td><input name="<?=$unique2?>" type="text" id="<?=$unique2?>" value="<?=$$unique2?>" size="" />
                                         </td>
                                       </tr>
                                       <tr>
                                        <td>Material Unit:</td>
                                        <td>
						
							 <select name="<?=$unique3?>">
							 <? foreign_relation('tbl_item_unit',$unique3,$unique3,$$unique3);?>
							 </select>
							                                        </td>
									  </tr>
                                    </table>
                                  </div></td>
                                </tr>
                                
                              
                                
                                 
                                
                                
                                
                                <tr>
                                  <td>
								  <div class="box">
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
								  </div>								  </td>
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