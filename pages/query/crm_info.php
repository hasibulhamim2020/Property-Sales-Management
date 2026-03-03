<?php
session_start();

require "../../support/inc.all.php";

$unique='party_code';

$table='tbl_party_info';
$page="party_info.php";

if(isset($_GET['project_code']))
{
$_SESSION['booked']['proj_code']= $_GET['project_code'];
$_SESSION['booked']['build_code']= $_GET['build_code'];
$_SESSION['booked']['flat_no']= $_GET['flat_no'];
}

if(isset($_GET['proj_code'])) $proj_code=$_GET['proj_code'];

$crud      =new crud($table);

$party_code = $_GET['party_code'];
if(isset($_POST['party_name']))
{
$party_code = $_POST['party_code'];
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
echo 'test';
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
<link href="../../css/style.css" type="text/css" rel="stylesheet"/>
<link href="../../css/table.css" type="text/css" rel="stylesheet"/>
<link href="../../css/input.css" type="text/css" rel="stylesheet"/>
<link href="../../css/pagination.css" rel="stylesheet" type="text/css" />
<link href="../../css/jquery-ui-1.8.2.custom.css" rel="stylesheet" type="text/css" />
<link href="../../css/jquery.autocomplete.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../js/jquery-ui-1.8.2.custom.min.js"></script>
<script type="text/javascript" src="../../js/jquery.ui.datepicker.js"></script>
<script type="text/javascript" src="../../js/jquery.autocomplete.js"></script>
<script type="text/javascript" src="../../js/jquery.validate.js"></script>
<script type="text/javascript" src="../../js/paging.js"></script>
<script type="text/javascript" src="../../js/ddaccordion.js"></script>
<script type="text/javascript" src="../../js/js.js"></script>
<script type="text/javascript"> function DoNav(lk){document.location.href = '<?=$page?>?party_code='+lk;}
function submit_nav(lkf){document.location.href = '<?=$page?>?proj_code='+lkf;}
</script>
<script type="text/javascript"> 
function send(){
var lk=document.getElementById('party_code').value;
document.location.href = 'party_info2.php?party_code='+lk;}

</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top"><div class="left">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
								    <td><div class="box3">  <form id="form1" name="form1" method="post" action="">
    <table width="88%" border="0" cellspacing="0" cellpadding="0" align="center">
      <tr>
        <td>Client Name: </td>
        <td><input  name="ss" type="text" id="ss"  value=""/></td>
        <td><input class="btn" type="button" name="Button" value="Button" onclick="getData('../../common/flat_option1.php', 'fid', document.getElementById('ss').value);"/></td>
        <td >&nbsp;</td>
      </tr>
    </table>
  </form></div></td>
						      </tr>
								  <tr>
									<td>&nbsp;</td>
								  </tr>
								  <tr>
                                    <td><div class="tabledesign"><span id="fid">
                                        <? 

										$res='select party_code,party_code,party_name,per_add from '.$table;
										echo $crud->link_report($res,$link);?>
                                      
                                        </span></div></td>
						      </tr>
		</table>

							</div></td>
    <td><div class="right"><form id="form2" name="form2" method="post" action="">
							  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td><div class="box">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td >Project :</td>
                                        <td><select name="proj_code" id="proj_code">
										  <? foreign_relation('tbl_project_info','proj_code','proj_name',$proj_code);?>
                                        </select></td>
									  </tr>
                                      
                                      <tr>
                                        <td >Client Code</td>
										<? if(!isset($party_code)) $party_code=db_last_insert_id($table,'party_code')?>
                                        <td><input name="party_code" type="text" id="party_code" value="<?=$party_code?>" readonly  />                                        </td>
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
                                        <td><input name="in_no" type="text" id="in_no" value="<?=$in_no?>"  />    </td>
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
                                  <td>
								  <div class="box"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td>
										<? if(!isset($_GET[$unique])){?>
										<input name="insert" type="submit" id="insert" value="Insert" class="btn" />
										<? }?>										</td>
                                        <td>
										<? if(isset($_GET[$unique])){?>
																<input name="update" type="button" id="update" value="Book On Him!" class="btn" onclick="send();"/>
				<? }?>										</td>
                                        <td>
										<? if(isset($_GET[$unique])){?>
										<input name="reset" type="button" class="btn" id="reset" value="Reset" onclick="parent.location='<?=$page?>'" /><? }?>	</td>
                                        
                                      </tr>
                                    </table></div>								  </td>
                                </tr>
                              </table>
    </form>
							</div></td>
  </tr>
</table>