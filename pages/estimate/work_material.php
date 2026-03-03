<?php
session_start();
ob_start();
require "../../support/inc.all.php";
$title='Work Material';
$table='tbl_work_material';
$page="work_material.php";
$unique='id';
$unique2='work_id';
$unique3='material_id';

$crud      =new crud($table);
if(isset($_GET[$unique])) $$unique = $_GET[$unique];

if(isset($_POST[$unique2]))
{
$$unique = $_POST[$unique];
if(isset($_POST['insert']))
{
	$$unique2 = $_POST[$unique2];
	$$unique3 = $_POST[$unique3];
	$con=$unique2.'='.$$unique2.' and '.$unique3.'='.$$unique3;
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
		$msg='This Material under this work is already added.';
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
								    <td><form id="form1" name="form1" method="post" action="<?=$page?>">
                                      <table width="85%" border="0" cellspacing="0" cellpadding="0" align="left">
                                        <tr>
                                          <td width="40%" valign="top">Work Title: </td>
                                          <td width="60%" colspan="2">

<select name="<?=$unique2?>">
<? if(isset($_REQUEST[$unique2])) $$unique2=$_REQUEST[$unique2];
foreign_relation('tbl_work_title','id','work_title',$$unique2);?>
</select><br /><br />
<input name="search" id="search" type="submit" value="Search" />
</td>
                                        </tr>
                                      </table>
							        </form></td>
						      </tr>
								  <tr>
								    <td>&nbsp;</td>
						      </tr>
								  <tr>
									<td>
									<div class="tabledesign">
							<? 
	if(isset($_POST['search']))
	{
$$unique2 = $_POST[$unique2];
$res='select c.id,b.work_title,a.material, a.unit from tbl_material a,tbl_work_title b,tbl_work_material c where c.work_id=a.id and c.material_id=b.id and b.id='.$$unique2;
	}
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
                                        <td>Id:</td>
										<? if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique)?>
                                        <td>
										<input readonly name="<?=$unique?>" type="text" id="<?=$unique?>" value="<?=$$unique?>" />                                        </td>
									  </tr>
                                      
                                     
                                     
                                      
                                       <tr>
                                         <td>Work Title:</td>
                                         <td>							 <select name="<?=$unique2?>">
							 <? foreign_relation('tbl_work_title','id','work_title',$$unique2);?>
							 </select>
                                         </td>
                                       </tr>
                                       <tr>
                                        <td>Material:</td>
                                        <td>
							 <select name="<?=$unique3?>">
							 <? foreign_relation('tbl_material','id','material',$$unique3);?>
							 </select>                                       </td>
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