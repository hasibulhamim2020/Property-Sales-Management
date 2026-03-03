<?php
session_start();
ob_start();
require "../../support/inc.all.php";
$title='Share Information Reports';

do_calander("#f_date");
do_calander("#t_date");
?>
<script type="text/javascript">
function getflatData()
{
	var b=1;
	var a=document.getElementById('proj_code').value;
			$.ajax({
		  url: '../../common/flat_option_report.php',
		  data: "a="+a+"&b="+b,
		  success: function(data) {						
				$('#fid').html(data);	
			 }
		});
}
</script>
<form action="master_report.php" method="post" name="form1" target="_blank" id="form1">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><div class="box4">
          <table width="84%" border="0" cellspacing="0" cellpadding="0" align="center">
            <tr>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td colspan="2" class="title1"><div align="left">Select Report </div></td>
                              </tr>
                              <tr>
                                <td width="6%"><input name="report" type="radio" class="radio" value="31" /></td>
                                <td width="94%"><div align="left">Share Holder Investment Amount</div></td>
                              </tr>
                              
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="33" /></td>
                                <td><div align="left">Running Share Holder Information</div></td>
                              </tr>
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="34" /></td>
                                <td><div align="left">Withdrawn Share Holder Information</div></td>
                              </tr>
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="35" /></td>
                                <td><div align="left">Agent Information</div></td>
                              </tr>
                              
                          </table></td>
                        </tr>
                    </table></td>
                  </tr>
              </table></td>
              <td valign="top"><div class="box3">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>Project  :</td>
                      <td><select name="proj_code" id="proj_code" onchange="getflatData();">
                          <? if(isset($_REQUEST['proj_code'])) $proj_code=$_REQUEST['proj_code'];
foreign_relation('tbl_project_info','proj_code','proj_name',$proj_code);?>
                      </select></td>
                    </tr>
                    <tr>
                      <td>From : </td>
                      <td><input  name="f_date" type="text" id="f_date" value=""/></td>
                    </tr>
                    <tr>
                      <td>To : </td>
                      <td><input  name="t_date" type="text" id="t_date" value=""/></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                  </table>
              </div></td>
            </tr>
          </table>
      </div></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><div class="box">
        <table width="1%" border="0" cellspacing="0" cellpadding="0" align="center">
            <tr>
              <td><input name="submit" type="submit" class="btn" value="Report" /></td>
            </tr>
          </table>
      </div></td>
    </tr>
  </table>
</form>
<?
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout.php");
?>
