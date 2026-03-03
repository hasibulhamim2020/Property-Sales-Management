<?php
session_start();
require "../config/db_connect.php";
require "../common/my.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');
$str = $_POST['ledger'];

$res='select b.cslno,b.cslno,b.comment,b.cdate,b.emp_id from tbl_flat_info a,tbl_comment b where a.proj_code=b.proj_code and a.build_code=b.build_code and a.flat_no=b.flat_no and a.fid='.$str.' order by cslno ';
$view=link_report($res);
if($view!=''){
echo $view;
?>
<table width="1" align="center" cellpadding="0" cellspacing="0" border="0">
  <tr>
    <td align="center"><a href = "../setup/party_info.php?flat_no=1" title = "Party Information" rel = "gb_page_center[800, 560]">New</a>
    </td>
  </tr>
</table><? }?>