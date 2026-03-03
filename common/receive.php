<?
session_start();
require "../config/db_connect.php";
require "../common/my.php";
$rent_id=$_GET['rent_id'];

$r=$_GET['a1'];

$e=$_GET['a2'];

$w=$_GET['a3'];

$g=$_GET['a4'];

$o=$_GET['a5'];

$t=$_GET['a6'];

$party_code=$_GET['a7'];

$proj_code=$_GET['a8'];

$period=$_GET['a9'];

$flat_no=$_GET['a10'];
$jv=db_last_insert_id('journal','jv_no');
if($jv<1)$jv=201101011001;

$find="select jv_no from tbl_rent_receive where mon='$period' and rent_id='$rent_id'";
$found=mysql_query($find);
if(mysql_num_rows($found)>0)
{
$data=mysql_fetch_row($found);
$jv_no=$data[0];
$del=mysql_query("delete from tbl_rent_receive where jv_no='$jv_no'");
$del=mysql_query("delete from journal where jv_no='$jv_no'");
}

$narr='Income From Rent Period: '.$period;
$jv_date=time();

$sql="INSERT INTO `tbl_rent_receive` (`jv_no`, `proj_code`, `flat_no`, `mon`, `rent_id`, `party_code`, `rent_amt`, `electricity_bill`, `wasa_bill`, `gas_bill`, `other_bill`, `total_amt`) VALUES ('$jv', '$proj_code', '$flat_no', '$period', '$rent_id', '$party_code','$r','$e','$w','$g','$o','$t')";
mysql_query($sql);
$sql1=mysql_query("INSERT INTO `journal` (`proj_id`, `jv_no`, `jv_date`, `ledger_id`, `narration`, `dr_amt`, `cr_amt`, `tr_from`) VALUES ('Asset', '$jv', '$jv_date', '$rent_id', '$narr', '$t', '0', 'Rent')");

$sql2=mysql_query("INSERT INTO `journal` (`proj_id`, `jv_no`, `jv_date`, `ledger_id`, `narration`, `dr_amt`, `cr_amt`, `tr_from`) VALUES ('Asset', '$jv', '$jv_date', '100011', '$narr', '0', '$t', 'Rent')");
echo '<font color="green">SUCCESS</font>';


?>
