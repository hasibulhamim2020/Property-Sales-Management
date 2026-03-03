<?php
session_start();
ob_start();
require "../../support/inc.all.php";
$title='Transfer Allotment';

//echo $proj_id;

?>
<style type="text/css">
<!--
.style1 {color: #000000}
-->
</style>

  
  <script type = "text/javascript">
    var GB_ROOT_DIR = "../../greybox/";
  </script>
  <script type = "text/javascript" src = "../../greybox/AJS.js"></script>
  <script type = "text/javascript" src = "../../greybox/AJS_fx.js"></script>
  <script type = "text/javascript" src = "../../greybox/gb_scripts.js"></script>
  <link href = "../../greybox/gb_styles.css" rel = "stylesheet" type = "text/css" media = "all"/>
  
  <div class="form-container">
  <form id="form1" name="form1" method="post" action="transfer_allotment2.php">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">

    <tr>
      <td colspan="2" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td valign="top">
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
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td>
			  <fieldset>
		  <legend>Present Allotment </legend>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>Project  :</td>
            <td><select name="proj_code_from" id="proj_code_from">
                <? if(isset($_REQUEST['proj_code'])) $proj_code=$_REQUEST['proj_code'];
foreign_relation('tbl_project_info','proj_code','proj_name',$proj_code);?>
            </select></td>
          </tr>
          <tr>
            <td>Plot Category : </td>
            <td><select name="category_from" id="category_from" onchange="getflatData2();">
                <? if(isset($_REQUEST['building'])&&isset($_REQUEST['proj_code'])) $building=$_REQUEST['building'];
$sql='select bid,category from tbl_building_info';
join_relation($sql,$_REQUEST['building']);?>
            </select>            </td>
          </tr>
          <tr>
            <td>Plot no.: </td>
            <? if(isset($_REQUEST['flat'])) $flat=$_REQUEST['flat'];?>
            <td><span id="fid2">
              <select name="flat_no_from" id="flat_no_from">
              </select>
            </span></td>
          </tr>
      </table>
		  </fieldset>			  </td>
              <td>
			  <fieldset>
		  <legend>Requested Allotment </legend>
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>Project  :</td>
            <td><select name="proj_code_to" id="proj_code_to">
                <? 
foreign_relation('tbl_project_info','proj_code','proj_name',$proj_code);?>
            </select></td>
          </tr>
          <tr>
            <td>Plot Category: </td>
            <td><select name="category_to" id="category_to" onchange="getflatData3();">
                <? 
$sql='select bid,category from tbl_building_info';
join_relation($sql,$_REQUEST['building']);?>
            </select>            </td>
          </tr>
          <tr>
            <td>Plot no.: </td>
            <? if(isset($_REQUEST['flat'])) $flat=$_REQUEST['flat'];?>
            <td><span id="fid3">
              <select name="flat_no_to" id="select3">
              </select>
            </span></td>
          </tr>
      </table>
			</fieldset>			  </td>
            </tr>
            <tr>
              <td colspan="2">
				<table width="30%" border="0" cellspacing="0" cellpadding="0" align="center">
				  <tr>
				    <td>&nbsp;</td>
				    </tr>
				  <tr>
					<td>
					<div class="button">
					<input name="transfer" type="submit" id="transfer" value="Transfer"/>
					<input name="transfa" type="hidden" id="transfa" value="1" />
					</div>					</td>
				  </tr>
				</table>
			 
			   </td>
              </tr>
          </table></td>
        </tr>
      </table></td>
    </tr>

    <tr>
      <td></td>
    </tr>
  </table>
  <label>
  </form>
  </div>
  <?
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout.php");
?>
