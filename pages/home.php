<?php
session_start();
ob_start();
require "../../config/inc.all.php";
$title='Sajeeb Homes';

?>
<div class="oe_view_manager oe_view_manager_current">
        <table width="100%" class="oe_view_manager_header">
            <colgroup><col width="20%">
            <col width="35%">
            <col width="15%">
            <col width="30%">
            </colgroup><tbody><tr class="oe_header_row oe_header_row_top">
              <td colspan="2">
                
                
                <h2 class="oe_view_title">
                  <span class="oe_view_title_text oe_breadcrumb_title"><span class="oe_breadcrumb_item"><?=$page_title;?></span></span>
                  </h2>
                
                
                </td>
              <td colspan="2"><table width="100%" border="0" align="center" cellpadding="10" cellspacing="0">
  <tr>
    <td height="30">&nbsp;</td>
    <td height="30">&nbsp;</td>
    <td height="30">&nbsp;</td>
  </tr>
</table>

              </td>
            </tr>
            </tbody></table>

        <div class="oe_view_manager_body">
            
          <div  class="oe_view_manager_view_list"></div>
            
                <div class="oe_view_manager_view_form"><div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">
        <div class="oe_form_buttons"></div>
        <div class="oe_form_sidebar"></div>
        <div class="oe_form_pager"></div>
        <div class="oe_form_container"></div>
    </div></div>
            
</div>
    </div>
<?
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout.php");
?>