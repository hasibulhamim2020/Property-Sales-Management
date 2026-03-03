<?php
session_start();
ob_start();
require "../../support/inc.all.php";
$title='Create User';

include('../../config/db_connect.php');

if(isset($_POST['save']))
{
                         $id=$_POST['user_id'];
                         $name=$_POST['name'];
                         $pass=$_POST['pass'];
                         $con_pass=$_POST['con_pass'];
                 if($pass==$con_pass )
				 {

                        $sql="INSERT INTO `tbl_user_info` (
                        `id` ,
                        `name` ,
                        `pass`
                        )
                        VALUES ('$id','$name','$con_pass')";
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
                                        <td align="right">Password: </td>
                                        <td align="right"><input name="pass" id="pass" type="password"/></td>
                                      </tr>
                                      
                                      <tr>
                                        <td align="right">Confirm Pass: </td>
                                        <td align="right"><input name="con_pass" id="con_pass" type="password"/></td>
                                      </tr>
                                      
                                      
                                      
                                      
                                      <tr>
                                        <td>&nbsp;</td>
										<td>
										<table width="20%" border="0" cellspacing="0" cellpadding="0" align="left">
											  <tr>
												<td><input class="btn"  type="submit" name="save" id="save" value="Save" /></td>
												<td><input  class="btn"type="button" name="close" id="close" value="Cancel" /></td>
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