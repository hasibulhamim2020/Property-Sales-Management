<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Collection Summary';
do_calander('#f_date');
do_calander('#t_date');
//echo $proj_id;

?>

<div class="form-container_large">
<form id="form1" name="form1" method="post" action="">
  <table width="50%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
  <td>
  <fieldset>
			<legend>Collection Summery</legend>
			<div>
			<label>From : </label>
			<input name="f_date" type="text" id="f_date" size="12" maxlength="12" value="<?php echo $_REQUEST['fdate'];?>" />
			</div>
			<div>
			<label for="email">To : </label>
			<input name="t_date" type="text" id="t_date" size="12" maxlength="12" value="<?php echo $_REQUEST['tdate'];?>"/>			</div>
			<div class="buttonrow" style="margin-left:154px; margin-right:14px;"><input name="submit" type="submit" class="btn" value="Filter" /></div>
		  </fieldset>
  </td>
  </tr>
  
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
  </form>
</div>
  
<table width="97%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><div class="tabledesign2">
        <?
		if($_REQUEST['f_date']!=''&&$_REQUEST['t_date']!='')
		{
$res="select rec_no,rec_date,party_code,proj_code,build_code as allotment_type,flat_no as allotment_no,pay_mode,rec_amount from tbl_receipt where rec_date between '".$_REQUEST['f_date']."' and '".$_REQUEST['t_date']."'";
echo link_report($res);
		}else{
		?>
		<table width="100%" cellspacing="0" cellpadding="0" id="grp"><tbody><tr><th>Rec Date</th><th>Party Code</th><th>Proj Code</th>
		<th>Allotment Type </th>
		<th>Allotment No</th>
		<th>Pay Mode</th><th>Rec Amount</th></tr><tr><td>&nbsp;</td><td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		</tr><tr><td>&nbsp;</td><td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		</tr><tr><td>&nbsp;</td><td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		</tr></tbody></table>
		<? }?>
    </div></td>
  </tr>
</table>
  <?
require_once SERVER_CORE."routing/layout.bottom.php";
?>