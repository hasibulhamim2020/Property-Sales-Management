<?php
session_start();

require "../../config/inc.all.php";

// ::::: Edit This Section ::::: 
$title='User Management';			// Page Name and Page Title
$page="user_manage.php";		// PHP File Name
$input_page="user_manage_input.php";
$root='admin';

$table='user_activity_management';		// Database Table Name Mainly related to this page
$unique='user_id';			// Primary Key of this Database table
$shown='username';				// For a New or Edit Data a must have data field
			// For a New or Edit Data a must have data field

// ::::: End Edit Section :::::

//if(isset($_GET['proj_code'])) $proj_code=$_GET[$proj_code];
$crud      =new crud($table);

$$unique = $_GET[$unique];
if(isset($_POST[$shown]))
{
$$unique = $_POST[$unique];

if(isset($_POST['insert'])||isset($_POST['insertn']))
{		
$now				= time();

$crud->insert();
$type=1;
$msg='New Entry Successfully Inserted.';

if(isset($_POST['insert']))
{
echo '<script type="text/javascript">
parent.parent.document.location.href = "../'.$root.'/'.$page.'";
</script>';
}
unset($_POST);
unset($$unique);


}


//for Modify..................................

if(isset($_POST['update']))
{

		$crud->update($unique);
		$type=1;
		$msg='Successfully Updated.';
				echo '<script type="text/javascript">
parent.parent.document.location.href = "../'.$root.'/'.$page.'";
</script>';
}
//for Delete..................................

if(isset($_POST['delete']))
{		$condition=$unique."=".$$unique;		$crud->delete($condition);
		unset($$unique);
		echo '<script type="text/javascript">
parent.parent.document.location.href = "../'.$root.'/'.$page.'";
</script>';
		$type=1;
		$msg='Successfully Deleted.';
}
}

if(isset($$unique))
{
$condition=$unique."=".$$unique;
$data=db_fetch_object($table,$condition);
while (list($key, $value)=each($data))
{ $$key=$value;}
}
if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique);
?>
<html style="height: 100%;"><head>
        <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
        <meta content="text/html; charset=UTF-8" http-equiv="content-type">
        <link href="../../css/css.css" rel="stylesheet"></head>
<body>
        <!--[if lte IE 8]>
        <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1/CFInstall.min.js"></script>
        <script>CFInstall.check({mode: "overlay"});</script>
        <![endif]-->
       <form action="" method="post"> <div class="ui-dialog ui-widget ui-widget-content ui-corner-all oe_act_window ui-draggable ui-resizable openerp" style="outline: 0px none; z-index: 1002; position: absolute; height: auto; width: 900px; display: block; /* [disabled]left: 217.5px; */" tabindex="-1" role="dialog" aria-labelledby="ui-id-19">
          <? include('../../common/title_bar_popup.php');?>
          <div style="display: block; max-height: 464px; overflow-y: auto; width: auto; min-height: 82px; height: auto;" class="ui-dialog-content ui-widget-content" scrolltop="0" scrollleft="0">

            <div style="width:100%" class="oe_popup_form">
              <div class="oe_formview oe_view oe_form_editable" style="opacity: 1;">
                <div class="oe_form_buttons"></div>
                <div class="oe_form_sidebar" style="display: none;"></div>
                <div class="oe_form_container">
                  <div class="oe_form">
                    <div class="">
                      <? include('../../common/input_bar.php');?>
                      <div class="oe_form_sheetbg">
                        <div class="oe_form_sheet oe_form_sheet_width">
        <h1><label for="oe-field-input-27" title="" class=" oe_form_label oe_align_right">
        <a href="home2.php" rel = "gb_page_center[940, 600]"><?=$title?></a>
    </label>
          </h1><table class="oe_form_group " border="0" cellpadding="0" cellspacing="0"><tbody><tr class="oe_form_group_row"><td colspan="1" class="oe_form_group_cell" width="50%"><table class="oe_form_group " border="0" cellpadding="0" cellspacing="0"><tbody>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Full Name :</td>
                  <td colspan="1" class="oe_form_group_cell"><input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                    <input name="fname" type="text" id="fname" value="<?=$fname?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><label>Mobile No:</label></td>
                  <td colspan="1" class="oe_form_group_cell"><input name="mobile" type="text" id="mobile" value="<?=$mobile?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td width="1%" colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><label>Designation:</label></td>
                  <td width="99%" colspan="1" class="oe_form_group_cell"><input name="designation" type="text" id="designation" value="<?=$designation?>" /></td>
                </tr>
                </tbody></table></td><td colspan="1" class="oe_form_group_cell oe_group_right" width="50%"><table class="oe_form_group " border="0" cellpadding="0" cellspacing="0"><tbody><tr class="oe_form_group_row"><td colspan="1" class="oe_form_group_cell oe_form_group_cell_label" width="1%"><label>User Type:</label></td><td colspan="1" class="oe_form_group_cell" width="99%"><select name="level">
      <? foreign_relation('user_type','user_level','user_type_name_show',$level);?>
    </select></td></tr><tr class="oe_form_group_row"><td colspan="1" class="oe_form_group_cell oe_form_group_cell_label" width="1%"><label>UserName:</label></td><td colspan="1" class="oe_form_group_cell" width="99%"><span class="oe_form_field oe_datepicker_root oe_form_field_date"><span>
        
        <input value="" id="dp1358603602645" class="oe_datepicker_container hasDatepicker" disabled="disabled" style="display: none;" type="text">
        <input name="username" type="text" id="username" value="<?=$username?>" />
    </span></span></td></tr><tr class="oe_form_group_row"><td colspan="1" class="oe_form_group_cell oe_form_group_cell_label" width="1%"><label>Password:</label></td><td colspan="1" class="oe_form_group_cell" width="99%"><input name="password" type="text" id="password" value="<?=$password?>" /></td></tr></tbody></table></td></tr></tbody></table></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="ui-resizable-handle ui-resizable-n" style="z-index: 1000;"></div>
          <div class="ui-resizable-handle ui-resizable-e" style="z-index: 1000;"></div>
          <div class="ui-resizable-handle ui-resizable-s" style="z-index: 1000;"></div>
          <div class="ui-resizable-handle ui-resizable-w" style="z-index: 1000;"></div>
          <div class="ui-resizable-handle ui-resizable-se ui-icon ui-icon-gripsmall-diagonal-se ui-icon-grip-diagonal-se" style="z-index: 1000;"></div>
          <div class="ui-resizable-handle ui-resizable-sw" style="z-index: 1000;"></div>
          <div class="ui-resizable-handle ui-resizable-ne" style="z-index: 1000;"></div>
          <div class="ui-resizable-handle ui-resizable-nw" style="z-index: 1000;"></div>
          <div class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix">

          </div>
        </div>
        </form>
</body></html>
