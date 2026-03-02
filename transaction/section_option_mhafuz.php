<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
 
  $str = $_POST['data'];
$data=explode('##',$str);
  $con="select a.section_id,a.section_name from tbl_add_section a where a.proj_id='".$data[0]."'";
 

$q=db_query($con);
?>
<select name="section_name" id="section_name" onchange="getData2('flat_option_mhafuz.php', 'fid', document.getElementById('proj_code').value,this.value);" >
<?
while($r=mysqli_fetch_object($q)){
?>
<option></option>
<option value="<?=$r->section_id?>"><?=$r->section_name?></option>
<?
}
?>
</select>