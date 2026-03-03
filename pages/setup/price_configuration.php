<?php
session_start();
ob_start();
require "../../support/inc.all.php";
$title='Price Configaration';
$table='tbl_flat_info';
$page="price_configuration.php";
$unique='fid';

$crud      =new crud($table);

if(isset($_REQUEST['fid'])) $fid=$_REQUEST['fid'];

if(isset($_POST['fid']))
{
$fid = $_POST['fid'];
$type = $_POST['b_type'];
$proj_code=$_POST['proj_code'];
$build_code=$_POST['build_code'];
$cat_id=$_POST['cat_id'];
$total_flat=$_POST['total_flat'];
$section=$_POST['section_name'];
$road=$_POST['road_no'];
$flat_size=$_POST['flat_size'];
$sqft_price=$_POST['sqft_price'];
$unit_price=$_POST['unit_price'];
$parking_price=$_POST['parking_price'];
$development_fee=$_POST['development_fee'];
$price=$_POST['total_price'];
$flat_no=$_POST['flat_no'];
//$dgm_commission=$_POST['dgm_commission'];
$sr_executive_commission=$_POST['sr_executive_commission'];
$team_leader=$_POST['team_leader_commission'];
$group_leader=$_POST['group_leader_commission'];
//$head_of_sales_commission=$_POST['head_of_sales_commission'];
$other_commission=$_POST['other_commission'];
$discount=$_POST['discount'];
$fine_per=$_POST['fine_per'];
$reserve=$_POST['reserve'];



$con=" where type='".$type."' and proj_code='".$proj_code."' and build_code='".$proj_code."'";
$condi="type='".$type."' and proj_code='".$proj_code."' and build_code='".$build_code."'";

if(isset($_POST['insert']))
{

	$type_id=$_POST['fid'];


		$type=1;
		$msg='New Entry Successfully Inserted. '.$type_id;


$sqls="INSERT INTO `tbl_flat_info` (
			`proj_code`, 
			`build_code`, 
			`b_type`, 
			`section_name`,
			`road_no`,
			`flat_no`, 
			`cat_code`, 
			`floor_no`, 
			`garag_no`, 
			`facing`, 
			`flat_size`, 
			`sqft_price`, 
			`unit_price`, 
			`park_price`,reserve,
			`total_price`, 
			`sr_executive_commission`,
			`team_leader_commission`,
			`group_leader_commission`,
			`other_commission`,
			`ledger_id`, 
			`bank_loan`, 
			`cat_id`, 
			`discount`,fine_per,acc_no)
VALUES ('$proj_code', '$build_code', '$type','$section','$road', '$flat_no', '', '', '', '$facing', '$flat_size', '$sqft_price', 
'$unit_price', '$parking_price','$reserve','$price','$sr_executive_commission','$team_leader','$group_leader','$other_commission', '','','$cat_id','$discount','$fine_per','$acc_no')";
		$querys=mysql_query($sqls);
		unset($_POST);
		unset($$unique);
	
}
//for modify.........................
if(isset($_POST['update']))
{
// log insert
$log_in = 'insert into tbl_flat_info_history(
fid, proj_code, build_code, b_type, section_name, road_no, flat_no, cat_code, cat_id, 
floor_no, garag_no, facing, flat_size, sqft_price, unit_price, disc_price, utility_price, 
park_price, development_fee, add_price, reg_price, oth_price, total_price, bank_loan, res_date, 
status, sr_status, booked_on, party_code, pos_date, loan, tobedel, agreement, acc_no, op_date, 
no_of_inst, issue_lett, non_insentive, sr_executive_commission, team_leader_commission, group_leader_commission, 
other_commission, entry_by, entry_date, edit_by, edit_date, ledger_id, discount, fine_per
) 
select *
from tbl_flat_info 
where fid="'.$fid.'"
';
mysql_query($log_in);

		echo $crud->update($unique);
		$type=1;
		$msg='Successfully Updated.';
}
//for Delete..................................

if(isset($_POST['delete']))
{		$condition="fid=".$fid;
		$sql="DELETE FROM `tbl_flat_info` WHERE proj_code='$proj_code' and build_code='$build_code' and b_type='$type'";	
		mysql_query($sql);
		$crud->delete($condition);
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

<script type="text/javascript"> function DoNav(lk){document.location.href = '<?=$page?>?<?=$unique?>='+lk;}
function a_sum()
{
document.getElementById('unit_price').value=((document.getElementById('flat_size').value)*1)*((document.getElementById('sqft_price').value)*1);
}
function c_sum(){
document.getElementById('development_fee').value=((document.getElementById('flat_size').value)*1)*((document.getElementById('parking_price').value)*1);
}

function b_sum()
{
document.getElementById('total_price').value=(((document.getElementById('unit_price').value)*1)+((document.getElementById('utility_price').value)*1)
+((document.getElementById('reserve').value)*1)+((document.getElementById('park_price').value)*1))-((document.getElementById('discount').value)*1);
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
                                          <td>Section Name :</td>
                                          <td colspan="2"><select name="section_name" id="section_name">
                                              <? if(isset($_REQUEST['section_name'])&&isset($_REQUEST['proj_code'])) $section_name=$_REQUEST['section_name'];
foreign_relation('add_section','section_id','section_name',$section_name);?>
                                            </select></td>
                                        </tr>
										
										
										
				<tr>
                    <td>Block No :</td>
                    <td>
						<select name="b_type" id="b_type">
						<option><?=$b_type?></option>
						<option value="A">A</option>
						<option value="B">B</option>
						</select>
					</td>
                  </tr>
				  
	
										
										<tr>
                                          
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
									<td>
							<div class="tabledesign1">
							<? 
							if(isset($section_name))
							{
				 $res='select a.fid ,a.b_type as block_no,b.category as type,a.road_no as Road_No,a.flat_no as Plot_No from tbl_flat_info a, tbl_building_info b where a.cat_id=b.build_code and a.proj_code='.$proj_code.' and a.section_name='.$section_name;
						
							}else{
				 $res='select fid ,b_type as block_no,cat_id,road_no as Road_No,flat_no as Plot_No from tbl_flat_info  where proj_code='.$proj_code.' and b_type='.$b_type;
							}
							
							if(isset($res))
							echo $crud->link_report($res,'');
							else
							{?>
							<table width="100%" cellspacing="0" cellpadding="0" id="grp">
							<tbody>
							<tr>
							  <th>Type</th>
							<th>Block No</th>
							<th>Floor No </th>
							<th>Plot No</th>
							</tr>
							<tr>
							  <td></td>
							<td></td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							</tr>
							<tr class="alt">
							  <td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							</tr>
							<tr >
							  <td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							</tr></tbody></table>
								<? }?>	</div>
							<?=paging(80);?></td>
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
                      <input name="fid" type="hidden" id="fid" value="<?=$fid?>" /></td>
                  </tr>
                  <tr>
                    <td>Category : </td>
                    <td><select name="cat_id" id="cat_id">
                      <? if(isset($_REQUEST['cat_id']) && isset($_REQUEST['proj_code'])) $build_code=$_REQUEST['cat_id'];
foreign_relation('tbl_building_info','build_code','category',$cat_id);?>
                    </select></td>
                  </tr>
                 <!-- <tr>
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
                  </tr> -->
                  <tr>
                    <td>Block No :</td>
                    <td>
						<select name="b_type" id="b_type">
						<option><?=$b_type?></option>
						<option value="A">A</option>
						<option value="B">B</option>
						</select>
					</td>
                  </tr>
				  
				  
				  
				  
				  
				   <tr>
										  <td>Section Name :</td>
										  <td><select name="section_name" id="section_name" value="<?=$section_name?>">
										  
										 	<?php
											
												foreign_relation('add_section','section_id','section_name',$section_name);
										  	
										   ?>
										 
										  </select> </td>
										  
				 </tr>
				 
				 <tr>
                 							<td>Floor No :</td>

  											<td><input type='text' name="road_no" id="road_no" value="<?=$road_no?>"/></td>
   
                  </tr>
				  
				   <tr>
                 							<td>Flat/Shop No :</td>

  											<td><input type='text' name="flat_no" id="flat_no" value="<?=$flat_no?>"/></td>
   
                  </tr>
				  
				  <tr>
				  	<td>Face :</td>
					<td>
						<select name="facing" id="facing">
						<option><?=$facing?></option>
						<option value="North">North</option>
						<option value="South">South</option>
						</select>
					</td>
				  </tr>
	<tr>
                    <td> Acc Ledger: </td>
                    <td><input  name="acc_no" type="text" id="acc_no" value="<?=$acc_no?>"/></td>
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
                   <!--<tr>
                    <td>Total Plot : </td>
                    <td><input  name="total_flat" type="text" id="total_flat" value="<?=$total_flat?>"/></td>
                  </tr>-->
                  <tr>
                    <td>No of Sft : </td>
                    <td><input  name="flat_size" type="text" id="flat_size" value="<?=$flat_size?>"/></td>
                  </tr>
                  <tr>
                    <td>Rate Per Sft.  : </td>
                    <td><input  name="sqft_price" type="text" id="sqft_price" value="<?=$sqft_price?>"/></td>
                  </tr>
                  <tr>
                    <td> Amount  : </td>
                    <td><input  name="unit_price" type="text" id="unit_price" value="<?=$unit_price?>" onfocus="a_sum()" readonly/></td>
                  </tr>
                  <tr>
                    <td>Parking : </td>
                    <td><input  name="park_price" type="text" id="park_price" value="<?=$park_price?>"/></td>
                  </tr>
				   <tr>
                    <td>Utility : </td>
                    <td><input  name="utility_price" type="text" id="utility_price" value="<?=$utility_price?>"  /></td>
                  </tr>
<!--onfocus="c_sum()"-->				  
                   <tr>
                     <td>Reserve : </td>
                     <td><input  name="reserve" type="text" id="reserve" value="<?=$reserve?>" /></td>
                   </tr>
                   <tr>
                     <td>Discount : </td>
                     <td><input  name="discount" type="text" id="discount" value="<?=$discount?>" /></td>
                   </tr>
                   <tr>
                    <td>Total Price   : </td>
                    <td><input  name="total_price" type="text" id="total_price" value="<?=$total_price?>"  onfocus="b_sum()" readonly/></td>
                  </tr>
				  
                   <tr>
                    <td>Fine % : </td>
                    <td><input  name="fine_per" type="text" id="fine_per" value="<?=$fine_per?>"/></td>
                  </tr>				  
				  
				  <!--Commision-->
		   </table>
		   <tr>
            <td>&nbsp;</td>
          </tr>
		  
          <tr>
            <td><div class="box">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                   
                <!--  <tr>
                    <td>DGM Commission : </td>
                    <td><input  name="dgm_commission" type="text" id="dgm_commission" value="dgm_commission?>"/></td>
                  </tr>-->
                  <tr>
                    <td>Senior Executive Commission : </td>
                    <td><input  name="sr_executive_commission" type="text" id="sr_executive_commission" value="<?=$sr_executive_commission?>"/></td>
                  </tr>
				  <tr>
                    <td>Team Leader Commission :</td>
                    <td><input  name="team_leader_commission" type="text" id="team_leader_commission" value="<?=$team_leader_commission?>"/></td>
                  </tr>
				  <tr>
                    <td>Group Leader Commission :</td>
                    <td><input  name="group_leader_commission" type="text" id="group_leader_commission" value="<?=$group_leader_commission	?>"/></td>
                  </tr>
			<!--	  <tr>
                    <td>Head Of Sales Commission</td>
                    <td><input  name="head_of_sales_commission" type="text" id="head_of_sales_commission" value="<=$head_of_sales_commission?>"/></td>
                  </tr>-->
                  <tr>
                    <td>Others Commission : </td>
                    <td><input  name="other_commission" type="text" id="other_commission" value="<?=$other_commission?>"/></td>
                  </tr>
                 
                  <!--Commision-->
                </table>
            </div></td>
          </tr>
		

         
          <tr>
            <td> <div class="form-container">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
              
				  <td><div class="button">
				  <? if(!isset($_GET[$unique])){?>
                      <input name="insert" type="submit" id="insert" value="Save" class="btn" />
                  <? }?>
				  </div></td>
                  <td>
				  <div class="button">
				  <? if(isset($_GET[$unique])){?>
                      <input name="update" type="submit" id="update" value="Update" class="btn" />
                  <? }?>
				  </div></td>
                  <td>
				  <div class="button">
				  <input name="reset" type="button" class="btn" id="reset" value="Reset" onclick="parent.location='<?=$page?>'" />
				  </div></td>
                  <td>
				  <div class="button">
				  <!--<input class="btn" name="delete" type="submit" id="delete" value="Delete"/>-->
				  </div></td>	
				  </tr>			 
          
              </table>			  
             </div>			
             </td>
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