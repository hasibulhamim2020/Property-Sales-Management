<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once SERVER_CORE."routing/layout.top.php";

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
//

$title='Allotment Wise Deposit';


$table='tbl_project_info';
$page="flat_deposit.php";

$crud      =new crud($table);
if(isset($_REQUEST['proj_code'])) $proj_code=$_REQUEST['proj_code'];

?>

<script type="text/javascript"> 
function submit_nav(lkf){document.location.href = '<?=$page?>?proj_code='+lkf;}
</script>

<table width="50%" border="0" cellspacing="0" cellpadding="0" align="center">
						  <tr>
							<td>
							<div class="form-container_large">
							<form id="form1" name="form1" method="post" action="">
							  <table width="100%" border="0" cellspacing="2" cellpadding="0">
                                <tr>
                                  <td width="100%">
									<fieldset>
									<legend>Project Details</legend>
									<div>
									<label>Project : </label>
									<select name="proj_code" id="proj_code">
									<? if(isset($_REQUEST['proj_code'])) $proj_code=$_REQUEST['proj_code'];
									foreign_relation('tbl_project_info','proj_code','proj_name',$proj_code);?>
									</select>
									</div>
									<div>
									<label for="email">Category : </label>
									<span id="bld">
									<select name="building" id="building" onchange="getflatData();">
									<? if(isset($_REQUEST['building'])&&isset($_REQUEST['proj_code'])) $building=$_REQUEST['building'];
									$sql='select bid,category from tbl_building_info';
									join_relation($sql,$_REQUEST['building']);?>
									</select>
									</span>								  
									</div>
									<div class="buttonrow" style="margin-left:154px;">
									<input name="search" type="submit" class="btn1" id="search" value="Search details " />
									</div>
									</fieldset>								  </td>
                                </tr>
                              </table>
							  </form>	
							</div>						  						
							</td> 
						  </tr>
</table>
						
<table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><?  if(isset($_REQUEST['building'])&&isset($_REQUEST['proj_code'])){ ?>
	<div class="tabledesign1">
							<? 
$res = 'select a.flat_no,a.flat_no as Flat_or_Plot_NO,c.party_code,c.party_name,sum(a.rcv_amount) as receive_amount,b.status from tbl_flat_cost_installment a,tbl_flat_info b,tbl_party_info c where a.proj_code=b.proj_code and a.build_code=b.build_code and a.flat_no=b.flat_no and b.party_code=c.party_code and a.proj_code='.$_REQUEST['proj_code'].' and a.build_code='.$_REQUEST['building'].' group by a.flat_no';
echo $crud->link_report($res);
							?>
	</div>
						  <?=paging(15);
	}else{
	?>
		<div class="tabledesign1">
<table width="100%" cellspacing="0" cellpadding="0" id="grp"><tbody><tr><th>Plot No</th><th>Party Code</th><th>Party Name</th><th>Receive Amount</th><th>Status</th></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<tr><td>&nbsp;</td><td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<tr><td>&nbsp;</td><td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
</tbody></table>
	</div>
	<?
	}?></td>
  </tr>
	
  <tr>
	<td></td>
  </tr>
	
	
	
  <tr>
	<td>    </td>
  </tr>
</table>


  <?
require_once SERVER_CORE."routing/layout.bottom.php";
?>