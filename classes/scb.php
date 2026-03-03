<?
if(!isset($_SESSION))
session_start();
/////////////////////////////////////////////////////////////////
///////////////////// VOUCHER FUNCTIONS /////////////////////////
/////////////////////////////////////////////////////////////////
function next_journal_voucher_id()
	{
			$jv_no=mysql_fetch_row(mysql_query("select MAX(jv_no) from journal"));
			$p_id= date("Ymd")."0000";
			
			if($jv_no[0]>$p_id)
			$jv=$jv_no[0]+1;
			else
			$jv=$p_id+1;
			
			return $jv;
	}


function js_ledger_subledger_autocomplete_new($ledger_type,$proj_id,$type='')
{
if(	$ledger_type	==	'receipt'	) $balance_type = "balance_type IN ('Credit','Both') AND";
if(	$ledger_type	==	'payment'	) $balance_type = "balance_type IN ('Debit','Both') AND";
if(	$ledger_type	==	'journal'	) $balance_type = "";
if(	$ledger_type	==	'contra'	) $balance_type = "";
echo '<script type="text/javascript">';
$under_ledger = '[';
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
		
	  while($a = mysql_fetch_row($a1)){$under_ledger .= '{ name: "'.$a[1].'", id: "'.$a[0].'" },';}
      $under_ledger = substr($under_ledger, 0, -1);
 
$under_ledger .= ']';	
echo '
$().ready(function() {
var data = '.$under_ledger.';
	$("#ledger_id").autocomplete(data, {
		matchContains: false,
		minChars: 0,
		scroll: true,
		scrollHeight: 300,
        formatItem: function(row, i, max, term) {
			//return row.name.replace(new RegExp("(" + term + ")", "gi"), "<strong>$1</strong>") + "<br><span style="font-size: 80%;">ID: " + row.id + "</span>"; 
			';
            if($type==1)
            echo 'return row.name + " [" + row.id + "]";';
			else
			echo 'return row.id + " [" + row.name + "]";';
		echo '},
		formatResult: function(row) {
			return row.name;
		}
	});
	
	$(function() {
		$("#date").datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: "dd-mm-y"
		});

		$("#c_date").datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: "dd-mm-y"
		});
	});
	
	
});
</script>';
}



function group_class($rp){
	if($rp==100) 		$cls='Asset';
	elseif($rp==200) 	$cls='Income';
	elseif($rp==300) 	$cls='Expense';
	elseif($rp==400) 	$cls='Liabilities';
	else $cls=NULL;
	return $cls;
}
function next_group_id($cls)
{
$max=(ceil(($cls+1)/100))*100;
$min=$cls-1;
$s='select max(group_id) from ledger_group where group_id>'.$min.' and group_id<'.$max;
$sql=mysql_query($s);
if(mysql_num_rows($sql)>0)
$data=mysql_fetch_row($sql);
else
$acc_no=$min;
if(!isset($acc_no)&&(is_null($data[0]))) 
$acc_no=$cls;
else
$acc_no=$data[0]+1;
return $acc_no;
}
function next_ledger_id($group_id)
{
$max=($group_id*1000000)+1000000;
$min=($group_id*1000000)-1;
$s='select max(ledger_id) from accounts_ledger where ledger_id>'.$min.' and ledger_id<'.$max;
$sql=mysql_query($s);
if(mysql_num_rows($sql)>0)
$data=mysql_fetch_row($sql);
else
$acc_no=$min;
if(!isset($acc_no)&&(is_null($data[0]))) 
$acc_no=$cls;
else
$acc_no=$data[0]+1000;
return $acc_no;
}
function under_ledger_id($id)
{
//***-***-***
if(($id%1000000)==0)// group level
{
	$max=($id)+1000000;
	$min=($id)-1;
	$add=1000;		// make ledger
}
elseif(($ledger_id%1000)==0)// ledger level
{
	$max=($id)+1000;
	$min=($id)-1;
	$add=1;		// make ledger
}
$s='select max(ledger_id) from accounts_ledger where ledger_id>'.$min.' and ledger_id<'.$max;
$sql=mysql_query($s);
if(mysql_num_rows($sql)>0)
$data=mysql_fetch_row($sql);
else
$acc_no=$id+$add;
if(!isset($acc_no)) 
$acc_no=$data[0]+$add;
return $acc_no;
}
function next_sub_ledger_id($ledger_id)
{
$max=$ledger_id+1000;
$min=$ledger_id-1;
$s='select max(ledger_id) from accounts_ledger where ledger_id>'.$min.' and ledger_id<'.$max;
$sql=mysql_query($s);
if(mysql_num_rows($sql)>0)
$data=mysql_fetch_row($sql);
else
$acc_no=$min;
if(!isset($acc_no)&&(is_null($data[0]))) 
$acc_no=$cls;
else
$acc_no=$data[0]+1;
return $acc_no;
}
function group_ledger_id($group_id)
{
return $group_id*1000000;
}
function sub_ledger_create($sub_ledger_id,$name, $under, $balance, $now, $proj_id)
{
			$sql="INSERT INTO `sub_ledger` (
			`sub_ledger_id` ,
			`sub_ledger` ,
			`ledger_id` ,
			`opening_balance` ,
			`created_on` ,
			`proj_id`
			)
			VALUES ('$sub_ledger_id','$name', '$under', '$balance', '$now', '$proj_id')";

		$query=mysql_query($sql);
}
function ledger_create($ledger_id,$ledger_name,$ledger_group_id,$opening_balance,$balance_type,$depreciation_rate,$credit_limit, $opening_balance_on,$proj_id,$budget_enable='NO')
{
		$sql="INSERT INTO `accounts_ledger` 
		(`ledger_id`,
		`ledger_name` ,
		`ledger_group_id` ,
		`opening_balance` ,
		`balance_type` ,
		`depreciation_rate` ,
		`credit_limit` ,
		`opening_balance_on` ,
		`proj_id`,
		`budget_enable`)
		VALUES ('$ledger_id','$ledger_name', '$ledger_group_id', '$opening_balance', '$balance_type', '$depreciation_rate', '$credit_limit', '$opening_balance_on','$proj_id','$budget_enable')";
		if(mysql_query($sql))
		return TRUE;
		else 
		return FALSE;
}
function ledger_redundancy($ledger_name,$ledger_id='')
{	
	if($ledger_id!='')
	$advance_check=" and ledger_id!='$ledger_id'";
	$check="select ledger_id from accounts_ledger where ledger_name='$ledger_name'".$advance_check;
	if(mysql_num_rows(mysql_query($check))>0)
	return FALSE;
	else
	return TRUE;
}
function group_redundancy($group_name,$manual_group_code='',$group_id='')
{
	if($manual_group_code!='')
	$add_check=" or manual_group_code='$manual_group_code'";
	if($group_id!='')
	$advance_check=" and group_id!='$group_id'";
	$check="select group_id from ledger_group where group_name='$group_name'".$add_check.$advance_check;
	if(mysql_num_rows(mysql_query($check))>0)
	return FALSE;
	else
	return TRUE;
}
function add_to_journal($proj_id, $jv_no, $jv_date, $ledger_id, $narration, $dr_amt, $cr_amt, $tr_from, $jv,$sub_ledger='')
{
	$journal="INSERT INTO `journal` (
	`proj_id` ,
	`jv_no` ,
	`jv_date` ,
	`ledger_id` ,
	`narration` ,
	`dr_amt` ,
	`cr_amt` ,
	`tr_from` ,
	`tr_no` ,
	`sub_ledger`
	)VALUES ('$proj_id', '$jv_no', '$jv_date', '$ledger_id', '$narration', '$dr_amt', '$cr_amt', '$tr_from', '$jv','$sub_ledger')";
	$query_journal=mysql_query($journal);
}
function pay_invoice_amount($proj_id, $jv_no, $jv_date, $cr_ledger_id,$dr_ledger_id, $narration, $amount, $tr_from, $jv)
{	
add_to_journal($proj_id, $jv_no, $jv_date, $cr_ledger_id, $narration, '0', $amount, $tr_from, $jv);
add_to_journal($proj_id, $jv_no, $jv_date, $dr_ledger_id, $narration, $amount, '0', $tr_from, $jv);
}
?>