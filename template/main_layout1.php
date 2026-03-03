<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: CloudCodz Real State Solution :.</title>
<link href="../../css/style.css" type="text/css" rel="stylesheet"/>
<link href="../../css/menu.css" type="text/css" rel="stylesheet"/>
<link href="../../css/table.css" type="text/css" rel="stylesheet"/>
<link href="../../css/pagination.css" rel="stylesheet" type="text/css" />
<link href="../../css/jquery-ui-1.8.2.custom.css" rel="stylesheet" type="text/css" />
<meta name="Developer" content="Md. Mhafuzur Rahman Cell:01815-224424 email:mhafuz@yahoo.com" />
<link href="../../css/jquery.autocomplete.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../js/jquery-ui-1.8.2.custom.min.js"></script>
<script type="text/javascript" src="../../js/jquery.ui.datepicker.js"></script>
<script type="text/javascript" src="../../js/jquery.autocomplete.js"></script>
<script type="text/javascript" src="../../js/jquery.validate.js"></script>
<script type="text/javascript" src="../../js/paging.js"></script>
<script type="text/javascript" src="../../js/ddaccordion.js"></script>
<script type="text/javascript" src="../../js/js.js"></script>
<style type="text/css">
<!--
.style1 {font-size: 20px}
-->
</style>
</head>
<body>
<div class="wrapper">
			<div class="header">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td><img src="<?=$_SESSION['company_logo']?>" width="200" height="73" /></td>
				<td><div class="header2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td valign="top" class="title"><div align="right">
                      <p class="style1"><?=$_SESSION['company_name']?></p>
                    </div></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                </table>
				</div></td>
			  </tr>
			</table>
			</div>
			<div class="top_bar"><table width="100%" border="0" cellspacing="0" cellpadding="0">
				  <tr>
					<td><div class="wel"><a href="http://CloudCodz.com.bd/" target="_blank">Powered by CloudCodz Ltd.</a></div></td>
					<td>
					
					<div class="icon">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						  <tr>
							<td class="heading"><?=$title?> </td>
							<td>
						<? if(isset($msg)){?>	<table width="100%" border="0" cellspacing="0" cellpadding="0">
							  <tr>
								<td><div class="msg_text"><?=$msg?></div></td>
								<td width="2%">&nbsp;</td>
							  </tr>
							</table>
<? }?>
							</td>
						  </tr>
						</table>

					 </div>
					
					</td>
				  </tr>
				</table>
  </div>
			<div class="body_box">
			  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td><img src="../../images/index_green_04.jpg" width="21" height="10" /></td>
                      <td class="body_box_topbar"><img src="../../images/index_green_05.jpg" width="51" height="10" /></td>
                      <td><img src="../../images/index_green_06.jpg" width="15" height="10" /></td>
                    </tr>
                    <tr>
                      <td class="body_box_leftbar" valign="top"><img src="../../images/index_green_07.jpg" width="21" height="420" /></td>
                      <td valign="top">
					    <div class="body_middlebox_bar">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
						  <tr>
							<td valign="top">
							<?
					if($_SESSION['mhafuz'])
					{
					?>
							<div class="menu">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
									<td><img src="../../images/menu_01.jpg" width="219" height="14" /></td>
								  </tr>
								  <tr>
									<td valign="top">
									<? include("../../template/main_layout_menu.php");?>
									</td>
								  </tr>
								  <tr>
									<td><img src="../../images/menu_03.jpg" width="219" height="23" /></td>
								  </tr>
								</table>

							</div><? }?></td>
							<td valign="top" align="right">
							<div class="right_main">
							<?=$main_content?>
							</div>
							</td>
						  </tr>
						</table>
						</div>					  </td>
                      <td class="body_box_rightbar" valign="top"><img src="../../images/index_green_09.jpg" width="15" height="420" /></td>
                    </tr>
                    <tr>
                      <td><img src="../../images/index_green_10.jpg" width="21" height="25" /></td>
                      <td class="body_box_bottombar">&nbsp;</td>
                      <td><img src="../../images/index_green_12.jpg" width="15" height="25" /></td>
                    </tr>
                  </table></td>
                </tr>
              </table>
			</div>
</div>


</body>
</html>
