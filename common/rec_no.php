<?php
session_start();
require "../config/db_connect.php";
require "../common/my.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');
$str = $_POST['ledger'];
 
$res='select a.rec_no,a.pay_code,b.pay_desc,a.inst_amount as due_amount,a.rec_amount from tbl_receipt_details a,tbl_payment_head b where a.pay_code=b.pay_code and a.rec_no='.$str;
$view=link_report($res);
if($view!=''){
echo $view;
?>
<table width="1" border="0" align="center" cellpadding="0" cellspacing="0" border="0">
  <tr>
    <td align="center"><form id="form1" name="form1" method="post" action="">
      <input name="del_rec_no" type="hidden" id="del_rec_no" value="<?=$str?>" />
      <input name="del" type="submit" id="del" value="Delete it!" />
        </form>
    </td>
  </tr>
</table><? }?>