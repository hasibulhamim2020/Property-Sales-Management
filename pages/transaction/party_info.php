<?php
session_start();
require "../../support/inc.all.php";

if($_GET['party_code'])
{
$sql='select * from tbl_party_info where party_code='.$_GET['party_code'].' limit 1';
$query=mysql_query($sql);
if(mysql_num_rows($query))
{
$data=mysql_fetch_object($query);
}
}
?>
<table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#3f590a" bgcolor="#c7eb8e" style="border:1px solid #3f590a; border-collapse:collapse; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px; color:#000000;">
  <tr bgcolor="#679435">
    <td colspan="2" align="center" style="padding:3px; font-weight:bold;  font-size:13px; color:#FFFFFF;">Party Information </td>
  </tr>
  <tr bgcolor="#f8fbc1">
    <td width="39%" align="right" style="padding:5px;">Party Code : </td>
    <td width="61%" align="left"><?=$data->party_code?>&nbsp;</td>
  </tr>
  <tr>
    <td align="right" style="padding:5px;">Party Name : </td>
    <td align="left"><?=$data->party_name?></td>
  </tr>
  <tr bgcolor="#f8fbc1">
    <td style="padding:5px;" align="right">Party Address : </td>
    <td align="left"><?=$data->pre_house?></td>
  </tr>
  <tr>
    <td style="padding:5px;" align="right">Party Contact No. : </td>
    <td align="left"><?=$data->ah_mobile_tel?></td>
  </tr>
  <tr bgcolor="#f8fbc1">
    <td style="padding:5px;" align="right">Party Telephone (Off) : </td>
    <td align="left"><?=$data->pre_tel_of?></td>
  </tr>
</table>

