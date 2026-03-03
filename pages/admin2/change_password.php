<?php
session_start();
ob_start();
require "../../support/inc.all.php";
$title='Change Password';

//echo $proj_id;

if(isset($_POST['ok']))
{
                         $id=$_POST['user_id'];
                         $name=$_POST['name'];
                         $old_pass=$_POST['old_pass'];
						 $new_pass=$_POST['new_pass'];  
                         $con_pass=$_POST['con_pass'];
						 						 
                 if($new_pass==$con_pass )
				 {

                       $sql="UPDATE `tbl_user_info` SET 
						`name` = '$name',
						`pass` = '$new_pass'
						 WHERE `id` = $id and `pass`='$old_pass'";
						 
                        //echo $sql;
                        $query=mysql_query($sql);
						$msg='New Entry Successfully Inserted.';
               }
			   
			   else
			     {
			     echo "Password and confirm password are not matched";
                }
        
}


?>
<script type="text/javascript">
function DoNav(theUrl)
{
	document.location.href = 'ledger_account2_report.php?g_id='+theUrl;
}
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div class="left_report">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
								    <td><div class="box"><form id="form1" name="form1" method="post" action=""><table width="100%" border="0" cellspacing="2" cellpadding="0">
                                      <tr>
                                        <td width="40%" align="right">
		                                                                User Id:   </td>
                                        <td width="60%" align="right"><input name="user_id" id="user_id" type="text" /></td>
                                      </tr>
                                      <tr>
                                        <td align="right">User Name:  </td>
                                        <td align="right"><input name="name" id="name" type="text" /></td>
                                      </tr>
                                      
                                      
                                      
                                      <tr>
                                        <td align="right">Old Password: </td>
                                        <td align="right"><input name="old_pass" id="old_pass" type="text" /></td>
                                      </tr>
                                      
                                      
                                      <tr>
                                        <td align="right">New Password: </td>
                                        <td align="right"><input name="new_pass" id="new_pass" type="text" /></td>
                                      </tr>
                                      
                                      <tr>
                                        <td align="right">Confirm Pass: </td>
                                        <td align="right"><input name="con_pass" id="con_pass" type="text" /></td>
                                      </tr>
                                      
                                      <tr>
                                        <td>&nbsp;</td>
										<td>
										<table width="20%" border="0" cellspacing="0" cellpadding="0" align="left">
											  <tr>
											    <td><input class="btn"  type="submit" name="ok" id="ok" value="OK" /></td>
												<td><input  class="btn"type="button" name="cancel" id="cancel" value="Cancel" /></td>
											  </tr>
											</table></td>
                                      </tr>
                                    </table>
								    </form></div></td>
						      </tr>
								  <tr>
									<td>&nbsp;</td>
								  </tr>
								  <tr>
									<td>
									<div id="pageNavPosition"></div>									</td>
								  </tr>
		</table>

							</div></td>
    
  </tr>
</table>

<?
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout.php");
?>