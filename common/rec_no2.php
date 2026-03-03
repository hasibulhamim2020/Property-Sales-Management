<?php
session_start();
require "../config/db_connect.php";
require "../common/my.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');
$str = $_POST['ledger'];
 
$res='select party_code,party_code,party_name,per_add,per_tel from tbl_party_info where party_code = '.$str.' limit 5';
echo ajax_report($res,'../../common/rec_no2.php','hid');?>
<table width="100%" border="0" cellspacing="2" cellpadding="0">
                                      <tr>
                                        <td >Received No:   </td>
                                       <td ><input name="user_id" id="user_id" type="text" /></td>
                                      
                                       <td >Realize Date:  </td>
                                        <td ><input name="name" id="name" type="text" /></td>
                                      
                                        <td >Total:  </td>
                                       <td ><input name="name" id="name" type="text" /></td>
                                      </tr>
</table>