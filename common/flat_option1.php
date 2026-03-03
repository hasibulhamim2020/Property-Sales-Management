<?php
session_start();
require "../config/db_connect.php";
require "../common/my.php";
require "../common/crud.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');
$str = $_POST['ledger'].'%';
$table='tbl_party_info';
$page="party_info.php";
$crud      =new crud($table);
$res='select party_code,party_code,party_name,per_add from tbl_party_info where party_name like \''.$str.'\'';
echo $crud->link_report($res,$link);
?>
	