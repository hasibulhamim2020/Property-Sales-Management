<?
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
 $_SESSION['execution_no'] = $_SESSION['user']['id'].'0000'.time();
 $tr_from="Sales";

$c_id = $_SESSION['proj_id'];
date_default_timezone_set('Asia/Dhaka');
//echo $_REQUEST['report'];
if(isset($_REQUEST['submit'])&&isset($_REQUEST['report'])&&$_REQUEST['report']>0)
{

//print_r($_REQUEST);
//die();

if($_POST['proj_code']>0){
$proj_code=$_POST['proj_code']; if($_POST['fid']!='') $fid=$_POST['fid'];
elseif
($_POST['flat']!='') $fid=$_POST['flat'];
}

if((strlen($_POST['t_date'])==10)&&(strlen($_POST['f_date'])==10)){
$t_date=$_POST['t_date'];
$f_date=$_POST['f_date'];
}

if($_POST['party_code']>0) $party_code=$_POST['party_code'];


switch ($_POST['report']) {

case 1:

$report="Project Summary Statement (Sold & Unsold)";
if(isset($proj_code)) 
if(!isset($fid))
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and a.proj_code='.$proj_code;}
/*$sql="SELECT a.proj_code,x.proj_name,
(select count(b.fid) from `tbl_flat_info` b where a.proj_code=b.proj_code) as total_Plot,
(select count(c.fid) from `tbl_flat_info` c where a.proj_code=c.proj_code and (status='Booked' )) as sold_Plot, 
(select count(c.fid) from `tbl_flat_info` c where a.proj_code=c.proj_code and (status!='booked' or status is NULL)) as unsold_plot, 
(select sum(d.flat_size) from `tbl_flat_info` d where a.proj_code=d.proj_code and status='booked') as sold_katha,
(select sum(d.flat_size) from `tbl_flat_info` d where a.proj_code=d.proj_code and (status!='booked' or status is NULL)) as unsold_kata,
(select format(avg(sqft_price),2) from `tbl_flat_info` d where a.proj_code=d.proj_code limit 1) as present_rate,
(select sum(inst_amount) from tbl_flat_cost_installment e where a.proj_code=e.proj_code) as so_far_sale_value,
(select sum(rcv_amount) from tbl_flat_cost_installment e where a.proj_code=e.proj_code) as so_far_receive_value,
(select sum(inst_amount)-sum(rcv_amount) from tbl_flat_cost_installment e where a.proj_code=e.proj_code) as balance_amount,
(select sum(d.total_price) from `tbl_flat_info` d where a.proj_code=d.proj_code and (status!='booked' or status is NULL)) as unsold_value,
sum(total_price) as total_sales_value
FROM tbl_flat_info a,tbl_project_info x
where a.proj_code=x.proj_code ".$proj_con."
group by a.proj_code";
break;*/


$sql1='select a.proj_code,b.proj_name,sum(a.flat_size) as flat_size from tbl_flat_info a, tbl_project_info b where  1 and a.proj_code=b.proj_code and a.status!="" group by a.proj_code order by a.proj_code';

echo '<table width="100%" border="0" cellpadding="2" cellspacing="0">

<thead><tr><td colspan="6" style="border:0px;"><div class="header"><h1>Sajeeb Homes Ltd.</h1><h2>Project Summary Statement (Sold &amp; Unsold)</h2></div></td></tr></thead>

<tr><th>S/L</th><th>Proj Code</th><th>Proj Name</th><th>Total Katha</th><th>Sold Katha</th><th>Unsold Katha</th></tr>


<tbody>';


$query = db_query($sql1);

$sl=0;

while($row = mysqli_fetch_object($query)){

echo '<tr><td>'.++$sl.'</td>';
echo  '<td>'.$row->proj_code.'</td>';
echo '<td>'.$row->proj_name.'</td>';
echo  '<td style="text-align:right">';


if($row->proj_code==2){


echo $tot_katha = 20000;


}


else if($row->proj_code==3){


echo $tot_katha = 30000;


}


else if($row->proj_code==4){


echo $tot_katha = 40000;


}


else if($row->proj_code==5){


echo $tot_katha = 50000;


}


echo '</td>';


echo '<td style="text-align:right">'.$row->flat_size.'</td>';


echo '<td style="text-align:right">'.$unsold_katha=($tot_katha-$row->flat_size).'</td></tr>';


$g_tot_katha +=$tot_katha;


$g_sold_katha +=$row->flat_size;


$g_unsold_katha +=$unsold_katha;


}


echo '<tr style="font-weight: bold;"><td colspan="3"  style="text-align:right">Total :</td><td style="text-align:right">'.$g_tot_katha.'</td><td style="text-align:right">'.$g_sold_katha.'</td><td>'.$g_unsold_katha.'</td></tr>';


echo '</tbody></table>';


break;


case 21:
$report="Product Statement";
break;


case 2:


$report="Plot Booking Statement";


if(isset($proj_code)) 


if(!isset($fid))


{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and a.proj_code='.$proj_code;}


else


{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); 


$allotment_no=$fid; $flat_show=',a.flat_no as Plot_no'; $flat_con=' and a.proj_code='.$proj_code.' and a.fid=\''.$fid.'\' ';}


if(isset($party_code))


{$client_name=find_a_field('tbl_party_info','party_name','party_code='.$party_code); $party_con=' and c.party_code='.$party_code;}


if(isset($t_date)) 


{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.booked_on between \''.$fr_date.'\' and \''.$to_date.'\'';}


if($_POST['section_name']!=''){$section_con = ' and s.section_id="'.$_POST['section_name'].'"';};


$sql="SELECT c.party_code as customer_id, c.party_name as Customer_name, b.proj_name as project_name,(select section_name from add_section where section_id=a.section_name) as section_name, road_no as floor, a.flat_no as allotment, a.flat_size as allotment_Size, a.booked_on, a.total_price,a.sr_status as status 

FROM `tbl_flat_info` a,tbl_project_info b,tbl_party_info c, add_section s 

WHERE a.section_name=s.section_id and a.proj_code=b.proj_code and a.party_code=c.party_code ".$proj_con.$date_con.$flat_con.$party_con.$section_con.$flat_con;


break;


case 113:


$report="Plot Agreement Statement";


if(isset($proj_code)) 


if(!isset($fid))


{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and a.proj_code='.$proj_code;}


else


{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); 


$allotment_no=$fid; $flat_show=',a.flat_no as Plot_no'; $flat_con=' and a.proj_code='.$proj_code.' and a.fid=\''.$fid.'\' ';}


if(isset($party_code))


{$client_name=find_a_field('tbl_party_info','party_name','party_code='.$party_code); $party_con=' and a.party_code='.$party_code;}


if(isset($t_date)) 


{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.inst_date between \''.$fr_date.'\' and \''.$to_date.'\'';}


if($_POST['section_name']!=''){$section_con = ' and a.section_name="'.$_POST['section_name'].'"';};


$sql="select  d.party_name as customer_name ,d.party_code, c.proj_name,b.section_name,e.road_no as floor,a.flat_no as allotment,sum(a.inst_amount) as total_payable,sum(a.rcv_amount) as total_received, concat((sum(a.rcv_amount)/((sum(a.inst_amount)/100)*1)),'%') as Percentage  

from tbl_flat_cost_installment a, add_section b, tbl_project_info c, tbl_party_info d, tbl_flat_info e 

where  1 and e.sr_status='AGREEMENT'  and a.fid=e.fid   and a.section_name=b.section_id and a.proj_code=c.proj_code and a.party_code=d.party_code  ".$proj_con.$date_con.$flat_con.$party_con.$section_con.$flat_con." group by a.fid ";


break;


case 114:


$report="Plot Registered Statement";


if(isset($proj_code)) 


if(!isset($fid))


{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and a.proj_code='.$proj_code;}


else


{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); 


$allotment_no=$fid; $flat_show=',a.flat_no as Plot_no'; $flat_con=' and a.proj_code='.$proj_code.' and a.fid=\''.$fid.'\' ';}


if(isset($party_code))


{$client_name=find_a_field('tbl_party_info','party_name','party_code='.$party_code); $party_con=' and c.party_code='.$party_code;}


if(isset($t_date)) 


{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.booked_on between \''.$fr_date.'\' and \''.$to_date.'\'';}


if($_POST['section_name']!=''){$section_con = ' and s.section_id="'.$_POST['section_name'].'"';};


$sql="SELECT c.party_name as Customer_name,c.party_code as customer_id,b.proj_name,(select section_name from add_section where section_id=a.section_name) as section_name,road_no as floor ,a.flat_no as allotment,a.flat_size as allotment_Size,a.total_price 

FROM `tbl_flat_info` a,tbl_project_info b,tbl_party_info c, add_section s 

WHERE a.sr_status='SOLD' and a.section_name=s.section_id and a.proj_code=b.proj_code and a.party_code=c.party_code ".$proj_con.$date_con.$flat_con.$party_con.$section_con.$flat_con;


break;


case 115:


$report="Valuable Client Report (By Value)";


if(isset($proj_code)) 


if(!isset($fid))


{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and a.proj_code='.$proj_code;}


else


{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); 


$allotment_no=$fid; $flat_show=',a.flat_no as Plot_no'; $flat_con=' and a.proj_code='.$proj_code.' and a.fid=\''.$fid.'\' ';}


if(isset($party_code))


{$client_name=find_a_field('tbl_party_info','party_name','party_code='.$party_code); $party_con=' and a.party_code='.$party_code;}


if(isset($t_date)) 


{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.inst_date between \''.$fr_date.'\' and \''.$to_date.'\'';}


if($_POST['section_name']!=''){$section_con = ' and a.section_name="'.$_POST['section_name'].'"';};


echo '<h2 style="text-align: center; font-size: 20px; margin-bottom: 50px;"> Valuable Client Report (By Value)<h2>';


echo '<table width="100%" border="0" cellpadding="2" cellspacing="0">


<tr><th>S/L</th><th>Party Code</th><th>Party Name</th><th>Mobile Number</th><th>Amount 50 lac to 1 core Name</th><th>Amount 1 core to 1.5 core </th><th>Amount 1.5 crore +</th></tr>';


$select = "select a.party_code, a.party_name, a.ah_mobile_tel,sum(b.inst_amount) as total_amt from tbl_party_info a,  tbl_flat_cost_installment b where b.party_code=a.party_code group by b.party_code  having sum(b.inst_amount)>5000000 order by a.party_code";


$qq = db_query($select);


$sl = 0;


while($row = mysqli_fetch_object($qq)){


echo '<tr>';


echo '<td>'.++$sl.'</td>';


echo '<td>'.$row->party_code.'</td>';


echo '<td>'.$row->party_name.'</td>';


echo '<td>'.$row->ah_mobile_tel.'</td>';


echo '<td>';


if(5000000 <= $row->total_amt && $row->total_amt <= 10000000){ echo number_format($row->total_amt,2) ;}


echo '</td>'; 


echo '<td>';


if(10000000 <= $row->total_amt && $row->total_amt <= 15000000){ echo number_format($row->total_amt,2) ;}


echo '</td>'; 


echo '<td>';


if(15000000 <= $row->total_amt ){ echo number_format($row->total_amt,2) ;}


echo '</td>'; 


echo '</tr>';


}


echo '</table>';


break;


case 116:


$report="Valuable Client Report (By Plot)";


if(isset($proj_code)) 


if(!isset($fid))


{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and a.proj_code='.$proj_code;}


else


{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); 


$allotment_no=$fid; $flat_show=',a.flat_no as Plot_no'; $flat_con=' and a.proj_code='.$proj_code.' and a.fid=\''.$fid.'\' ';}


if(isset($party_code))


{$client_name=find_a_field('tbl_party_info','party_name','party_code='.$party_code); $party_con=' and a.party_code='.$party_code;}


if(isset($t_date)) 


{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.booked_on between \''.$fr_date.'\' and \''.$to_date.'\'';}


if($_POST['section_name']!=''){$section_con = ' and a.section_name="'.$_POST['section_name'].'"';};


$sql="select b.party_name,b.party_code,b.ah_mobile_tel as mobile_no,(count(a.flat_no)) as total_plot from tbl_flat_info a, tbl_party_info b where 1 and a.party_code=b.party_code  ".$proj_con.$date_con.$flat_con.$party_con.$section_con.$flat_con." group by a.party_code having (count(a.flat_no))>1 ORDER BY total_plot desc";


break;


case 117:


$report="Brake Down Plot Report";


if(isset($proj_code)) 


if(!isset($fid))


{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and a.proj_code='.$proj_code;}


else


{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); 


$allotment_no=$fid; $flat_show=',a.flat_no as Plot_no'; $flat_con=' and a.proj_code='.$proj_code.' and a.fid=\''.$fid.'\' ';}


if(isset($party_code))


{$client_name=find_a_field('tbl_party_info','party_name','party_code='.$party_code); $party_con=' and a.party_code='.$party_code;}


if(isset($t_date)) 


{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.entry_at between \''.$fr_date.'\' and \''.$to_date.'\'';}


if($_POST['section_name']!=''){$section_con = ' and a.section_name="'.$_POST['section_name'].'"';};


$sql="select b.proj_name, c.section_name,a.road_no, a.flat_no as plot_no,a.flat_size as plot_size  from tbl_flat_info a, tbl_project_info b, add_section c where 1 and a.section_name=c.section_id and a.proj_code=b.proj_code and a.flat_no like  '%#%'   ".$proj_con.$date_con.$flat_con.$party_con.$section_con.$flat_con." order by a.flat_no ";


break;


case 3:
$report="Allotment Status & Price Configaration";

if(isset($proj_code)) 

if(!isset($fid))

{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and a.proj_code='.$proj_code;}
else
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); 
$allotment_no=$fid; $flat_show=',a.flat_no as Plot_no'; $flat_con=' and a.proj_code='.$proj_code.' and a.fid=\''.$fid.'\' ';}

if(isset($t_date)) 
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.booked_on between \''.$fr_date.'\' and \''.$to_date.'\'';}
if($_POST['section_name']!=''){$section_con = ' and s.section_id="'.$_POST['section_name'].'"';};


$sql="SELECT 
a.fid as allotment_id,a.booked_on,
p.party_name as client_name, 
p.party_code as client_code,
b.proj_name as project_name,
a.road_no as floor_no, 
a.flat_no as allotment,
a.flat_size as allotment_size,
a.sqft_price as per_sft_price,
a.unit_price as total_price,
a.utility_price,
a.park_price as parking_price,
a.discount,
(a.unit_price+a.utility_price+a.park_price-a.discount) as grand_total,
(select sum(rcv_amount) from tbl_flat_cost_installment where fid=a.fid group by fid) as receive_amount,
((a.unit_price+a.utility_price+a.park_price-a.discount)-(select sum(rcv_amount) from tbl_flat_cost_installment where fid=a.fid group by fid)) as pending_amount 

FROM tbl_flat_info a,tbl_project_info b,tbl_party_info p,add_section s 

WHERE a.section_name=s.section_id and a.party_code=p.party_code 
and a.proj_code=b.proj_code 
and a.status!='' ".$proj_con.$date_con.$flat_con.$section_con." 
order by p.party_code";

break;



case 55:
$report="All Plot List";

if(isset($proj_code)) 
if(!isset($fid))

{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and a.proj_code='.$proj_code;}
else
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); 
$allotment_no=$fid; $flat_show=',a.flat_no as Plot_no'; $flat_con=' and a.proj_code='.$proj_code.' and a.fid=\''.$fid.'\' ';}

if(isset($t_date)) 
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.booked_on between \''.$fr_date.'\' and \''.$to_date.'\'';}
if($_POST['section_name']!=''){$section_con = ' and s.section_id="'.$_POST['section_name'].'"';};

$sql="SELECT 
a.fid as allotment_id,a.status,a.booked_on,
b.proj_name as project_name,
a.road_no as floor_no, 
a.flat_no as allotment,
a.flat_size as allotment_size,
a.sqft_price as per_sft_price,
a.unit_price as total_price,
a.utility_price,
a.park_price as parking_price,
a.discount,
(a.unit_price+a.utility_price+a.park_price-a.discount) as grand_total

FROM tbl_flat_info a,tbl_project_info b,add_section s 

WHERE a.section_name=s.section_id
and a.proj_code=b.proj_code 
".$proj_con.$date_con.$flat_con.$section_con." 
order by a.fid";

break;




case 3333:


echo "<h1 style='text-align: center; margin-bottom: 50px; margin-top: 20px;'>Cancel Alottment Report</h1>";

if(isset($proj_code)) 

if(!isset($fid))
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and a.proj_code='.$proj_code;}
else
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); 

$allotment_no=$fid; $flat_show=',a.flat_no as Plot_no'; $flat_con=' and a.proj_code='.$proj_code.' and a.fid=\''.$fid.'\' ';}

if(isset($t_date)) 
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.booked_on between \''.$fr_date.'\' and \''.$to_date.'\'';}

?>
<table border="0" cellpadding="2" cellspacing="0" width="100%" >
<thead>
<th>S/L-3333</th>
<th>Date</th>
<th>Allotment Id</th>
<th>Party Code</th>
<th>Party Name</th>
<th>Project Name</th>
<th>Section Name</th>
<th>Floor</th>
<th>Allotment</th>
<th>Allotment Size</th>
<th>Total Price</th>
<th>Received Amount</th>
<th>Refund Amount</th>
<th>Saller  Name</th>
</thead>
<tbody>
<? 
$sl=0;
$sqll='SELECT a.* from tbl_flat_cancel_allotment a,tbl_party_info b where 1 and a.party_code=b.party_code and reason="Cancel Plot" ';
$query = db_query($sqll);
while($row = mysqli_fetch_object($query)){
?>
<tr>
<td><?=++$sl?></td>
<td><?=$row->entry_date?></td>
<td><?=$row->fid?></td>
<td><?=$row->party_code?></td>
<td><?=find_a_field('tbl_party_info','party_name','party_code='.$row->party_code)?></td>
<td><?=find_a_field('tbl_project_info','proj_name','proj_code='.$row->proj_code)?></td>
<td><?=find_a_field('add_section','section_name','section_id='.$row->section_name)?></td>
<td><?=$row->road_no?></td>
<td><?=$row->flat_no?></td>
<td><?=$row->flat_size?></td>
<td><?=$row->total_price?></td>
<td><?=$row->rcv_amount?></td>
<td><?=$row->refund_amount?></td>
<td>
<?

$se = 'select sr_executive,	team_leader,group_leader from tbl_party_info where party_code='.$row->party_code;
$qu = mysqli_fetch_object(db_query($se));


if($qu->sr_executive!=''){

echo find_a_field('personnel_basic_info','PBI_NAME','PBI_ID='.$qu->sr_executive);

}elseif($qu->team_leader!=''){

echo find_a_field('personnel_basic_info','PBI_NAME','PBI_ID='.$qu->team_leader);

}elseif($qu->group_leader!=''){

echo find_a_field('personnel_basic_info','PBI_NAME','PBI_ID='.$qu->group_leader);

}else{

echo "Sajeeb Homes Ltd.";

}


?>

</td>

</tr>
<? } ?>
</tbody>

<tfoot>

<tr></tr>

</tfoot>

</table>

<?
break;


case 4:
$report="Project Information";

break;


case 5:


if(isset($proj_code)) 


if(!isset($fid))


{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and a.proj_code='.$proj_code;}


else


{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); 


$allotment_no=$fid; $flat_show=',a.flat_no as Plot_no'; $flat_con=' and a.proj_code='.$proj_code.' and a.fid=\''.$fid.'\' ';}


if(isset($party_code))


{$client_name=find_a_field('tbl_party_info','party_name','party_code='.$party_code); $party_con=' and  party_code='.$party_code;}


if(isset($t_date)) 


{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.booked_on between \''.$fr_date.'\' and \''.$to_date.'\'';}


if($_POST['section_name']!=''){$section_con = ' and s.section_id="'.$_POST['section_name'].'"';};


if($_POST['party_code'] !='') {$party_con=' and  party_code='.$party_code;} ;


if($_POST['proj_code'] !='') {$proj_con=' and  proj_code='.$proj_code;} ;


$report="Client Detail Information";

$sql="SELECT `party_code`, `party_name`, `fname` as father_name, `mname` as mother_name, `birth_date`, `age`, `ah_mobile_tel` as mobile_no, `email_address`, `per_house`, `per_road`, `per_village`, `per_postoffice`, `per_district`, `per_country`, `pre_house`, `pre_road`, `pre_village`, `pre_postoffice`, `pre_district`, `pre_country`, `nominee`, `nrelation`,`n_country`, `n_mobile_tel`, `n_office_tel`, `nation`,`national_id_no`, `register_date`, `pre_police_station`,`sr_executive`, `team_leader`, `group_leader`, `others`, `payment_type` FROM `tbl_party_info` where 1 ".$party_con.$proj_con;


break;


case 6:
$report="Collection Statement(Total)";

if(isset($proj_code))			{$proj_con = " and b.proj_code='".$proj_code."'";};
if($_POST['flat']!='')			{$flat_con = " and a.fid='".$_POST['flat']."'";};
if($_POST['section_name']!='')	{$section_con = " and c.section_name='".$_POST['section_name']."'";};

//if($_POST['flat']!=''){$section_con = " and c.flat_no='".$_POST['flat']."'";};

if(isset($t_date)) 
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.rec_date between \''.$fr_date.'\' and \''.$to_date.'\'';}


$sql="select p.party_code as client_code,p.party_name as client_name, b.proj_name as project_name,a.flat_no as allotment,
a.rec_date receive_date,e.pay_code,e.inst_no as instalment_no,a.cheq_no,a.cheq_date,a.rec_no as MRN,a.manual_no as Manual_MRN,a.bank_name,e.rec_amount as total_amount,a.remarks 

from tbl_receipt a,tbl_project_info b, tbl_party_info p ,tbl_receipt_details e
where e.fid=a.fid and e.rec_no=a.rec_no
and p.party_code=a.party_code and b.proj_code=a.proj_code
".$proj_con.$date_con.$flat_con." 
group by e.rec_no,e.pay_code,e.inst_no
order by a.rec_date";


break;


case 7:
$report="Payment Statement";

if(isset($_POST['mr'])&&$_POST['mr']>0) {$mr_no=$_POST['mr']; $mr_con=' and a.rec_no='.$mr_no;}
if(isset($party_code)){$client_name=find_a_field('tbl_party_info','party_name','party_code='.$party_code); $party_con=' and d.party_code='.$party_code;}

if(isset($proj_code)) 
if(!isset($fid))
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and d.proj_code='.$proj_code;}
else
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); 
$allotment_no=$fid; $flat_show=',a.fid as allot_no'; $flat_con=' and d.proj_code='.$proj_code.' and d.fid=\''.$fid.'\' ';}

if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.rec_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
if($_POST['section_name']!=''){$section_con = ' and d.section_name="'.$_POST['section_name'].'"';}

$s="SELECT a.fid, a.`rec_date`,a.`rec_no` as m_r_no,a.`manual_no` as voucher_no,b.proj_name,road_no,a.flat_no as plot_no,(select section_name from add_section where section_id=d.section_name) as section_name,c.party_name,sum(a.`rec_amount`) as rec_amount,(select sum(rcv_amount) from tbl_flat_cost_installment where fid=a.fid group by fid) as flat_cost,a.`bank_name` as detail

FROM tbl_receipt a, tbl_party_info c,tbl_project_info b, tbl_flat_info d

WHERE b.proj_code=d.proj_code and d.fid=a.fid and a.party_code=c.party_code ".$proj_con.$date_con.$section_con.$flat_con.$party_con.$mr_con.' group by a.rec_no order by a.rec_no ';
$query = db_query($s);
?>
<center><h1>Sajeeb Homes</h1>
<h3><?=$report?></h3>
<? if (isset($_POST['t_date'])){ ?><h6>Date Interval : <?=$_POST['f_date']?> To <?=$_POST['t_date']?></h6><? } ?></center>


<table cellpadding="2" cellspacing="0" width="100%" border="1">
<tr style="border-top: 1px solid black;">
<td><strong>S/L</strong></td>
<td><strong>Allotment_no</strong></td>
<td><strong>Receive Date</strong></td>
<td><strong>MR No</strong></td>
<td><strong>Manual No</strong></td>
<td><strong>Client Name</strong></td>
<td><strong>Project Name</strong></td>
<td><strong>Floor No</strong></td>
<td><strong>Allotment</strong></td>
<td><strong>Section Name</strong></td>
<td><strong>Received Amount</strong></td>
<td><strong>Detail</strong></td></tr>
<?

$s = 1;

while($r = mysqli_fetch_object($query)){
if($r->detail==''){$b_type = 'Cash';}else{ $b_type = $r->detail; };

echo '<tr>
<td>'.$s++.'</td>
<td>'.$r->fid.'</td>
<td>'.$r->rec_date.'</td>
<td><a href="../../common/voucher_print_report.php?rec_no='.$r->m_r_no.'" target="_blank">'.$r->m_r_no.'</a></td>
<td>'.$r->voucher_no.'</td>
<td>'.$r->party_name.'</td>
<td>'.$r->proj_name.'</td>
<td>'.$r->road_no.'</td>
<td>'.$r->plot_no.'</td>
<td>'.$r->section_name.'</td>
<td>'.number_format($r->rec_amount).'</td>
<td>'.$b_type.'</td></tr>';

$tot_rec_amt += $r->rec_amount;
}
echo '<tr><td colspan="9"></td><td align="right"><b>Total : </b></td><td><b>'.number_format($tot_rec_amt).'</b></td><td></td></tr>
</table>';
break;




/*case 70_old:

$report="Monthly Sales Report";


if(isset($_POST['mr'])&&$_POST['mr']>0)


{$mr_no=$_POST['mr']; $mr_con=' and a.rec_no='.$mr_no;}


if(isset($party_code))


{$client_name=find_a_field('tbl_party_info','party_name','party_code='.$party_code); $party_con=' and d.party_code='.$party_code;}


if(isset($proj_code)) 


if(!isset($fid))


{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and d.proj_code='.$proj_code;}


else


{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); 


$allotment_no=$fid; $flat_show=',a.fid as allot_no'; $flat_con=' and d.proj_code='.$proj_code.' and d.fid=\''.$fid.'\' ';}


if(isset($t_date)) 


{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.rec_date between \''.$fr_date.'\' and \''.$to_date.'\'';}


if($_POST['section_name']!=''){$section_con = ' and b.section_name="'.$_POST['section_name'].'"';}


if($_POST['party_code']!=''){$party_con = ' and a.party_code="'.$_POST['party_code'].'" ';}


if($_POST['proj_code']!=''){$proj_con = ' and b.proj_code="'.$_POST['proj_code'].'" ';}


echo '<h3 style="text-align: center; font-size: 25px;">Sales Report</h3>';


if(isset($t_date)) {echo '<h3 style="text-align: center; margin-bottom: 50px;">Date Interval : '.$f_date.' and '.$t_date.' </h3>';}


echo '<table id="example"  width="100%" border="0" cellpadding="2" cellspacing="0"><thead>


<tr><th>S/L-70</th>
<th>Client Code</th>
<th>Client Name</th>
<th>Project Name</th>
<th>Section Name</th>
<th>Floor No</th>
<th>Allotment</th>
<th>Allotment Size</th>
<th>Total Price</th>
<th>Received Amount</th>
<th>Pending Amount</th>
</tr></thead><tbody>';


$sql1 = "select a.fid from tbl_receipt a, tbl_flat_info b where 1 and a.fid=b.fid ".$proj_con.$section_con." group by a.fid order by a.fid";

$sl = 0;

$query = db_query($sql1);

while($row=mysqli_fetch_object($query)){

$select = "select * from tbl_receipt where fid='".$row->fid."' order by rec_date limit 1";

$q2 = db_query($select);

while($row2 = mysqli_fetch_object($q2)){

if($fr_date==''){ $fr_date ='2001-01-01'; }

if($to_date==''){ $to_date ='2099-01-01'; }

if($fr_date<=$row2->rec_date && $row2->rec_date<=$to_date){

echo '<tr><td>'.++$sl.'</td><td>'.$row2->party_code.'</td><td>';

$se = "select party_name from tbl_party_info where party_code=".$row2->party_code;


$rr=mysqli_fetch_object(db_query($se));


echo $rr->party_name;


echo '</td><td>';


$se = "select a.proj_name from tbl_project_info a,tbl_flat_info b where a.proj_code=b.proj_code  and b.fid=".$row2->fid;


$rr=mysqli_fetch_object(db_query($se));


echo $rr->proj_name;


echo '</td><td>';


$seee = "select b.section_name  from tbl_flat_info a,add_section b where a.section_name=b.section_id and a.fid=".$row2->fid." ";


$rrrr=mysqli_fetch_object(db_query($seee));


echo $rrrr->section_name;


echo '</td><td>';


$se = "select b.road_no from tbl_flat_info b where  b.fid=".$row2->fid;


$rr=mysqli_fetch_object(db_query($se));


echo $rr->road_no;


echo '</td><td>';


$seee = "select flat_no  from tbl_flat_info where fid=".$row2->fid." ";


$rrrr=mysqli_fetch_object(db_query($seee));


echo $rrrr->flat_no;


echo '</td><td>';


$seee = "select flat_size  from tbl_flat_info where fid=".$row2->fid." ";


$rrrr=mysqli_fetch_object(db_query($seee));


echo $rrrr->flat_size;


echo '</td><td>';


$see = "select sum(total_price) as tot_amt from tbl_flat_info where fid=".$row2->fid." ";


$rrr=mysqli_fetch_object(db_query($see));


echo number_format($rrr->tot_amt, 2);


echo '</td><td>';


$se = "select sum(rec_amount) as rec_Amount from tbl_receipt where rec_date between '".$fr_date."' and '".$to_date."' and fid=".$row2->fid." ";


$rr=mysqli_fetch_object(db_query($se));


echo number_format($rr->rec_Amount, 2);

$pending_amount =($rrr->tot_amt-$rr->rec_Amount);
echo '</td><td>'.number_format($pending_amount, 2) .'</td></tr>';


$tot_rec_amt += $rr->rec_Amount;;


$tot_f_size +=$rrrr->flat_size;


$tot_amtt += $rrr->tot_amt;


$tot_p_amt +=$pending_amount;


}


}


}


echo '</tbody><tfoot><tr style="font-weight: bold;"><td colspan="7">Total :</td><td>'.number_format($tot_f_size,2).'</td><td>'.number_format($tot_amtt,2).'</td><td>'.number_format($tot_rec_amt,2).'</td><td>'.number_format($tot_p_amt,2).'</td></tr></tfoot>';


echo '</table>';


echo $tot;

?>




<?
break;*/


case 700:


$report="Sales Summary Report";


if($_POST['f_date']!='' && $_POST['t_date']!=''){


$report.= '<h1 style="text-align: center; font-size: 15px;">Date Interval : '.$_POST['f_date'].' To '.$_POST['t_date'].'</h1>';


}


if($_POST['proj_code']!=''){ $proj_con = ' and b.proj_code= "'.$_POST['proj_code'].'" ';}


if($_POST['section_name']!=''){ $section_con = ' and b.section_name= "'.$_POST['section_name'].'" ';}


if(isset($t_date)) 


{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.rcv_date between \''.$fr_date.'\' and \''.$to_date.'\'';}


if(isset($t_date)) 


{$to_date=$t_date; $fr_date=$f_date; $date_conn=' and b.booked_on between \''.$fr_date.'\' and \''.$to_date.'\'';}


$sql1 = "select fid from tbl_receipt where 1 group by fid order by fid";


$query = db_query($sql1);


while($row=mysqli_fetch_object($query)){


echo $select = "select a.fid, a.rec_date,(select total_price from tbl_flat_info where fid=a.fid) as total_price,sum(a.rec_amount) as rec_amount from tbl_receipt a where 1 ".$date_con." and a.fid='".$row->fid."' order by a.rec_date limit 1";


$q2 = db_query($select);


while($row2 = mysqli_fetch_object($q2)){


echo '<br><br>'.$row2->fid.' - '.$row2->total_price.' - '.$row2->rec_date."<br>";


$tot +=$row2->rec_amount;


}


}


echo $tot;


break;


case 11:

$report="Outstanding Report";

break;


case 12:
if(isset($t_date)) 
if(isset($proj_code)) 
if(!isset($fid))
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and a.proj_code='.$proj_code;}
else{
$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); 
$allotment_no=$fid; $flat_show=',a.flat_no as Plot_no'; $flat_con=' and a.proj_code='.$proj_code.' and a.fid=\''.$fid.'\' ';}

if(isset($party_code))
{$client_name=find_a_field('tbl_party_info','party_name','party_code='.$party_code); $party_con=' and b.party_code='.$party_code;}

if(isset($t_date)) 
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.inst_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

if($_POST['section_name']!=''){$section_con = ' and s.section_id="'.$_POST['section_name'].'"';};

$sql1="select b.party_name as client_name, c.proj_name as project_name,b.sr_executive,b.team_leader,b.group_leader,b.others, (select section_name from add_section where section_id=a.section_name) as section_name, road_no as floor, a.flat_no as product, a.inst_date as installment_date,a.inst_amount as payable_amt, a.rcv_amount as received_amt, (inst_amount-a.rcv_amount) as pending_amount

from tbl_flat_cost_installment a,add_section s, tbl_party_info b, tbl_project_info c,tbl_flat_info d 
where a.section_name=s.section_id and a.proj_code=c.proj_code and a.party_code=b.party_code and a.proj_code=d.proj_code and a.fid=d.fid ".$proj_con.$date_con.$section_con.$flat_con.$party_con." order by a.inst_date";

echo '<table width="100%" border="0" cellpadding="2" cellspacing="0"><thead><tr><td colspan="10" style="border:0px;"><div class="header">
<h4>Sajeeb Homes Ltd.</h4><h5>Expected Collection</h5><h6>Period: '.$fr_date.' to '.$to_date.'</h6></div>
<div class="left"></div><div class="right"></div><div class="date">Reporting Time: 03:52 PM 12-11-2018</div></td></tr>
<tr><th>S/L</th>
<th>Client Name</th>
<th>Project Name</th>
<th>Floor No</th>
<th>Allotment</th>
<th>Installment Date</th>
<th>Payable Amount</th>
<th>Received Amount</th>
<th>Pending Amount</th>
</tr></thead>';

$query = db_query($sql1);

$sl=0;

while($row=mysqli_fetch_object($query)){

echo '<tr><td>'.++$sl.'</td><td>'.$row->client_name.'</td>';

echo '<td>'.$row->project_name.'</td><td>'.$row->floor.'</td><td>'.$row->product.'</td>
<td>'.$row->installment_date.'</td><td style="text-align:right">'.number_format($row->payable_amt).'</td>
<td style="text-align:right">'.number_format($row->received_amt).'</td>';

echo '<td>'.number_format($row->pending_amount).'</td>';

echo '</tr>';

$tot_p_amt +=$row->payable_amt;
$tot_r_Amt +=$row->received_amt;
$tot_g_pending_Amt += $row->pending_amount;

}

echo '<tr style="font-weight: bold; text-align: right;"><td colspan="6">Total</td><td style="text-align:right">'.number_format($tot_p_amt).'</td><td style="text-align:right">'.number_format($tot_r_Amt).'</td><td style="text-align:right">'.number_format($tot_g_pending_Amt).'</td></tr>';

echo '</table>';


break;


case 13:
$report="Payment Schedule";

break;





case 14:


$report="Party Rent Agreement Terms";
if(isset($party_code))
{$client_name=find_a_field('tbl_party_info','party_name','party_code='.$party_code); $party_con=' and a.party_code='.$party_code;}
if(isset($proj_code)) 
if(!isset($fid))
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and a.proj_code='.$proj_code;}

else

{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); 
$allotment_no=$fid; $flat_show=',a.fid as allot_no'; $flat_con=' and a.proj_code='.$proj_code.' and a.fid=\''.$fid.'\' ';}

$sql="SELECT b.`proj_name`,a.`fid`,c.`party_name`,a.`monthly_rent`,a.`effective_date`,a.`expire_date`,a.`notice_period`,a.discontinue_term,a.`witness1`,a.`witness1_address` FROM `tbl_rent_info` a,tbl_party_info c,tbl_project_info b WHERE a.party_code=c.party_code and a.proj_code=b.proj_code ".$proj_con.$flat_con.$party_con;


break;


case 15:


$report="Party Rent Payment Terms";


if(isset($party_code))


{$client_name=find_a_field('tbl_party_info','party_name','party_code='.$party_code); $party_con=' and a.party_code='.$party_code;}


if(isset($proj_code)) 


if(!isset($fid))


{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and a.proj_code='.$proj_code;}


else


{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); 


$allotment_no=$fid; $flat_show=',a.fid as allot_no'; $flat_con=' and a.proj_code='.$proj_code.' and a.fid=\''.$fid.'\' ';}


$sql="SELECT b.`proj_name`,a.`fid`,c.`party_name`,a.`security_money`,a.`monthly_rent`,a.`electricity_bill`,a.`other_bill`,a.`wasa_bill`,a.`gas_bill`,(a.`monthly_rent`++a.`electricity_bill`+a.`other_bill`+a.`wasa_bill`+a.`gas_bill`) as total_payable FROM `tbl_rent_info` a,tbl_party_info c,tbl_project_info b WHERE a.party_code=c.party_code and a.proj_code=b.proj_code ".$proj_con.$flat_con.$party_con;


break;


case 16:


$report="Party Rent Payment Terms";


if(isset($party_code))


{$client_name=find_a_field('tbl_party_info','party_name','party_code='.$party_code); $party_con=' and a.party_code='.$party_code;}


if(isset($proj_code)) 


if(!isset($fid))


{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and a.proj_code='.$proj_code;}


else


{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); 


$allotment_no=$fid; $flat_show=',a.fid as allot_no'; $flat_con=' and a.proj_code='.$proj_code.' and a.fid=\''.$fid.'\' ';}


$sql="SELECT a.jv_no as Invoice_no,a.mon as period,b.`proj_name`,a.`fid`,c.`party_name`,a.`rent_amt`,a.`electricity_bill`,a.`other_bill`,a.`wasa_bill`,a.`gas_bill`,total_amt as total_amt FROM `tbl_rent_receive` a,tbl_party_info c,tbl_project_info b WHERE a.party_code=c.party_code and a.proj_code=b.proj_code ".$proj_con.$flat_con.$party_con;


break;


case 24:


$report="Collection Statement (Cash)";


if(isset($proj_code)) 


if(!isset($fid))


{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and c.proj_code='.$proj_code;}


else


{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); 


$allotment_no=$fid; $flat_show=',c.flat_no as Plot_no'; $flat_con=' and c.proj_code='.$proj_code.' and c.fid=\''.$fid.'\' ';}


if(isset($t_date)) 


{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.rec_date between \''.$fr_date.'\' and \''.$to_date.'\'';}


$sql="select d.party_code as client_code, d.party_name as client_name, a.rec_date as receive_date,b.proj_name as project_name".$flat_show.",
c.flat_no as allotment_name, c.road_no as floor, a.rec_amount as total_amt 
from tbl_receipt a,tbl_project_info b,tbl_flat_info c,tbl_party_info d, add_section s 
where c.section_name=s.section_id and a.party_code=d.party_code 
and c.fid=a.fid and a.pay_mode=0 
and c.proj_code=b.proj_code ".$proj_con.$date_con.$flat_con." order by a.rec_date";


break;


case 25:


$report="Collection Statement (Chaque)";


if(isset($proj_code)) 


if(!isset($fid))


{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and c.proj_code='.$proj_code;}


else


{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); 


$allotment_no=$fid; $flat_show=',c.flat_no as allot_no'; $flat_con=' and c.proj_code='.$proj_code.' and c.fid=\''.$fid.'\' ';}


if(isset($t_date)) 


{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.rec_date between \''.$fr_date.'\' and \''.$to_date.'\'';}


$sql="select d.party_name as client_name,b.proj_name as project_name,c.road_no as floor, c.flat_no as allotment, a.rec_date as receive_date,a.cheq_no as cheque_number,a.cheq_date as cheque_date,  sum(a.rec_amount) as total_amount 
from tbl_receipt a,tbl_project_info b,tbl_flat_info c,tbl_party_info d, add_section s 
where c.section_name=s.section_id and a.party_code=d.party_code and c.fid=a.fid and a.pay_mode in (1,2) and c.proj_code=b.proj_code ".$proj_con.$date_con.$flat_con." group by a.cheq_no order by a.rec_date";


break;


case 255:


$report="Collection Statement (Discount)";


if(isset($proj_code)) 


if(!isset($fid))


{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and c.proj_code='.$proj_code;}


else


{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); 


$allotment_no=$fid; $flat_show=',c.flat_no as allot_no'; $flat_con=' and c.proj_code='.$proj_code.' and c.fid=\''.$fid.'\' ';}


if(isset($t_date)) 


{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.rec_date between \''.$fr_date.'\' and \''.$to_date.'\'';}


$sql="select d.party_name as client_name,b.proj_name as project_name, c.road_no as floor, c.flat_no as allotment, a.rec_date as receive_date, sum(a.rec_amount) as total_amount
from tbl_receipt a,tbl_project_info b,tbl_flat_info c,tbl_party_info d, add_section s where c.section_name=s.section_id and a.party_code=d.party_code and c.fid=a.fid and a.pay_mode=3 and c.proj_code=b.proj_code ".$proj_con.$date_con.$flat_con." group by a.rec_no order by a.rec_date";


break;


// COMMISION REPORTS


case 31:


$report="Share Holder Investment Amount";


if(isset($proj_code))


{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and a.proj_code='.$proj_code;}


if(isset($t_date)) 


{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.opening_date between \''.$fr_date.'\' and \''.$to_date.'\'';}


$sql="SELECT a.`member_no`,a.`party_name` as share_holder,b.proj_name,a.`status`,a.`agent_code`,c.`emp_name` as agent_name,a.`opening_date` as invest_date,a.`invested`,a.`withdraw` FROM `tbl_director_info` AS a,tbl_project_info as b,tbl_employee_info as c WHERE a.proj_code=b.proj_code and c.emp_id=a.`agent_code`".$date_con.$proj_con ." order by a.proj_code,a.agent_code";


break;


case 33:


$report="Running Share Holder Information";


if(isset($proj_code))


{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and a.proj_code='.$proj_code;}


if(isset($t_date)) 


{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.opening_date between \''.$fr_date.'\' and \''.$to_date.'\'';}


$sql="SELECT a.`member_no`,a.`party_name` as share_holder,b.proj_name,a.`agent_code`,c.`emp_name` as agent_name,a.`opening_date` as invest_date,a.`invested`,a.`withdraw` FROM `tbl_director_info` AS a,tbl_project_info as b,tbl_employee_info as c WHERE a.proj_code=b.proj_code and c.emp_id=a.`agent_code` and a.status='Running' ".$date_con.$proj_con ." order by a.proj_code,a.agent_code";


break;


case 34:


$report="Withdrawn Share Holder Information";


if(isset($proj_code))


{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and a.proj_code='.$proj_code;}


if(isset($t_date)) 


{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.opening_date between \''.$fr_date.'\' and \''.$to_date.'\'';}


$sql="SELECT a.`member_no`,a.`party_name` as share_holder,b.proj_name,a.`agent_code`,c.`emp_name` as agent_name,a.`opening_date` as invest_date,a.`invested`,a.`status_date` as withdrawn_date,a.`withdraw` FROM `tbl_director_info` AS a,tbl_project_info as b,tbl_employee_info as c WHERE a.proj_code=b.proj_code and c.emp_id=a.`agent_code` and a.status='Withdrawn' ".$date_con.$proj_con ." order by a.proj_code,a.agent_code";


break;


case 35:


$report="Agent Information";


$sql="SELECT `emp_id`,`emp_name`,`emp_designation`,`emp_joining_date`,`emp_contact_no`, (select count(1) from tbl_director_info where agent_code=a.emp_id) as total_member, (select sum(invested) from tbl_director_info where agent_code=a.emp_id) as total_invested, (select sum(withdraw) from tbl_director_info where agent_code=a.emp_id)  as total_withdrawn FROM `tbl_employee_info` as a WHERE 1";


break;


case 111:


$report="Project Commission Report ";


if(isset($proj_code)) 


if(!isset($section_name))


if(!isset($flat_no))


{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and a.proj_code='.$proj_code;}


else


{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); 


$allotment_no=$flat_no; $flat_show=',a.flat_no as allot_no'; $flat_con=' and a.proj_code='.$proj_code.' and a.flat_no=\''.$flat_no.'\' ';}


if(isset($party_code))


{$client_name=find_a_field('tbl_party_info','party_name','party_code='.$party_code); $party_con=' and c.party_code='.$party_code;}


if(isset($t_date)) 


{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.booked_on between \''.$fr_date.'\' and \''.$to_date.'\'';}


/*$sql="SELECT b.proj_name,a.flat_no as Plot_no,concat(' &emsp;',a.flat_size) as Plot_size,(select section_name from add_section where section_id=a.section_name) as section_name,i.sr_executive_commission,i.team_leader_commission,i.group_leader_commission,i.other_commission,


(i.sr_executive_commission+i.team_leader_commission+i.group_leader_commission+i.other_commission) as total_commission,


sum(i.rcv_amount) as receive_amount,


a.total_price,(select PBI_NAME from personnel_basic_info where PBI_ID=c.sr_executive) as sr_executive_name,(select PBI_NAME from personnel_basic_info where PBI_ID=c.team_leader) as team_leader,(select PBI_NAME from personnel_basic_info where PBI_ID=c.group_leader) as group_leader, c.party_name FROM `tbl_flat_info` a,tbl_project_info b,tbl_party_info c,tbl_flat_cost_installment i WHERE (i.sr_executive_commission+i.team_leader_commission+i.group_leader_commission+i.other_commission)!='' and a.party_code=i.party_code and a.proj_code=b.proj_code and a.party_code=c.party_code ".$proj_con.$date_con.$flat_con.$party_con." group by i.id";*/


$sql="SELECT c.party_name, b.proj_name as project_name, a.flat_no as Plot_no,a.road_no, concat(' &emsp;',a.flat_size) as Plot_size,(select section_name from add_section where section_id=a.section_name) as section_name,


a.sr_status as status, 


concat('&emsp;',i.rcv_amount) as total_received_amount,


(i.sr_executive_commission+i.team_leader_commission+i.group_leader_commission+i.other_commission) as total_commission,


i.sr_executive_commission,i.team_leader_commission,i.group_leader_commission,i.other_commission


FROM `tbl_flat_info` a,tbl_project_info b,tbl_party_info c,tbl_flat_cost_installment i WHERE (i.sr_executive_commission+i.team_leader_commission+i.group_leader_commission+i.other_commission)!='' and i.pay_code!=98 and i.rcv_amount!=0 and a.party_code=i.party_code and a.proj_code=b.proj_code and a.party_code=c.party_code ".$proj_con.$date_con.$flat_con.$party_con." group by i.id";


break;


case 1111:


$report="Sr Commission Report";


if(isset($proj_code)) 


if(!isset($flat_no))


if(!isset($section_name))


{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and a.proj_code='.$proj_code;}


else


{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); 


$allotment_no=$flat_no; $flat_show=',a.flat_no as allot_no'; $flat_con=' and a.proj_code='.$proj_code.' and a.flat_no=\''.$flat_no.'\' ';}


if(isset($party_code))


{$client_name=find_a_field('tbl_party_info','party_name','party_code='.$party_code); $party_con=' and c.party_code='.$party_code;}


if($_POST['emp_id']!='')


{$emp_con=' and c.sr_executive='.$_POST['emp_id'].' ';}


if(isset($t_date)) 


{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.booked_on between \''.$fr_date.'\' and \''.$to_date.'\'';}


/* 	 $sql="SELECT b.proj_name,(select section_name from add_section where section_id=a.section_name) as section_name,a.flat_no as Plot_no,a.flat_size as Plot_size,(select PBI_NAME from personnel_basic_info where PBI_ID=c.sr_executive) as sr_executive_name,i.sr_executive_commission,i.rcv_amount as receive_amount,a.total_price, a.status,a.booked_on,c.party_name FROM `tbl_flat_info` a,tbl_project_info b,tbl_party_info c,tbl_flat_cost_installment i WHERE i.sr_executive_commission!='' and  a.party_code=i.party_code and a.proj_code=b.proj_code and a.party_code=c.party_code ".$emp_con.$proj_con.$date_con.$flat_con.$party_con." group by i.id"; */


$sql="SELECT c.party_name, b.proj_name as project_name,(select section_name from add_section where section_id=a.section_name) as section_name, a.flat_no as Plot_no,a.road_no, concat(' &emsp;',a.flat_size) as Plot_size, a.sr_status as status,concat(' &emsp;',i.rcv_amount) as received_amount, i.sr_executive_commission, (select PBI_NAME from personnel_basic_info where PBI_ID=c.sr_executive) as sr_executive_name  FROM `tbl_flat_info` a,tbl_project_info b,tbl_party_info c,tbl_flat_cost_installment i WHERE i.sr_executive_commission!='' and i.pay_code!=98 and  a.party_code=i.party_code and a.proj_code=b.proj_code and a.party_code=c.party_code ".$emp_con.$proj_con.$date_con.$flat_con.$party_con." group by i.id";


break;


case 1112:


$report="Team Leader Commission Report";


if(isset($proj_code)) 


if(!isset($flat_no))


if(!isset($section_name))


{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and a.proj_code='.$proj_code;}


else


{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); 


$allotment_no=$flat_no; $flat_show=',a.flat_no as allot_no'; $flat_con=' and a.proj_code='.$proj_code.' and a.flat_no=\''.$flat_no.'\' ';}


if(isset($party_code))


{$client_name=find_a_field('tbl_party_info','party_name','party_code='.$party_code); $party_con=' and c.party_code='.$party_code;}


if($_POST['emp_id']!='')


{$emp_con=' and c.team_leader='.$_POST['emp_id'].' ';}


if(isset($t_date)) 


{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.booked_on between \''.$fr_date.'\' and \''.$to_date.'\'';}


/*$sql="SELECT b.proj_name,(select section_name from add_section where section_id=a.section_name) as section_name,a.flat_no as Plot_no,a.flat_size as Plot_size,(select PBI_NAME from personnel_basic_info where PBI_ID=c.team_leader) as team_leader,i.team_leader_commission,i.other_commission,i.rcv_amount as receive_amount,a.total_price, a.status,a.booked_on,c.party_name FROM `tbl_flat_info` a,tbl_project_info b,tbl_party_info c,tbl_flat_cost_installment i WHERE i.team_leader_commission!='' and  a.party_code=i.party_code and a.proj_code=b.proj_code and a.party_code=c.party_code ".$emp_con.$proj_con.$date_con.$flat_con.$party_con." group by i.id";*/


$sql="SELECT c.party_name, b.proj_name as project_name,(select section_name from add_section where section_id=a.section_name) as section_name,a.flat_no as Plot_no,a.road_no,concat(' &emsp;',a.flat_size) as Plot_size, a.sr_status as status, concat(' &emsp;',i.rcv_amount) as received_amount, i.team_leader_commission, (select PBI_NAME from personnel_basic_info where PBI_ID=c.team_leader) as team_leader FROM `tbl_flat_info` a,tbl_project_info b,tbl_party_info c,tbl_flat_cost_installment i WHERE i.team_leader_commission!='' and i.pay_code!=98 and  a.party_code=i.party_code and a.proj_code=b.proj_code and a.party_code=c.party_code ".$emp_con.$proj_con.$date_con.$flat_con.$party_con." group by i.id";


break;




case 22:
$report="Client Statement";
break;




break;
case 1113:


$report="Group Leader Commission Report";


if(isset($proj_code)) 


if(!isset($flat_no))


if(!isset($section_name))


{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and a.proj_code='.$proj_code;}


else


{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); 


$allotment_no=$flat_no; $flat_show=',a.flat_no as allot_no'; $flat_con=' and a.proj_code='.$proj_code.' and a.flat_no=\''.$flat_no.'\' ';}


if(isset($party_code))


{$client_name=find_a_field('tbl_party_info','party_name','party_code='.$party_code); $party_con=' and c.party_code='.$party_code;}


if($_POST['emp_id']!='')


{$emp_con=' and c.group_leader='.$_POST['emp_id'].' ';}


if(isset($t_date)) 


{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.booked_on between \''.$fr_date.'\' and \''.$to_date.'\'';}


/*$sql="SELECT b.proj_name,(select section_name from add_section where section_id=a.section_name) as section_name,a.flat_no as Plot_no,a.flat_size as Plot_size,(select PBI_NAME from personnel_basic_info where PBI_ID=c.group_leader) as group_leader,i.group_leader_commission,i.other_commission,i.rcv_amount as receive_amount, a.total_price, a.status,a.booked_on,c.party_name FROM `tbl_flat_info` a,tbl_project_info b,tbl_party_info c,tbl_flat_cost_installment i WHERE  i.group_leader_commission and a.party_code=i.party_code and a.proj_code=b.proj_code and a.party_code=c.party_code ".$emp_con.$proj_con.$date_con.$flat_con.$party_con." group by i.id";*/


$sql="SELECT c.party_name, b.proj_name as project_name,(select section_name from add_section where section_id=a.section_name) as section_name,a.flat_no as Plot_no,a.road_no,concat(' &emsp;',a.flat_size) as Plot_size, a.sr_status as status, concat(' &emsp;',i.rcv_amount) as received_amount, i.group_leader_commission, (select PBI_NAME from personnel_basic_info where PBI_ID=c.group_leader) as group_leader


FROM `tbl_flat_info` a,tbl_project_info b,tbl_party_info c,tbl_flat_cost_installment i WHERE  i.group_leader_commission and a.party_code=i.party_code and a.proj_code=b.proj_code and i.pay_code!=98 and a.party_code=c.party_code ".$emp_con.$proj_con.$date_con.$flat_con.$party_con." group by i.id";


break;


//ROW_NUMBER() OVER(ORDER BY Id) AS Row

}}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="UTF-8">
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title><?=$report?></title>
<link href="../../css/report.css" type="text/css" rel="stylesheet" />

<!--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.bootstrap4.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">-->
<script language="javascript">
function hide(){
document.getElementById('pr').style.display='none';
}
</script>
<!--    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>
    <script>
	$(document).ready(function() {

	    var table = $('#example').DataTable( {

	        lengthChange: true,

	        buttons: [ 'copy', 'excel', 'csv', 'pdf', 'colvis' ]

	    } );

	    table.buttons().container()

	        .appendTo( '#example_wrapper .col-md-6:eq(0)' );

	} );

     </script>-->
<style type="text/css">
<!--
.style1 {
	font-size: 18px;
	font-weight: bold;
}
-->
</style>
</head>
<body>
<div align="center" id="pr">


<!--<input type="button" value="Print" onClick="hide();window.print();"/>-->
</div>
<div class="main">
<?


$str 	.= '<div class="header">';
if(isset($_SESSION['company_name'])) $str 	.= '<h3>Sajeeb Homes Ltd</h3>';
if(isset($report)) $str 	.= '<h4>'.$report.'</h4>';
if(isset($to_date)) 
$str 	.= '<h4>'.$fr_date.' To '.$to_date.'</h4>';
$str 	.= '</div>';
if(isset($_SESSION['company_logo'])) 
//$str 	.= '<div class="logo"><img height="60" src="'.$_SESSION['company_logo'].'"</div>';
$str 	.= '<div class="left">';
if(isset($project_name)) $str 	.= '<p>Project Name: '.$project_name.'</p>';
if(isset($allotment_no)) $str 	.= '<p>Allotment No.: '.$allotment_no.'</p>';
$str 	.= '</div><div class="right">';
if(isset($client_name)) 
$str 	.= '<p>Client Name: '.$client_name.'</p>';
$str 	.= '</div><div class="date">Reporting Time: '.date("h:i A d-m-Y").'</div>';

//-------------- start report


if($_POST['report']==22){ // client statement
$report_time 	.= '</div><div class="date">Reporting Time: '.date("h:i A d-m-Y").'</div>';
?>
<center><img src="logo.jpg" /></center>
<h4>Project Information</h4>
<table width="100%" border="0">
  <tr>
    <th colspan="2" bgcolor="#CC9900" scope="col">Project Info </th>
    <th bgcolor="#669900" scope="col">Client Info </th>

    <th bgcolor="#669900" scope="col"><?=$report_time;?></th>
  </tr>
  <tr>
    <td height="26" colspan="2"><b>
      <?=find_a_field('tbl_flat_info f, tbl_project_info i','i.proj_name','f.proj_code=i.proj_code and f.fid='.$_POST['flat'])?>
    </b></td>
    <td><div align="left">Name</div></td>
    <td><b><?=find_a_field('tbl_flat_info f, tbl_party_info i','i.party_name','f.party_code=i.party_code and f.fid='.$_POST['flat']);?></b></td>
    </tr>
  <tr>
    <td bgcolor="#CCCCCC">Flat Size </td>
    <td bgcolor="#CCCCCC"><div align="left">
      <? $query = 'select f.flat_size from tbl_flat_info f where f.fid='.$_POST['flat'];
$r = mysqli_fetch_object(db_query($query)); 
echo $r->flat_size; ?>
    </div></td>
    <td bgcolor="#CCCCCC"><div align="left">Current Address </div></td>
    <td bgcolor="#CCCCCC"><? 
$query = 'select i.pre_house,i.pre_road from tbl_flat_info f, tbl_party_info i where f.party_code=i.party_code and f.fid='.$_POST['flat'];$r = mysqli_fetch_object(db_query($query)); echo $r->pre_house.','.$r->pre_road; ?></td>
    </tr>
  <tr>
    <td>Flat No </td>
    <td><div align="left">
      <? $query = 'select f.fid,f.road_no,f.flat_no from tbl_flat_info f where f.fid='.$_POST['flat'];
$r = mysqli_fetch_object(db_query($query)); 
echo $r->road_no.' Floor ,'.$r->flat_no; ?>
    </div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td bgcolor="#CCCCCC">Allotment No: </td>
    <td bgcolor="#CCCCCC"><b><div align="left">
      <?=$r->fid;?>
    </div>
    </b></td>
    <td bgcolor="#CCCCCC"><div align="left">Total Price </div></td>
    <td bgcolor="#CCCCCC"><b>
      <? $queryy = 'select f.total_price from tbl_flat_info f where  f.fid='.$_POST['flat'];$ry = mysqli_fetch_object(db_query($queryy)); 
	  echo number_format($ry->total_price,0); ?>
    </b></td>
    </tr>
</table>

<p>
<h4>Financial Information</h4>
<table width="100%" border="1">
<thead>
<tr>
<td><b>S/L</b></td>
<td width=""><b>Pay Code</b></td>
<td width=""><b>Installment</b></td>
<td width=""><b>Installment</b><strong> No</strong></td>
<td width=""><b>MR No</b></td>
<td width=""><b>Payment Mood</b></td>
<td  width=""><b>Bank Name</b></td>
<td width=""><b>Cheque  Date</b></td>
<td width=""><b>Cheque No</b></td>


<td width=""><b>Receive Date</b></td>

<td width=""><b>Receive Amount</b></td>
</tr>
</thead>
<tbody>

<?
if($_POST['f_date']!= '' && $_POST['t_date']!=''){ $date_con = ' and m.rec_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"  '; }
if($_POST['flat']!='') $flat_con = ' and d.fid='.$_POST['flat'];

// and c.inst_date between  "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"

$select = 'select d.rec_no, d.pay_code,d.inst_no, m.pay_mode,d.pay_code,d.inst_no,m.rec_date,h.pay_desc,h.pay_short, m.bank_name, m.cheq_date, m.cheq_no,d.inst_amount,sum(d.rec_amount) as rec_amount 
from  tbl_payment_head h, tbl_receipt m, tbl_receipt_details d 
where h.pay_code=d.pay_code 
and m.rec_no=d.rec_no '.$flat_con.$date_con.' 
group by d.rec_no,d.pay_code,d.inst_no order by h.serial,d.inst_no,m.rec_date';

$query = db_query($select);
$sl = 0;
$sll = 0;
while ($row = mysqli_fetch_object($query)){

//start
$check = find_a_field_sql("select count(pay_desc) from tbl_payment_head where pay_code= '".$row->pay_code."' and (pay_desc LIKE '%Booki%' or  pay_desc LIKE '%Down%') ");
if ($check >0) { } else {

if($old_pay_code!=$row->pay_code || $old_inst_no!=$row->inst_no){$sll += 1; }
$old_pay_code = $row->pay_code;
$old_inst_no = $row->inst_no;
}
// end

?>
<tr>
<td width=""> <?=++$sl?></td>
<td width=""> <?=$row->pay_code?></td>
<td width=""> <?=$row->inst_no?></td>
<td width="">
<? $check = find_a_field_sql("select count(pay_desc) from tbl_payment_head where pay_code= '".$row->pay_code."' and (pay_desc LIKE '%Booki%' or  pay_desc LIKE '%Down%') ");
if ($check >0) { 
echo $row->pay_desc; 
} else {
echo substr($row->pay_desc,0,-2)."-".$sll; }
?>
</td>
<td width=""><?=$row->rec_no?></td>
<td width=""><? if($row->pay_mode==1) echo "Bank"; else echo "Cash";?></td>
<td  width=""><?=$row->bank_name?></td>
<td width=""><?=$row->cheq_date?></td>
<td width=""><?=$row->cheq_no?></td>
<td width=""><?=$row->rec_date?></td>
<td width=""><div align="right"><?=number_format($row->rec_amount,0);?></div></td>
</tr>

<? 
$t_rec_amount += $row->rec_amount;
$t_inst_amount +=$row->inst_amount;
} ?>

<tr>
<td colspan="8"><b> Total :<?=convertNumberMhafuz($t_rec_amount);?></b></td>
<td></td>
<td></td>
<td><b><div align="right"><?=number_format($t_rec_amount,0)?></div></b></td>
</tr>

</tbody>
</table>
<div align="right">Total Dues : <?=number_format(($ry->total_price-$t_rec_amount),0);?>
  
  
  
<?
}


elseif($_POST['report']==4){

if(isset($proj_code)){
$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con='proj_code='.$proj_code;
} else { $proj_con=1; }

$proj_total_cost = find_a_field('tbl_flat_info','sum(total_price)','proj_code="'.$proj_code.'"');
$proj_comm= find_a_field('tbl_flat_info','sum(total_price)','cat_id=2 and proj_code="'.$proj_code.'"');
$proj_res= find_a_field('tbl_flat_info','sum(total_price)','cat_id=3 and proj_code="'.$proj_code.'"');

$proj_total_sft = find_a_field('tbl_flat_info','sum(flat_size)','proj_code="'.$proj_code.'"');
$proj_comm_sft= find_a_field('tbl_flat_info','sum(flat_size)','cat_id=2 and proj_code="'.$proj_code.'"');
$proj_res_sft= find_a_field('tbl_flat_info','sum(flat_size)','cat_id=3 and proj_code="'.$proj_code.'"');


$sale_comm_sold_unit= find_a_field('tbl_flat_info','count(fid)','cat_id=2 and status in("Booked","Sold") and proj_code="'.$proj_code.'"');
$sale_comm_sold_value= find_a_field('tbl_flat_info','sum(total_price)','cat_id=2 and status in("Booked","Sold") and proj_code="'.$proj_code.'"');
$sale_res_sold_unit= find_a_field('tbl_flat_info','count(fid)','cat_id=3 and status in("Booked","Sold") and proj_code="'.$proj_code.'"');
$sale_res_sold_value= find_a_field('tbl_flat_info','sum(total_price)','cat_id=3 and status in("Booked","Sold") and proj_code="'.$proj_code.'"');

$sale_comm_unsold_unit= find_a_field('tbl_flat_info','count(*)','cat_id="2" and status not in("Booked","Sold") and proj_code="'.$proj_code.'"');
$sale_comm_unsold_value= find_a_field('tbl_flat_info','sum(total_price)','cat_id=2 and status not in("Booked","Sold") and proj_code="'.$proj_code.'"');
$sale_res_unsold_unit= find_a_field('tbl_flat_info','count(*)','cat_id=3 and status not in("Booked","Sold") and proj_code="'.$proj_code.'"');
$sale_res_unsold_value= find_a_field('tbl_flat_info','sum(total_price)','cat_id=3 and status not in("Booked","Sold") and proj_code="'.$proj_code.'"');
?>


<center>
<h2>Sajeeb Homes Ltd</h2>
<h5><?=$report?></h5>
<br>
<table width="57%" border="0" cellspacing="0" cellpadding="2">
<thead>
<?
$sql="SELECT * FROM tbl_project_info WHERE 1 and ".$proj_con;
$query = db_query($sql);
while($data= mysqli_fetch_object($query)){ ?>
<tr>
  <td width="28%">Name</td>
  <td width="2%">:</td>
  <td width="70%"><?=$data->proj_name?></td>
  </tr>
</thead>
<tbody>

<tr>
  <td>Address</td>
  <td>:</td>
  <td><?=$data->proj_add?></td>
</tr>
<tr>
  <td>Storied</td>
  <td>:</td>
  <td><?=$data->proj_storied?></td>
</tr>
<tr>
  <td>Satus</td>
  <td>:</td>
  <td><?=$data->proj_status?></td>
</tr>
<tr>
  <td>Project Start Date</td>
  <td>:</td>
  <td><?=$data->proj_start_date?></td>
</tr>
<tr>
  <td>Project Handover Date</td>
  <td>:</td>
  <td><?=$data->proj_ho_date?></td>
</tr>
<tr>
  <td>Budgeted Cost</td>
  <td>:</td>
  <td><?=$data->proj_budget_cost?></td>
</tr>
<tr>
  <td><strong>Project Sale Value</strong></td>
  <td>:</td>
  <td>Tk:     <?=$proj_total_cost?></td>
</tr>
<tr>
  <td> &gt; Residential</td>
  <td>:</td>
  <td> > Tk: <?=$proj_res?></td>
</tr>
<tr>
  <td> &gt;Commercial</td>
  <td>:</td>
  <td> > Tk:     <?=$proj_comm?></td>
</tr>
<tr>
  <td><strong>Project Salable Area</strong></td>
  <td>:</td>
  <td><?=$proj_total_sft?> sft </td>
</tr>
<tr>
  <td>&gt; Residential</td>
  <td>:</td>
  <td> > <?=$proj_res_sft?>     sft</td>
</tr>
<tr>
  <td>&gt; Commercial</td>
  <td>:</td>
  <td> >
    <?=$proj_comm_sft?>     sft</td>
  </tr>
<? } ?>
</tbody>
</table>

<p><br>
<h3>Allotment Status</h3>

<table width="70%" border="0">
  <tr>
    <td colspan="6" bgcolor="#996699"><div align="center" class="style1">Sold</div></td>
    </tr>
  <tr>
    <td colspan="3"><div align="center">Commercial</div></td>
    <td colspan="3"><div align="center">Residential</div></td>
    </tr>
  <tr>
    <td>Allotment/Units</td>
    <td>&nbsp;</td>
    <td>Value</td>
    <td>Allotment/Units</td>
    <td>&nbsp;</td>
    <td>Value</td>
  </tr>
  <tr>
    <td><?=$sale_comm_sold_unit?></td>
    <td>&nbsp;</td>
    <td><?=$sale_comm_sold_value?></td>
    <td><?=$sale_res_sold_unit?></td>
    <td>&nbsp;</td>
    <td><?=$sale_res_sold_value?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6" bgcolor="#996699"><div align="center" class="style1">Unsold</div></td>
    </tr>
  <tr>
    <td>Allotment/Units</td>
    <td>&nbsp;</td>
    <td>Value</td>
    <td>Allotment/Units</td>
    <td>&nbsp;</td>
    <td>Value</td>
  </tr>
  <tr>
    <td><?=$sale_comm_unsold_unit?></td>
    <td>&nbsp;</td>
    <td><?=$sale_comm_unsold_value?></td>
    <td><?=$sale_res_unsold_unit?></td>
    <td>&nbsp;</td>
    <td><?=$sale_res_unsold_value?></td>
  </tr>
</table>




<? 
} // end 4



elseif($_POST['report']==21){

$report="Product Statemennt Report";
$_REQUEST['warehouse_id'] = $_SESSION['user']['depot'];
$f_date = $_REQUEST['f_date'];
$t_date = $_REQUEST['t_date'];

if(isset($proj_code)) {$proj_con=' and i.proj_code='.$proj_code;} 
if($_POST['flat']) {$flat_con=' and i.fid='.$_POST['flat'];} 

$date_con = ' and r.rec_date between "'.$f_date.'" and "'.$t_date.'" ';


	
// client List
$sql="SELECT i.fid as code,p.party_code,p.party_name
FROM  tbl_flat_cost_installment i, tbl_party_info p
where i.party_code = p.party_code
group by i.fid
order by i.fid";
	
$res = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$client_id[$row->code] = $row->party_code;
		$party_name[$row->code] = $row->party_name;
	}
	
// opening balance----- old all collection
$sql="SELECT r.fid as code,sum(rec_amount) as amount
FROM  tbl_receipt r
WHERE r.rec_date < '".$f_date."'
group by r.fid order by r.fid
";	
$res = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$opening[$row->code] = $row->amount;
	}
	
// Collection this month----- old all collection
$sql="SELECT r.fid as code,sum(rec_amount) as amount
FROM  tbl_receipt r
WHERE r.rec_date between '".$f_date."' and '".$t_date."'
group by r.fid order by r.fid
";	
$res = db_query($sql);
	while($row=mysqli_fetch_object($res))
	{
		$collection[$row->code] = $row->amount;
	}		


?>
    <center>
    <style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}
td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 4px;
}
tr:nth-child(even) {
  background-color: #dddddd;
}
  </style>
</div>
<h4>Sajeeb Homes Ltd.</h4>
<h5>Monthly Sales Contract Receivable Report</h5>
<? if($_REQUEST['proj_code']){ ?><h6><?=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); ?></h6><? } ?>
<h6>Period: <?=$_REQUEST['f_date'];?> to <?=$_REQUEST['t_date'];?></h6>
<table width="100%" border="0" cellspacing="0" cellpadding="2">
<thead>
<tr>
  <th>S/L-21</th>
  <th>Project</th>
  <th>Allotment ID</th>
  <th>Allotment Name </th>
  <th>Client ID </th>
  <th>Client Name </th>
  <th>Size(SFT) </th>
  <th>Rate</th>
  <th>Value</th>
  <th>Car Parking </th>
  <th>Utility</th>
  <th>Discount</th>
  <th>Contract Value </th>
  <th>Previous Collection  </th>
  <th>Collection</th>
  <th>Total Collection </th>
  <th>Opening Receivable </th>
  <th>Closing Receivable </th>
  <th>Remarks</th>
  </tr>
</thead>
<tbody>
<?

// Product list
$sql="SELECT i.fid as code,i.* 
FROM  tbl_flat_info i , tbl_flat_cost_installment c
WHERE i.fid=c.fid 
".$proj_con.$flat_con."
group by i.fid 
order by i.proj_code,i.road_no,i.fid
";

$query = db_query($sql);
while($data= mysqli_fetch_object($query)){ ?>
<tr><td><?=++$op;?></td>
  <td><?=find_a_field('tbl_project_info','proj_name','proj_code='.$data->proj_code);?></td>
  <td><?=$data->code?></td>
  <td><?=$data->flat_no?></td>
  <td><?=$client_id[$data->code]?></td>
  <td><?=$party_name[$data->code]?></td>
  <td><?=(int)$data->flat_size?></td>
  <td><?=$data->sqft_price?></td>
  <td><?=$value=($data->sqft_price * $data->flat_size);?></td>
  <td><?=$data->park_price?></td>
  <td><?=$data->utility_price?></td>
  <td><?=$data->discount?></td>
  <td><?=$sales_value=($value+ $data->park_price + $data->utility_price - $data->discount);?></td>
  <td><?=$opening[$data->code]?></td>
  <td><?=$collection[$data->code]?></td>
  <td><?=$total_col=($opening[$data->code] + $collection[$data->code])?></td>
  <td><?=$opening_rec=(($sales_value - $opening[$data->code]));?></td>
  <td><?=$closing_rec=(($sales_value - $total_col));?></td>
  <td></td>
<?
$t_sft+=$data->flat_size;
$t_value += $value;
$t_park_price += $data->park_price;
$t_utility_price += $data->utility_price;
$t_discount += $data->discount;
$t_sales_value += $sales_value;
$t_opening += $opening[$data->code];
$t_collection += $collection[$data->code];
$t_total_col += $total_col;
$t_opening_rec+= $opening_rec;
$t_closing_rec+= $closing_rec;

?>
</tr>
<? } ?>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td><strong>Total: </strong></td>
  <td><strong>
    <?=$t_sft;?></strong></td>
  <td>&nbsp;</td>
  <td><strong>
    <?=$t_value;?>
  </strong></td>
  <td><strong>
    <?=$t_park_price;?>
  </strong></td>
  <td><strong>
    <?=$t_utility_price;?>
  </strong></td>
  <td><strong>
    <?=$t_discount;?>
  </strong></td>
  <td><strong>
    <?=$t_sales_value;?>
  </strong></td>
  <td><strong>
    <?=$t_opening;?>
  </strong></td>
  <td><strong>
    <?=$t_collection;?>
  </strong></td>
  <td><strong>
    <?=$t_total_col;?>
  </strong></td>
  <td><strong>
    <?=$t_opening_rec;?>
  </strong></td>
  <td><strong>
    <?=$t_closing_rec;?>
  </strong></td>
  <td>&nbsp;</td>
</tr>
</tbody>
</table>
<table width="100%" border="0">
  <tr>
    <th><p></th>
    <th></th>
    <th></th>
    <th></th>
  </tr>
  <tr>
    <th scope="col"><div align="center">__________________</div></th>
    <th scope="col"><div align="center">__________________</div></th>
    <th scope="col"><div align="center">__________________</div></th>
    <th scope="col"><div align="center">__________________</div></th>
  </tr>
  <tr>
    <td><div align="center">Accounts</div></td>
    <td><div align="center">Head of Project </div></td>
    <td><div align="center">Director</div></td>
    <td><div align="center">Chairman</div></td>
  </tr>
</table>

<? 
}


// Payment Sechudule

elseif($_POST['report']==13){

if(isset($party_code))
{$client_name=find_a_field('tbl_party_info','party_name','party_code='.$party_code); $party_con=' and d.party_code='.$party_code;}
if(isset($proj_code)) 

if(!isset($fid))
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and d.proj_code='.$proj_code;}
else
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); 
$allotment_no=$fid; $flat_show=',a.flat_no as allot_no'; $flat_con=' and d.proj_code='.$proj_code.' and d.fid=\''.$fid.'\' ';}

if($_POST['section_name']!=''){$section_con = ' and d.section_name="'.$_POST['section_name'].'"';}

if(isset($t_date)) 
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.inst_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

?>

</div>
<h4>Sajeeb Homes Ltd.</h4>
<h5><?=$report?></h5>
<?php if($_REQUEST['proj_code']){ ?><h6><?=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); ?></h6><? } ?>
<!--<h6>Period: <?=$_REQUEST['f_date'];?> to <?=$_REQUEST['t_date'];?></h6>-->
<table width="100%" border="0" cellspacing="0" cellpadding="2">
<thead>
<tr>
  <th>S/L-13</th>
  <th>Installment</th>
  <th>Installment No</th>
  <th>Project Name	</th>
  <th>Client Name</th>
  <th>Floor</th>
  <th>Allotment No</th>
  <th>Allotment</th>
  <th>Installment Date </th>
  <th>Payable Amount</th>
  <th>Rcv Amt</th>
  <th>Outstanding</th>
  <th>Remarks</th>
  </tr>
</thead>
<tbody>
<?
$sql2="SELECT e.pay_desc as installment,a.inst_no as installment_no,c.proj_name as project_name,b.party_name as client_name,
road_no as floor_no,d.fid as allotment_no,a.flat_no AS allotment, a.inst_date as installment_date, 
a.inst_amount as payable_amount, a.pay_code,a.inst_no
FROM 
tbl_flat_cost_installment a, 
tbl_party_info b, 
tbl_project_info c, 
tbl_flat_info d,
tbl_payment_head e
WHERE a.proj_code = c.proj_code
AND d.party_code = b.party_code
AND a.proj_code = d.proj_code
AND a.fid = d.fid
AND a.pay_code = e.pay_code".$proj_con.$date_con.$flat_con.$party_con.$section_con." order by a.inst_date";
$query = db_query($sql2);
while($data=mysqli_fetch_object($query)){

// rec_date between "'.$f_date.'" and "'.$t_date.'"
$ss='select sum(rec_amount) from tbl_receipt_details where pay_code="'.$data->pay_code.'" and inst_no="'.$data->inst_no.'" 
and fid="'.$data->allotment_no.'" ';

$g_pay += $data->payable_amount;

$collection = find_a_field_sql($ss);
$g_coll += $collection;

$outstanding = $data->payable_amount - $collection;
$g_out += $outstanding;
?>
<tr>
<td><?=++$op;?></td>
  <td><?=$data->installment?></td>
  <td><?=$data->installment_no?></td>
  <td><?=$data->project_name?></td>
  <td><?=$data->client_name;?></td>
  <td><?=$data->floor_no;?></td>
  <td><?=$data->allotment_no;?></td>
  <td><?=$data->allotment;?></td>
  <td><?=$data->installment_date;?></td>
  <td><?=$data->payable_amount;?></td>
  <td><?=$collection;?></td>
  <td><?=$outstanding;?></td>
  <td></td>
</tr>
<? } ?>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>  
  <td>&nbsp;</td>
  <td><strong><?=number_format($g_pay,0);?></strong></td>
  <td><strong><?=number_format($g_coll,0);?></strong></td>
  <td><strong><?=number_format($g_out,0);?></strong></td>
  <td>&nbsp;</td>
</tr>
</tbody>
</table>

<? 
}
// end 713





elseif($_POST['report']==11){

if(isset($party_code))
{$client_name=find_a_field('tbl_party_info','party_name','party_code='.$party_code); $party_con=' and d.party_code='.$party_code;}
if(isset($proj_code)) 
if(!isset($fid))
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and d.proj_code='.$proj_code;}
else
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); 
$allotment_no=$fid; $flat_show=',a.fid as allot_no'; $flat_con=' and d.proj_code='.$proj_code.' and d.fid=\''.$fid.'\' ';}
if($_POST['section_name']!=''){$section_con = ' and d.section_name="'.$_POST['section_name'].'"';}
if(isset($t_date)) 
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.inst_date < \''.$to_date.'\'';}

?>

<center>
<h4>Sajeeb Homes Ltd.</h4>
<h5><?=$report?></h5>
<?php if($_REQUEST['proj_code']){ ?><h6><?=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); ?></h6><? } ?>
<h6>Period: <?=$_REQUEST['f_date'];?> to <?=$_REQUEST['t_date'];?></h6>
<table width="100%" border="0" cellspacing="0" cellpadding="2">
<thead>
<tr>
  <th>S/L-11</th>
  <th>Project Name</th>
  <th>Clinet Name</th>
  <th>Floor No</th>
  <th>Allotment ID</th>
  <th>Allotment Name</th>
  <th>Payable Amount</th>
  <th>Receive Amount</th>
  <th>Outstanding</th>
  <th>Last Receive Date</th>
  <th>Last Receive Amount</th>
  <th>Remarks</th>
  </tr>
</thead>
<tbody>
<?
$sql2="select b.party_name as client_name,c.proj_name as project_name,road_no as floor_no,d.fid as allotment_id,a.flat_no as allotment_name, 
sum(a.inst_amount) as payable_amount,sum(a.rcv_amount) as received_amount ,(sum(a.inst_amount) -sum(a.rcv_amount)) as outstanding

from tbl_flat_cost_installment a, tbl_party_info b, tbl_project_info c,tbl_flat_info d 
where a.proj_code=c.proj_code and d.party_code=b.party_code 
and a.fid=d.fid  
and a.inst_date <= '".$to_date."' 
".$proj_con.$section_con.$flat_con.$party_con." 
group by c.proj_name,d.fid order by d.fid";
$query = db_query($sql2);
while($data=mysqli_fetch_object($query)){

$rec_info = findall("select rec_date,rec_amount from tbl_receipt where fid='".$data->allotment_id."' order by rec_date desc limit 1");
?>
<tr>
<td><?=++$op;?></td>
  <td><?=$data->project_name?></td>
  <td><?=$data->client_name?></td>
  <td><?=$data->floor_no?></td>
  <td><?=$data->allotment_id;?></td>
  <td><?=$data->allotment_name;?></td>
  <td><?=$data->payable_amount;?></td>
  <td><?=$data->received_amount;?></td>
  <td><?=$data->outstanding;?></td>
  <td><?=$rec_info->rec_date?></td>
  <td><?=$rec_info->rec_amount?></td>
  <td></td>
</tr>
<? 
$gpay+=$data->payable_amount;
$grec+=$data->received_amount;
$gout+=$data->outstanding;

} ?>
<tr>

  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>  
  <td>&nbsp;</td>
  <td><strong><?=number_format($gpay,0);?></strong></td>
  <td><strong><?=number_format($grec,0);?></strong></td>
  <td><strong><?=number_format($gout,0);?></strong></td>
   <td>&nbsp;</td>  
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  
</tr>
</tbody>
</table>

<? 
}
// end 11








elseif($_POST['report']==70){
$report="Sales Report";
$_REQUEST['warehouse_id'] = $_SESSION['user']['depot'];
$f_date = $_REQUEST['f_date'];
$t_date = $_REQUEST['t_date'];

if(isset($proj_code)) {$proj_con=' and i.proj_code='.$proj_code;} 
if($_POST['flat']) {$flat_con=' and i.fid='.$_POST['flat'];} 

$date_con = ' and r.rec_date between "'.$f_date.'" and "'.$t_date.'" ';
?>

</div>
<h4>Sajeeb Homes Ltd.</h4>
<h5>Sales Report</h5>
<?php if($_REQUEST['proj_code']){ ?><h6><?=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); ?></h6><? } ?>
<h6>Period: <?=$_REQUEST['f_date'];?> to <?=$_REQUEST['t_date'];?></h6>
<table width="100%" border="0" cellspacing="0" cellpadding="2">
<thead>
<tr>
  <th>S/L-70</th>
  <th>Project</th>
  <th>Section</th>
  <th>FID</th>
  <th>Allotment</th>
  <th>Client ID</th>
  <th>Clinet Name</th>
  <th>Allotment Size</th>
  <th>Sales Price </th>
  <th>Collection</th>
  <th>Sales Date</th>
  <th>Sales Person</th>
  <th>Remarks</th>
  </tr>
</thead>
<tbody>
<?
$sql1 = "select b.* from tbl_flat_info b where status !='' and booked_on between '".$f_date."' and '".$t_date."'";
$query = db_query($sql1);
while($data=mysqli_fetch_object($query)){ 

$collection = find_a_field('tbl_receipt','sum(rec_amount)','rec_date between "'.$f_date.'" and "'.$t_date.'" and fid="'.$data->fid.'"');
$g_coll += $collection;
?>

<tr>
<td><?=++$op;?></td>
  <td><?=find_a_field('tbl_project_info','proj_name','proj_code='.$data->proj_code);?></td>
  <td>&nbsp;</td>
  <td><?=$data->fid;?></td>
  <td><?=$data->flat_no;?></td>
  <td><?=$data->party_code;?></td>
  <td><?=find_a_field('tbl_party_info','party_name','party_code="'.$data->party_code.'"');?></td>
  <td><?=$data->flat_size;?></td>
  <td><?=number_format($data->total_price,0); $g_price += $data->total_price;?></td>
  <td><?=number_format($collection,0);?></td>
  <td><?=$data->booked_on;?></td>
  <td><?=$data->sales_person;?></td>
  <td></td>
</tr>
<? } ?>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td><strong><?=number_format($g_price,0);?></strong></td>
  <td><strong><?=number_format($g_coll,0);?></strong></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
</tbody>
</table>

<? 
}
// end 70




elseif($_POST['report']==23){

$report="Party Fine Statement Report";


$sql_party='select p.party_name 
from tbl_flat_cost_installment i, tbl_party_info p
where i.party_code=p.party_code
and i.fid="'.$_POST['flat'].'" limit 1';

$client_name=find_a_field_sql($sql_party);
$fid=$_POST['flat'];


if(isset($proj_code)) 
if(!isset($fid))
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and d.proj_code='.$proj_code;}
else
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); 
$allotment_no=$fid; 
$allotment_name=find_a_field('tbl_flat_info','flat_no','fid="'.$_POST['flat'].'"');
$flat_show=',a.flat_no as allot_no'; 
$flat_con=' and d.proj_code='.$proj_code.' and d.fid=\''.$fid.'\' ';}

if($_POST['section_name']!=''){$section_con = ' and d.section_name="'.$_POST['section_name'].'"';}
if(isset($t_date)) 
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.inst_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

?>
<center>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}
td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 4px;
}
tr:nth-child(even) {
  background-color: #dddddd;
}
  </style>
</div>
<center>
<h4>Sajeeb Homes Ltd.</h4>
<h5>Delay Charge  Report</h5>
<h6>Allotment Details: <?=$project_name;?>, No: <?=$allotment_no;?>, Allotment: <?=$allotment_name;?></h6>
<h6>Client Name: <?=$client_name;?></h6>
</center><?
echo $report_time 	.= '</div><div class="date">Reporting Time: '.date("h:i A d-m-Y").'</div>'; ?>
<table width="100%" border="0" cellspacing="0" cellpadding="2">
<thead>
<tr>
  <th>S/L-23</th>
  <th>Installment</th>
  <th>Installmet No </th>
  <th>Installment Date  </th>
  <th>Last Deadline </th>
  <th>Delay %  </th>
  <th>Ins Amt  </th>
  <th>Delay Start Date</th>
  <th>Payable Amount </th>
  <th>Receive Date </th>
  <th>Delay's Days </th>
  <th>Receive Amt </th>
  <th>Outstanding</th>
  <th>Delay Amt </th>
  <th>Sub Total </th>
  <th>Get/Weave</th>
  <th>Net Fine </th>
  <th>Remarks</th>
  </tr>
</thead>
<tbody>
<?
$today_date = date('Y-m-d');
$sql="SELECT e.pay_desc as installment,
a.inst_no as installment_no,
a.pay_code,
c.proj_name as project_name,
b.party_name as client_name,
road_no as floor,
d.fid as allotment_no,
a.flat_no AS allotment, 
a.inst_date as installment_date, 
a.inst_amount as payable_amount, 
a.rcv_date as receive_date, 
a.rcv_amount AS receive_amount, 
(a.inst_amount-a.rcv_amount) as outstanding,d.fine_per
FROM 
tbl_flat_cost_installment a, 
tbl_party_info b, 
tbl_project_info c, 
tbl_flat_info d,
tbl_payment_head e

WHERE a.proj_code = c.proj_code
AND d.party_code = b.party_code
AND a.proj_code = d.proj_code
AND a.fid = d.fid
AND a.pay_code = e.pay_code".$proj_con.$date_con.$flat_con.$party_con.$section_con." order by a.inst_date,a.id";

$query = db_query($sql);
while($data= mysqli_fetch_object($query)){ 

$weave_amt = find_a_field('tbl_fine','sum(amount)','fid="'.$data->allotment_no.'" and inst_no="'.$data->installment_no.'" and  pay_code="'.$data->pay_code.'" ');
$installment=$data->installment;

$pay_code=$data->pay_code;
$payable_amount=$data->payable_amount;

$installment_no=$data->installment_no;
$allotment_no=$data->allotment_no;
$allotment = $data->allotment;
$installment_date = $data->installment_date;
$allotment_no=$data->allotment_no;
$fine_per=$data->fine_per;
$last_deadline = date('Y-m-d',strtotime($data->installment_date)+(24*60*60*5));
//&&($pay_code!=$old_pay_code||$old_installment_no!=$old_installment_no)
if($outstanding_amt>0)
{
$fine_date_start = $old_receive_date;
$fine_days = (int)((strtotime($today_date) - strtotime($fine_date_start))/(24*60*60));
$fine_amt = (int)((($payable_due*($fine_per/100))/30)*$fine_days);
$old_outstanding_amt = $payable_due;

?>
<tr><td><?=++$op;?></td>
  <td></td>
  <td></td>
  <td></td>
  <td><?=$old_last_deadline?></td>
  <td><?=$fine_per;?>%</td>
  <td><div align="right"><?=number_format($old_payable_amount,0);?></div></td>
  <td><?=$fine_date_start?></td>
  <td><div align="right"><?=number_format($payable_due,0)?></div></td>
  <td>&nbsp;</td>
  <td><?=$fine_days?></td>
  <td>&nbsp;</td>
  <td><div align="right"><?=number_format($outstanding_amt,0)?></div></td>
  <td><div align="right"><?=number_format($fine_amt,0); $grand_fine +=$fine_amt; $sub_grand_fine[$old_pay_code][$old_installment] +=$fine_amt; ?></div></td>
  <td align="right"><? echo $mhafuz_amt = $sub_grand_fine[$old_pay_code][$old_installment];?></td>
  <td><?=$weave_amt?></td>
  <td><? //=($sub_grand_fine[$old_pay_code][$old_installment]-$weave_amt);?></td>
  <td>&nbsp;</td>
</tr>
<?
$outstanding_amt = 0;
}

$old_installment=$installment;
$old_pay_code=$pay_code;
$old_payable_amount=$payable_amount;
$old_installment_no=$installment_no;
$old_allotment_no=$allotment_no;
$old_allotment = $allotment;
$old_installment_date = $installment_date;
$old_allotment_no=$allotment_no;
$old_fine_per=$fine_per;
$old_last_deadline = $last_deadline;

$old_receive_date = '';

$sql2="select a.rec_date as receive_date, b.rec_amount  
from tbl_receipt_details b, tbl_receipt a
where a.rec_no=b.rec_no and b.pay_code='".$data->pay_code."' 
and b.inst_no='".$data->installment_no."' 
and b.fid='".$data->allotment_no."'
order by a.rec_date
";

$query2 = db_query($sql2);
$receipt_count = mysqli_num_rows($query2);
if($receipt_count!=0){
$c=0;
while($info= mysqli_fetch_object($query2)){ $c++;


if($c==1) {$payable_due = $payable_amount; $fine_date_start=$installment_date;}
else $fine_date_start=$old_receive_date;

if((strtotime($info->receive_date)) <= (strtotime($last_deadline))){
$fine_days = 0;} else {
$fine_days = (int)((strtotime($info->receive_date) - strtotime($fine_date_start))/(24*60*60));
}
if($fine_days<0) $fine_days = 0;

$outstanding_amt =$payable_due - $info->rec_amount;
$fine_amt = (int)((($payable_due*($fine_per/100))/30)*$fine_days);

$old_receive_date = $info->receive_date;
?>
<tr><td><?=++$op;?></td>
  <td><?=$installment?></td>
  <td><?=$installment_no?></td>
  <td><?=$installment_date?></td>
  <td><?=$last_deadline?></td>
  <td><?=$fine_per;?>%</td>
  <td><div align="right"><?=number_format($payable_amount,0);?></div></td>
  <td><?=$fine_date_start?></td>
  <td><div align="right"><?=number_format($payable_due,0);?></div></td>
  <td><?=$info->receive_date?></td>
  <td><?=$fine_days?></td>
  <td><div align="right"><?=number_format($info->rec_amount,0);?></div></td>
  <td><div align="right"><?=number_format($outstanding_amt,0);?></div></td>
  <td><div align="right"><?=number_format($fine_amt,0); $grand_fine +=$fine_amt; $sub_grand_fine[$data->pay_code][$data->installment_no] +=$fine_amt;?></div></td>
  <td align="right"><?=($outstanding_amt==0)?$sub_grand_fine[$data->pay_code][$data->installment_no]:'';?><?  $mhafuz_amt = $sub_grand_fine[$data->pay_code][$data->installment_no]?></td>
  <td><?=($installment_no!='')?$weave_amt:''; 
  
  ?></td>
  <td><? //=($outstanding_amt==0)?($sub_grand_fine[$data->pay_code][$data->installment_no]-$weave_amt):'';?></td>
  <td></td>
</tr>
<? 
$payable_due = $payable_due - $info->rec_amount;
$installment='';
$installment_no='';
$installment_date='';
}
}else{
if($today_date<$last_deadline){
?>
<tr><td><?=++$op;?></td>
  <td><?=$installment?></td>
  <td><?=$installment_no?></td>
  <td><?=$installment_date?></td>
  <td><?=$last_deadline?></td>
  <td><?=$fine_per;?>%</td>
  <td><div align="right"><?=number_format($payable_amount,0);?></div></td>
  <td><?=$installment_date?></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td></tr>
<?
}
else{
$outstanding_amt =$payable_due =$payable_amount;
$fine_days = (int)((strtotime($today_date) - strtotime($installment_date))/(24*60*60));
$fine_amt = (int)((($payable_due*($fine_per/100))/30)*$fine_days);
?>
<tr>
  <td><?=++$op;?></td>
  <td><?=$installment?></td>
  <td><?=$installment_no?></td>
  <td><?=$installment_date?></td>
  <td><?=$last_deadline?></td>
  <td><?=$fine_per;?>%</td>
  <td><div align="right"><?=number_format($payable_amount,0);?></div></td>
  <td><?=$installment_date?></td>
  <td><div align="right"><?=number_format($payable_due,0);?></div></td>
  <td><?=$info->receive_date?></td>
  <td><?=$fine_days?></td>
  <td><div align="right"><?=number_format($info->rec_amount,0);?></div></td>
  <td><div align="right"><?=number_format($outstanding_amt,0);?></div></td>
  <td><div align="right"><?=number_format($fine_amt,0); $grand_fine +=$fine_amt; $sub_grand_fine[$data->pay_code][$data->installment_no] +=$fine_amt; $C=$fine_amt;?></div></td>
  <td align="right"><?  echo $mhafuz_amt = $sub_grand_fine[$data->pay_code][$data->installment_no];?></td>
  <td><?=$weave_amt?></td>
  <td><? //=($sub_grand_fine[$old_pay_code][$old_installment]-$weave_amt);?></td>
  <td>&nbsp;</td>
</tr>
<?
echo $sub_grand_fineM = $sub_grand_fine[$data->pay_code][$data->installment_no];
$outstanding_amt = 0;
}
}

}
if($outstanding_amt>0)
{
$fine_date_start = $old_receive_date;
$fine_days = (int)((strtotime($today_date) - strtotime($fine_date_start))/(24*60*60));
$fine_amt = $fine_amt1 = (int)((($payable_due*($fine_per/100))/30)*$fine_days);
$old_outstanding_amt = $payable_due;
//$fine_amt = $fine_amt + $fine_amt1;
$sub_grand_fine[$old_pay_code][$old_installment_no] = $sub_grand_fine[$old_pay_code][$old_installment_no] + $fine_amt1;
echo $data->installment_no;
?>
<tr><td><?=++$op;?></td>
  <td></td>
  <td></td>
  <td></td>
  <td><?=$old_last_deadline?></td>
  <td><?=$fine_per;?>%</td>
  <td><div align="right"><?=number_format($old_payable_amount,0);?></div></td>
  <td><?=$fine_date_start?></td>
  <td><div align="right"><?=number_format($payable_due,0)?></div></td>
  <td>&nbsp;</td>
  <td><?=$fine_days?></td>
  <td>&nbsp;</td>
  <td><div align="right"><?=number_format($outstanding_amt,0)?></div></td>
  <td><div align="right"><?=number_format($fine_amt1,0); $grand_fine +=$fine_amt1;  ?></div></td>
  <td align="right"><?  echo $mhafuz_amt = $mhafuz_amt+$fine_amt;?></td>
  <td><?=$weave_amt?></td>
  <td><? //=($sub_grand_fine[$data->pay_code][$data->installment_no]-$weave_amt);?></td>
  <td>&nbsp;</td>
</tr>
<?
$outstanding_amt = 0;
}

/*if($outstanding_amt>0){
?>
<tr><td><?=++$op;?></td>
  <td><?=$installment?></td>
  <td><?=$installment_no?></td>
  <td><?=$installment_date?></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td><? //echo $sub_grand_fineM?></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td></tr>
<?
}*/
?>

<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td><strong><div align="right">Total</div></strong></td>
  <td><strong><div align="right"><?=number_format($grand_fine,0)?></div></strong></td>
  <td></td>
  <td><strong><div align="center"><? $weave_amt_total = find_a_field('tbl_fine','sum(amount)','fid="'.$fid.'" ');
echo number_format($weave_amt_total,0);
?>  </div></strong>
  </td>
  <td><strong><div align="right"><?=number_format(($grand_fine-$weave_amt_total),0)?></div></strong></td>
  <td></td>
</tr>
</tbody>
</table>
<table width="100%" border="0">
  <tr>
    <th><p></th>
    <th></th>
    <th></th>
    <th></th>
  </tr>
  <tr>
    <th scope="col"><div align="center">__________________</div></th>
    <th scope="col"><div align="center">__________________</div></th>
    <th scope="col"><div align="center">__________________</div></th>
    <th scope="col"><div align="center">__________________</div></th>
  </tr>
  <tr>
    <td><div align="center">Accounts</div></td>
    <td><div align="center">Head of Project </div></td>
    <td><div align="center">Director</div></td>
    <td><div align="center">Chairman</div></td>
  </tr>
</table>

<? 
} // end 23





// ---------------- end page
elseif(isset($sql)&&$sql!='') echo report_create($sql,1,$str);
?>
</div>
</body>
</html>



<?
$page_name= $_POST['report'].$report."(Master Report Page)";
require_once SERVER_CORE."routing/layout.report.bottom.php";
?>

