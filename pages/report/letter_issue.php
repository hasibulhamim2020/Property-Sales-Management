<?php
session_start();
ob_start();
require "../../support/inc.all.php";
$title='Client Information Report';

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
<form action="master_letter.php" method="post" name="form1" target="_blank" id="form1">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
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
                    <td>Category : </td>
                    <td><select name="building" id="building" onchange="getflatData();">
                        <? if(isset($_REQUEST['building'])&&isset($_REQUEST['proj_code'])) $building=$_REQUEST['building'];
$sql='select bid,category from tbl_building_info';
join_relation($sql,$_REQUEST['building']);?>
                    </select></td>
                  </tr>
                  <tr>
                    <td>Allotment no.: </td>
                    <? if(isset($_REQUEST['flat'])) $flat=$_REQUEST['flat'];?>
                    <td><span id="fid">
                      <select name="flat" id="flat">
                        <? 
foreign_relation('tbl_flat_info','fid','flat_no',$flat);?>
                      </select>
                    </span></td>
                  </tr>
                  <tr>
                    <td>Client: </td>
                    <td><select name="party_code" id="party_code">
                        <option value=""></option>
                        <?php $items = mysql_query("select * from tbl_party_info");
	 									 while($itemname = mysql_fetch_row($items))
	  									{
	  										if($party_code==$itemname[1]) 
	  										{
	  										echo "<option value=\"$itemname[1]\" selected>$itemname[1]: $itemname[2]</option>";
											}
	  										else
											{
												echo "<option value=\"$itemname[1]\">$itemname[1]: $itemname[2]</option>";
											}
	  									}
	  									?>
                    </select></td>
                  </tr>
                  
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                </table>
            </div></td>
            <td>&nbsp;</td>
            <td valign="top"><div class="box3">
              <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td colspan="2" class="title1">&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="2" class="title1"><div align="left">Select Letter</div></td>
                  </tr>
                  <tr>
                    <td><input name="report" type="radio" class="radio" value="7" /></td>
                    <td><div align="left">Address Code </div></td>
                  </tr>
                  <tr>
                    <td width="5%"><input name="report" type="radio" class="radio" value="1" /></td>
                    <td width="95%"><div align="left">Offer Letter </div></td>
                  </tr>
                  <tr>
                    <td><input name="report" type="radio" class="radio" value="2" /></td>
                    <td><div align="left">Request To Pay Due Payments Letter </div></td>
                  </tr>
                  
                  <tr>
                    <td><input name="report" type="radio" class="radio" value="3" /></td>
                    <td><div align="left">Possession Letter </div></td>
                  </tr>
                  <tr>
                    <td><input name="report" type="radio" class="radio" value="4" /></td>
                    <td><div align="left">Due Installment Amount Request Letter </div></td>
                  </tr>
                  
                  <tr>
                    <td><input name="report" type="radio" class="radio" value="5" /></td>
                    <td><div align="left">Thanks Letter </div></td>
                  </tr>
                  <tr>
                    <td><input name="report" type="radio" class="radio" value="6" /></td>
                    <td><div align="left">Due Installment including this month Request Letter </div></td>
                  </tr>
                </table>
            </div></td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><div class="box">
        <table width="1%" border="0" cellspacing="0" cellpadding="0" align="center">
            <tr>
              <td><input name="submit" type="submit" class="btn" value="Letter" /></td>
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
