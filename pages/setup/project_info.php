<?php
session_start();
ob_start();
require "../../support/inc.all.php";
$title='Project Info';
$table='tbl_project_info';
$page="project_info.php";
$unique='proj_code';
$crud      =new crud($table);
$proj_code = $_GET['proj_code'];
if(isset($_POST['proj_name'])&&$_POST['proj_code']>0)
{
$proj_code = $_POST['proj_code'];
if(isset($_POST['insert']))
{
	$proj_name=$_POST['proj_name'];
	if(!reduncancy_check($table,'proj_name',$proj_name))
	{	$crud->insert();
		unset($proj_name);
		unset($_POST);
		unset($$unique);
		$type=1;
		$msg='New Entry Successfully Inserted.';
	}
}


//for Modify..................................

if(isset($_POST['update']))
{

		$crud->update('proj_code');
		$type=1;
		$msg='Successfully Updated.';
}
//for Delete..................................

if(isset($_POST['delete']))
{		$condition="proj_code=".$proj_code;		$crud->delete($condition);
		unset($$unique);
		$type=1;
		$msg='Successfully Deleted.';
}
}


if(isset($proj_code))
{
$condition="proj_code=".$proj_code;
$data=db_fetch_object($table,$condition);
while (list($key, $value)=each($data))
{ $$key=$value;}
}
do_calander('#expc_date');
do_calander('#work_start');
?>
  <script>
  $(document).ready(function(){
    $("#form2").validate();
  });
  </script>


<script type="text/javascript">function DoNav(lk){document.location.href = 'project_info.php?proj_code='+lk;}</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div class="left">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
									<td>
									<div class="tabledesign">
							<? $res='select proj_code,proj_name,proj_add from tbl_project_info order by proj_code';
							echo $crud->link_report($res,'project_info.php?proj_code=');?>
									</div>
							<?=paging(8);?></td>
								  </tr>
								</table>

							</div></td>
							<td>
							<div class="right">
							
							<form id="form2" name="form2" method="post" action="">
													  <table width="100%" border="0" cellspacing="0" cellpadding="0">
														<tr>
														  <td><div class="box">
															<table width="100%" border="0" cellspacing="0" cellpadding="0">
															 
															 

															  
															  <tr>
																<td>Project Name:</td>
																<td>
<? if(!isset($proj_code)) $proj_code=db_last_insert_id($table,'proj_code')?>
<input readonly name="proj_code" type="hidden" id="proj_code" value="<?=$proj_code?>" require/>
<input class="required" name="proj_name" type="text" id="proj_code" value="<?=$proj_name?>"  />																</td>
															  </tr>
															  
															  <tr>
																<td>Project Brief:</td>
																<td><input name="proj_brf" type="text" id="proj_brf" value="<?=$proj_brf?>"  />																</td>
															  </tr>
															 
															 
															  
															   <tr>
																<td>Address:</td>
																<td><textarea name="proj_add" id="proj_add" rows="" cols=""><?=$proj_add?></textarea>																</td>
															  </tr>
															  
															    <tr>
																<td>Project Value:</td>
																<td><input name="proj_value" type="text" id="proj_brf" value="<?=$proj_value?>"  />																</td>
															  </tr>
															  
															  <tr>
																<td>Project Budgeted cost:</td>
						                                        <td><input name="proj_budget_cost" type="text" id="proj_budget_cost" value="<?=$proj_budget_cost?>"  /></td>
															  </tr>
															  
															  <tr>
																<td>sand filling:</td>
																<td><input name="sand_filling" type="text" id="sand_filling" value="<?=$sand_filling?>"  />																</td>
															  </tr>
															  
															  <tr>
																<td>tree plantation:</td>
																<td><input name="tree_plantation" type="text" id="tree_plantation" value="<?=$tree_plantation?>"  />																</td>
															  </tr>
															  
															  
															  <tr>
																<td>registary:</td>
																<td><input name="registary" type="text" id="registary" value="<?=$registary?>"  />																</td>
															  </tr>
															  
															  
															  <tr>
																<td>legal_exp:</td>
																<td><input name="legal_exp" type="text" id="legal_exp" value="<?=$legal_exp?>"  />																</td>
															  </tr>
															  
															  <tr>
																<td>road_exp:</td>
																<td><input name="road_exp" type="text" id="road_exp" value="<?=$road_exp?>"  />																</td>
															  </tr>
															  
															  
															  <tr>
																<td>bricks:</td>
																<td><input name="bricks" type="text" id="bricks" value="<?=$bricks?>"  />																</td>
															  </tr>
															  
															  
															  <tr>
																<td>cement:</td>
																<td><input name="cement" type="text" id="cement" value="<?=$cement?>"  />																</td>
															  </tr>
															  
															  <tr>
																<td>rod:</td>
																<td><input name="rod" type="text" id="rod" value="<?=$rod?>"  />																</td>
															  </tr>
															  
															  <tr>
																<td>lebor:</td>
																<td><input name="lebor" type="text" id="lebor" value="<?=$lebor?>"  />																</td>
															  </tr>
															  
															  
															  <tr>
																<td>miscell:</td>
																<td><input name="miscell" type="text" id="miscell" value="<?=$miscell?>"  />																</td>
															  </tr>
															  
															  <tr>
																<td>broker_exp:</td>
																<td><input name="broker_exp" type="text" id="broker_exp" value="<?=$broker_exp?>"  />																</td>
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
																<input name="insert" type="submit" id="insert" value="Save" class="btn" />
																<? }?>
																</div>																</td>
																<td>
																<div class="button">
																<? if(isset($_GET[$unique])){?>
																<input name="update" type="submit" id="update" value="Update" class="btn" />
																<? }?>
																</div>																</td>
																<td>
																<div class="button">
																<input name="reset" type="button" class="btn" id="reset" value="Reset" onclick="parent.location='<?=$page?>'" />
																</div>																</td>
																<td>
																<div class="button">
																<input class="btn" name="delete" type="submit" id="delete" value="Delete"/>
																</div>																</td>
															  </tr>
															</table>
															</div>														  </td>
														</tr>
													  </table>
							</form>
					
							</div>
							</td>
  </tr>
</table>

<?
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout.php");
?>