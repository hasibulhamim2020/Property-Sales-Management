<?php
session_start();
ob_start();
require "../../support/inc.all.php";
$title='Work Material';
$table='tbl_work_material';
$page="work_material.php";
?><link rel="stylesheet" type="text/css" href="../../css/form.css" />
<script language="javascript">
function mas(count,total_count){

var q="q_"+count;
var r="r_"+count;
var a="a_"+count;
var tc=(total_count*1);
var qty=((document.getElementById(q).value)*1);
var rate=((document.getElementById(r).value)*1);
var amt=qty*rate;
document.getElementById(a).value=amt;
var total=0;
var i;
for(i=0;i<tc;i++)
{
var j="a_"+(i+1);
if(document.getElementById(j).value!='')
total=total+((document.getElementById(j).value)*1);
}
//alert(total);
document.getElementById("tamt").value=total;
}
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td>    
										<div class="form-container">
                                          <form action="../report/master_report.php" method="post" target="_blank"> 
                                            <fieldset>
                                            <legend>Work Selection</legend>
											  <div style="clear:both;">
											    <label>Project: </label>
<select name="proj_code" id="proj_code">
<? if(isset($_REQUEST['proj_code'])) $proj_code=$_REQUEST['proj_code'];
foreign_relation('tbl_project_info','proj_code','proj_name',$proj_code);?>
                                          </select>
									        </div>
								  
											</fieldset>
									  
									<div class="buttonrow">
									  <input name="search" type="submit" id="search" value="Search" />
									</div>
									</form>
	                                    </div>
										</td></tr>
										<tr>
                                        <td>    
										<div></div>
										</td></tr>
										
                                      <tr>
                                        <td>&nbsp;</td>
                                      </tr>
                                  </table>

<?
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout.php");
?>