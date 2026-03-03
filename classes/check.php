<? if($_SESSION['mhafuz']!='Active'){?><script>location.href="../index.php";</script><? }else
{
	if($_REQUEST['employee_selected']>0)
	{$_SESSION['employee_selected']=$_REQUEST['employee_selected'];
	$_GET['employee_selected']=$_SESSION['employee_selected'];}
	elseif(($_SESSION['employee_selected'])>0)
	{$_GET['employee_selected']=$_SESSION['employee_selected'];}
	
	if($_REQUEST['dealer_selected']>0)
	{$_SESSION['dealer_selected']=$_REQUEST['dealer_selected'];
	$_GET['dealer_selected']=$_SESSION['dealer_selected'];}
	elseif(($_SESSION['dealer_selected'])>0)
	{$_GET['dealer_selected']=$_SESSION['dealer_selected'];}
	
}?>
