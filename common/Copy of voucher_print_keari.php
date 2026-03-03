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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Voucher :.</title>
<style>
body 
{
	background-color: #ffffff;	
	font-family:"Courier New", Courier, monospace;
	font-size:14px;
	margin:0px 0px 0px 0px;
	color:#000000;
	text-align:left;
	text-decoration:none;
}
.wrapper
{
width:816px;
height:528px;
margin:0px auto 0px auto;
}
.main
{
width:624px;
height:345px;
margin:132px auto 0px auto;
}
.no
{
width:441px;
margin-left:5px;
float:left;
text-align:left;
margin-top:5px;
}
.date
{
width:100px;
float:left;
text-align:left;
margin-left:60px;
}
.receive
{
width:458px;
margin-top:34px;
margin-left:163px;
clear:both;
float:left;
text-align:left;
}
.add
{
width:566px;
margin-top:13px;
margin-left:57px;
clear:both;
float:left;
text-align:left;
}
.sum
{
width:458px;
margin-top:16px;
margin-left:163px;
clear:both;
float:left;
text-align:left;
}
.cash
{
width:185px;
margin-left:115px;
float:left;
margin-top:34px;
text-align:left;
}
.bank
{
width:278px;
float:left;
margin-left:40px;
margin-top:34px;
text-align:left;
}
.branch
{
width:260px;
margin-left:48px;
float:left;
margin-top:27px;
text-align:left;
}
.date2
{
width:270px;
float:left;
margin-left:40px;
margin-top:26px;
text-align:left;
}
.again
{
width:570px;
margin-top:26px;
margin-left:52px;
clear:both;
float:left;
text-align:left;
}
.taka
{
width:152px;
margin-top:67px;
margin-left:52px;
clear:both;
float:left;
text-align:left;
}
</style>
</head>
<body>
<div class="wrapper">
  <div class="main">
					 <div class="no"><?=$_REQUEST['rec_no']?></div>
					 <div class="date"><?=$_REQUEST['rec_date']?></div>
					 
					 <div class="receive"><?=$data2[0]?></div>
					 <div class="add"><?=$data2[1]?></div>
					 <div class="sum">Taka <?=CLASS_Numbertoword::convert(((int)$data[4]),'en')?> only</div>
					 
					 <div class="cash"><? if(is_numeric($data[0])) echo $data[0];?></div>
					 <div class="bank"><?=$data[2]?></div>
					 
					 <div class="branch"><?=$data[3]?></div>
					 <div class="date2"><?=$data[1]?></div>
					 
					 <div class="again"><?=$data1[0]?>, <?=$data3[0]?>, #<?=$data4[0]?></div>
					 
					 <div class="taka"><?=number_format($data[4],2)?></div>
					 
  </div>
</div>
</body>
</html>