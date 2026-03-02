<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');
$str = $_POST['data'];
$data=explode('##',$str);



  $con="select a.fid,a.flat_no,a.road_no from tbl_flat_info a where a.proj_code=".$data[0]." and a.section_name=".$data[1];
$q=db_query($con);
?>
<select name="flat" id="flat">
<?
while($r=mysqli_fetch_object($q)){
?>
<option></option>
<option value="<?=$r->fid?>"><?=$r->road_no?>::<?=$r->flat_no?></option>
<?
}
?>
</select>