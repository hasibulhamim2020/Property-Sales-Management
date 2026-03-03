<?php

session_start();
ob_start();
require "../../support/inc.all.php";

$title='Allotment Status';
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


<select name="proj_code" id="proj_code" onchange="getData2('../../common/section_option_mhafuz.php', 'bld', document.getElementById('proj_code').value,this.value);">
						<? if(isset($_REQUEST['proj_code'])) $proj_code=$_REQUEST['proj_code'];
						foreign_relation('tbl_project_info','proj_code','proj_name',$proj_code);?>
						</select>
                                  </div>

                                        <div>

<label for="email">Section Name :</label>
<span id="bld">
<select name="section_name" id="section_name">
<? if(isset($_REQUEST['section_name'])) $section_name=$_REQUEST['section_name'];
if(isset($_REQUEST['proj_code']))
foreign_relation('add_section','section_id','section_name',$section_name,'proj_id = "'.$proj_code.'"');
?>
</select>
</span>

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

if($_POST['submit']){

		$info = array();

		$code = array();

		$status = array();


$proj_code=$_POST['proj_code'];

$section_name=$_POST['section_name'];

$road_sql="select road_no,count(flat_no) as total_flat from tbl_flat_info where proj_code='$proj_code' 
and section_name='$section_name' 
group by road_no";

$road_query=mysql_query($road_sql);
if(mysql_num_rows($road_query)>0)

while($road_data=mysql_fetch_object($road_query))
{
 $road_no=$road_data->road_no;
 
echo '<tr>';
echo '<td  style="background:#595757; height:25px; color:white;" colspan="'.$road_data->total_flat.'">Floor No : ' .$road_no.'</td>';
echo '</tr>';
echo '<tr>';


$sql="select fid,party_code,build_code,flat_no,status 
from tbl_flat_info 
where road_no='$road_no' 
and proj_code='$proj_code' and section_name='$section_name'";

$query=mysql_query($sql);
if(mysql_num_rows($query)>0)
while($data=mysql_fetch_object($query))

{


if($data->status == 'Booked')
echo '<td class="purple"><a href = "party_info.php?fid='.$data->fid.'&party_code='.$data->party_code.'" title = "Party Information" rel = "gb_page_center[480, 320]">'.$data->flat_no.'</a></td>';

elseif($data->status == 'Reserve')
echo '<td class="yallow"><a href = "party_info.php?fid='.$data->fid.'&party_code='.$data->party_code.'" title = "Party Information" rel = "gb_page_center[480, 320]">'.$data->flat_no.'</a></td>';

elseif($data->status == 'Sold')
echo '<td class="red"><a href = "party_info.php?fid='.$data->fid.'&party_code='.$data->party_code.'" title = "Party Information" rel = "gb_page_center[480, 320]">'.$data->flat_no.'</a></td>';

else
echo '<td class="blue"><a href = "../setup/party_info.php?fid='.$data->fid.'&flat_no='.$data->flat_no.'&build_code='.$data->build_code.'" 
title = "Party Information" rel = "gb_page_center[800, 560]">'.$data->flat_no.'</a></td>';
}
echo '</tr>';
}


}

/*if($_POST['submit'])

{

		$info = array();

		$code = array();

		$status = array();



$proj_code=$_POST['proj_code'];

$section_name=$_POST['section_name'];

$sql="select fid,party_code,flat_no,status from tbl_flat_info where proj_code='$proj_code' and section_name='$section_name'";
/*echo $sql="select flat_no from tbl_flat_info where proj_code='$proj_code' and section_name='$section_name'";

$query=mysql_query($sql);

if(mysql_num_rows($query)>0)

while($data=mysql_fetch_row($query))

{

			echo $a=$data[2];

			echo $b=$data[1];

			$c=$data[3];

		    $code 	= array_merge($code,array($a=>$b));

			$status	= array_merge($status,array($a=>$c));

}


}


if($build_code>0){

if($_POST['submit'])

{

for ($j=24; $j>0; $j--) {		

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

$bar	='class="pink"';

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

}}*/

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