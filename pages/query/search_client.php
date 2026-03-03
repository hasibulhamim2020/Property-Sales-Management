<?php
session_start();
ob_start();
require "../../support/inc.all.php";
$title='Client Status';
?>
<style type="text/css">
<!--
.style1 {
	color: #000000;
	font-size: 12px;
}
-->
</style>
<script type = "text/javascript">
    var GB_ROOT_DIR = "../../greybox/";
</script>
<script type = "text/javascript" src = "../../greybox/AJS.js"></script>
<script type = "text/javascript" src = "../../greybox/AJS_fx.js"></script>
<script type = "text/javascript" src = "../../greybox/gb_scripts.js"></script>
<link href = "../../greybox/gb_styles.css" rel = "stylesheet" type = "text/css" media = "all"/>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
    <td>
	 <div class="form-container_large">
      <form id="form1" name="form1" method="post" action="">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
		  <td>
		  <table width="88%" border="0" cellspacing="0" cellpadding="0" align="center">
          <tr>
            <td>
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
				<label for="email">Section : </label>
				<span id="bld">
				<select name="section_name" id="section_name" onchange="getData2('../../common/flat_option_mhafuz.php', 'fid', document.getElementById('proj_code').value,this.value);">
 <? foreign_relation('add_section','section_id','section_name',$section_name);?>
											</select>
				</span></div>
				<div>
				<label for="fname">Plot no. : </label>
				<? if(isset($_REQUEST['flat'])) $flat=$_REQUEST['flat'];
				if(isset($_REQUEST['proj_code'])) $con='proj_code='.$_REQUEST['proj_code'];
				?>
				<span id="fid">
                    <select name="flat" id="flat">
                      <? foreign_relation('tbl_flat_info','fid','flat_no',$flat,$con);?>
                    </select>
                  </span>                                        </div>
				<div class="buttonrow" style="margin-left:154px;">
				<input name="payment" type="button" class="btn" id="payment" value="Payment" onclick="getData('../../common/search_client1.php', 'nid', document.getElementById('flat').value);" /></div>
				</fieldset>		  </td>
				<td valign="top" align="right">
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
				<input  name="" type="text" id="" value=""/>
				</span>                                        </div>
				</fieldset>		  </td>
		  </tr>
        </table>
		  </td>
		  </tr>
		<tr>
		  <td>&nbsp;</td>
		  </tr>
		<tr>
		<td>&nbsp;</td>
		</tr>
        </table>
        </form>
    </div>
	  
	  </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div class="box4">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="25%">Plot Size (Katha)   : </td>
                  <td width="25%"><input  name="code22" type="text" value="<?=$info->flat_size?>"/></td>
                </tr>
                <tr>
                  <td>Rate Per Khata : </td>
                  <td><input  name="code22" type="text" value="<?=$info->sqft_price?>"/></td>
                </tr>
                <tr>
                  <td>Unit Price : </td>
                  <td><input  name="code22" type="text" value="<?=$info->unit_price?>"/></td>
                </tr>
                <tr>
                  <td>Discount Amount  : </td>
                  <td><input  name="code22" type="text" value="<?=$info->disc_price?>"/></td>
                </tr>
                <tr>
                  <td>Payable Unit price  : </td>
                  <td><input  name="code22" type="text" value="<?=$info->unit_price?>"/></td>
                </tr>
                <tr>
                  <td>Development Price   : </td>
                  <td><input  name="code22" type="text" value="<?=$info->park_price?>"/></td>
                </tr>
                <tr>
                  <td>Total Price  : </td>
                  <td><input  name="code22" type="text" value="<?=$info->total_price?>"/></td>
                </tr>
              </table></td>
            </tr>
          </table></td>
          <td width="50%" valign="top"><span id="nid"></span></td>
        </tr>
      </table>
    </div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div class="box4">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><div class="tabledesign2">
            <span id="iid"></span>
          </div></td>
        </tr>
      </table>
    </div></td>
  </tr>
</table>
<?
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout.php");
?>