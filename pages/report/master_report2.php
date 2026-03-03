<?
session_start();
require "../../common/check.php";
require "../../config/db_connect.php";
require "../../common/report.class.php";
require "../../common/my.php";
date_default_timezone_set('Asia/Dhaka');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title><?=$report?></title>
<link href="../../css/report2.css" type="text/css" rel="stylesheet" />
<script language="javascript">
function hide()
{
document.getElementById('pr').style.display='none';
}
</script>
</head>
<body>
<div align="center" id="pr">
<input type="button" value="Print" onclick="hide();window.print();"/>
</div>
<div class="main">
<table width="100%" cellspacing="0" cellpadding="2" border="0"><thead><tr><td style="border:0px;" colspan="3"><div class="header"></div><div class="right"><p><b>AB Bank Ltd. (29th AGM Attendance Sheet)</b></p></div><div class="right"></div></td></tr><tr>
  <th>BO ID &amp; Name </th>
  <th>BO Signature </th>
  <th>Signature</th>
</tr></thead>
<tbody>
<? 
$sql='select * from sheet1';
$query=mysql_query($sql);
while($data=mysql_fetch_object($query))
{
?>
<tr>
<td>
<b><?=$data->folio?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$data->dsno?></b><BR>
<?=$data->name?><BR>
<?=$data->address?><BR>

Bank:<?=$data->bank;?>; Br.:<?=$data->branch;?></td>
<td>
<? 
if(is_file('../../pic/'.$data->folio.'0101.jpg'))
$pic='../../pic/'.$data->folio.'0101.jpg';
elseif(is_file('../../pic/'.$data->folio.'.jpg'))
$pic='../../pic/'.$data->folio.'.jpg';
else
$pic='';

if($pic!='')
echo '<img src="'.$pic.'" width="300" height="80" />';
?></td>
<td>&nbsp;</td>
</tr>
<? }?>
</tbody></table>
</div>
</body>
</html>