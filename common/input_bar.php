<header>
    <? if(!isset($_GET[$unique])){?>

    <span class="oe_form_buttons_edit" style="display: inline;">
      <button name="insert" accesskey="S" class="oe_button oe_form_button_save oe_highlight" type="submit">Save</button>
    </span>
    <? }?>
    <? if(!isset($_GET[$unique])){?>
    <span class="oe_form_buttons_edit" style="display: inline;">
      <button name="insertn" accesskey="S" class="oe_button oe_form_button_save oe_highlight" type="submit">Save & New</button>
    </span>
    <? }?>
    <? if(isset($_GET[$unique])){?>
    <span class="oe_form_buttons_edit" style="display: inline;">
      <button name="update" accesskey="S" class="oe_button oe_form_button_save oe_highlight" type="submit">Update</button>
    </span>
    <? }?>
    <span class="oe_form_buttons_edit" style="display: inline;">
    <button name="reset" class="oe_button oe_form_button" type="button" onclick="parent.parent.GB_hide();">Cancel</button>
    </span>
    <span class="oe_form_buttons_edit" style="display: inline;">
    <button class="oe_button oe_form_button" type="button" onclick="parent.parent.document.location.href = '../<?=$root?>/<?=$page?>';">Show All</button>
    </span>
    <? if(isset($_GET[$unique])){?>
    <span class="oe_form_buttons_edit" style="display: inline;">
    <button name="delete" accesskey="S" class="oe_button oe_form_button_save oe_highlight" type="submit">Delete</button>
    </span>
    <? }?>
    
    <ul class="oe_form_field_status oe_form_status">
    
        <li class="oe_active" data-id="draft">
            <span class="label">Data Successfully Saved</span>
            
            <span class="arrow"><span></span></span>
        </li>
    
        <li class="" data-id="posted">
            <span class="label">Report</span>
            
            <span class="arrow"><span></span></span>
        </li>
    
</ul><div class="oe_clear"></div></header>