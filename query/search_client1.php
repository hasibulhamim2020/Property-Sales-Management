<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once SERVER_CORE."routing/layout.top.php";

//@ini_set('error_reporting', E_ALL);
//@ini_set('display_errors', 'Off');


$str = $_POST['ledger'];
$res='select a.rec_no,a.rec_no,a.rec_date,a.cheq_no,a.cheq_date,a.rec_amount as amount from tbl_receipt a, tbl_flat_info c where a.flat_no=c.flat_no and a.build_code=c.build_code and a.proj_code=c.proj_code and c.fid='.$str;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div class="tabledesign1"><? echo ajax_report($res,'../../common/rec_no.php','iid');?></div></td>
</tr>
</table>