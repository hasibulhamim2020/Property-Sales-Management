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
			
				<textarea name="" id=""></textarea>
			                                      </div>
				<div>
				<label for="fname">Mobile no. : </label>
				<input  name="" type="text" id="" value=""/>
				                                       </div>
				</fieldset>		  </td>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td>
			  <fieldset>
		  <legend>Present Allotment </legend>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>Project  :</td>
            <td><select name="proj_code" id="proj_code" onchange="getData2('../../common/section_option_mhafuz.php', 'bld', document.getElementById('proj_code').value,this.value);">
              <? if(isset($_REQUEST['proj_code'])) $proj_code=$_REQUEST['proj_code'];

						foreign_relation('tbl_project_info','proj_code','proj_name',$proj_code);?>
            </select></td>
          </tr>
          <tr>
            <td>Plot Category : </td>
            <td><span id="bld">

											<select name="section_name" id="section_name" onchange="getData2('../../common/flat_option_mhafuz.php', 'fid', document.getElementById('proj_code').value,this.value);">

											<? if(isset($_REQUEST['section_name'])) $section_name=$_REQUEST['section_name'];

											foreign_relation('add_section','section_id','section_name',$section_name);

											

											?>

											</select>

											</span></td>
          </tr>
          <tr>
            <td>Plot no.: </td>
            <td>
			<span id="fid">

                                         

										  <?

										  if($_POST['flat']>0){

										  

										  ?>

                                          <select name="flat" id="flat">

                                            <? foreign_relation('tbl_flat_info','fid','CONCAT("RN :", road_no ,"/", "PN ", flat_no)',$flat);?>

                                          </select>

										  

										  <? }else{

										  ?>

										  <select name="flat" id="flat">

                                            <option value=""></option>

                                          </select>

										  <?

										  } ?>

                                        </span>
			
			
			</td>
          </tr>
      </table>
		  </fieldset>			  </td>
              <td>
			  <fieldset>
		  <legend>Requested Allotment </legend>
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>Project  :</td>
            <td><select name="proj_code" id="proj_code" onchange="getData2('../../common/section_option_mhafuz.php', 'bld2', document.getElementById('proj_code').value,this.value);">
              <? if(isset($_REQUEST['proj_code'])) $proj_code=$_REQUEST['proj_code'];

						foreign_relation('tbl_project_info','proj_code','proj_name',$proj_code);?>
            </select></td>
          </tr>
          <tr>
            <td>Plot Category: </td>
            <td><span id="bld2">

											<select name="section_name" id="section_name" onchange="getData2('../../common/flat_option_mhafuz.php', 'fid2', document.getElementById('proj_code').value,this.value);">

											<? if(isset($_REQUEST['section_name'])) $section_name=$_REQUEST['section_name'];

											foreign_relation('add_section','section_id','section_name',$section_name);

											

											?>

											</select>

											</span>            </td>
          </tr>
          <tr>
            <td>Plot no.: </td>
            <td><span id="fid2">

                                         

										  <?

										  if($_POST['flat']>0){

										  

										  ?>

                                          <select name="flat" id="flat">

                                            <? foreign_relation('tbl_flat_info','fid','CONCAT("RN :", road_no ,"/", "PN ", flat_no)',$flat);?>

                                          </select>

										  

										  <? }else{

										  ?>

										  <select name="flat" id="flat">

                                            <option value=""></option>

                                          </select>

										  <?

										  } ?>

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
