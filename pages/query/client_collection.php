<?php
session_start();
ob_start();
require "../../support/inc.all.php";
$title='Client Wise Collection';
?>
<div class="form-container_large">
<form id="form1" name="form1" method="post" action="">
  <table width="50%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
  <td>
  <fieldset>
			<legend>Client Details</legend>
			<div>
			<label>Name : </label>
			<input  name="" type="text" id="" value=""/>
			</div>
			<div>
			<label for="email">Address : </label>
			<span id="bld">
			<textarea name="" id=""></textarea>
			</span>                                        </div>
		<div>
			<label for="fname">Mobile no. : </label>
			<span id="fid">
			<input  name="Input" type="text" id="Input" value=""/>
			</span></div>
			<div class="buttonrow" style="margin-left:154px;"><input name="submit" type="submit" class="btn1" value="Search details " /></div>
			</fieldset>  </td>
  </tr>
  </table>
</form>
<div class="form-container_large">
<?
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout.php");
?>
