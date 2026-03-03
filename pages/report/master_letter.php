<?
session_start();
require "../../common/check.php";
require "../../config/db_connect.php";
require "../../common/letter_issue.php";
require "../../common/my.php";
date_default_timezone_set('Asia/Dhaka');

if(isset($_POST['submit'])&&isset($_POST['report'])&&$_POST['report']>0)
{
	if($_POST['proj_code']>0)
	{
		$proj_code=$_POST['proj_code'];
	if(isset($_POST['flat_no'])&&$_POST['flat_no']!=''&&$_POST['proj_code']>0)
		$flat_no=$_POST['flat_no'];

	}
	if($_POST['party_code']>0)
	$party_code=$_POST['party_code'];

switch ($_POST['report']) {
    case 1:
	$letter="Offer Letter";
	$letter_content=offer_letter();
	break;
    case 2:
	$letter="Pay Due Installment";
	$letter_content=pay_due_installment();
	break;
    case 3:
	$letter="POSSESSION LETTER";
	$letter_content=possession_letter();
	break;
    case 4:
	$letter="Due Installment";
	$letter_content=due_installment();
	break;
    case 5:
	$letter="Thanks Letter";
	$letter_content=thanks_letter();
	break;
    case 6:
	$letter="Request For Due Letter";
	$letter_content=request_due();
	case 7:
	$letter="Address Code";
	$letter_content=address_code($proj_code,$flat_no,$party_code);
	break;
}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title><?=$letter?></title>
<link href="../../css/letter.css" type="text/css" rel="stylesheet" />
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
<?
if(isset($letter_content)&&$letter_content!='') echo $letter_content;
?></div>
</body>
</html>