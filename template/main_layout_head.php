<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Cloud Account Book :.</title>
<link href="../../css/style.css" type="text/css" rel="stylesheet"/>
<link href="../../css/menu.css" type="text/css" rel="stylesheet"/>
<link href="../../css/table.css" type="text/css" rel="stylesheet"/>
<link href="../../css/pagination.css" rel="stylesheet" type="text/css" />
<link href="../../css/jquery-ui-1.8.2.custom.css" rel="stylesheet" type="text/css" />
<link href="../../css/jquery.autocomplete.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../js/jquery-ui-1.8.2.custom.min.js"></script>
<script type="text/javascript" src="../../js/jquery.ui.datepicker.js"></script>
<script type="text/javascript" src="../../js/jquery.autocomplete.js"></script>
<script type="text/javascript" src="../../js/jquery.validate.js"></script>
<script type="text/javascript" src="../../js/paging.js"></script>
<script type="text/javascript" src="../../js/ddaccordion.js"></script>
<script type="text/javascript" src="../../js/js.js"></script>
<script type="text/javascript">

  $(document).ready(function(){
    $("#form2").validate();
  });

</script>
<?=$head?>
<? if($support=='accounts_ledger') include('../support/accounts_ledger.php');?>
<? if($support=='accounts_sub_ledger') include('../support/accounts_sub_ledger.php');?>
</head>
<body>
<div class="wrapper" align="">
			<div class="header">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td>
				<img src="../../../logo/<?=$_SESSION['proj_id']?>sajeeb_homes.jpg" width="355" height="72" border="0" />				</td>
				<td><div class="header2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="title"><div align="right">
					<?php /*?><? if(isset($_SESSION['proj_name'])) echo $_SESSION['proj_name']; else echo 'Online Account Solution';?><?php */?>
					<?=find_a_field('user_activity_management','fname','user_id='.$_SESSION['user']['id']);?>
					</div>
					
					</td>
                  </tr>
                  <tr>
                    <td><div align="right">
                      <table border="0" cellspacing="0" cellpadding="0" style="width:450px">
                        <tr>
                          <td><img src="../../images/icon.gif" /></td>
                          <td>Hi, <a href="#">User name</a></td>
                          <td>|</td>
                          <td><img src="../../images/icon2.gif" width="30" height="22" /></td>
                          <td><a href="#">Live Chat</a></td>
                          <td>|</td>
                          <td><img src="../../images/icon4.jpg" width="49" height="20" /></td>
                          <td><a href="#">  main page</a></td>
						  <td>|</td>
						  <td valign="top"><img src="../../images/icon3.jpg" width="22" height="24" /></td>
						  <td><a href="../pages/logout.php">logout</a></td>
                        </tr>
                      </table>
                    </div></td>
                  </tr>
                </table>
				</div></td>
			  </tr>
			</table>
			</div>