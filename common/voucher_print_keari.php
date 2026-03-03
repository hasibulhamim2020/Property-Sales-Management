<?php
session_start();
require "../config/db_connect.php";
require_once ('../common/class.numbertoword.php');
$fid=$_REQUEST['fid'];
$rec_no=$_REQUEST['rec_no'];
$rec_date=$_REQUEST['rec_date'];

//echo $sqll="select a.proj_name,a.proj_add from tbl_project_info a, tbl_flat_info b where a.proj_code=b.proj_code and a.build_code=b.build_code and a.flat_no=b.flat_no and b.fid=".$fid;
$sqll="select a.proj_name,a.proj_add from tbl_project_info a, tbl_flat_info b where a.proj_code=b.proj_code and b.fid=".$fid." limit 1";
$data1=mysql_fetch_row(mysql_query($sqll));


$sql2="select a.party_name,a.per_add from tbl_party_info a, tbl_flat_info b where a.party_code=b.party_code and b.fid=".$fid." limit 1";
$data2=mysql_fetch_row(mysql_query($sql2));


$sql3="select a.category from tbl_building_info a, tbl_flat_info b where  a.bid=b.build_code and b.fid=".$fid." limit 1";
$data3=mysql_fetch_row(mysql_query($sql3));


$sql4="select flat_no from tbl_flat_info  where  fid=".$fid." limit 1";
$data4=mysql_fetch_row(mysql_query($sql4));

$sql="select 
cheq_no, 
cheq_date, 
bank_name, 
branch,
sum(rec_amount)  from tbl_receipt where rec_no=".$rec_no." limit 1";
$data=mysql_fetch_row(mysql_query($sql));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Keari Limited Voucher Print</title>
<style type="text/css">
<!--
body {margin:0;border:0;font-family:"Courier New", Courier, monospace;font-size:16px;line-height:16px}
#slNo {
	position:absolute;
	left:1.9cm;
	top:3.704cm;
	width:159px;
	height:22px;
	z-index:2;
}
#dateTop {
	position:absolute;
	left:15.1cm;
	top:3.651cm;
	width:154px;
	height:22px;
	z-index:3;
}
#name {
	position:absolute;
	left:5.953cm;
	top:4.419cm;
	width:546px;
	height:35px;
	z-index:4;
}
#address {
	position:absolute;
	left:2.91cm;
	top:5.318cm;
	width:661px;
	height:35px;
	z-index:5;
}
#amountInWord {
	position:absolute;
	left:6.244cm;
	top:6.191cm;
	width:535px;
	height:35px;
	z-index:6;
}
#accNo {
	position:absolute;
	left:4.736cm;
	top:7.964cm;
	width:134px;
	height:22px;
	z-index:7;
}
#bankName {
	position:absolute;
	left:10.742cm;
	top:7.514cm;
	width:361px;
	height:35px;
	z-index:8;
}
#bankBranch {
	position:absolute;
	left:2.857cm;
	top:8.546cm;
	width:262px;
	height:35px;
	z-index:9;
}
#dateCheque {
	position:absolute;
	top:9.022cm;
	width:351px;
	height:22px;
	z-index:10;
	left: 10.874cm;
}
#against {
	position:absolute;
	left:2.857cm;
	top:362px;
	width:654px;
	height:35px;
	z-index:11;
}
#amount {
	position:absolute;
	left:2.91cm;
	top:12.356cm;
	width:141px;
	height:22px;
	z-index:12;
}
.v_align {display: table-cell; vertical-align: bottom;height:35px}
-->
</style>
</head>

<body onload="window.print()">
<div id="slNo"><?=$_REQUEST['rec_no']?></div>
<div id="dateTop"><?=$_REQUEST['rec_date']?></div>
<div id="name">
  <div class="v_align"><?=$data2[0]?></div>
</div>
<div id="address">
  <div class="v_align"><?=$data2[1]?></div>
</div>
<div id="amountInWord">
  <div class="v_align">Taka <?=CLASS_Numbertoword::convert(((int)$data[4]),'en')?> only</div>
</div>
<div id="accNo"><? if(is_numeric($data[0])) echo $data[0];?></div>
<div id="bankName">
  <div class="v_align"><?=$data[2]?></div>
</div>
<div id="bankBranch">
  <div class="v_align"><?=$data[3]?></div>
</div>    
<div id="dateCheque"><?=$data[1]?></div>
<div id="against">
	<div class="v_align"><?=$data1[0]?>, <?=$data3[0]?>, #<?=$data4[0]?></div>
</div>
<div id="amount"><?=number_format($data[4],2)?></div>
</body>
</html>
