<?php
session_start();
require "../config/db_connect.php";
require "../common/my.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');
$str = $_POST['ledger'];
?>
<select name="building" id="building" onchange="getflatData();">
<? 
$con="proj_code=$str";
foreign_relation('tbl_building_info','build_code','build_code','',$con);?>
</select>