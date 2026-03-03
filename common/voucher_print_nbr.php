<?php
session_start();
//var_dump($_SESSION);
require "../config/db_connect.php";
require_once ('../common/class.numbertoword.php');
$fid=$_REQUEST['fid'];
$rec_no=$_REQUEST['rec_no'];
$rec_date=$_REQUEST['rec_date'];
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Voucher :.</title>
<link href="../css/voucher_print.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript">
function hide()
{
    document.getElementById("pr").style.display="none";
}
</script></head>
<body>
<table width="900" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><div class="header">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="center" class="title"><?
//echo $sqll="select a.proj_name,a.proj_add from tbl_project_info a, tbl_flat_info b where a.proj_code=b.proj_code and a.build_code=b.build_code and a.flat_no=b.flat_no and b.fid=".$fid;
$sqll="select a.proj_name,a.proj_add from tbl_project_info a, tbl_flat_info b where a.proj_code=b.proj_code and b.fid=".$fid." limit 1";
$data1=mysql_fetch_row(mysql_query($sqll));


$sql2="select a.party_name from tbl_party_info a, tbl_flat_info b where a.party_code=b.party_code and b.fid=".$fid." limit 1";
$data2=mysql_fetch_row(mysql_query($sql2));


$sql3="select a.category from tbl_building_info a, tbl_flat_info b where  a.bid=b.build_code and b.fid=".$fid." limit 1";
$data3=mysql_fetch_row(mysql_query($sql3));


$sql4="select flat_no from tbl_flat_info  where  fid=".$fid." limit 1";
$data4=mysql_fetch_row(mysql_query($sql4));

?>
                  <?=$_SESSION['company_name']?></td>
                </tr>
              <tr>
                <td align="center"><?=$_SESSION['company_address']?>&nbsp;</td>
                </tr>
              
            </table></td>
            </tr>

        </table></td>
	    </tr>
	  <tr>
	    <td>&nbsp;</td>
	  </tr>
    </table>
    </div></td>
  </tr>
  <tr>
    
	<td>	</td>
  </tr>
  
  <tr>

    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><div id="pr">
          <div align="left">
            <input name="button" type="button" onclick="hide();window.print();" value="Print" />
          </div>
        </div></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr bordercolor="#000000">
        <td colspan="2" class="tabledesign_text"> Receipt No  : 
          <?=$_REQUEST['rec_no']?></td>
        <td colspan="2" align="right" class="tabledesign_text">Receipt Date : 
          <?=$_REQUEST['rec_date']?></td>
        </tr>
    </table>
      <p>&nbsp;</p>
      <table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
        <tr>
          <td colspan="2" class="tabledesign_text"><div id="div">
              <div align="left">
                <?
//echo $sqll="select a.proj_name,a.proj_add from tbl_project_info a, tbl_flat_info b where a.proj_code=b.proj_code and a.build_code=b.build_code and a.flat_no=b.flat_no and b.fid=".$fid;
$sqll="select a.proj_name,a.proj_add from tbl_project_info a, tbl_flat_info b where a.proj_code=b.proj_code and b.fid=".$fid." limit 1";
$data1=mysql_fetch_row(mysql_query($sqll));


$sql2="select a.party_name,a.party_name,a.pre_house,a.pre_road,a.pre_village,a.pre_postcode,a.pre_postoffice,a.pre_district from tbl_party_info a, tbl_flat_info b where a.party_code=b.party_code and b.fid=".$fid." limit 1";
$data2=mysql_fetch_row(mysql_query($sql2));


$sql3="select a.category from tbl_building_info a, tbl_flat_info b where  a.bid=b.build_code and b.fid=".$fid." limit 1";
$data3=mysql_fetch_row(mysql_query($sql3));


$sql4="select flat_no from tbl_flat_info  where  fid=".$fid." limit 1";
$data4=mysql_fetch_row(mysql_query($sql4));

?>
              </div>
          </div></td>
        </tr>
        <tr>
          <td width="25%" class="tabledesign_text">Received with thanks from</td>
          <td width="75%" class="tabledesign_text"> :
<?=$data2[1]?></td>
        </tr>
        <tr>
          <td class="tabledesign_text">Address</td>
          <td class="tabledesign_text"> :
<?=$data2[2].', '.$data2[3].', '.$data2[4].', '.$data2[5].', '.', '.$data2[6].', '.', '.$data2[7];?></td>
        </tr>
      </table>
      <table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
      <tr>
        <td colspan="2" class="tabledesign_text">&nbsp;</td>
        </tr>
      <tr>
        <td width="25%" class="tabledesign_text">Against</td>
        <td width="75%" class="tabledesign_text"> :
<?=$data1[0];?>
,
  <?=$data3[0]?>
, #
<?=$data4[0]?></td>
      </tr>
      <tr>
        <td width="25%" class="tabledesign_text">Project Address</td>
        <td width="75%" class="tabledesign_text"> :
<?=$data1[1]?></td>
        </tr>
    </table>
      <p>&nbsp;</p>
      <table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
        <tr>
          <td colspan="4" class="tabledesign_text"><div id="div2">
              <div align="left">
                	  <?
$sql="select 
cheq_no, 
cheq_date, 
bank_name, 
branch,
sum(rec_amount)  from tbl_receipt where rec_no=".$rec_no." limit 1";
$data=mysql_fetch_row(mysql_query($sql));

?>
              </div>
          </div></td>
        </tr>
        <tr>
          <td width="14%" class="tabledesign_text">Bank</td>
          <td width="7%" class="tabledesign_text"> : 
          <?=$data[2]?></td>
          <td width="8%" class="tabledesign_text">Cash/Chaque No</td>
          <td width="27%" class="tabledesign_text"> :
          <? if(is_numeric($data[0])) echo $data[0];?></td>
        </tr>
        <tr>
          <td class="tabledesign_text">Branch</td>
          <td class="tabledesign_text"> :
<?=$data[3]?>&nbsp;</td>
          <td class="tabledesign_text">Cash/Chaque Date: </td>
          <td class="tabledesign_text"> :
<?=$data[1]?></td>
        </tr>
      </table></td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" class="tabledesign" border="0" cellspacing="0" cellpadding="0">

      <tr>
        <td width="27%"><table class="tabledesign1" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left" valign="top">Amount  : <?=number_format($data[4],2)?></td>
            <td valign="bottom">&nbsp;</td>
          </tr>
          <tr>
            <td width="75%" valign="top"><div align="left">Amount in Word : (Taka
                <?=CLASS_Numbertoword::convert(((int)$data[4]),'en')?> Only) </div></td>
            <td width="25%" valign="bottom"><table  cellspacing="0" cellpadding="0">
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>........................................<br />
                Receiver Singnature </td>
              </tr>
            </table></td>
          </tr>
        </table></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="tabledesign_text"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center" valign="bottom">..........................................</td>
        <td align="center" valign="bottom">..........................................</td>
        <td align="center" valign="bottom">..........................................</td>
      </tr>
      <tr>
        <td width="33%"><div align="center">Prepared by </div></td>
        <td width="33%"><div align="center">Accountant</div></td>
        <td width="34%"><div align="center">Authorised Singnature </div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
