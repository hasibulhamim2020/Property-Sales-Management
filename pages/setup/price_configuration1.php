<?php
session_start();
ob_start();
require "../../support/inc.all.php";
$title='Client Info';
$unique='party_code';

$table='tbl_flat_type';
$page="price_configuration.php";

if(isset($_REQUEST['proj_code'])) $proj_code=$_REQUEST['proj_code'];
if(isset($_REQUEST['build_code'])) $build_code=$_REQUEST['build_code'];
$crud      =new crud($table);

if(isset($_POST['proj_name']))
{
$type = $_POST['type'];
$proj_code=$_POST['proj_code'];
$build_code=$_POST['build_code'];
$total_flat=$_POST['total_flat'];
$con=" where type='".$type."' and proj_code='".$proj_code."' and build_code='".$proj_code."'";
$condi="type='".$type."' and proj_code='".$proj_code."' and build_code='".$build_code."'";
if(isset($_POST['insert']))
{
	
	if(!reduncancy_check2($table,$con))
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


if(isset($_REQUEST['type']))
{
$type = $_REQUEST['type'];
$proj_code=$_REQUEST['proj_code'];
$build_code=$_REQUEST['build_code'];
$condi="type='".$type."' and proj_code='".$proj_code."' and build_code='".$proj_code."'";

$data=db_fetch_object($table,$condi);
while (list($key, $value)=each($data))
{ $$key=$value;}
}
?>
<script type="text/javascript"> 
function DoNav(lk){document.location.href = '<?=$page?>?type='+lk;}
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td valign="top">
								<div class="left">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
								    <td><div class="box3">
								      <form id="form1" name="form1" method="post" action="">
								        <table width="85%" border="0" cellspacing="0" cellpadding="0" align="left">
                                          <tr>
                                            <td width="40%">Project : </td>
                                            <td width="60%" colspan="2"><select name="proj_code" id="proj_code">
                                                <? if(isset($_REQUEST['proj_code'])) $proj_code=$_REQUEST['proj_code'];
foreign_relation('tbl_project_info','proj_code','proj_name',$proj_code);?>
                                            </select></td>
                                          </tr>
                                          <tr>
                                            <td>Category : </td>
                                            <td colspan="2"><select name="build_code" id="build_code">
                                                <? if(isset($_REQUEST['build_code'])&&isset($_REQUEST['proj_code'])) $build_code=$_REQUEST['build_code'];
foreign_relation('tbl_building_info','bid','category',$build_code);?>
                                                                                          </select>
                                                <input name="submit" type="submit" class="exit" value="Show Status" /></td>
                                          </tr>
                                        </table>
                                                                            </form>
								      </div></td>
						      </tr>
								  <tr>
									<td>&nbsp;</td>
								  </tr>
								  <tr>
									<td>
									  <div class="tabledesign">
									  <table cellspacing="0" cellpadding="0" width="100%">									
							  <tr>
								<th>No Initial</th>
								<th>Total Units/Nos</th>
								<th>Size of Unit</th>
							  </tr>
							  <?
							  if(isset($proj_code)&&isset($build_code)) $con= " where build_code='".$build_code."' and proj_code='".$proj_code."'";
							  $sql="select * from ".$table." ".$con;
							  $que=mysql_query($sql);
							  if(mysql_num_rows($que)>0)
							  {
							  $i=0;
							  while($info=mysql_fetch_object($que)){
							 $link=$info->type."&proj_code=".$info->proj_code."&build_code=".$info->build_code;
							  ?>
							<tr <? if($i%2) echo 'class="alt"'; $i++;?> onclick="DoNav('<?=$link?>')">
								<td><?=$info->type?></td>
								<td><?=$info->total_flat?></td>
								<td><?=$info->flat_size?></td>
							  </tr>
							  <? }}?>

							</table>
									  </div>
									   </td>
								  </tr>
								</table>
							</div></td>
                                <td>
								<div class="right">
							  <form method="post" name="form2" id="form2">
							    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td><div class="box">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td>Project  :</td>
                                        <td><select name="proj_code" id="proj_code">
                                          <? if(isset($_REQUEST['proj_code'])) $proj_code=$_REQUEST['proj_code'];
foreign_relation('tbl_project_info','proj_code','proj_name',$proj_code);?>
                                                                                </select></td>
                                      </tr>

                                      <tr>
                                        <td>Category : </td>
                                        <td><select name="build_code" id="build_code">
                                          <? if(isset($_REQUEST['build_code'])&&isset($_REQUEST['proj_code'])) $build_code=$_REQUEST['build_code'];
foreign_relation('tbl_building_info','bid','category',$build_code);?>
                                                                                </select></td>
                                      </tr>
									  <tr>
                                        <td>No Initial :</td>
                                        <td><input  name="type" type="text" id="type" value="<?=$type?>"/></td>
									  </tr>
                                    </table>
                                  </div></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td><div class="box">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td>Total Units/Nos.  : </td>
                                        <td><input  name="total_flat" type="text" id="total_flat" value="<?=$total_flat?>"/></td>
									  </tr>
									    <tr>
                                        <td>Size of Unit : </td>
                                        <td><input  name="flat_size" type="text" id="flat_size" value="<?=$flat_size?>"/></td>
                                      </tr>
									    <tr>
                                        <td>Rate/Sqft.  : </td>
                                        <td><input  name="sqft_price" type="text" id="sqft_price" value="<?=$sqft_price?>"/></td>
                                      </tr>
									    <tr>
                                          <td>Unit Price  : </td>
									      <td><input  name="unit_price" type="text" id="unit_price" value="<?=$unit_price?>"/></td>
								      </tr>
									    <tr>
                                          <td>Parking  : </td>
									      <td><input  name="parking_price" type="text" id="parking_price" value="<?=$parking_price?>"/></td>
								      </tr>
									    <tr>
                                        <td>Total Price   : </td>
                                        <td><input  name="price" type="text" id="price" value="<?=$price?>"/></td>
                                      </tr>
									    <tr>
                                        <td>Bank loan   : </td>
                                        <td><input  name="bank_loan" type="text" id="bank_loan" value="<?=$bank_loan?>"/></td>
                                      </tr>
                                    </table>
                                  </div></td>
                                </tr>
                                
                                <tr>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>
								  <div class="box">
								  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td><input name="insert" type="submit" class="btn" id="insert" value="Save" /></td>
                                      <td><input type="submit" value="Update" class="btn" /></td>
                                      <td><input type="submit" value="Cancle" class="btn" /></td>
                                      <td><input type="submit" value="Close" class="btn" />
                                      <input name="proj_name" type="hidden" id="proj_name" value="1" /></td>
                                    </tr>
                                  </table>
								  </div>								  </td>
                                </tr>
                              </table>
							  </form>
							</div>								</td>
                              </tr>
                            </table>
<?
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout.php");
?>