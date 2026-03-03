<?php
session_start();
ob_start();
require "../../support/inc.all.php";
$title='Client  Info';
$unique='party_code';

$table='tbl_party_info';
$page="client_info.php";
do_calander('#birth_date');
do_calander('#register_date');
if(isset($_GET['proj_code'])) $proj_code=$_GET['proj_code'];

$crud      =new crud($table);



$party_code = $_GET['party_code'];
if(isset($_POST['party_name']))
{
$party_code = $_POST['party_code'];
if($_FILES['pic_1']['size']>0)
{
$root='../../pictures/'.$party_code.'_1.jpg';
move_uploaded_file($_FILES['pic_1']['tmp_name'],$root);
$_POST['pic_1']=$root;
}

if($_FILES['pic_2']['size']>0)
{
$root='../../pictures/'.$party_code.'_2.jpg';
move_uploaded_file($_FILES['pic_2']['tmp_name'],$root);
$_POST['pic_2']=$root;
}

if($_FILES['pic_3']['size']>0)
{
$root='../../pictures/'.$party_code.'_3.jpg';
move_uploaded_file($_FILES['pic_3']['tmp_name'],$root);
$_POST['pic_3']=$root;
}

if($_FILES['pic_4']['size']>0)
{
$root='../../pictures/'.$party_code.'_4.jpg';
move_uploaded_file($_FILES['pic_4']['tmp_name'],$root);
$_POST['pic_4']=$root;
}

if(isset($_POST['insert']))
{		

$customer_name		= $_POST['party_name'].':-'.$$unique;
$customer_name		= str_replace("'","",$customer_name);
$customer_name		= str_replace("&","",$customer_name);
$customer_name		= str_replace('"','',$customer_name);
$customer_company	= $_REQUEST['company_name'];
$address			= $_REQUEST['pre_postoffice'];
$contact			= $_REQUEST['ah_mobile_tel'];
$proj_id			= $_SESSION['proj_id'];
$now				= time();


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
								    <td><div class="box3"><form id="form2" name="form2" method="post" action=""><table width="100%" border="0" cellspacing="2" cellpadding="0">
                                      <tr>
                                        <td width="40%" align="right">
		    Project                                        </td>
                                        <td width="60%" align="right">
										<select name="proj_code" id="proj_code" onchange="submit_nav(this.value)">
<? foreign_relation('tbl_project_info','proj_code','proj_name',$proj_code);?>
                                        </select></td>
                                      </tr>
                                     
                                    </table>
								    </form></div></td>
						      </tr>
								  <tr>
									<td>&nbsp;</td>
								  </tr>
								  <tr>
                                    <td><div class="tabledesign">
                                        <? 
										if(isset($proj_code))
										echo $res='select party_code,party_code as code,party_name as Client_Name from tbl_party_info where proj_code='.$proj_code;
										else
										$res='select party_code,party_code as code,party_name as Client_Name from '.$table;
										
										echo $crud->link_report($res,'');?>
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
									<td>
									<fieldset>
<legend>Project Details</legend>
<div>
<label><!--1. Project Name:--></label>
<!--<select name="proj_code" id="proj_code">
<? foreign_relation('tbl_project_info','proj_code','proj_name',$proj_code);?>
</select>-->
</div>
                                        <div>
                                          <label>2. Client Code: </label>
											<? if(!isset($party_code)) $party_code=db_last_insert_id($table,'party_code')?>
											<input name="party_code" type="text" id="proj_code" readonly="readonly" value="<?=$party_code?>"  />
									</div>
                                        <div> </div>
                                        <div class="buttonrow"></div>
										
									<div>
                                          <label>3. Client Name:</label>                                          
                                          <input name="party_name" type="text" id="party_name" value="<?=$party_name?>">
									</div>
										<div>
                                          <label>3a.Client's Pic1: </label>
                                          <? if($pic_1!='') echo '<img src="'.$pic_1.'" width="50" height="75" />';?>
                                         <input name="pic_1" type="file" id="pic_1" size="9" style="height:20px;" />
                                        </div>
										<div>
                                          <label>3b. Client's Pic2:</label>
                                         <? if($pic_2!='') echo '<img src="'.$pic_2.'" width="50" height="75" />';?>
                                         <input name="pic_2" type="file" id="pic_2" size="9" style="height:20px;" />
                                        </div>
										<div>
                                          <label>4. Father's Name:</label>
                                          
                                          <input name="fname" type="text" id="fname" value="<?=$fname?>">
                                        </div>
									<div>
                                          <label>5. Mother's Name:</label>
                                          <input name="mname" type="text" id="mname" value="<?=$mname?>" />
									</div>
										<div>
                                          <label>6. Spouse's Name:</label>
                                          <input name="hname" type="text" id="hname" value="<?=$hname?>" />
                                        </div>
									</fieldset>									</td>
								  </tr>
								  <tr>
									<td>&nbsp;</td>
								  </tr>
								  <tr>
									<td>
									<fieldset>
                                        <legend>7. Client's Contact Info </legend>
                                    <div>
                                          <label>1. 7a. Mobile Tel No:</label>
                                          <input name="ah_mobile_tel" type="text" id="ah_mobile_tel" value="<?=$ah_mobile_tel?>">
                                    </div>
                                        <div>
                                          <label>7b. Office Tel No.:</label>
											<input name="ah_office_tel" type="text" id="ah_office_tel" value="<?=$ah_office_tel?>"  />                                      
									</div>
                                        <div class="buttonrow"></div>
										
									<div>
                                          <label>7c. Residence Tel No.:</label>
                                          <input name="ah_residence_tel" type="text" id="ah_residence_tel" value="<?=$ah_residence_tel?>" />
									</div>
										<div>
                                          <label>7d. Email Address: </label>
                                        <input name="email_address" type="text" id="email_address" value="<?=$email_address?>">
                                        </div>
										<div>
                                          <label>7e. Website Address:</label>
                                         <input name="website_address" type="text" id="website_address" value="<?=$website_address?>">
                                        </div>
									  </fieldset>									</td>
								  </tr>
								  <tr>
									<td>&nbsp;</td>
								  </tr>
								  <tr>
									<td>
									<fieldset>
                                        <legend>8. Client's Present Address  </legend>
                                    <div>
                                          <label>8a. House/Flat No:</label>
                                          <input name="pre_house" type="text" id="pre_house" value="<?=$pre_house?>" />
                                    </div>
                                        <div>
                                          <label>8b. Road Name/No:</label>
                                          <input name="pre_road" type="text" id="pre_road" value="<?=$pre_road?>" />
                                        </div>
                                        <div class="buttonrow"></div>
										
									<div>
                                          <label>8c. Village Name:</label>
                                          <input name="pre_village" type="text" id="pre_village" value="<?=$pre_village?>" />
									</div>
										<div>
                                          <label>8d. Post Code: </label>
                                          <input name="pre_postcode" type="text" id="pre_postcode" value="<?=$pre_postcode?>" />
										</div>
										<div>
                                          <label>8e. Post Office:</label>
                                          <input name="pre_postoffice" type="text" id="pre_postoffice" value="<?=$pre_postoffice?>" />
										</div>
										<div>
                                          <label>8f. Police Station:</label>
                                          <input name="pre_police_station" type="text" id="pre_police_station" value="<?=$pre_police_station?>" />
										</div>
										<div>
                                          <label>8g. District:</label>
                                          <input name="pre_district" type="text" id="pre_district" value="<?=$pre_district?>" />
										</div>
										<div>
                                          <label>8h. Country:</label>
                                          <input name="pre_country" type="text" id="pre_country" value="<?=$pre_country?>" />
										</div>
									  </fieldset>									</td>
								  </tr>
								  <tr>
									<td>&nbsp;</td>
								  </tr>
								</table></td>
							    </tr>
                                
                             <tr>
                               <td>
							   <fieldset>
                                        <legend>9. Client's Permanent Address</legend>
                               <div>
                                          <label>9a. House/Flat No. :</label>
                                          <input name="per_house" type="text" id="per_house" value="<?=$per_house?>" />
                               </div>
                                        <div>
                                          <label>9b. Road Name/No</label>
                                          <input name="per_road" type="text" id="per_road" value="<?=$per_road?>" />
                                        </div>
                                        <div class="buttonrow"></div>
										
							   <div>
                                          <label>9c. Village Name:</label>
                                          <input name="per_village" type="text" id="per_village" value="<?=$per_village?>" />
							   </div>
										<div>
                                          <label>9d. Post Code: </label>
                                          <input name="per_postcode" type="text" id="per_postcode" value="<?=$per_postcode?>" />
										</div>
										<div>
                                          <label>9e. Post Office</label>
                                          <input name="per_postoffice" type="text" id="per_postoffice" value="<?=$per_postoffice?>" />
										</div>
																				<div>
                                          <label>9f. Police Station:</label>
                                          <input name="per_police_station" type="text" id="per_police_station" value="<?=$per_police_station?>" />
							   </div>
										<div>
                                          <label>9g. District:</label>
                                          <input name="per_district" type="text" id="per_district" value="<?=$per_district?>" />
										</div>
										<div>
                                          <label>9h. Country:</label>
                                          <input name="per_country" type="text" id="per_country" value="<?=$per_country?>" />
										</div>
										<div>
                                          <label>10. Occupation:</label>
                                          <input name="prof_code" type="text" id="prof_code" value="<?=$prof_code?>">
										</div>
										<div>
                                          <label>11. Nationality:</label>
                                          <input name="nation" type="text" id="nation" value="<?=$nation?>" />
										</div>
										<div>
                                          <label>12. National ID:</label>
                                          <input name="national_id_no" type="text" id="national_id_no" value="<?=$national_id_no?>" />
										</div>
										<div>
                                          <label>13. VAT No.:</label>
                                          <input name="vat_no" type="text" id="vat_no" value="<?=$vat_no?>" />
										</div>
										<div>
                                          <label>14. TIN No.:</label>
                                          <input name="tin_no" type="text" id="tin_no" value="<?=$tin_no?>">
										</div>
										<div>
                                          <label>15. Date of Birth:</label>
                                          <input name="birth_date" type="text" id="birth_date" value="<?=$birth_date?>">
										</div>
								 </fieldset>									  </td>
                             </tr>
                             <tr>
                               <td>&nbsp;</td>
                             </tr>
                             <tr>
                               <td>
							   <fieldset>
                                      
                               <div>
                                          <label>16. Company Name :</label>
                                          <input name="company_name" type="text" id="company_name" value="<?=$company_name?>" />
                               </div>
									<div>
									<label>17. Department: </label>
									<input name="department" type="text" id="department" value="<?=$department?>" />
									</div>
                                        <div>
                                          <label>18. Contact Person: </label>
                                          <input name="contact_person" type="text" id="contact_person" value="<?=$contact_person?>" />
                                        </div>
                                        <div class="buttonrow"></div>
										
							   <div>
                                          <label>19. Nominee Name :</label>
                                          <input name="nominee" type="text" id="nominee" value="<?=$nominee?>" />
							   </div>
										<div>
                                          <label>19a. Nominee Picture1 : </label>
                                          <? if($pic_3!='') echo '<img src="'.$pic_3.'" width="50" height="75" />';?>
										  <input name="pic_3" type="file" id="pic_3" size="9"  style="height:20px;"  />
										</div>
							   <div>
                                          <label>19b. Nominee Picture2:</label>
                                 <? if($pic_4!='') echo '<img src="'.$pic_4.'" width="50" height="75" />';?>
										<input name="pic_4" type="file" id="pic_4" size="9"  style="height:20px;" />
							   </div>
										<div>
                                          <label>20. Nominee Relation :</label>
                                          <select name="nrelation" id="nrelation">
                                            <? if($nrelation!='') echo '<option selected>'.$nrelation.'</option>';
									  else echo '<option selected>Choose One</option>';
									  ?>
                                            <option>SON</option>
                                            <option>DAUGHTER</option>
                                            <option>WIFE</option>
                                            <option>HASBAND</option>
                                            <option>FATHER</option>
                                            <option>MOTHER</option>
                                            <option>SISTER</option>
                                            <option>BROTHER</option>
                                            <option>SISTER-IN-LAW</option>
                                            <option>BROTHER-IN-LAW</option>
                                            <option>MOTHER-IN-LAW</option>
                                            <option>FATHER-IN-LAW</option>
                                            <option>FRIEND</option>
                                            <option>OTHERS</option>
                                          </select>
										</div>
								 </fieldset>							   </td>
                             </tr>
                             <tr>
                               <td>&nbsp;</td>
                             </tr>
                             <tr>
                               <td>
							   <fieldset>
                                        <legend>21. Nominee Address </legend>
                               <div>
                                          <label>21a. House/Flat No :</label>
                                          <input name="n_house" type="text" id="n_house" value="<?=$n_house?>" />
                               </div>
                                        <div>
                                          <label>Road Name/No.:</label>
                                          <input name="n_road" type="text" id="n_road" value="<?=$n_road?>" />
                                        </div>
                                        <div class="buttonrow"></div>
										
							   <div>
                                          <label>21c. Village Name:</label>
                                          <input name="n_village" type="text" id="n_village" value="<?=$n_village?>" />
							   </div>
										<div>
                                          <label>21d. Post Code: </label>
                                          <input name="n_postcode" type="text" id="n_postcode" value="<?=$n_postcode?>" />
										</div>
										<div>
                                          <label>21e. Post Office:</label>
                                          <input name="n_postoffice" type="text" id="n_postoffice" value="<?=$n_postoffice?>" />
										</div>
										<div>
                                          <label>21f. Police Station:</label>
                                          <input name="n_police_station" type="text" id="per_district" value="<?=$n_police_station?>" />
										</div>
										<div>
                                          <label>21g. District:</label>
                                          <input name="n_district" type="text" id="n_district" value="<?=$n_district?>" />
										</div>
										<div>
                                          <label>21h. Country:</label>
                                          <input name="n_country" type="text" id="n_country" value="<?=$n_country?>" />
										</div>
								 </fieldset>							   </td>
                             </tr>
                             <tr>
                               <td>&nbsp;</td>
                             </tr>
                             <tr>
                               <td>
							   <fieldset>
                                        <legend>22. Nominee Contact Info </legend>
                               <div>
                                          <label>22a. Mobile Tel No :</label>
                                          <input name="n_mobile_tel" type="text" id="n_mobile_tel" value="<?=$n_mobile_tel?>" />
                               </div>
                                        <div>
                                          <label>22b. Office Tel No:</label>
                                          <input name="n_office_tel" type="text" id="n_office_tel" value="<?=$n_office_tel?>" />
                                        </div>
                                        <div class="buttonrow"></div>
										
							   <div>
                                          <label>22c. Residence Tel No:</label>
                                          <input name="n_residence_tel" type="text" id="n_residence_tel" value="<?=$n_residence_tel?>" />
							   </div>
										<div>
                                          <label>23. Brand Ambassador: </label>
                                          <input name="brand_ambassador" type="text" id="brand_ambassador" value="<?=$brand_ambassador?>" />
										</div>
										<div>
                                          <label>24. Ambassador Code :</label>
                                          <input name="ambasidor_account" type="text" id="ambasidor_account" value="<?=$ambasidor_account?>" />
										</div>
										<div>
                                          <label>25. Client Dealt by:</label>
                                          <input name="account_dealt_by" type="text" id="account_dealt_by" value="<?=$account_dealt_by?>" />
										</div>
										<div>
                                          <label>26. Any Special Notes:</label>
                                          <input name="any_special_notes" type="text" id="any_special_notes" value="<?=$any_special_notes?>" />
										</div>
										<div>
                                          <label>27. Registration Date :</label>
                                          <input name="register_date" type="text" id="register_date" value="<? if($register_date=='') echo date('Y-m-d'); else echo $register_date;?>" />
										</div>
										<div>
                                          <label>28. Account Created by:</label>
                                          <input name="created_by" type="text" id="created_by" value="<?=$created_by?>" />
										</div>
										<div>
                                          <label>29. Account Authorised by :</label>
                                          <input name="authorised_by" type="text" id="authorised_by" value="<?=$authorised_by?>" />
										</div>
								 </fieldset>							   </td>
                             </tr>
                             <tr>
                               <td>&nbsp;</td>
                             </tr>
                             <tr>
                               <td>
							   <fieldset>
                                        <legend> Commission Referance Name</legend>
                               
										<div>
                                          <label>Non Insentive :</label>
                                         <select name="non_insentive" id="non_insentive">
                                            <? foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME',$non_insentive);?>
											
                                          </select>
										
										<label>Executive/Sr Executive : </label>
                                          
										  <select name="sr_executive" id="sr_executive">
                                            <? foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME',$sr_executive);?></select>
										
										<label>Team Leader : </label>
                                        <select name="team_leader" id="team_leader">
                                            <? foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME',$team_leader);?></select>
										
										<label>Group Leader: </label>
                                        <select name="group_leader" id="group_leader">
                                            <? foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME',$group_leader);?></select>
											
											<label>Others : </label>
                                        <select name="others" id="others">
                                            <? foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME',$others);?></select>
											
											<label>Payment Type : </label>
                                        <select name="payment_type" id="payment_type">
                                            <option><?=$payment_type?></option>
											 <option>Cash</option>
											  <option>Installment</option>
										</div>
								 </fieldset>
							   
							   
                               </td>
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