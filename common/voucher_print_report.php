<?php
session_start();
require "../config/db_connect.php";
require_once ('../common/class.numbertoword.php');





$rec_no=$_REQUEST['rec_no'];


$s = "select fid,rec_date from tbl_receipt where 1 and rec_no=".$rec_no;

$q = mysql_query($s);

$r = mysql_fetch_object($q);

$fid = $r->fid;
$rec_date =  $r->rec_date;





//$fid=find_a_field('tbl_receipt','fid','rec_no="'.$rec_no.'"');
//$rec_date=find_a_field('tbl_receipt','rec_date','rec_no='.$rec_no);





$get_value="?rec_no=".$rec_no."&fid=".$fid."&rec_date=".$rec_date;
if($_SESSION['voucher_type']>1)
{
if($_SESSION['voucher_type']==2) header("Location:voucher_print_keari.php".$get_value);
if($_SESSION['voucher_type']==3) header("Location:voucher_print_nbr.php".$get_value);
}

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
</script>
</head>
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
                <td align="center" class="title"><div align="center"><img src="../logo/cropped-logo-modhu.png" /></div></td>
              </tr>
              <tr>
                <td align="center" class="title"><?
//echo $sqll="select a.proj_name,a.proj_add from tbl_project_info a, tbl_flat_info b where a.proj_code=b.proj_code and a.build_code=b.build_code and a.flat_no=b.flat_no and b.fid=".$fid;
$sqll="select a.proj_name,a.proj_add from tbl_project_info a, tbl_flat_info b where a.proj_code=b.proj_code and b.fid=".$fid." limit 1";
$data1=mysql_fetch_row(mysql_query($sqll));


$sql2="select a.party_name,a.pre_house,a.ah_mobile_tel from tbl_party_info a, tbl_flat_info b where a.party_code=b.party_code and b.fid=".$fid." limit 1";
$data2=mysql_fetch_row(mysql_query($sql2));


$sql3="select a.category from tbl_building_info a, tbl_flat_info b where  a.bid=b.build_code and b.fid=".$fid." limit 1";
$data3=mysql_fetch_row(mysql_query($sql3));


$sql4="select flat_no from tbl_flat_info  where  fid=".$fid." limit 1";
$data4=mysql_fetch_row(mysql_query($sql4));



?>
                  <?=$_SESSION['company_name']?></td>
                </tr>
              <tr>
                <td align="center"><?=$_SESSION['company_address']?></td>
                </tr>
              
            </table></td>
            </tr>

        </table></td>
	    </tr>
	  <tr>
	    <td><div align="center"><span style="border:1px solid black; padding: 3px 5px; font-size:15px; background:#E7E9ED;">Money Receipt</span></div></td>
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
        <td colspan="2" class="tabledesign_text"><span style="background:#E7E9ED; padding: 3px; border: 1px solid gray;"> Receipt No  :  <?=$_REQUEST['rec_no']?></span></td>
        <td colspan="2" align="right" class="tabledesign_text"><span style="background:#E7E9ED; padding: 3px; border: 1px solid gray;">Receipt Date : 
          <?=$rec_date?></span></td>
        </tr>
    </table>
      <p>&nbsp;</p>
      <table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
        <tr>
          <td colspan="3" class="tabledesign_text"><div id="div">
              <div align="left">              </div>
          </div></td>
        </tr>
        <tr>
          <td width="26%" class="tabledesign_text">Received with thanks from</td>
          <td width="2%" class="tabledesign_text"><strong>:</strong></td>
          <td width="72%" class="tabledesign_text"><?=$data2[0]?></td>
        </tr>
        <tr>
          <td class="tabledesign_text"><span>Address</span></td>
          <td class="tabledesign_text"><strong>:</strong></td>
          <td class="tabledesign_text"><?=$data2[1]?></td>
        </tr>
		
		 <tr>
          <td class="tabledesign_text">Mobile No </td>
          <td class="tabledesign_text"><strong>:</strong></td>
          <td class="tabledesign_text"><?=$data2[2]?></td>
        </tr>
      </table>
      <table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
      <tr>
        <td colspan="3" class="tabledesign_text">&nbsp;</td>
        </tr>
      <tr>
        <td width="26%" class="tabledesign_text">Agains t </td>
        <td width="2%" class="tabledesign_text"><strong>:</strong></td>
        <td width="72%" class="tabledesign_text"><?=$data1[0]?>
,
  <?=$data3[0]?>
, #
<?=$data4[0]?></td>
      </tr>
      <tr>
        <td width="26%" class="tabledesign_text">Project Address </td>
        <td width="2%" class="tabledesign_text"><strong>:</strong></td>
        <td width="72%" class="tabledesign_text"><?=$data1[1]?></td>
        </tr>
    </table>
      <p>&nbsp;</p>
      <table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
        <tr>
          <td colspan="6" class="tabledesign_text"><div id="div2">
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
          <td width="26%" class="tabledesign_text" style="background: #E7E9ED; padding: 2px; border: 1px solid white;">Chaque No: </td>
          <td width="2%" class="tabledesign_text" style="background: #E7E9ED; padding: 2px; border: 1px solid white;"><strong>:</strong></td>
          <td width="17%" class="tabledesign_text" style="background: #E7E9ED; padding: 2px; border: 1px solid white;"><? echo $data[0];?></td>
          <td width="22%" class="tabledesign_text"  style="background: #E7E9ED; padding: 2px;  border: 1px solid white;">Bank</td>
          <td width="1%" class="tabledesign_text" style="background: #E7E9ED; padding: 2px; border: 1px solid white;"><strong>:</strong></td>
          <td width="32%" class="tabledesign_text" style="background: #E7E9ED; padding: 2px; border: 1px solid white;"><?=$data[2]?></td>
        </tr>
        <tr>
          <td class="tabledesign_text"  style="background: #E7E9ED; padding: 2px;  border: 1px solid white;">Branch:</td>
          <td class="tabledesign_text" style="background: #E7E9ED; padding: 2px; border: 1px solid white;"><strong>:</strong></td>
          <td class="tabledesign_text" style="background: #E7E9ED; padding: 2px; border: 1px solid white;"><?=$data[3]?>&nbsp;</td>
          <td class="tabledesign_text"  style="background: #E7E9ED; padding: 2px;  border: 1px solid white;">Cash/Chaque Date</td>
          <td class="tabledesign_text" style="background: #E7E9ED; padding: 2px; border: 1px solid white;"><strong>:</strong></td>
          <td class="tabledesign_text" style="background: #E7E9ED; padding: 2px; border: 1px solid white;"><?=$data[1]?></td>
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
                <?=CLASS_Numbertoword::convert(((int)$data[4]),'en')?>
Only) </div></td>
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
        <td align="center" valign="bottom">
		
		
		<? $s='select b.fname from tbl_receipt_details a, user_activity_management b where 1 and a.p_by=b.user_id and a.rec_no='.$_GET['rec_no'];
		$q=mysql_query($s);
		while($r=mysql_fetch_object($q)){ echo $r->fname;}
		?>
		
		
		
		</td>
        <td align="center" valign="bottom">&nbsp;</td>
        <td align="center" valign="bottom">&nbsp;</td>
      </tr>
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
