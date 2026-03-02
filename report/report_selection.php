<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once SERVER_CORE."routing/layout.top.php";


$title='Genarel Report';

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
                                <td width="5%"><input name="report" type="radio" class="radio" value="6" /></td>
                                <td width="95%"><div align="left">Collection Statement(Total) (6) </div></td>
                              </tr>

                              
							  <tr>

                                <td><input name="report" type="radio" class="radio" value="24" /></td>

                                <td><div align="left">Collection Statement (Cash) (24) </div></td>
                              </tr>

                              <tr>
                                <td><input name="report" type="radio" class="radio" value="25" /></td>
                                <td><div align="left">Collection Statement (Chaque) (25) </div></td>
                              </tr>
                              <tr>

                                <td><input name="report" type="radio" class="radio" value="255" /></td>

                                <td><div align="left">Collection Statement (Discount) (255) </div></td>
                              </tr>

                              

                              

                              <tr>

                                <td><input name="report" type="radio" class="radio" value="11" /></td>

                                <td><div align="left"> Outstanding dues (11) </div></td>
                              </tr>

                              <tr>

                                <td><input name="report" type="radio" class="radio" value="12" /></td>

                                <td><div align="left">Expected Collection (12)  </div></td>
                              </tr>

                              <tr>

                                <td><input name="report" type="radio" class="radio" value="13" /></td>

                                <td><div align="left">Payment Schedule (13) </div></td>
                              </tr>

                              <tr>

                                <td><input name="report" type="radio" class="radio" value="7" /></td>

                                <td><div align="left">Payment Statement (Money Receipt)(7)</div></td>
                              </tr>

							  

							  <tr>
                                <td><input name="report" type="radio" class="radio" value="70" /></td>
							    <td><div align="left">Sales Report(70)</div></td>
						      </tr>
							  <tr>
							    <td>&nbsp;</td>
							    <td>&nbsp;</td>
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
                                <td><input name="report" type="radio" class="radio" value="22" /></td>
							    <td><div align="left">Installment wise report(22)</div></td>
						      </tr>
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="23" /></td>
							    <td><div align="left">Party Fine Statement(23)</div></td>
						      </tr>
							  <tr>
							    <td>&nbsp;</td>
							    <td>&nbsp;</td>
						      </tr>
							  <tr>
							    <td>&nbsp;</td>
							    <td>&nbsp;</td>
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

                    <td style="color:black">Project  :</td>

<td><select name="proj_code" id="proj_code" onchange="getData2('section_option_mhafuz.php', 'bld', document.getElementById('proj_code').value,this.value);">

<option></option>
 <? if(isset($_REQUEST['proj_code'])) $proj_code=$_REQUEST['proj_code'];foreign_relation('tbl_project_info','proj_code','proj_name',$proj_code);?></select></td>
                  </tr>

				  

				  

                  

                   <tr>

                      <td>Section: </td>

                      <td><span id="bld">

				<select name="section_name" id="section_name" onchange="getData2('flat_option_mhafuz.php', 'fid', document.getElementById('proj_code').value,this.value);">

					<? foreign_relation('add_section','section_id','section_name',$section_name);?></select>

					   </span></td>
                    </tr>


                   <tr>
                     <td style="color:black">Floor No : </td>
                     <td><input name="road_no" type="text" id="road_no" /></td>
                   </tr>
                  <tr>

                    <td>Product.: </td>

                    <? if(isset($_REQUEST['flat'])) $flat=$_REQUEST['flat'];?>

                    <td> <span id="fid">


                                          <select name="flat" id="flat">
                                            
											<option></option>
											<? 
											foreign_relation('tbl_flat_info','fid','CONCAT(road_no ,": ",flat_no)',$flat);
											?>
                                          </select>


                                        </span></td>
                  </tr>


                  <tr>

                    <td style="color:black">Client: </td>

                    <td>
					<input type="text"  name="party_code" id="party_code"  />	</td>
                  </tr>

                  <tr>

                    <td>From : </td>

                    <td><input  name="f_date" type="text" id="f_date" value="" autocomplete="off"/></td>
                  </tr>

                  <tr>

                    <td style="color:black">To : </td>

                    <td><input  name="t_date" type="text" id="t_date" value="" autocomplete="off"/></td>
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
require_once SERVER_CORE."routing/layout.bottom.php";
?>