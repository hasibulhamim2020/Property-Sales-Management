<?php
session_start();
ob_start();
require "../../support/inc.all.php";
$title='Genarel Report';

do_calander("#f_date");
do_calander("#t_date");



function auto_complete_from_db($table,$show,$id,$con,$text_field_id)
{
if($con!='') $condition = " where ".$con;
$query="Select ".$id.", ".$show." from ".$table.$condition;

$led=mysql_query($query);
	if(mysql_num_rows($led) > 0)
	{
		$ledger = '[';
		while($ledg = mysql_fetch_row($led)){
		  $ledger .= '{ name: "'.$ledg[1].'", id: "'.$ledg[0].'" },';
		}
		$ledger = substr($ledger, 0, -1);
		$ledger .= ']';
	}
	else
	{
		$ledger = '[{ name: "empty", id: "" }]';
	}

echo '<script type="text/javascript">
$(document).ready(function(){
    var data = '.$ledger.';
    $("#'.$text_field_id.'").autocomplete(data, {
		matchContains: true,
		minChars: 0,
		scroll: true,
		scrollHeight: 300,
        formatItem: function(row, i, max, term) {
            return row.name + " [" + row.id + "]";
		},
		formatResult: function(row) {
			return row.id;
		}
	});
  });
</script>';
}


auto_complete_from_db('tbl_party_info','party_name','party_code',' 1 ','party_code');

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

      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

          <tr>

            <td><div class="box3">

                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                  <tr>

                    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

                        <tr>

                          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

                              <tr>

                                <td colspan="2" class="title1"><div align="left">Select Report </div></td>
                              </tr>
							  <tr>
							    <td width="5%">&nbsp;</td>
							    <td width="95%">&nbsp;</td>
						      </tr>
							  <tr>
							    <td>&nbsp;</td>
							    <td>&nbsp;</td>
						      </tr>
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="21" /></td>
							    <td><div align="left">Monthly Product Statement At a Glance(21)</div></td>
						      </tr>
							  <tr>
							    <td>&nbsp;</td>
							    <td>&nbsp;</td>
						      </tr>

							  <!--<tr>

                                <td><input name="report" type="radio" class="radio" value="700" /></td>

                                <td><div align="left">Sales Summary Report </div></td>

                              </tr>-->

                              

                              

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

			 <td><select name="proj_code" id="proj_code" onchange="getData2('../../common/section_option_mhafuz.php', 'bld', document.getElementById('proj_code').value,this.value);">

 <? if(isset($_REQUEST['proj_code'])) $proj_code=$_REQUEST['proj_code'];foreign_relation('tbl_project_info','proj_code','proj_name',$proj_code);?></select></td>
                  </tr>

				  

				  

                  

                   <tr>

                      <td>Section: </td>

                      <td><span id="bld">

				<select name="section_name" id="section_name" onchange="getData2('../../common/flat_option_mhafuz.php', 'fid', document.getElementById('proj_code').value,this.value);">

					<? foreign_relation('add_section','section_id','section_name',$section_name);?></select>

					   </span></td>
                    </tr>


                   <tr>
                     <td>Floor No : </td>
                     <td><input name="road_no" type="text" id="road_no" /></td>
                   </tr>
                  <tr>

                    <td>Product.: </td>

                    <? if(isset($_REQUEST['flat'])) $flat=$_REQUEST['flat'];?>

                    <td> <span id="fid">

										  

										  

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


                  <tr>

                    <td>Client: </td>

                    <td>
					<input type="text"  name="party_code" id="party_code"  />	</td>
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

                    <td>Money Receipt No: </td>

                    <td><input name="mr" type="text" id="mr" /></td>
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

      <td height="5"></td>

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

