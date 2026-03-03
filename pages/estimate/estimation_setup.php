<?php
session_start();
ob_start();
require "../../support/inc.all.php";
$title='Work Material';
$table='tbl_work_material';
$page="work_material.php";

if($_POST['approve'])
{
$proj_code=$_POST['proj_code'];
$floor_head=$_POST['floor_head'];
$work_title=$_POST['work_title'];
$count=$_POST['count'];
for($i=0;$i<$count;$i++)
{
$me=$_POST['me_'.($i+1)];
$u=$_POST['u_'.($i+1)];
$q=$_POST['q_'.($i+1)];
$r=$_POST['r_'.($i+1)];
$a=$_POST['a_'.($i+1)];
$re=$_POST['re_'.($i+1)];
$sql="INSERT INTO `tbl_estimated_setup_amt` ( `proj_id`, `floor_head_id`, `work_head_id`,`material_id`, `unit_id`, `qty`, `rate`, `amt`, `remarks`, `status`) VALUES ('$proj_code', '$floor_head','$work_title', '$me', '$u', '$q', '$r', '$a', '$r', 0)";
$query=mysql_query($sql);
		$type=1;
		$msg='New Entry Successfully Inserted.';
}
}
?><link rel="stylesheet" type="text/css" href="../../css/form.css" />
<script language="javascript">
function mas(count,total_count){

var q="q_"+count;
var r="r_"+count;
var a="a_"+count;
var tc=(total_count*1);
var qty=((document.getElementById(q).value)*1);
var rate=((document.getElementById(r).value)*1);
var amt=qty*rate;
document.getElementById(a).value=amt;
var total=0;
var i;
for(i=0;i<tc;i++)
{
var j="a_"+(i+1);
if(document.getElementById(j).value!='')
total=total+((document.getElementById(j).value)*1);
}
//alert(total);
document.getElementById("tamt").value=total;
}
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td>    
										<div class="form-container">
                                          <form action="" method="post"> 
                                            <fieldset>
                                            <legend>Work Selection</legend>
											  <div style="clear:both;">
											    <label>Project: </label>
<select name="proj_code" id="proj_code">
<? if(isset($_REQUEST['proj_code'])) $proj_code=$_REQUEST['proj_code'];
foreign_relation('tbl_project_info','proj_code','proj_name',$proj_code);?>
                                          </select>
									        </div>
								  
											<div style="clear:both;">
											  <label for="email">Floor Head: </label> 
											 <select name="floor_head">
<? if(isset($_REQUEST['floor_head'])) $floor_head=$_REQUEST['floor_head'];
foreign_relation('tbl_floor_head','id','floor_head',$floor_head);?>
							 				</select>
										    </div>
									  
											<div style="clear:both;">
											  <label for="fname">Work Selection: </label>
											 <select name="work_title">
<? if(isset($_REQUEST['work_title'])) $work_title=$_REQUEST['work_title'];
foreign_relation('tbl_work_title','id','work_title',$work_title);?>
							 </select>
											</div>
										    </fieldset>
									  
									<div class="buttonrow">
									  <input name="search" type="submit" id="search" value="Search" />
									</div>
									</form>
	                                    </div>
										</td></tr>
										<tr>
                                        <td>    
										<div>
                                          <form action="#" method="post">
                                            <input name="proj_code" type="hidden" id="proj_code" value="<?=$proj_code?>" />
                                            <input name="floor_head" type="hidden" id="floor_head" value="<?=$floor_head?>" />
                                            <input name="work_title" type="hidden" id="work_title" value="<?=$work_title?>" />
                                            <fieldset>
                                            <legend style="color:#FFFFFF; font-weight:bold;">Expanse Estimation</legend>
											<div class="tabledesign2">
                                                  <table cellspacing="0" cellpadding="0" width="100%">
                                                    <tr>
                                                      <th>Work material</th>
                                                      <th>Unit</th>
                                                      <th>Qty</th>
                                                      <th>Rate</th>
                                                      <th>Amount </th>
                                                      <th>Remarks </th>
                                                    </tr>
<? 
if($_POST['search']){
$res='select c.id,b.work_title,a.material, a.unit,a.id from tbl_material a,tbl_work_title b,tbl_work_material c where c.work_id=a.id and c.material_id=b.id and b.id='.$work_title;
$query=mysql_query($res);
if(mysql_num_rows($query)>0){
$counting=mysql_num_rows($query);
$c==0;
while($data=mysql_fetch_row($query)){
$c++;
?>

<tr class="alt">
  <td>
  <input id="me_<?=$c;?>" type="hidden" name="me_<?=$c;?>" value="<?=$data[4];?>" size="15" />
  <input id="m_<?=$c;?>" type="text" name="m_<?=$c;?>" value="<?=$data[2];?>" size="15" /></td>
  <td><input id="u_<?=$c;?>" type="text" name="u_<?=$c;?>" value="<?=$data[3];?>" size="15"/></td>
  <td><input id="q_<?=$c;?>" type="text" name="q_<?=$c;?>" value="" size="15" onchange="mas(<?=$c?>,<?=$counting;?>)"/></td>
  <td><input id="r_<?=$c;?>" type="text" name="r_<?=$c;?>" value="" size="15" onchange="mas(<?=$c?>,<?=$counting;?>)"/></td>
  <td><input id="a_<?=$c;?>" type="text" name="a_<?=$c;?>" value="" size="15" readonly/></td>
  <td><input id="re_<?=$c;?>" type="text" name="re_<?=$c;?>" value="" size="15"/></td>
</tr>
<? }}}?>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td><input id="count" type="hidden" name="count" value="<?=$counting;?>" size="15" />
  <input id="tamt" type="text" name="tamt" value="" size="15" readonly="readonly"/></td>
  <td>&nbsp;</td>
</tr>
                                                  </table>
                                            </div>
										    </fieldset>
									  
									<div class="buttonrow1">
									  <input name="approve" type="submit" id="approve" value="Varify Estimation" />
									</div>
									</form>
	                                    </div>
										</td></tr>
										
                                      <tr>
                                        <td>&nbsp;</td>
                                      </tr>
                                  </table>

<?
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout.php");
?>