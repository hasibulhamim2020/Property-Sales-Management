<?php
session_start();
require "../config/db_connect.php";
require "../common/my.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');
$str = $_POST['ledger'];
$res='select a.rec_no,a.pay_code,b.pay_desc,a.inst_amount,a.rcv_amount from tbl_flat_cost_installment a,tbl_payment_head b,tbl_flat_info c where a.pay_code=b.pay_code and a.flat_no=c.flat_no and a.build_code=c.build_code and a.proj_code=c.proj_code and c.fid='.$str;
echo link_report($res);?>