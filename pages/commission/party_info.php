<?php
session_start();
ob_start();
require "../../support/inc.all.php";
$title='Party Information';
$unique='party_code';

$table='tbl_party_provider';
$page="party_info.php";
do_calander('#date_birth');
if(isset($_GET['proj_code'])) $proj_code=$_GET['proj_code'];

$crud      =new crud($table);

$party_code = $_GET['party_code'];
if(isset($_POST['party_name']))
{
$party_code = $_POST['party_code'];
if(isset($_POST['insert']))
{		$crud->insert();

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
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top"><div class="left">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">

								
								  <tr>
                                    <td><div class="tabledesign">
                                        <? 
										if(isset($proj_code))
										$res='select party_code,party_code,party_name,per_add from '.$table.' where proj_code='.$proj_code;
										else
										$res='select party_code,party_code,party_name,per_add from '.$table;
											$link=$page.'?pay_code=';
											echo $crud->link_report($res,$link);?>
                                      </div>
                                        <?=paging(50);?></td>
						      </tr>
								</table>

							</div></td>
    <td><div class="right"><form id="form1" name="form1" method="post" action="">
							  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td><div class="box">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      
                                      
                                      <tr>
                                        <td >Client Code</td>
										<? if(!isset($party_code)) $party_code=db_last_insert_id($table,'party_code')?>
                                        <td><input name="party_code" type="text" id="proj_code" value="<?=$party_code?>"  />                                        </td>
									  </tr>
                                      <tr>
                                        <td >Client Name</td>
                                        <td><input name="party_name" type="text" id="party_name" value="<?=$party_name?>"  />                                        </td>
									  </tr>
                                      
                                       <tr>
                                        <td >Father's Name:</td>
                                        <td><input name="fname" type="text" id="fname" value="<?=$fname?>"></td>
									  </tr>
                                      
                                      <tr>
                                        <td >Mother's Name:</td>
                                        <td><input name="mname" type="text" id="mname" value="<?=$mname?>" /></td>
									  </tr>
                                      
                                      
                                      <tr>
                                        <td >Husband's Name:</td>
                                        <td><input name="hname" type="text" id="hname" value="<?=$hname?>" /></td>
									  </tr>
                                      
                                       <tr>
                                        <td >Contact No:</td>
                                        <td><input name="per_tel" type="text" id="per_tel" value="<?=$per_tel?>"  />                                        </td>
									  </tr>
                                      
                                      <tr>
                                        <td > Contact No(off):</td>
                                        <td><input name="pre_tel_of" type="text" id="pre_tel_of" value="<?=$pre_tel_of?>"  />                                        </td>
									  </tr>
                                      
                                       <tr>
                                        <td >Present Address</td>
                                        <td><textarea name="pre_add" id="pre_add" rows="" cols=""><?=$pre_add?></textarea>                                        </td>
									  </tr>
                                      
                                      <tr>
                                        <td >Permanent Address</td>
                                        <td><textarea name="per_add" id="per_add" rows="" cols=""><?=$per_add?></textarea>                                        </td>
									  </tr>
                                      

                                       <tr>
                                        <td >Occupation:</td>
                                        <td><input name="prof_code" type="text" id="prof_code" value="<?=$prof_code?>"  />                                        </td>
									  </tr>
                                      
                                      <tr>
                                        <td >TIN No:</td>
                                        <td><input name="tin_no" type="text" id="tin_no" value="<?=$tin_no?>"  />    </td>
									  </tr>
                                      
                                      
                                      
                                      <tr>
                                        <td>Date of Birth:</td>
                                      <td>
                                        <input name="date_birth" type="text" id="date_birth" value="<?=$birth_date?>"  />  </td>
                                      </tr>
                                       
                                        <tr>
                                          <td>Nominee Name: </td>
                                          <td><input name="nominee" type="text" id="nominee" value="<?=$nominee?>"></td>
                                        </tr>
                                        <tr> 
                                      <td>Nominee Address: </td>
                                      <td><textarea name="naddr" id="naddr"><?=$naddr?></textarea>   </td>
                                      </tr>
                                      
                                      <tr>
                                        <td >Nominee Relation: </td>
                                        <td><input name="nrelation" type="text" id="nrelation" value="<?=$nrelation?>"  />                                        </td>
									  </tr>
                                    </table>
                                  </div></td>
                                </tr>
                                
                                 <tr>
                                  <td>&nbsp;</td>
                                </tr>
                                
                                 

                                     
                                      
                                      
                                     
                                    
                                
           
                                <tr>
                                  <td>
								  <div class="box"><table width="100%" border="0" cellspacing="0" cellpadding="0">
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
                                    </table></div>								  </td>
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