<?php
session_start();
ob_start();
require "../../support/inc.all.php";
$title='Agent Information';
$unique='emp_id';

$table='tbl_employee_info';
$page="employee_info.php";
do_calander('#emp_joining_date');
$crud      =new crud($table);
$emp_id = $_GET['emp_id'];
if(isset($_POST['emp_name']))
{
$emp_id = $_POST['emp_id'];
if(isset($_POST['insert']))
{		$crud->insert();
		unset($_POST);
		unset($$unique);
		$type=1;
		$msg='New Entry Successfully Inserted.';
}


//for Modify..................................

if(isset($_POST['update']))
{
		$crud->update('emp_id');
		$type=1;
		$msg='Successfully Updated.';
}
//for Delete..................................

if(isset($_POST['delete']))
{		$condition="emp_id=".$emp_id;		$crud->delete($condition);
		unset($$unique);
		$type=1;
		$msg='Successfully Deleted.';
}
}


if(isset($emp_id))
{
$condition="emp_id=".$emp_id;
$data=db_fetch_object($table,$condition);
while (list($key, $value)=each($data))
{ $$key=$value;}
}
?>
<script type="text/javascript"> function DoNav(lk){document.location.href = '<?=$page?>?emp_id='+lk;}</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div class="left">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
									<td>
									<div class="tabledesign">
							<? $res='select emp_id,emp_id,emp_name,emp_father_name from '.$table;
							$link=$page.'?pay_code=';
											echo $crud->link_report($res,$link);?>
									</div>
							<?=paging(15);?></td>
								  </tr>
								</table>

							</div></td>
    <td><div class="right"><form id="form2" name="form2" method="post">
							  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          
                                                             
                                 <tr>
                                  <td><div class="box">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      
                                      <tr>
                                        <td>Agent ID :</td>
										<? if(!isset($emp_id)) $emp_id=db_last_insert_id($table,'emp_id')?>
                                        <td> <input name="emp_id" type="text" id="emp_id" value="<?=$emp_id?>" readonly  />
										</td>
									  </tr>
                                      <tr>
                                        <td>Agent Name :</td>
                                        <td> <input name="emp_name" type="text" id="emp_name" value="<?=$emp_name?>"  /> </td>
									  </tr>
                                      
                                      <tr>
                                        <td >Father's Name:</td>
                                        <td><input name="emp_father_name" type="text" id="emp_father_name" value="<?=$emp_father_name?>"  />                                        </td>
									  </tr>
                                      
                                       <tr>
                                        <td >Contact No:</td>
                                        <td><input name="emp_contact_name" type="text" id="emp_contact_name" value="<?=$emp_contact_name?>"  />                                        </td>
									  </tr>
                                      
                                      
                                       <tr>
                                        <td>Address : </td>
                                        <td><textarea name="emp_add" id="emp_add" rows="" cols=""><?=$emp_add?>
                                        </textarea>
                                        </td>
									  </tr>

                                     
                                      
                                      
                                      <tr>
                                        <td>Designation:</td>
                                        <td><input name="emp_designation" type="text" id="emp_designation" value="<?=$emp_designation?>"  />
                                        </td>
									  </tr>
                                      
                                      <tr>
                                        <td>Department</td>
                                        <td><input name="emp_department" type="text" id="emp_department" value="<?=$emp_department?>"  />
                                        </td>
									  </tr>
                                      
                                      <tr>
                                        <td>Joining Date</td>
                                        <td><input name="emp_joining_date" type="text" id="emp_joining_date" value="<?=$emp_joining_date?>"  />
                                        </td>
									  </tr>
                                      
                                    </table>
                                  </div></td>
                                </tr>
                                
                                
                                <tr>
                                  <td>&nbsp;</td>
                                </tr>
                                
                                <tr>
                                <td>    
								<div class="form-container_large">                  
								                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td><? if(!isset($_GET[$unique])){?>
									  <div class="button">
                                          <input name="insert" type="submit" id="insert" value="Save" class="btn" />
                                          <? }?>  
									</div>                                    
									</td>
                                      <td>
									  <div class="button">
									  <? if(isset($_GET[$unique])){?>
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