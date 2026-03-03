<?php
session_start();
ob_start();
require "../../support/inc.all.php";
$title='Price Configaration';
$table='tbl_flat_type';
$page="price_configuration.php";
$unique='type_id';

$crud      =new crud($table);

if(isset($_REQUEST['type_id'])) $type_id=$_REQUEST['type_id'];

if(isset($_POST['type_id']))
{
$type_id = $_POST['type_id'];
$type = $_POST['type'];
$proj_code=$_POST['proj_code'];
$build_code=$_POST['build_code'];
$total_flat=$_POST['total_flat'];
$con=" where type='".$type."' and proj_code='".$proj_code."' and build_code='".$proj_code."'";
$condi="type='".$type."' and proj_code='".$proj_code."' and build_code='".$build_code."'";

if(isset($_POST['insert']))
{

	$type_id=$_POST['type_id'];
	$conit=" where type='".$type."' and proj_code='".$proj_code."' and build_code='".$build_code."'";
	if(!reduncancy_check2($table,$conit))
	{		$crud->insert();

		$type=1;
		$msg='New Entry Successfully Inserted.';
		$findquery=mysql_query('select * from tbl_flat_type where type_id='.$type_id);
		if(mysql_num_rows($findquery)>0){
		$info=mysql_fetch_object($findquery);
		}
		for($i=1;$i<=$info->total_flat;$i++)
		{
		$flat_no=$info->type.'-'.$i;
		$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); 
		$build_type=find_a_field('tbl_building_info','category','bid='.$build_code);
		
		$sqls="INSERT INTO `tbl_flat_info` (
			`proj_code`, 
			`build_code`, 
			`b_type`, 
			`flat_no`, 
			`cat_code`, 
			`floor_no`, 
			`garag_no`, 
			`facing`, 
			`flat_size`, 
			`sqft_price`, 
			`unit_price`, 
			`disc_price`, 
			`park_price`, 
			`total_price`, 
			`ledger_id`, 
			`bank_loan`)
VALUES ('$info->proj_code', '$info->build_code', '$info->type', '$flat_no', '', '', '', '', '$info->flat_size', '$info->sqft_price', '$info->unit_price', '0', '$info->parking_price', '$info->price','$id', '$info->bank_loan')";
		$querys=mysql_query($sqls);
		}
		unset($_POST);
		unset($$unique);
	}
}
//for Delete..................................

if(isset($_POST['delete']))
{		$condition="type_id=".$type_id;
		$sql="DELETE FROM `tbl_flat_info` WHERE proj_code='$proj_code' and build_code='$build_code' and b_type='$type'";	
		mysql_query($sql);
		$crud->delete($condition);
		unset($$unique);
		$type=1;
		$msg='Successfully Deleted.';
}
}

if(isset($type_id))
{
$condition="type_id=".$type_id;
$data=db_fetch_object($table,$condition);
while (list($key, $value)=each($data))
{ $$key=$value;}
}
?>

<script type="text/javascript"> function DoNav(lk){document.location.href = '<?=$page?>?<?=$unique?>='+lk;}
function a_sum()
{
document.getElementById('unit_price').value=((document.getElementById('flat_size').value)*1)*((document.getElementById('sqft_price').value)*1);
}
function b_sum()
{
document.getElementById('price').value=((document.getElementById('unit_price').value)*1)+((document.getElementById('parking_price').value)*1);
}
function Do_Nav()
{
	var URL =  'pop_ledger_selecting_list.php';
	popUp(URL);
}
function popUp(URL) 
{
day = new Date();
id = day.getTime();
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=800,left = 383,top = -16');");
}</script>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top"><div class="left">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
								    <td>
									<div class="box">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
									<td>
									<form id="form2" name="form2" method="post" action="<?=$page?>">
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
                                            </select></td>
                                        </tr>
										 <tr>
                                          <td>&nbsp;</td>
                                          <td colspan="2">
										  <div class="form-container">
										  <div class="button">
										  <input name="submit2" type="submit" value="Show Status" />
										  </div>
										  </div>
										  </td>
                                        </tr>
                                      </table>
							        </form>
									</td>
									</tr>
									</table>
									</div>
									</td>
						      </tr>
								  <tr>
								    <td>&nbsp;</td>
						      </tr>
								  <tr>
									<td>
							<div class="tabledesign1">
							<? 
							if(isset($_POST['proj_code']))
							{
							$res='select type_id,type as block_no,total_flat as No_Allotment,flat_size as allotment_size from '.$table.' where proj_code='.$_POST['proj_code'].' and build_code='.$_POST['build_code'];
							}
							else
							if(isset($proj_code))
							$res='select type_id,type as block_no,total_flat as No_Allotment,flat_size as allotment_size from '.$table.' where proj_code='.$proj_code.' and build_code='.$build_code;
							if(isset($res))
							echo $crud->link_report($res,'');
							else
							{?>
							<table width="100%" cellspacing="0" cellpadding="0" id="grp"><tbody><tr><th>Block No</th>
							<th>No Allotment </th>
							<th>Allotment Size</th>
							</tr><tr><td>&nbsp;</td><td>&nbsp;</td>
							<td>&nbsp;</td>
							</tr><tr class="alt"><td>&nbsp;</td><td>&nbsp;</td>
							<td>&nbsp;</td>
							</tr><tr ><td>&nbsp;</td><td>&nbsp;</td>
							<td>&nbsp;</td>
							</tr></tbody></table>
								<? }?>	</div>
							<?=paging(9);?></td>
								  </tr>
								</table>

							</div></td>
    <td><div class="right">
      <form method="post" name="form1" id="form1">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><div class="box">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td>Project  :</td>
                    <td><select name="proj_code" id="proj_code">
                        <? if(isset($_REQUEST['proj_code'])) $proj_code=$_REQUEST['proj_code'];
foreign_relation('tbl_project_info','proj_code','proj_name',$proj_code);?>
                    </select>
					<? if(!isset($type_id)) $type_id=db_last_insert_id($table,'type_id')?>
                      <input name="type_id" type="hidden" id="type_id" value="<?=$type_id?>" /></td>
                  </tr>
                  <tr>
                    <td>Category : </td>
                    <td><select name="build_code" id="build_code">
                        <? if(isset($_REQUEST['build_code'])&&isset($_REQUEST['proj_code'])) $build_code=$_REQUEST['build_code'];
foreign_relation('tbl_building_info','bid','category',$build_code);?>
                    </select></td>
                  </tr>
                  <tr>
                    <td>Under Ledger : </td>
                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td><span class="form-container">
                          <input style="width:100px" name="under_ledger" type="text" id="under_ledger" value="" />
                        </span></td>
                        <td valign="top">
						<div class="form-container">
						<div class="button">
						<input style="width:30px;" type="button" name="Button" value="Go" class="go" onclick="Do_Nav()" />
						</div>
						</div>						</td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td>Block No :</td>
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
                    <td>Rate-Sqft or Khata.  : </td>
                    <td><input  name="sqft_price" type="text" id="sqft_price" value="<?=$sqft_price?>"/></td>
                  </tr>
                  <tr>
                    <td>Unit Price  : </td>
                    <td><input  name="unit_price" type="text" id="unit_price" value="<?=$unit_price?>" onfocus="a_sum()" readonly/></td>
                  </tr>
                  <tr>
                    <td>Parking  : </td>
                    <td><input  name="parking_price" type="text" id="parking_price" value="<?=$parking_price?>"/></td>
                  </tr>
                  <tr>
                    <td>Total Price   : </td>
                    <td><input  name="price" type="text" id="price" value="<?=$price?>"  onfocus="b_sum()" readonly/></td>
                  </tr>
                  <tr>
                    <td>Bank loan   : </td>
                    <td><input  name="bank_loan" type="text" id="bank_loan" value="<?=$bank_loan?>"/></td>
                  </tr>
                </table>
            </div></td>
          </tr>
          <tr>
            <td><div class="form-container">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td>
				  <div class="button">
				  <? if(!isset($_GET[$unique])){?>
                      <input name="insert" type="submit" id="insert" value="Save" class="btn" />
                  <? }?>
				  </div>                  </td>
                  <td>
				  <div class="button">
				  <? if(isset($_GET[$unique])){?>
                      <input name="update" type="submit" id="update" value="Update" class="btn" />
                  <? }?>
				  </div>                  </td>
                  <td>
				  <div class="button">
				  <input name="reset" type="button" class="btn" id="reset" value="Reset" onclick="parent.location='<?=$page?>'" />
				  </div>				  </td>
                  <td>
				  <div class="button">
				  <input class="btn" name="delete" type="submit" id="delete" value="Delete"/>
				  </div>				  </td>
                </tr>
              </table>			  
             </div>			</td>
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