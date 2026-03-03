<?php
session_start();
session_destroy();
ob_start();

require_once "../../../scb_mod/support/default_values.php";
include('../../../scb_mod/common/db_connect_scb_main.php');


if(isset($_POST['ibssignin']))
{
	$passward = $_POST['pass'];
	$uid  = $_POST['uid'];
	$cid  = $_POST['cid'];

$sql="SELECT b.db_user,b.db_pass,b.db_name,a.cid,a.id FROM company_info a,database_info b WHERE a.cid='$cid' and a.id=b.company_id and a.status='ON' limit 1";
//echo $sql;
	$sql=@mysql_query($sql);
	if($proj=@mysql_fetch_object($sql))
	{

					$_SESSION['proj_id']	= $proj->cid;
					$_SESSION['db_name']	= $proj->db_name;
					$_SESSION['db_user']	= $proj->db_user;
					$_SESSION['db_pass']	= $proj->db_pass;
					
require_once "../../../scb_mod/common/db_connect.php";
		
		$user_sql="select * from user_activity_management where  username='$uid' AND password = '$passward' and status='Active'";
				$user_query=mysql_query($user_sql);
				if(mysql_num_rows($user_query)>0)
				{
				$proj_sql="select * from project_info limit 1";
				$proj=@mysql_fetch_object(mysql_query($proj_sql));
				$info=@mysql_fetch_row($user_query);
					
					$_SESSION['user']['level']	= $info[3];
					$_SESSION['user']['id']		= $info[0];
					$_SESSION['user']['fname']	= $info[4];
					
					$_SESSION['separator']='';
					$_SESSION['mhafuz']='Active';
					$_SESSION['voucher_type']=3;
					// 1 for voucher_print// 2 for keari // 3 for nirban;
					
					$_SESSION['company_name']=$_SESSION['proj_name']=$proj->proj_name;
					$_SESSION['company_address']=$proj->proj_address;
					$_SESSION['company_logo']='../images/'.$_SESSION['proj_id'].'.jpg';
					
//add_user_activity_log($_SESSION['user']['id'],1,1,'Login Page','Successfully Logged In',$_SESSION['user']['level']);
					header("Location:home.php");
				}
		}

}
?>

<div class="login_box">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td colspan="3"><img src="../../images/index_green_login_01.jpg" width="346" height="22" /></td>
                          </tr>
                          <tr>
                            <td><img src="../../images/index_green_login_02.jpg" width="33" height="197" /></td>
                            <td class="login_box_body">
							  <div class="form"><div class="form"><form method="POST" action="">
							  <table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
									<td>User name : </td>
									<td><input name="uid" type="text" class="input" id="uid" size="15" /></td>
								  </tr>
								  <tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								  </tr>
								  <tr>
									<td>Password:</td>
									<td><input name="pass" type="password" class="input" id="pass" size="15" /></td>
								  </tr>
								  <tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								  </tr>
								  <tr>
									<td>&nbsp;</td>
									<td><input name="ibssignin"  type="submit" class="btn" id="ibssignin" value="Login" /></td>
								  </tr>
								   <tr>
								     <td>&nbsp;</td>
								     <td>&nbsp;</td>
						        </tr>
								   <tr>
								     <td colspan="2">Forgot passwod? Change password.</td>
						        </tr>
								   <tr>
								     <td>&nbsp;</td>
								     <td>&nbsp;</td>
						        </tr>
								   <tr>
									<td colspan="2">New User? Register now</td>
								   </tr>
								</table>
								</form></div></div>							</td>
                            <td><img src="../../images/index_green_login_04.jpg" width="29" height="197" /></td>
                          </tr>
                          <tr>
                            <td colspan="3"><img src="../../images/index_green_login_05.jpg" /></td>
                          </tr>
                        </table>
                      </div>
<?
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout.php");
?>