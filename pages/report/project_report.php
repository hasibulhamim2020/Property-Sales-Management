<?php
session_start();
ob_start();
require "../../support/inc.all.php";
$title='Project Info';

//echo $proj_id;
?>

<script type="text/javascript">

function checkUserName()
{	
	var e = document.getElementById('group_name');
	if(e.value=='')
	{
		alert("Invalid Group Name!!!");
		e.focus();
		return false;
	}
	else
	{
		$.ajax({
		  url: 'common/check_entry.php',
		  data: "query_item="+$('#group_name').val()+"&pageid=ledger_group",
		  success: function(data) 
		  	{			
			  if(data=='')
			  	return true;
			  else	
			  	{
				alert(data);
				e.value='';
				e.focus();
				return false;
				}
			}
		});
	}
}
function DoNav(theUrl)
{
	document.location.href = 'ledger_group.php?group_id='+theUrl;
}
</script>



<div class="box2">
									  <table width="100%" border="0" cellspacing="0" cellpadding="0">
										  <tr>
											<td>
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												  <tr>
													<td>
										          <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                                      <tr>
                                        <td>Project  :</td>
                                        <td><select name="project" id="project">
                                          <option  value="Category">Category</option>
                                          <option  value="Category">Category</option>
                                          <option  value="Category">Category</option>
                                          <option  value="Category">Category</option>
                                        </select></td>
									  </tr>

                                      <tr>
                                        <td>Builings: </td>
                                        <td><select name="select" id="select">
                                          <option  value="Category">Category</option>
                                          <option  value="Category">Category</option>
                                          <option  value="Category">Category</option>
                                          <option  value="Category">Category</option>
                                        </select></td>
									  </tr>
                                     
									  
									  <tr>
									 <td>&nbsp;</td>
									<td><input type="submit" value="Filter" class="btn" /></td>
									
								  </tr>
															  
									  
                                    </table>													</td>
												  </tr>
												  
												  <tr>
													<td>&nbsp;</td>
												  </tr>
												  
												  
												  
												  
											  </table>											</td>
											<td valign="top">
																						</td>
										  </tr>
										</table>
									  </div>

<div class="box4">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><div class="tabledesign2">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <th>Payment Head </th>
            <th>Amount</th>
            <th>Duration</th>
            <th>Total Inst.</th>
            <th>Inst. Amount </th>
            <th>On or Before date </th>
          </tr>
         
          <tr class="alt">
            <td>Paycode Des.</td>
            <td>Amount</td>
            <td>Duration</td>
            <td>Total Inst. </td>
            <td>Inst. Amount </td>
            <td>On or before date </td>
          </tr>
          <tr>
            <td>Demo text </td>
            <td>Demo text </td>
            <td>Demo text </td>
            <td>Demo text </td>
            <td>Demo text </td>
            <td>Demo text </td>
          </tr>
          <tr class="alt">
            <td>Paycode Des.</td>
            <td>Amount</td>
            <td>Duration</td>
            <td>Total Inst. </td>
            <td>Inst. Amount </td>
            <td>On or before date </td>
          </tr>
          <tr>
            <td>Demo text </td>
            <td>Demo text </td>
            <td>Demo text </td>
            <td>Demo text </td>
            <td>Demo text </td>
            <td>Demo text </td>
          </tr>
          <tr class="alt">
            <td>Paycode Des.</td>
            <td>Amount</td>
            <td>Duration</td>
            <td>Total Inst. </td>
            <td>Inst. Amount </td>
            <td>On or before date </td>
          </tr>
          <tr>
            <td>Demo text </td>
            <td>Demo text </td>
            <td>Demo text </td>
            <td>Demo text </td>
            <td>Demo text </td>
            <td>Demo text </td>
          </tr>
          <tr class="alt">
            <td>Paycode Des.</td>
            <td>Amount</td>
            <td>Duration</td>
            <td>Total Inst. </td>
            <td>Inst. Amount </td>
            <td>On or before date </td>
          </tr>
          <tr>
            <td>Demo text </td>
            <td>Demo text </td>
            <td>Demo text </td>
            <td>Demo text </td>
            <td>Demo text </td>
            <td>Demo text </td>
          </tr>
        </table>
      </div></td>
    </tr>
    
  </table>
</div>

<?
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout.php");
?>