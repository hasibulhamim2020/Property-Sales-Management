<?php
session_start();
ob_start();
require "../../support/inc.all.php";
if(isset($_POST['submit']))
{
$sql="select rec_no from tbl_receipt where pay_mode=1  and check_realize_status<1 limit 20 ";
$query=mysql_query($sql);
	while($data=mysql_fetch_row($query))
	{
	$v=$data[0];
	if($_POST[$v]>0)
		{ 
		$res="UPDATE `tbl_receipt` SET `check_realize_reason` = '".$_POST[$v.'R']."',`check_realize_status` = '".$_POST[$v]."' WHERE `rec_no` ='".$v."' LIMIT 1";
		mysql_query($res);
		if($_POST[$v]==1){
			$sql=mysql_query("select a.*,b.proj_code,b.build_code,b.flat_no from tbl_receipt_details a, tbl_receipt b where a.rec_no=b.rec_no and a.rec_no='".$v."'");
				if(mysql_num_rows($sql)>0)
				{
				while($data=mysql_fetch_object($sql)){
				$rec_no=$data->rec_no;
				$pay_code=$data->pay_code;
				$inst_no=$data->inst_no;
				$rec_amount=(int)$data->rec_amount;
				$proj_code=$data->proj_code;
				$build_code=$data->build_code;
				$flat_no=$data->flat_no;
				$feed=mysql_query("update tbl_flat_cost_installment 
				set rcv_amount=rcv_amount-".$rec_amount." , rcv_status=0, rec_no='NULL', rcv_date='NULL' where 
						proj_code='".$proj_code."' and 
						build_code='".$build_code."' and 
						flat_no='".$flat_no."' and 
						pay_code=".$pay_code." and 
						inst_no=".$inst_no." and 
						rec_no='".$rec_no."'");
				}
			}
		}
	}

}
}
function create_advance_report($res){

	if($res==NULL) return NULL;

	$str.=  '
<table border="1" cellpadding="1" cellspacing="0"  class="tabledesign" id="grp"  bordercolor="#3f590a" bgcolor="#c7eb8e" style="border:1px solid #3f590a; border-collapse:collapse; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px; color:#000000; text-align:left;" >
<thead>';



		



		$str .='<tr>';

		$cols = mysql_num_fields($res)-2; 

		//print_r($res);

		$per = floor(100 / $cols);

		for($i=0;$i<$cols;$i++)

		{

			$name = mysql_field_name($res,$i);

			$str .='<th>'.ucwords(str_replace('_', ' ',$name)).'</th>';

		}

		$str .='<th>Reason</th>';

		$str .='<th>Status</th>';

		$str .='</tr></thead>';

		$count=0;

		while($row=mysql_fetch_array($res)) {

		$count++;

		if($count%2)

		$str .='<tr class="alt">';

		else

		$str .='<tr class="alt1">';

	

		  for($i=0;$i<$cols;$i++) {

			$str .='<td>'.$row[$i]."</td>";

		  }

		  $str .='<td align="center"><input type="text" name="'.$row[$i].'R'.'" id="'.$row[$i].'R'.'" value="" /></td>';

		  $str .='<td align="center"><select name="'.$row[$i+1].'" id="'.$row[$i+1].'">
  <option value="">Pending</option>
  <option value="1">Fail</option>
  <option value="2">Success</option>
  </select></td>';

		  $str .='</tr>';

	

		}

	$str .='</table>';

	//echo $str;

	return $str;

}
?>
 <div class="form-container">
<form id="form1" name="form1" method="post" action="">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="100%" align="center" style="font-weight:bold;  font-size:13px; color:#FFFFFF;">Chaque Realization </td>
      </tr>
      
    </table>
	  <div align="center">
	    <?
	$sql=mysql_query("select cheq_no ,cheq_date ,bank_name, branch ,rec_amount,rec_no,rec_no from tbl_receipt where pay_mode=1  and check_realize_status<1 limit 20");
	echo create_advance_report($sql);
	paging(10);
	?>
	
        </div></td>
  </tr>
</table>

  <table width="30%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
	<td> <div align="center" class="button">
	  <input type="submit" name="submit" value="Final Realize" />
	</div></td>

    </tr>
  </table>

  
  
</form>
</div>
<?
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout.php");
?>