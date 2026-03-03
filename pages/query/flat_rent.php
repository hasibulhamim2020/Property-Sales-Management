<?php
session_start();
ob_start();
require "../../support/inc.all.php";
$title='Flat Rent Status';
if($_POST['submit'])
{
		$info = array();
		$code = array();
		$status = array();

$proj_code=$_POST['proj_code'];
$build_code=$_POST['build_code'];
$sql="select flat_no,party_code,status from tbl_flat_info where proj_code='$proj_code' and build_code='$build_code'";
$query=mysql_query($sql);
if(mysql_num_rows($query)>0)
while($data=mysql_fetch_row($query))
{
			$a=$data[0];
			$b=$data[1];
			$c=$data[2];
			$code 	= array_merge($code,array($a=>$b));
			$status	= array_merge($status,array($a=>$c));
}
//var_dump($code);
}
?>
<script type = "text/javascript">var GB_ROOT_DIR = "../../greybox/";</script>
<script type = "text/javascript" src = "../../greybox/AJS.js"></script>
<script type = "text/javascript" src = "../../greybox/AJS_fx.js"></script>
<script type = "text/javascript" src = "../../greybox/gb_scripts.js"></script>
<link href = "../../greybox/gb_styles.css" rel = "stylesheet" type = "text/css" media = "all"/>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>              <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                <tr>
                  <td><table width="50%" border="0" cellspacing="0" cellpadding="0" align="center">
                    <tr>
                      <td>
					  <div class="form-container_large">
					  <form id="form1" name="form1" method="post" action="">
					  <fieldset>
                                        <legend>Project Details</legend>
                                  <div>
                                          <label>Project : </label>
										  <select name="proj_code" id="proj_code">
                                    <? if(isset($_REQUEST['proj_code'])) $proj_code=$_REQUEST['proj_code'];
foreign_relation('tbl_project_info','proj_code','proj_name',$proj_code);?>
                                    </select>
                                  </div>
                                        <div>
                                          <label for="email">Category : </label>
										<select name="build_code" id="build_code">
										<? if(isset($_REQUEST['build_code'])&&isset($_REQUEST['proj_code'])) $build_code=$_REQUEST['build_code'];
										foreign_relation('tbl_building_info','bid','category',$build_code);?>
										</select>
                                        </div>
                                        <div class="buttonrow">
                                          <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                                            <tr>
                                              <td width="12%">&nbsp;</td>
                                              <td><input name="submit" type="submit" class="exit" id="submit" value="Show Status" /></td>
											  <td width="20%">&nbsp;</td>
                                            </tr>
                                          </table>
                                        </div>
					  </fieldset>
					  </form>
					  </div>					  </td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
					      </tr>
                    
                    </table>					</td>
                    </tr>
              </table></td></tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>              <table border="0" cellspacing="0" cellpadding="0" align="center">
                <tr>
                  <td><div class="table_flat">
                    <table cellspacing="0" cellpadding="0">
                      
                      <?
//if($build_code!=1)echo '<tr>';
if($build_code==1){
if($_POST['submit'])
{
for ($j=1; $j<=100; $j++) {		
echo '<tr>';
for ($i=65; $i<=91; $i++) {
$x = chr($i);
$show = $x.'-'.$j;
$booked		='class="purple"';
$free		='class="blue"';
$reserved	='class="yallow"';
$sold		='class="red"';

if(array_key_exists($show,$code))
{
	if($code[$show]>0)
	{
		if(search_flat_cost_status($proj_code,$build_code,$show))
		{
			$class	=$sold;
		}
		else
		{
			if($status[$show]=='Booked')
			$class=$booked;
			else
			$class=$reserved;
		}
	echo '<td '.$class.'><a href = "party_info.php?party_code='.$code[$show].'" title = "Party Information" rel = "gb_page_center[480, 320]">'.$show.'</a></td>';
	}
	else
	{
	$class=$free;
	echo '<td '.$class.'><a href = "../setup/party_info.php?flat_no='.$show.'&build_code='.$build_code.'&project_code='.$proj_code.'" title = "Party Information" rel = "gb_page_center[800, 560]">'.$show.'</a></td>';
	}
}
else echo '<td></td>';
}
echo '</tr>';
}//if($build_code!=1)echo '</tr>';
}}

//if($build_code!=1)echo '<tr>';
if($build_code!=1){
if($_POST['submit'])
{
for ($i=65; $i<=91; $i++) {
$x = chr($i);
echo '<tr>';

for ($j=1; $j<=1000; $j++) {		
$show = $x.'-'.$j;
$booked	='class="purple"';
$free	='class="blue"';
$reserved	='class="yallow"';
$sold	='class="red"';
//$sold='class="red"';
//$reserved='class="yallow"';

if(array_key_exists($show,$code))
{
	if($code[$show]>0)
	{
		if(search_flat_cost_status($proj_code,$build_code,$show))
		{
			$class	=$sold;
		}
		else
		{
			if($status[$show]=='Booked')
			$class=$booked;
			else
			$class=$reserved;
		}
	echo '<td '.$class.'><a href = "party_info.php?party_code='.$code[$show].'" title = "Party Information" rel = "gb_page_center[480, 320]">'.$show.'</a></td>';
	}
	else
	{
	$class=$free;
	echo '<td '.$class.'><a href = "../setup/party_info.php?flat_no='.$show.'&build_code='.$build_code.'&project_code='.$proj_code.'" title = "Party Information" rel = "gb_page_center[800, 560]">'.$show.'</a></td>';
	}
}
else echo '<td></td>';
if($j%10==0) echo '</tr><tr>';
}

}echo '</tr>';
}}
					?>            
                      </table>
                      </div></td>
                    </tr>
              </table></td></tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
<?
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout.php");
?>