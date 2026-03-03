<?php
/////////////////////////////////////////////////////////////////
///////////////////// VOUCHER FUNCTIONS /////////////////////////
/////////////////////////////////////////////////////////////////

function next_value($field,$table)
	{
			$sql="select max(".$field.") from ".$table;
			$query=mysql_fetch_row(mysql_query($sql));
			$value=$query[0]+1;
			if($query[0] == 0)
			{
				$value=100001;
			}
			return $value;
	}

function js_ledger_subledger_autocomplete($ledger_type,$proj_id)
{
if(	$ledger_type	==	'receipt'	) $balance_type = "balance_type IN ('Credit','Both') AND";
if(	$ledger_type	==	'payment'	) $balance_type = "balance_type IN ('Debit','Both') AND";
if(	$ledger_type	==	'journal'	) $balance_type = "";
if(	$ledger_type	==	'contra'	) $balance_type = "";
echo '<script type="text/javascript">';
echo ' var sub_ledgers = [
		';
		$a2="select 
				ledger_id, 
				ledger_name 
			from 
				accounts_ledger 
			where 
				".$balance_type."
				proj_id='$proj_id'
				
			order by 
				ledger_name";
		$a1	=	mysql_query($a2);
		$i = 0; 
		while(	$a = mysql_fetch_row($a1) )
			{
				if( $i == 0 ) 	echo   "'".$a[1]."'";
				else 			echo ", '".$a[1]."'";
								
				$b2="select 
						sub_ledger_id,
						sub_ledger 
					from 
						sub_ledger 
					where 
						ledger_id='$a[0]'";
				$b1 = mysql_query($b2);
				$c  = mysql_num_rows($b1);
				
				if($c>0)
					{
						while($b=mysql_fetch_row($b1))
							{
							echo ", '".$a[1]."::".$b[1]."'";
							}
					}
			$i++;				
			}	 
echo ' ]; </script>';
}
/////////////////////////////////////////////////////////////////
/////////////////////  COMMON FUNCTIONS  ////////////////////////
/////////////////////////////////////////////////////////////////

function access_control($user_group)
{
if($user_group!='admin' && $user_group!='accountant') {
	echo '<script>alert("You Are Not Authorized to Access This Page! For More Information Contact Administrator."); self.location="home.php"</script>';
	exit;
}
}
function prevent_multi_submit($type = "post", $excl = "validator") {
    $string = "";
    foreach ($_POST as $key => $val) {
        if ($key != $excl) {
            $string .= $val;
        }
    }
    if (isset($_SESSION['last'])) {
        if ($_SESSION['last'] === md5($string)) {
            return false;
        } else {
            $_SESSION['last'] = md5($string);
            return true;
        }
    } else {
        $_SESSION['last'] = md5($string);
        return true;
    }
}
function notification($msg,$type)
{
	//MSG: CONTAINS THE MASSAGE NOTE
	//TYPE: 0>MAXIMUM ERROR,1>SUCESSFUL,2>WARNING,3>INFORMATION......
	
//	if($type==0) echo '<div class="error">'.$msg.'</div>';
//	elseif($type==1) echo '<div class="success">'.$msg.'</div>';
//	elseif($type==2) echo '<div class="warning">'.$msg.'</div>';
//	else echo '<div class="info">'.$msg.'</div>';


echo '	<table width="350" height="32" border="0" align="center" cellpadding="5" cellspacing="0" class="view'.$type.'">
		<tr>
			<td width="56" align="center"><img src="icon/'.$type.'.png" width="32" height="32" /></td>
			<td width="344">'.$msg.'</td>
		</tr>
	</table>';
}

    function Date2age($d) {
        $ts = time() - strtotime(str_replace("-","/",$d));
       if((strtotime(str_replace("-","/",$d)))<1000) return 'NA';
        if($ts>31536000) $val .= floor($ts/31536000).' year ';
		
		if($ts>31536000) $ts=$ts%31536000;
		
        if($ts>2419200) $val .= floor($ts/2592000).' month';
       // else if($ts>604800) $val = round($ts/604800,0).' week';
       // else if($ts>86400) $val = round($ts/86400,0).' day';
       // else if($ts>3600) $val = round($ts/3600,0).' hour';
       // else if($ts>60) $val = round($ts/60,0).' minute';
       // else $val = $ts.' second';
       

        return $val;
    } 


function image_upload($path,$file)
{
$root=$path.'/'.$_SESSION['employee_selected'].'.jpg';
move_uploaded_file($file['tmp_name'],$root);
return $root;
}

function image_upload_on_id($path,$file,$id)
{
$root=$path.'/'.$id.'.jpg';

move_uploaded_file($file['tmp_name'],$root);

return $root;
}


	    function Date2Dateinterval($d1,$d2) {
        $ts = strtotime(str_replace("-","/",$d2)) - strtotime(str_replace("-","/",$d1));
       if((strtotime(str_replace("-","/",$d1)))<1000) return 'NA';
        if($ts>31536000) $val .= floor($ts/31536000).' year ';
		
		if($ts>31536000) $ts=$ts%31536000;
		
        if($ts>2419200) $val .= floor($ts/2592000).' month';
       // else if($ts>604800) $val = round($ts/604800,0).' week';
       // else if($ts>86400) $val = round($ts/86400,0).' day';
       // else if($ts>3600) $val = round($ts/3600,0).' hour';
       // else if($ts>60) $val = round($ts/60,0).' minute';
       // else $val = $ts.' second';
       

        return $val;
    } 
	
function date_value($date)
{
	$j=0;
	for($i=0;$i<strlen($date);$i++)
	{
		if(is_numeric($date[$i]))
		$time[$j]=$time[$j].$date[$i];
		else $j++;
	}
	$time=mktime(0,0,0,$time[1],$time[0],$time[2]);
	return $time;
}

function mysql_format2array($date)
{
$j=0;
for($i=0;$i<strlen($date);$i++)
{
if(is_numeric($date[$i]))
$time[$j]=$time[$j].$date[$i];
else $j++;
}
return $time;
}

function mysql_format2stamp($date)
{
$j=0;
for($i=0;$i<strlen($date);$i++)
{
if(is_numeric($date[$i]))
$time[$j]=$time[$j].$date[$i];
else $j++;
}
$time=mktime(0,0,0,$time[1],$time[2],$time[0]);
return $time;
}

function date_2_date_add_mon_duration($date,$duration='')
{
$j=0;
for($i=0;$i<strlen($date);$i++)
{
if(is_numeric($date[$i]))
$time[$j]=$time[$j].$date[$i];
else $j++;
}
$stamp_time=mktime(0,0,0,($time[1]+$duration),$time[2],$time[0]);
$time=date('Y-m-d',$stamp_time);
return $time;
}

function date_2_stamp_add_mon_duration($date,$duration='')
{
$j=0;
for($i=0;$i<strlen($date);$i++)
{
if(is_numeric($date[$i]))
$time[$j]=$time[$j].$date[$i];
else $j++;
}
$stamp_time=mktime(0,0,0,($time[1]+$duration),$time[2],$time[0]);
return $stamp_time;
}
/////////////////////////////////////////////////////////////////
///////////////////// DATABASE FUNCTIONS ////////////////////////
/////////////////////////////////////////////////////////////////
?>