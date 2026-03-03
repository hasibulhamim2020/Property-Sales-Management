<?php


function report_create($sql,$s='',$head=''){
if($s!='') $sl=$s;
	if($sql==NULL) return NULL;
		$res	 = mysql_query($sql);
		$cols 	 = mysql_num_fields($res);
		if(isset($sl)) $total_cols=$cols+1; else $total_cols=$cols;
		$str	.= '<table width="100%" border="0" cellpadding="2" cellspacing="0">';
		$str 	.= '<thead>';
		$str 	.= '<tr><td colspan="'.$total_cols.'" style="border:0px;">';
		$str 	.= $head;
		$str 	.= '</td></tr>';
		$str 	.= '<tr>';
		if(isset($sl))$str .='<th>S/L</th>';
		for($i=0;$i<$cols;$i++)
			{
				$name = mysql_field_name($res,$i);
				$str .='<th>'.ucwords(str_replace('_', ' ',$name)).'</th>';
			}
		$str .='</tr></thead><tbody>';

		while($row=mysql_fetch_array($res))
			{				
				$str .='<tr>';
				if(isset($sl)){$str .='<td>'.$sl.'</td>';$sl++;}
				for($i=0;$i<$cols;$i++) 
{
if($show[$i]!=1&&(is_numeric($row[$i])&&strpos($row[$i],'.')||$row[$i]=='')){$sum[$i]=$sum[$i]+$row[$i]; $str .='<td style="text-align:right">'.@number_format($row[$i],2).'</td>';}
else {$show[$i]=1; $str .='<td>'.$row[$i].'</td>';}}
				$str .='</tr>';
			}
		$str .='<tr class="footer">';
		if(isset($sl))$str .='<td>&nbsp;</td>';
		for($i=0;$i<$cols;$i++)
			{
				if($show[$i]!=1&&$sum[$i]!=0)$str .='<td style="text-align:right">'.number_format($sum[$i],2).'</td>';
				else $str .='<td>&nbsp;</td>';;
			}
		$str .='</tr></tbody>';
	$str .='</table>';
	return $str;

}
?>