<? 
session_start();
$level=$_SESSION['user']['level'];

$permission = find_a_field('user_activity_management','home_mod','user_id="'.$_SESSION['user']['id'].'"');
if ($permission==0) {
?><script>location.href="../../index.php";</script>

<?php } ?>

<? //die('Access Limited');?>


<div class="menu_bg">
<table width="200" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
<td>
<div class="smartmenu">


<? if($level==5||$level==4||$level==2){?>
<div class="silverheader"><a href="#" >Setup</a></div>
<div class="submenu">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<? if($level==5||$level==4){?>
<tr><td><a href="../setup/project_info.php">Project Info</a></td></tr>
<tr><td><a href="../setup/add_category.php">Add Category</a></td></tr>
<tr><td><a href="../setup/add_block.php">Add Block </a></td></tr>
<tr><td><a href="../setup/add_section.php">Add Section </a></td></tr>

<!--<tr><td><a href="../setup/add_road.php">Add Road</a></td></tr>
<tr><td><a href="../setup/add_plot.php">Add Plot</a></td></tr>-->

<tr><td><a href="../setup/price_configuration.php">Product Information </a></td></tr>
<tr><td><a href="../setup/payment_head.php">Payment Head</a></td></tr>
<? } ?>
<tr><td><a href="../setup/client_info.php">Client Info</a></td></tr>

<!--<tr>
<td><a href="../setup/rent_info.php">Rent Info</a></td>
</tr>-->
</table>
</div>
<? } ?>
                
<? if(
$_SESSION['user']['id']==10004 || // mis faysal
$_SESSION['user']['id']==11912 // homes jakir
) { ?>				
<div class="silverheader"><a href="#">Delete</a></div>
<div class="submenu">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td><a href="../transaction/cancel_money_receipt.php"  style="color:#f36; font-weight: bold;">Cancel Money Receipt</a></td></tr>
<tr><td><a href="../transaction/cancel_allotment.php"  style="color:#f36; font-weight: bold;">Cancel Allotment</a></td></tr>
</table></div>
<? } ?>


<? if($level==5||$level==4){?>
<div class="silverheader"><a href="#">Transaction</a></div>
<div class="submenu">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td><a href="../transaction/flat_allotment.php">Allotment Status </a></td></tr>
<tr><td><a href="../transaction/price_installment.php">Deed With Client</a></td></tr>
<? if($_SESSION['user']['username']=='faysal'){?>
<tr><td><a href="../transaction/update_deed.php">Update Deed</a></td></tr>
<? } ?>	
<tr><td><a href="../transaction/money_receipt_fine.php">Fine Adjust/Receive</a></td></tr>
<tr><td><a href="../transaction/money_receipt.php">Money Receipt</a></td></tr>
<!--<tr><td><a href="../transaction/transfer_allotment.php">Transfer Allotment</a></td></tr>-->
<!--<tr><td><a href="../transaction/chaque_realize.php">Chaque Realization</a></td></tr>-->
<!--<tr><td><a href="../transaction/rent_receive.php">Rent Receive</a></td></tr>-->
</table></div>
<? } ?>	                              
							  
							  
<? if($level==5||$level==4){?>						  
<div class="silverheader"><a href="#">Query</a></div>
                              <div class="submenu">
                                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
                                      <td><a href="../query/client_payment_sechudule.php">Client Payment Sechudule</a></td>
                                    </tr>
								     <tr>
                                      <td><a href="../query/flat_deposit.php">Allotment Wise Deposit</a></td>
                                    </tr>
									<tr>
                                      <td><a href="../query/flat_installment.php">Allotment Wise Installment</a></td>
                                    </tr>
									
									<tr>
                                      <td><a href="../query/collection_summary.php">Collection Summary</a></td>
                                    </tr>
									
									<!-- <tr>
                                      <td><a href="../query/client_collection.php">Client wise Collection</a></td>
                                    </tr>-->
									
									 <tr>
                                      <td><a href="../query/money_receipt_report.php">Money Receipt View</a></td>
                                    </tr>
									
									
                                    <tr>
                                      <td><a href="../query/search_client.php">Client Status</a></td>
                                    </tr>
                                  </table>
                              </div>
							  
							  
							  
							  <!--
							  	<div class="silverheader"><a href="#">Estimate</a></div>
                              <div class="submenu">
                                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
                                      <td><a href="../estimate/floor_head.php">Floor Head</a></td>
                                    </tr>
								     <tr>
                                      <td><a href="../estimate/work_title.php">Work Title</a></td>
                                    </tr>
									<tr>
                                      <td><a href="../estimate/material_list.php">Material List</a></td>
                                    </tr>
									<tr>
                                      <td><a href="../estimate/unit_list.php">Unit List</a></td>
                                    </tr>
																	  <tr>
                                      <td><a href="../estimate/work_material.php">Work Wise Material</a></td>
                                    </tr>
									                                   
																	  <tr>
                                      <td><a href="../estimate/estimation_setup.php">Estimation Setup</a></td>
                                    </tr>
									<tr>
                                      <td><a href="../estimate/estimation_report.php">Estimation Report</a></td>
                                    </tr>
                                  </table>
                              </div>-->
							  
							  
<!-- <div class="silverheader"><a href="#">Sales Commission</a></div>
                              <div class="submenu">
                                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
								 <tr>
                                      <td><a href="../commission/party_info.php">Party Information</a></td>
                                    </tr>
									
									<tr>
                                      <td><a href="../commission/dir_info.php">Share Holder Information</a></td>
                                    </tr>
								     <tr>
                                      <td><a href="../commission/employee_info.php">Agent Information</a></td>
                                    </tr>
									<tr>
                                      <td><a href="../commission/commission.php">Commission Distribution</a></td>
                                    </tr>
                                  </table>
                              </div>-->
<? } ?>						  
							  


<? if($level==5||$level==4||$level==2||$level==1){?>							  
<div class="silverheader"><a href="#">Report</a></div>
                              <div class="submenu">
                                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    
									<tr><td><a href="../report/project_information.php">Project Information Reports</a></td></tr>
									<tr><td><a href="../report/client_information.php">Client Information Reports</a></td></tr>
                                    <tr><td><a href="../report/report_selection.php">General Reports</a></td></tr>
<!--									<tr><td><a href="../report/share_information.php">Share Information Reports</a></td></tr>
									<tr><td><a href="../report/rent_information.php">Rent Information Reports</a></td></tr>
                                   <tr><td><a href="../report/letter_issue.php">Letter Issue</a></td></tr>-->
									

<!--   
                                    <tr>
                                      <td><a href="../report/money_receipt_report.php">Money Receipt</a></td>
                                    </tr>-->
                                          
                                    <!--<tr>
                                      <td><a href="../report/project_report.php">Project Info</a></td>
                                    </tr>
                                    <tr>-->
                                    <!--  <td><a href="../report/sales_status_report.php">Sales Status Report</a></td>
                                    </tr>
                                    -->
                                    
</table>
</div>
<? } ?>	


<? if(
$_SESSION['user']['id']==10004 || // mis faysal
$_SESSION['user']['id']==103451 // audit.sc
) { ?>	
<div class="silverheader"><a href="#">Audit Report</a></div>
<div class="submenu">
<table width="100%" border="0" cellspacing="0" cellpadding="0">

<tr><td><a href="../report/report_list.php">General Reports</a></td></tr>

</table>
</div>
<? } ?>


							<!--  <div class="silverheader"><a href="#">Accounts</a></div>
                              <div class="submenu">
                                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td><a href="../../../scb_mod/pages/home.php">Main Page</a></td>
                                    </tr>
                                    <tr>
                                      <td><a href="../../../scb_mod/pages/credit_note.php">Credit Voucher</a></td>
                                    </tr>
                                    <tr>
                                      <td><a href="../../../scb_mod/pages/debit_note.php">Debit Voucher</a></td>
                                    </tr>
                                    <tr>
                                      <td><a href="../../../scb_mod/pages/voucher_view.php">Voucher View</a></td>
                                    </tr>
                                  </table>
                              </div>-->
                   
			   
				   
				   <div class="silverheader"><a href="../main/logout.php">Exit Program</a></div>
                              <div class="submenu">
                                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td><a href="../main/logout.php">Logout</a></td>
                                    </tr>
                                   
                                    
                                   
                                  </table>
                              </div></div>                             
											</td>
										  </tr>
										</table>

									</div>
