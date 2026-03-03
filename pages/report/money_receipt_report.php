<?php
session_start();
ob_start();
require "../../support/inc.all.php";
$title='Money Transaction Report';

//echo $proj_id;
?>
<script type="text/javascript" src="../../js/receipt_install.js"></script>
<form id="form1" name="form1" method="post" action="">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><div class="box3" style="height:136px;">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td colspan="2" class="title1"><div align="left">Select Report</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="1" /></td>
                                <td><div align="left">Client Details Information </div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="2" /></td>
                                <td><div align="left">Project wise Client Information </div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="3" /></td>
                                <td><div align="left">Client Permanent Address </div></td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                          </table></td>
                        </tr>
                    </table></td>
                  </tr>
                </table>
            </div></td>
            <td valign="top">&nbsp;</td>
            <td valign="top"><div class="box3">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>Project  :</td>
                    <td><select name="proj_code" id="proj_code">
                        <? if(isset($_REQUEST['proj_code'])) $proj_code=$_REQUEST['proj_code'];
foreign_relation('tbl_project_info','proj_code','proj_name',$proj_code);?>
                    </select></td>
                  </tr>
                  <tr>
                    <td>Builings: </td>
                    <td><select name="building" id="building" onchange="getflatData();">
                        <? if(isset($_REQUEST['building'])&&isset($_REQUEST['proj_code'])) $building=$_REQUEST['building'];
$sql='select bid,category from tbl_building_info';
join_relation($sql,$_REQUEST['building']);?>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td>Flat no.: </td>
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
