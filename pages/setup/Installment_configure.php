<?php
session_start();
ob_start();
require "../../support/inc.all.php";
$title='Project Info';

//echo $proj_id;


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
                                        <td>Flat Type : </td>
                                        <td><select name="select2" id="select2">
                                          <option  value="Category">Category</option>
                                          <option  value="Category">Category</option>
                                          <option  value="Category">Category</option>
                                          <option  value="Category">Category</option>
                                        </select></td>
									  </tr>
                                    </table>													</td>
												  </tr>
												  
												  <tr>
													<td>&nbsp;</td>
												  </tr>
											  </table>											</td>
											<td valign="top">
											<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                                      <tr>
                                        <td>Client Details: </td>
                                        <td><input  name="name2" type="text" value=""/></td>
									  </tr>

                                      <tr>
                                        <td>Unit Price: </td>
                                        <td><input  name="name" type="text" value=""/></td>
									  </tr>
                                      <tr>
                                        <td>Payable Unit Price   : </td>
                                        <td><input  name="brief" type="text" value=""/></td>
									  </tr>
									  <tr>
                                        <td>Parking Price   : </td>
                                        <td><input  name="brief" type="text" value=""/></td>
									  </tr>
									  <tr>
                                        <td>Total Price   : </td>
                                        <td><input  name="brief" type="text" value=""/></td>
									  </tr>
									  <tr>
                                        <td>Discount Amount  : </td>
                                        <td><input  name="brief" type="text" value=""/></td>
									  </tr>
									  <tr>
                                        <td>Configure Amount  : </td>
                                        <td><input  name="brief" type="text" value=""/></td>
									  </tr>
                                    </table>											</td>
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
          <tr>
            <td><select name="select3" id="select3">
              <option  value="Category">Category</option>
              <option  value="Category">Category</option>
              <option  value="Category">Category</option>
              <option  value="Category">Category</option>
            </select></td>
            <td><input  name="code29" type="text" value=""/></td>
            <td><input  name="code210" type="text" value=""/></td>
            <td><input  name="code211" type="text" value=""/></td>
            <td><input  name="code212" type="text" value=""/></td>
            <td><input  name="code213" type="text" value=""/></td>
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
    <tr>
      <td><div class="box">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><input type="submit" value="Save" class="btn" /></td>
            <td><input type="submit" value="Update" class="btn" /></td>
            <td><input type="submit" value="Cancle" class="btn" /></td>
            <td><input type="submit" value="Close" class="btn" /></td>
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