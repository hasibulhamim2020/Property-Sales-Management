<?php
/////////////////////////////////////////////////////////////////
/////////////////////  COMMON FUNCTIONS  ////////////////////////
/////////////////////////////////////////////////////////////////
class crud {

		var $table_name;
		var $table_mail;
		var $fields = array();	
		var $fields_empty = array();
		var $fields_type = array();
		
		
function crud($table_name) 
{
		$this->table_name = $table_name;
		$sql="SHOW COLUMNS FROM ".$this->table_name;
		$query=mysql_query($sql);
		while($res=@mysql_fetch_row($query))
		{
			$name=$res[0];
			$type=$res[1];
			$this->fields_empty = array_merge($this->fields_empty,array($name=>''));
			$this->fields = array_merge($this->fields,array($name));
			$this->fields_type = array_merge($this->fields_type,array($name=>$type));
		}
}


function insert($tag='',$id='')
{			
			$vars = get_vars($this->fields);
			//var_dump($vars);
			if ( count($vars) > 0 )
			$id=db_insert($this->table_name,$vars);
			return $id;	
}
function update($tag)
{
$vars = get_vars($this->fields);

if ( count($vars) > 0 )
db_update($this->table_name,$_POST[$tag],$vars,$tag);

return $id;	

}

function delete($condition) 
{	
	$sql = "delete from $this->table_name where $condition limit 1";
	return mysql_query($sql);
}

function link_report($sql,$link=''){
	if($sql==NULL) return NULL;
		$str.='
		<table  class="oe_list_content">';
		$str .='<thead><tr class="oe_list_header_columns">';
		if($res=mysql_query($sql)){
		$cols = mysql_num_fields($res);
		for($i=1;$i<$cols;$i++)
			{
				$name = mysql_field_name($res,$i);
				$str .='<th>'.ucwords(str_replace('_', ' ',$name)).'</th>';
			}
		$str .='</tr></thead>';
		
		$str .='<tfoot><tr>';
		for($i=1;$i<$cols;$i++)
			{
				$str .='<td></td>';
			}
		$str .='</tr></tfoot>';
		
		$c=0;
		if(mysql_num_rows($res)>0){
		while($row=mysql_fetch_array($res))
			{
				$c++;
				if($c%2==0)	$class=' class="alt"'; else $class=''; 
				
				$str .='<tr'.$class.' onclick="DoNav('.$row[0].')">';
				for($i=1;$i<$cols;$i++) {$str .='<td>'.$row[$i]."</td>";}
				$str .='</tr>';
			}}}
	$str .='</table>';
	return $str;

}

	}
?>