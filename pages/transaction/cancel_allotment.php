<?php
session_start();
ob_start();
require "../../support/inc.all.php";
$title='Cancle Allotment';

//echo $proj_id;



if(isset($_POST['cancel'])){

$f_id = $_POST['flat'];
$select = 'select fid from tbl_flat_cancel_allotment where fid='.$f_id;
$query = mysql_query($select);
$rows =  mysql_num_rows($query);

if($rows==0){


$select = 'select fid,	proj_code,	build_code,	section_name,	flat_no,party_code,	sum(non_insentive) as non_insentive,	sum(sr_executive_commission) as 	sr_executive_commission, sum(team_leader_commission) as team_leader_commission, sum(group_leader_commission) as group_leader_commission, sum(other_commission) as other_commission, sum(rcv_amount) as rcv_amount, sum(inst_amount) as total_amount  from tbl_flat_cost_installment where fid='.$f_id;
$query = mysql_query($select);
$r = mysql_fetch_object($query);


$fid	                = $f_id;
$proj_code             = $r->proj_code;
$build_code	        = $r->build_code;    
$section_name	        = $r->section_name;
$flat_no	            = $r->flat_no;
$flat_size             = find_a_field('tbl_flat_info','flat_size','fid='.$r->fid);
$road_no             = find_a_field('tbl_flat_info','road_no','fid='.$r->fid);
$party_code	        = $r->party_code;
$total_price           = $r->total_amount;
$rcv_amount            = $r->rcv_amount;
$refund_amount	        = (($r->rcv_amount/100)*85);
$non_insentive	        = $r->non_insentive;
$sr_executive_commission = $r->sr_executive_commission;
$team_leader_commission  = $r->team_leader_commission;	
$group_leader_commission = $r->group_leader_commission;
$other_commission        = $r->other_commission;





 $s = 'INSERT INTO `tbl_flat_cancel_allotment`
( 
`fid`,
 `proj_code`,
  `build_code`,
   `section_name`,
    `flat_no`,
	 `flat_size`,
	 `road_no`,
	 `party_code`,
	  `total_price`,
	   `rcv_amount`,
	    `refund_amount`,
		 `seller_code`,
		  `non_insentive`,
		   `sr_executive_commission`,
		    `team_leader_commission`,
			 `group_leader_commission`,
			  `other_commission`,
			  `entry_by`,`reason`) 
				  
				  VALUES (

"'.$fid.'",
"'.$proj_code.'",
"'.$build_code.'",
"'.$section_name.'",
"'.$flat_no.'",
"'.$flat_size.'",
"'.$road_no.'",
"'.$party_code.'",
"'.$total_price.'",
"'.$rcv_amount.'",
"'.$refund_amount.'",
"'.$party_code.'",
"'.$non_insentive.'",
"'.$sr_executive_commission.'",
"'.$team_leader_commission.'",
"'.$group_leader_commission.'",
"'.$other_commission.'",
"'.$_SESSION['user']['id'].'",
"'.$_POST['reason'].'"

)';

mysql_query($s);



$select = 'UPDATE tbl_flat_info 
SET status="",sr_status="",booked_on="0000-00-00",
party_code="0",non_insentive="0",sr_executive_commission="0",
team_leader_commission="0",group_leader_commission="0",
other_commission="0" where fid='.$f_id;
mysql_query($select);


$s = "DELETE FROM `tbl_receipt` WHERE `fid`=".$f_id;
mysql_query($s);

$s = "DELETE FROM `tbl_receipt_details` WHERE  `fid`=".$f_id;
mysql_query($s);

$s = "DELETE FROM `tbl_flat_cost_installment` WHERE `fid`=".$f_id;
mysql_query($s);



$success = "Canceled Flat Successfully !!";

}else{

 $wrongg =  "Allotment Deleted Exist !!";
}


//echo select->proj_code;



// $s_u = "insert into  tbl_flat_cancel_info (project_no,section_no,flat_no,user_id)values('".$proj_code."','".$section_name."','".$f_id."','".$_SESSION['user']['id']."')";
//
//mysql_query($s_u);



//$s = "UPDATE `tbl_flat_info` SET `flat_size` = '0', `sqft_price` = '0', `unit_price` = '0', `development_fee` = '0', `total_price` = '0', `status` = '', `booked_on` = '0000-00-00', `party_code` = '0', `sr_executive_commission` = '0', `team_leader_commission` = '0', `group_leader_commission` = '0', `other_commission` = '0' WHERE `tbl_flat_info`.`fid` ='".$f_id."'";
//
//mysql_query($s);


//$s = "DELETE FROM `tbl_receipt` WHERE `tbl_receipt`.`fid`=".$f_id;
//
//mysql_query($s);
//
//
//$s = "DELETE FROM `tbl_receipt_details` WHERE `tbl_receipt_details`.`fid`=".$f_id;
//
//mysql_query($s);




//$success = "Canceled Flat Successfully !!";

}





?>
<style type="text/css">
<!--
.style1 {color: #000000}
-->
</style>

  
  <script type = "text/javascript">
    var GB_ROOT_DIR = "../../greybox/";
  </script>
  <script type = "text/javascript" src = "../../greybox/AJS.js"></script>
  <script type = "text/javascript" src = "../../greybox/AJS_fx.js"></script>
  <script type = "text/javascript" src = "../../greybox/gb_scripts.js"></script>
  <link href = "../../greybox/gb_styles.css" rel = "stylesheet" type = "text/css" media = "all"/>
  
  <div class="form-container_large">
  <form id="form1" name="form1" method="post" action=""  onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td align="center"> 
					<fieldset>
					<legend>Cancle Allotment</legend>
				  <div>

                                          <label>Project : </label>


<select name="proj_code" id="proj_code" onchange="getData2('../../common/section_option_mhafuz.php', 'bld', document.getElementById('proj_code').value,this.value);" required>
						<? if(isset($_REQUEST['proj_code'])) $proj_code=$_REQUEST['proj_code'];
						foreign_relation('tbl_project_info','proj_code','proj_name',$proj_code);?>
						</select>
                                  </div>

					   <div>

                                          <label for="email">Section Name :</label>

										<span id="bld">
											<select name="section_name" id="section_name" required>
											<? if(isset($_REQUEST['section_name'])) $section_name=$_REQUEST['section_name'];
											if(isset($_REQUEST['proj_code']))
											foreign_relation('add_section','section_id','section_name',$section_name,'proj_id = "'.$proj_code.'"');

											
											?>
											</select>
											</span>                                        </div>
				    <div>
                                          <label for="fname">Plot no. : </label>
					                      <span id="fid">
					                      <select name="flat" id="flat" required>
                                            <? 
											foreign_relation('tbl_flat_info','fid','flat_no',$flat,$con);?>
                                          </select>
                      </span></div>
					  
					  
					  
					  
					  <div>
                                          <label for="fname">Reason : </label>
					                      <span id="fid">
					                      <select name="reason" id="reason" required>
                                           <option value=""></option>
                                           <option value="Cancel Plot">Cancel Plot</option>
                                           <option value="Transfer Plot">Transfer Plot</option>
                                          </select>
                      </span></div>
					  
					  
					
					<div class="buttonrow">
					<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
					<tr>
					<td width="12%">&nbsp;</td>
					<td>
					<input name="cancel" type="submit" id="transfer" value="Cancel"/>			</td>
					<td width="20%">&nbsp;</td>
					</tr>
					</table>
					</div>
					</fieldset>	  </td>
    </tr>
    <tr>
      <td align="center">&nbsp;</td>
    </tr>
    <tr>
	
			
	<? if($success){?>
	<tr>
				
					<td colspan="3">
					  <div align="center">
					    <input type="submit"  value="<?=$success?>" style="width: 300px; background: green; margin-left: 220px; height: 40px; color: white; font-weight:bold; "/>			
			        </div></td>
	  </tr>
	  
	  
					<? } ?>
					<? if($wrongg){?>
					
	
	<tr>
				
					<td colspan="3">
					  <div align="center">
					    <input type="submit"  value="<?=$wrongg?>" style="width: 300px; background: red; margin-left: 220px; height: 40px; color: white; font-weight:bold; "/>			
			        </div></td>
	  </tr>
	  
	  
					<? } ?>
			
					
      <td></td>
    </tr>
  </table>
  <label>
  <div align="center"></div>
  </label>
  </form>
  </div>
  <?
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout.php");
?>
