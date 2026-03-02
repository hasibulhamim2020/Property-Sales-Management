<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once SERVER_CORE."routing/layout.top.php";


$title='Client Status';
?>
<style type="text/css">
</style>


<script type = "text/javascript">
    var GB_ROOT_DIR = "../../greybox/";
</script>
<!--<script type = "text/javascript" src = "../../greybox/AJS.js"></script>
<script type = "text/javascript" src = "../../greybox/AJS_fx.js"></script>
<script type = "text/javascript" src = "../../greybox/gb_scripts.js"></script>-->



<!--<link href = "../../greybox/gb_styles.css" rel = "stylesheet" type = "text/css" media = "all"/>-->
<style type="text/css">
/* Last-Modified: 28/06/06 00:08:22 */
#GB_overlay {
    background-color: #000;
    position: absolute;
    margin: auto;
    top: 0;
    left: 0;
    z-index: 100;
}

#GB_window {
    left: 0;
    top: 0;
    font-size: 1px;
    position: absolute;
    overflow: visible;
    z-index: 150;
}

#GB_window .content {
    width: auto;
    margin: 0;
    padding: 0;
}

#GB_frame {
    border: 0;
    margin: 0;
    padding: 0;
    overflow: auto;
    white-space: nowrap;
}


.GB_Gallery {
    margin: 0 22px 0 22px;
}

.GB_Gallery .content {
    background-color: #fff;
    border: 3px solid #ddd;
}

.GB_header {
    top: 10px;
    left: 0;
    margin: 0;
    z-index: 500;
    position: absolute;
    border-bottom: 2px solid #555;
    border-top: 2px solid #555;
}

.GB_header .inner {
    background-color: #333;
    font-family: Arial, Verdana, sans-serif;
    padding: 2px 20px 2px 20px;
}

.GB_header table {
    margin: 0;
    width: 100%;
    border-collapse: collapse;
}

.GB_header .caption {
    text-align: left;
    color: #eee;
    white-space: nowrap;
    font-size: 20px;
}

.GB_header .close {
    text-align: right;
}

.GB_header .close img {
    z-index: 500;
    cursor: pointer;
}

.GB_header .middle {
    white-space: nowrap;
    text-align: center;
}


#GB_middle {
    color: #eee;
}

#GB_middle img {
    cursor: pointer;
    vertical-align: middle;
}

#GB_middle .disabled {
    cursor: default;
}

#GB_middle .left {
    padding-right: 10px;
}

#GB_middle .right {
    padding-left: 10px;
}


.GB_Window .content {
    background-color: #fff;
    border: 3px solid #ccc;
    border-top: none;
}

.GB_Window .header {
    border-bottom: 1px solid #aaa;
    border-top: 1px solid #999;
    border-left: 3px solid #ccc;
    border-right: 3px solid #ccc;
    margin: 0;

    height: 22px;
    font-size: 12px;
    padding: 3px 0;
    color: #333;
}

.GB_Window .caption {
    font-size: 12px;
    text-align: left;
    font-weight: bold;
    white-space: nowrap;
    padding-right: 20px;
}

.GB_Window .close { text-align: right; }
.GB_Window .close span { 
    font-size: 12px;
    cursor: pointer; 
}
.GB_Window .close img {
    cursor: pointer;
    padding: 0 3px 0 0;
}

.GB_Window .on { border-bottom: 1px solid #333; }
.GB_Window .click { border-bottom: 1px solid red; }

</style>


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
				<select name="section_name" id="section_name" onchange="getData2('flat_option_mhafuz.php', 'fid', document.getElementById('proj_code').value,this.value);">
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
require_once SERVER_CORE."routing/layout.bottom.php";
?>