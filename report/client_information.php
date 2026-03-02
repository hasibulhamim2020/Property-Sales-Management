<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once SERVER_CORE."routing/layout.top.php";

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

		  url: 'flat_option_report.php',

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

            <td valign="top"><div class="box3">

                <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

                  <tr>

                    <td>&nbsp;</td>

                    <td>&nbsp;</td>

                  </tr>

                  <tr>

                     <td style="color:black">Project  :</td>

                    <td><select name="proj_code" id="proj_code" onchange="getData2('section_option_mhafuz.php', 'bld', document.getElementById('proj_code').value,this.value);">
						
						<option></option>
						<? if(isset($_REQUEST['proj_code'])) $proj_code=$_REQUEST['proj_code'];

						foreign_relation('tbl_project_info','proj_code','proj_name',$proj_code);?>

						</select></td>

                  </tr>

                

                          <tr>

                      <td>Section: </td>

                      <td><span id="bld">

											<select name="section_name" id="section_name" onchange="getData2('flat_option_mhafuz.php', 'fid', document.getElementById('proj_code').value,this.value);">

											<? 

											foreign_relation('add_section','section_id','section_name',$section_name);

											

											?>

											</select>

											</span></td>

                    </tr>

                     <tr>

									<td style="color:black">Plot no.: </td>

									<? if(isset($_REQUEST['flat'])) $flat=$_REQUEST['flat'];?>

									<td>  <span id="fid">

										  

										  

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
					  <input type="text"  name="party_code" id="party_code"  />
					  
					  </td>

                    </tr>

                  <tr>

                    <td style="color:black">From : </td>

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

            <td>&nbsp;</td>

            <td valign="top"><div class="box3" style="height:135px;">

              <table width="100%" border="0" cellspacing="0" cellpadding="0">

                  <tr>

                    <td colspan="2" class="title1">&nbsp;</td>

                  </tr>

                  <tr>

                    <td colspan="2" class="title1"><div align="left" style="color:black">Select Report </div></td>

                  </tr>

                  <tr>

                    <td width="5%"><input name="report" type="radio" class="radio" value="5" checked /></td>

                    <td width="95%"><div align="left">Client Details Information </div></td>

                  </tr>

                  <tr>

                    <td><input name="report" type="radio" class="radio" value="2" /></td>

                    <td><div align="left" style="color:black">Allotment Booking Statement (Client Wise) </div></td>

                  </tr>

                  

<!--                  <tr>

                    <td><input name="report" type="radio" class="radio" value="115" /></td>

                    <td><div align="left">Valuable Client Report (By Value)</div></td>

                  </tr>

				  <tr>

                    <td><input name="report" type="radio" class="radio" value="116" /></td>

                    <td><div align="left">Valuable Client Report (By Plot)</div></td>

                  </tr>-->

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
require_once SERVER_CORE."routing/layout.bottom.php";
?>