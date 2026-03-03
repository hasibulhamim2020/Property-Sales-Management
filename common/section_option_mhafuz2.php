<?php
session_start();
require "../config/db_connect.php";
require "../common/my.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');
$str = $_POST['data'];
$data=explode('##',$str);
$con="select a.section_id,a.section_name from add_section a where a.proj_id=".$data[0]."";
?>
<select name="section_name" id="section_name" onchange="getData2('../../common/flat_option_mhafuz2.php', 'fid', document.getElementById('proj_code').value,this.value);">
<? join_relation($con);?>
</select>