<?php
session_start();
ob_start();
require "../../support/inc.all.php";
$title='Client Info';
$unique='party_code';

$table='tbl_building_info';
$page="building_info.php";

if(isset($_GET['proj_code'])) $proj_code=$_GET['proj_code'];
$crud      =new crud($table);
?>
<script type="text/javascript"> function DoNav(lk){document.location.href = '<?=$page?>?bid='+lk;}
function submit_nav(lkf){document.location.href = '<?=$page?>?proj_code='+lkf;}
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div class="left">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
								    <td><div class="box3">
								      <form id="form1" name="form1" method="post" action="">
								        <table width="100%" border="0" cellspacing="2" cellpadding="0">
                                          <tr>
                                            <td width="40%" align="right"> Project : </td>
                                            <td width="60%" align="right"><select name="proj_code" id="proj_code" onchange="submit_nav(this.value)">
                                                <? foreign_relation('tbl_project_info','proj_code','proj_name',$proj_code);?>
                                            </select></td>
                                          </tr>
                                        </table>
							          </form>
							        </div></td>
								  </tr>
								  <tr>
									<td>&nbsp;</td>
								  </tr>
								  <tr>
									<td>
									<div class="tabledesign">
								<? 
								if(isset($proj_code))
								$res='select bid , build_code,category,no_of_storied from '.$table.' where proj_code='.$proj_code;
								else
								$res='select bid , build_code,category,no_of_storied from '.$table;
								$link=$page.'?pay_code=';
								echo $crud->link_report($res,$link);
								?>
                                      </div>
                                        <?=paging(50);?></td>
    <td><div class="right"><form id="form2" name="form2" method="post" action="ledger_group.php?group_id=<?php echo $group_id;?>">
							  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td><div class="box">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td>Project :</td>
                                        <td><select name="proj_code" id="proj_code" onchange="submit_nav(this.value)">
                                                <? foreign_relation('tbl_project_info','proj_code','proj_name',$proj_code);?>
                                            </select>                                        </td>
									  </tr>
                                    </table>
                                  </div></td>
                                </tr>
                                
                                 <tr>
                                  <td>&nbsp;</td>
                                </tr>
                                
                                 <tr>
                                  <td><div class="box">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      
                                      <tr>
                                        <td>Category Code</td>
										<? if(!isset($proj_code)) $build_code=db_last_insert_id($table,'build_code')?>
                                        <td><input type="text" name="prj_code" id="proj_code"  />
                                        </td>
									  </tr>
                                      
                                      <tr>
                                        <td>Unit Per Floor</td>
                                        <td><input type="text" name="unit_per_floor" id="unit_per_floor"  />
                                        </td>
									  </tr>
                                      
                                      
                                      <tr>
                                        <td>Category :</td>
                                        <td><select name="category" id="category">
                                          <option  value="Category">Category</option>
                                          <option  value="Category">Category</option>
                                          <option  value="Category">Category</option>
                                          <option  value="Category">Category</option>
                                        </select>
                                        
                                        </td>
									  </tr>

                                     
                                      
                                      
                                      <tr>
                                        <td>No of Flat:</td>
                                        <td><input type="text" name="no_flat" id="no_flat"  />
                                        </td>
									  </tr>
                                      
                                      <tr>
                                        <td>No of Storied</td>
                                        <td><input type="text" name="no_storied" id="no_storied"  />
                                        </td>
									  </tr>
                                      
                                    </table>
                                  </div></td>
                                </tr>
                                
                                
                                <tr>
                                  <td>&nbsp;</td>
                                </tr>
                                
                                <tr>
                                  <td><div class="box">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td>Facility</td>
                                        <td><textarea name="facility" id="facility" rows="3" cols="3"> </textarea>
                                        </td>
									  </tr>
                                      
                                       <tr>
                                        <td>Fittings</td>
                                        <td><textarea name="fittings" id="fittings" rows="3" cols="3"> </textarea>
                                        </td>
									  </tr>
                                      
                                      
                                    </table>
                                  </div></td>
                                </tr>
                                
                                
                                
                                
                                <tr>
                                  <td>
								  <div class="box">
								  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td><input name="ngroup" type="submit" id="ngroup" value="Save" class="btn" /></td>
                                      <td><input name="mgroup" type="submit" id="mgroup" value="Update" class="btn" /></td>
                                      <td><input name="Button" type="button" class="btn" value="Cancel" /></td>
                                      <td><input class="btn" name="dgroup" type="submit" id="dgroup" value="Close"/></td>
                                    </tr>
                                  </table>
								  </div>								  </td>
                                </tr>
                              </table>
    </form>
							</div></td>
  </tr>
</table>

<?
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout.php");
?>