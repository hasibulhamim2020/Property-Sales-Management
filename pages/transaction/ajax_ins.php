<?php
session_start();
//require "../../config/inc.all.php";
require "../../support/inc.all.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');
$str = $_POST['data'];
$data=explode('##',$str);

?>
<select name="inst_no" id="inst_no">
<? 
$sql='select b.inst_no,b.inst_no
from tbl_flat_cost_installment b, tbl_flat_info c 
where 
b.fid=c.fid 
and b.pay_code="'.$data[0].'"
and c.fid="'.$_SESSION["fid"].'"';
join_relation($sql,'');
?>
</select>
