<?php
session_start();
require "../config/db_connect.php";
require "../common/my.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');
$str = $_POST['ledger'];
$res='select a.rec_no,c.pay_code as code,c.pay_desc,sum(a.inst_amount) as inst_amount, sum(a.rcv_amount) as rcv_amount from tbl_flat_cost_installment a,tbl_flat_info b,tbl_payment_head c where a.pay_code=c.pay_code and a.proj_code=b.proj_code and a.build_code=b.build_code and a.flat_no=b.flat_no and b.fid='.$str.' group by a.pay_code';
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div class="tabledesign1"><? echo link_report($res);?></div></td>
</tr>
<tr>
<td style="text-align:center"><input name="payment" type="button" class="btn" id="payment" value="View CRM Review" onclick="getData('../../common/rec_no_crm.php', 'iid', document.getElementById('flat').value);" /></td>
</tr>
</table>