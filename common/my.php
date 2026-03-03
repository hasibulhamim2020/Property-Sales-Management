<?php
/////////////////////////////////////////////////////////////////
///////////////////// DATABASE FUNCTIONS ////////////////////////
/////////////////////////////////////////////////////////////////
function connectDB()
{
$GLOBALS['DB'] = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die();
$np_db = mysql_select_db(DB_NAME) or die("<p class=error>There is a problem selecting the database.</p>");
}

function closeDB()
{
mysql_close(DB_NAME);
}

function db_execute($sql) 
{
return mysql_query($sql);
}

function db_fetch_object($table,$condition)
{
	$res="select * from $table where $condition limit 1";
	if($query=mysql_query($res)){
	if(mysql_num_rows($query)>0) return mysql_fetch_object($query);
	else return NULL;}else return NULL;
}
function find($res)
{
	$query=mysql_query($res);
	if(mysql_num_rows($query)>0) return 1;
	else return NULL;
}



function find_a_field_sql($sql){
	$res=@mysql_query($sql);
	$count=@mysql_num_rows($res);
	if($count>0)
	{
	$data=@mysql_fetch_row($res);
	return $data[0];
	}
	else
	return NULL;
	}
	
	

	
function find1($sql){
	$res=@mysql_query($sql);
	$count=@mysql_num_rows($res);
	if($count>0)
	{
	$data=@mysql_fetch_row($res);
	return $data[0];
	}
	else
	return NULL;
	}	

function findall($sql){

    $res=@mysql_query($sql);
    $count=@mysql_num_rows($res);
    
    if($count>0)
        {
        $data=@mysql_fetch_object($res);
        return $data;
        }
else
return NULL;
}


function next_journal_sec_voucher_id33($date='')
	{
if($date==''){
$min = date("Ymd")."0000";
$max = $min+10000;
}
else
{
$min = date("Ymd",strtotime($date))."0000";
$max = $min+10000;
}
$s ="select MAX(jv_no) jv_no from secondary_journal where jv_no between '".$min."' and '".$max."'";
			$jv_no=@mysql_fetch_row(mysql_query($s));

			if($jv_no[0]>$min)
			$jv=$jv_no[0]+1;
			else
			$jv=$min+1;
			
			return $jv;
	}



	
    function find_all_field($table,$field,$condition)
    {
    $sql="select * from $table where $condition limit 1";
    $res=@mysql_query($sql);
    $count=@mysql_num_rows($res);
    
    if($count>0)
        {
        $data=@mysql_fetch_object($res);
        return $data;
        }
    else
        return NULL;
    }


function add_to_sec_journal33($proj_id, $jv_no, $jv_date, $ledger_id, $narration, $dr_amt, $cr_amt, $tr_from, $tr_no,$sub_ledger='',$tr_id='',$cc_code='',$group='',$entry_by='',$entry_at='')
{
	if($group>0) $group_id = $group; else $group_id = $_SESSION['user']['group'];
	if($entry_at=='') $entry_at = date('Y-m-d H:s:i');
	if($entry_by=='') $entry_by = $_SESSION['user']['id']; 
	$journal="INSERT INTO `secondary_journal` (
	`proj_id` ,
	`jv_no` ,
	`jv_date` ,
	`ledger_id` ,
	`narration` ,
	`dr_amt` ,
	`cr_amt` ,
	`tr_from` ,
	`tr_no` ,
	`sub_ledger`,
	user_id,
	entry_at,
	group_for,
	tr_id,
	cc_code
	)VALUES ('$proj_id', '$jv_no', '$jv_date', '$ledger_id', '$narration', '$dr_amt', '$cr_amt', '$tr_from', '$tr_no','$sub_ledger','$entry_by','$entry_at','$group_id','$tr_id','$cc_code')";
	$query_journal=mysql_query($journal);
}




function search_flat_cost_status($proj_code,$build_code,$flat_no)
{
	$res="select 1 from tbl_flat_cost_installment where proj_code='$proj_code' and build_code='$build_code' and flat_no='$flat_no'";
	$query=mysql_query($res);
	if(mysql_num_rows($query)>0) return 1;
	else return NULL;
}
function db_fetch_array($table,$condition)
{
	$res="select * from $table where $condition limit 1";
	$query=mysql_query($res);
	if(mysql_num_rows($query)>0) return mysql_fetch_array($query);
	else return NULL;
}

function get_vars ($fields) 
{
	$vars = array();

	foreach($fields as $field_name) {
		if (isset($_POST[$field_name])) {
			$vars[$field_name] = $_POST[$field_name];
		}
	}
	return $vars;
}

function get_value ($fields) 
{
	$vars = array();

	foreach($fields as $field_name) {
	var_dump($field_name);
	}
	return $vars;
}

function reduncancy_check($table,$field,$value)
{
	$sql="select 1 from $table where $field='$value' limit 1";
	$query=mysql_query($sql);
	return mysql_num_rows($query);
}
function reduncancy_check2($table,$con)
{
	$sql="select 1 from $table $con limit 1";
	$query=mysql_query($sql);
	return mysql_num_rows($query);
}
function db_insert($table, $vars) 
{
	foreach ($vars as $field => $value) {
		$fields[] = $field;
		if ($value != 'NOW()') {
			$values[] = "'" . addslashes($value) . "'";
		} else {
			$values[] = $value;
		}
	}

	$fieldList = implode(", ", $fields);
	$valueList = implode(", ", $values);
	$sql="insert into $table ($fieldList) values ($valueList)";
	$id=mysql_query($sql);
	return $id;
}

function db_update($table, $id, $vars, $tag='') 
{
	foreach ($vars as $field => $value) {
		$sets[] = "$field = '" . addslashes($value) . "'";
	}

	$setList = implode(", ", $sets);

	if($tag=='')
		$sql = "update $table set $setList where id= $id";
	else
		$sql = "update $table set $setList where $tag= $id";
//echo $sql;
	db_execute($sql);
}

function db_delete($table,$condition) 
{	
	echo $sql = "delete from $table where $condition limit 1";
	return mysql_query($sql);
}

function paging($per_pg)
{
	echo '<div id="pageNavPosition"></div><script type="text/javascript"><!--
		var pager = new Pager("grp",'.$per_pg.');
		pager.init();
		pager.showPageNav("pager", "pageNavPosition");
		pager.showPage(1);
	//--></script>
	<script type="text/javascript">
		document.onkeypress=function(e){
		var e=window.event || e
		var keyunicode=e.charCode || e.keyCode
		if (keyunicode==13)
		{
			return false;
		}
	}
	</script>';
}

function db_last_insert_id($table,$field) {
	$sql = "select MAX($field)+1 from $table";
	if($result = mysql_query($sql)){
	$data = mysql_fetch_row($result);
	if($data[0]<1)
	return 1;
	else
	return $data[0];
	}
	else return 1;
}

	function find_a_field($table,$field,$condition)
	{
	$sql="select $field from $table where $condition limit 1";
	$res=mysql_query($sql);
	if(mysql_num_rows($res)>0)
	{
	$data=mysql_fetch_row($res);
	return $data[0];
	}
	else
	return NULL;
	}

function foreign_relation($table,$id,$show,$value,$condition=''){
if($condition=='')
$sql="select $id,$show from $table";
else
$sql="select $id,$show from $table where $condition";

$res=mysql_query($sql);
echo '<option></option>';
while($data=mysql_fetch_row($res))
{
if($value==$data[0])
echo '<option value="'.$data[0].'" selected>'.$data[1].'</option>';
else
echo '<option value="'.$data[0].'">'.$data[1].'</option>';
}
}

function join_relation($sql,$value=''){
$res=mysql_query($sql);
echo '<option></option>';
while($data=mysql_fetch_row($res))
{
if($value==$data[0])
echo '<option value="'.$data[0].'" selected>'.$data[1].'</option>';
else
echo '<option value="'.$data[0].'">'.$data[1].'</option>';
}
}


function link_report($sql,$link=''){

	if($sql==NULL) return NULL;

		$str.='
		<table id="grp" cellspacing="0" cellpadding="0" width="100%">';
		$str .='<tr>';
		$res=mysql_query($sql);
		$cols = mysql_num_fields($res);
		for($i=1;$i<$cols;$i++)
			{
				$name = mysql_field_name($res,$i);
				$str .='<th>'.ucwords(str_replace('_', ' ',$name)).'</th>';
			}
		$str .='</tr>';
		$c=0;
		while($row=mysql_fetch_array($res))
			{ if($link!='') $link= ' onclick="custom('.$row[0].');"';
				$c++;
				if($c%2==0)	$class=' class="alt"'; else $class=''; 
				
				$str .='<tr'.$class.$link.'>';
				for($i=1;$i<$cols;$i++) {$str .='<td>'.$row[$i]."</td>";}
				$str .='</tr>';
			}
	$str .='</table>';
	return $str;

}
function ajax_report($sql,$url,$div){

	if($sql==NULL) return NULL;

		$str.='
		<table id="grp" cellspacing="0" cellpadding="0" width="100%">';
		$str .='<tr>';
		$res=mysql_query($sql);
		$cols = mysql_num_fields($res);
		for($i=1;$i<$cols;$i++)
			{
				$name = mysql_field_name($res,$i);
				$str .='<th>'.ucwords(str_replace('_', ' ',$name)).'</th>';
			}
		$str .='</tr>';
		$c=0;
		while($row=mysql_fetch_array($res))
			{
				$c++;
				if($c%2==0)	$class=' class="alt"'; else $class=''; 
				
				$str .='<tr'.$class.' onclick="getData(\''.$url.'\',\''.$div.'\','.$row[0].');">';
				for($i=1;$i<$cols;$i++) {$str .='<td>'.$row[$i]."</td>";}
				$str .='</tr>';
			}
	$str .='</table>';
	return $str;

}
function do_calander($field)
{
echo '<script type="text/javascript">
$(document).ready(function(){
	
	$(function() {
		$("'.$field.'").datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: "yy-mm-dd"
		});

	});

});</script>';
}
function add_user_activity_log($user_id,$module_id,$menu_id,$page_name,$detail,$user_level)
{
$time=date('Y-m-d h:i:s');
$sql="INSERT INTO `user_activity_log` ( `user_id`, `access_time`, `module_id`, `menu_id`, `page_name`, `access_detail`, `access_type`) VALUES ($user_id, '$time', $module_id, $menu_id,'$page_name','$detail',$user_level)";
mysql_query($sql);
return 1;
}


?>