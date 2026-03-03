<?php
session_start();
ob_start();
require "../../support/inc.all.php";
$title='Share Holder Information';
$unique='party_code';

$table='tbl_director_info';
$page="dir_info.php";
do_calander('#birth_date');
do_calander('#register_date');
do_calander('#status_date');

$crud      =new crud($table);

$party_code = $_GET['party_code'];
if(isset($_POST['party_name']))
{
$party_code = $_POST['party_code'];
if($_FILES['pic_1']['size']>0)
{
$root='../../dir_pictures/'.$party_code.'.jpg';
move_uploaded_file($_FILES['pic_1']['tmp_name'],$root);
$_POST['pic_1']=$root;
}

if(isset($_POST['insert']))
{		

$crud->insert();
$type=1;
$msg='New Entry Successfully Inserted.';
unset($_POST);
unset($$unique);
}


//for Modify..................................

if(isset($_POST['update']))
{
		$crud->update('party_code');
		$type=1;
		$msg='Successfully Updated.';
}
//for Delete..................................

if(isset($_POST['delete']))
{		$condition="party_code=".$party_code;		$crud->delete($condition);
		unset($$unique);
		$type=1;
		$msg='Successfully Deleted.';
}
}

if(isset($party_code))
{
$condition="party_code=".$party_code;
$data=db_fetch_object($table,$condition);
while (list($key, $value)=each($data))
{ $$key=$value;}
}
?>
<script type="text/javascript"> function DoNav(lk){document.location.href = '<?=$page?>?party_code='+lk;}
function submit_nav(lkf){document.location.href = '<?=$page?>?proj_code='+lkf;}
function Do_Nav()
{
	var URL = 'pop_ledger_selecting_list.php';
	popUp(URL);
}

function popUp(URL) 
{
day = new Date();
id = day.getTime();
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=800,left = 383,top = -16');");
}
</script>
<div class="form-container_large">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top"><div class="left">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
								    <td><div class="box3"></div></td>
						      </tr>
								  <tr>
									<td>&nbsp;</td>
								  </tr>
								  <tr>
                                    <td><div class="tabledesign">
                                        <? 
										
										$res='select party_code,party_code as code,concat(party_name," - (",status,")") as Share_holder_name from tbl_director_info';
										$link=$page.'?party_code=';
										echo $crud->link_report($res,$link);?>
                                      </div>
                                        <?=paging(50);?></td>
						      </tr>
								</table>

							</div></td>
    <td valign="top"><form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">

      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td>                                   
							    <table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
								    <td>&nbsp;</td>
							      </tr>
								  <tr>
									<td>
									<fieldset>
									<div>
                                          <label>Share Holder Code: </label>
											<? if(!isset($party_code)) $party_code=db_last_insert_id($table,'party_code')?>
											<input name="party_code" type="text" id="proj_code" value="<?=$party_code?>"  />
									</div>
                                       
										
									<div>
                                          <label>Share Holder Name:</label>                                          
                                          <input name="party_name" type="text" id="party_name" value="<?=$party_name?>">
									</div>
										
										                    
                                    <div>
                                          <label>Invested On Project:</label>
                                          <select name="proj_code" id="proj_code">
                                            <? foreign_relation('tbl_project_info','proj_code','proj_name',$proj_code);?>
                                          </select>
                                    </div>
										<div>
                                          <label>Membership No:</label>
                                          
                                          <input name="member_no" type="text" id="member_no" value="<?=$member_no?>">
                                        </div>
										<div>
                                          <label>Share Holder Photo: </label>
                                          <? if($pic_1!='') echo '<img src="'.$pic_1.'" width="50" height="75" />';?>
                                         <input name="pic_1" type="file" id="pic_1" size="9" style="height:20px;" />
                                    </div>
										<div>
                                          <label>Father's Name:</label>
                                          
                                          <input name="fname" type="text" id="fname" value="<?=$fname?>">
                                        </div>
																		
									<div>
                                          <label> Mobile No:</label>
                                          <input name="mobile" type="text" id="mobile" value="<?=$mobile?>">
                                    </div>
                                        <div>
                                          <label> Contact Tel No.:</label>
											<input name="office_tel" type="text" id="office_tel" value="<?=$office_tel?>"  />                                      
									</div>
										<div>
                                          <label> Email Address: </label>
                                        <input name="email_address" type="text" id="email_address" value="<?=$email_address?>">
                                        </div>
									  
							   <div>
                                          <label> Residence Address:</label>
                                          <input name="address" type="text" id="address" value="<?=$address?>">
										</div>
							   
										<div>
                                          <label> Date of Birth:</label>
                                          <input name="birth_date" type="text" id="birth_date" value="<?=$birth_date?>">
										</div>
								<div>
                                          <label> Opening Date :</label>
                                          <input name="register_date" type="text" id="register_date" value="<? if($register_date=='') echo date('Y-m-d'); else echo $register_date;?>" />
										</div>
							  
							   <div>
                                          <label> No of Share(Holding) :</label>
                                          <input name="share" type="text" id="share" value="<? echo $share;?>" />
										</div>
							<div>
                                          <label> Invested Amount :</label>
                                          <input name="invested" type="text" id="invested" value="<? echo $invested;?>" />
										</div>
										
										<div>
                                          <label>Invested Period :</label>
                                          <select name="invested_period">
								<? if($invested_period!=''){?><option selected="selected"><?=$invested_period?></option><?}?>
										  <option>2 YEAR</option>
										  <option>3 YEAR</option>
										  <option>4 YEAR</option>
										  <option>5 YEAR</option>
										  </select>
										</div>
										<div>
                                          <label> Withdraw amount :</label>
                                          <input name="withdraw" type="text" id="withdraw" value="<? echo $withdraw;?>" />
										</div>
										<div>
                                          <label> Present Status :</label>
                                          <select name="status">
										  <? if($status!=''){?><option selected="selected"><?=$status?></option><?}?>
										  <option>Running</option>
										  <option>Withdrawn</option>
										  </select>
										</div>
							<div>
                                          <label> Present Status Date :</label>
                                          <input name="status_date" type="text" id="status_date" value="<? echo $share;?>" />
										</div>
										
										<div>
                                          <label> Agent Name:</label>
                                          <select name="agent_code" id="agent_code">
                                            <? foreign_relation('tbl_employee_info','emp_id','emp_name',$agent_code);?></select>
										</div>
										 
								 </fieldset>							   </td>
                             </tr>
                             <tr>
                               <td>&nbsp;</td>
                             </tr>
            
                            <tr>
                              <td>
							    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td>
									  <div class="button">
										<? if(!isset($_GET[$unique])){?>
										<input name="insert" type="submit" id="insert" value="Save" class="btn" />
										<? }?>	
										</div>										</td>
										<td>
										<div class="button">
										<? if(isset($_GET[$unique])){?>
										<input name="update" type="submit" id="update" value="Update" class="btn" />
										<? }?>	
										</div>									</td>
                                      <td>
									  <div class="button">
									  <input name="reset" type="button" class="btn" id="reset" value="Reset" onclick="parent.location='<?=$page?>'" />
									  </div>									  </td>
                                      <td>
									  <div class="button">
									  <input class="btn" name="delete" type="submit" id="delete" value="Delete"/>
									  </div>									  </td>
                                    </tr>
                                </table></td>
                            </tr>
        </table>
    </form></td>
  </tr>
</table>
</div>
<?
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout.php");
?>