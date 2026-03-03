<?



session_start();



require "../../common/check.php";



require "../../config/db_connect.php";



require "../../common/report.class.php";



require "../../common/my.php";



date_default_timezone_set('Asia/Dhaka');







//var_dump($_POST);



if(isset($_POST['submit'])&&isset($_POST['report'])&&$_POST['report']>0)



{



	if($_POST['proj_code']>0)



	{



		$proj_code=$_POST['proj_code'];



		if($_POST['fid']!='')



	    $fid=$_POST['fid'];



	    elseif($_POST['flat']!='')



	    $fid=$_POST['flat'];







	}



	if((strlen($_POST['t_date'])==10)&&(strlen($_POST['f_date'])==10))



	{



	$t_date=$_POST['t_date'];



	$f_date=$_POST['f_date'];



	}



	if($_POST['party_code']>0)



	$party_code=$_POST['party_code'];



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



		







        $sql="SELECT a.proj_code as project_code, x.proj_name as project_name,







 







 



(select sum(d.flat_size) from `tbl_flat_info` d where a.proj_code=d.proj_code and status='booked') as sold_katha,



(select sum(d.flat_size) from `tbl_flat_info` d where a.proj_code=d.proj_code and (status!='booked' or status is NULL)) as unsold_kata,











(select sum(inst_amount) from tbl_flat_cost_installment e where a.proj_code=e.proj_code) as so_far_sale_value,



(select sum(rcv_amount) from tbl_flat_cost_installment e where a.proj_code=e.proj_code) as so_far_receive_value,



(select sum(inst_amount)-sum(rcv_amount) from tbl_flat_cost_installment e where a.proj_code=e.proj_code) as balance_amount



FROM tbl_flat_info a,tbl_project_info x



where a.proj_code=x.proj_code ".$proj_con."



group by a.proj_code";



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











 $sql="SELECT b.proj_name,(select section_name from add_section where section_id=a.section_name) as section_name,road_no,a.flat_no as Plot_No,a.flat_size as Plot_Size,a.total_price,a.status,a.booked_on,c.party_code as customer_id,c.party_name as Customer_name FROM `tbl_flat_info` a,tbl_project_info b,tbl_party_info c, add_section s WHERE a.section_name=s.section_id and a.proj_code=b.proj_code and a.party_code=c.party_code ".$proj_con.$date_con.$flat_con.$party_con.$section_con.$flat_con;



	



	



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











$sql="select c.proj_name,a.flat_no as flot_name,b.section_name, d.party_name as customer_name ,sum(a.inst_amount) as total_payable,sum(a.rcv_amount) as total_received,(sum(a.inst_amount)*.25) as total_percentage from tbl_flat_cost_installment a, add_section b, tbl_project_info c, tbl_party_info d, tbl_flat_info e where  1 and a.fid=e.fid  and e.status!='Sold' and a.section_name=b.section_id and a.proj_code=c.proj_code and a.party_code=d.party_code  ".$proj_con.$date_con.$flat_con.$party_con.$section_con.$flat_con." group by a.flat_no having total_percentage < total_received ";







	



	



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











$sql="SELECT b.proj_name,(select section_name from add_section where section_id=a.section_name) as section_name,road_no,a.flat_no as Plot_No,a.flat_size as Plot_Size,a.total_price,c.party_code as customer_id,c.party_name as Customer_name FROM `tbl_flat_info` a,tbl_project_info b,tbl_party_info c, add_section s WHERE STATUS='Sold' and a.section_name=s.section_id and a.proj_code=b.proj_code and a.party_code=c.party_code ".$proj_con.$date_con.$flat_con.$party_con.$section_con.$flat_con;



	



	



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











  $sql="select b.party_name,b.ah_mobile_tel,(sum(a.inst_amount)) as total_amt from tbl_flat_cost_installment a, tbl_party_info b where 1 and a.party_code=b.party_code  ".$proj_con.$date_con.$flat_con.$party_con.$section_con.$flat_con." group by a.party_code having (sum(a.inst_amount))<5000001 ORDER BY total_amt desc";



	



	



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



	$report="Flat Status & Price Configaration";



		if(isset($proj_code)) 



		if(!isset($fid))



{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and a.proj_code='.$proj_code;}



		else



{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); 



$allotment_no=$fid; $flat_show=',a.flat_no as Plot_no'; $flat_con=' and a.proj_code='.$proj_code.' and a.fid=\''.$fid.'\' ';}



		if(isset($t_date)) 



{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.booked_on between \''.$fr_date.'\' and \''.$to_date.'\'';}



	$sql="SELECT b.proj_name,a.flat_no as Plot_no,a.flat_size as Plot_size,a.sqft_price,a.unit_price,a.disc_price,a.utility_price,a.oth_price,a.park_price,a.bank_loan,a.total_price,a.status,a.booked_on FROM `tbl_flat_info` a,tbl_project_info b WHERE a.proj_code=b.proj_code ".$proj_con.$date_con.$flat_con;



		break;



    case 4:



	$report="Project Information";



		if(isset($proj_code)) 



{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con='proj_code='.$proj_code;}



else $proj_con=1;







	$sql="SELECT * FROM `tbl_project_info` WHERE 1".$proj_con;



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



		



		if(isset($proj_code)){$proj_con = " and c.proj_code='".$proj_code."'";};



		



		if(isset($fid)){$fid_con = " and c.fid='".$fid."'";};



		



		if($_POST['section_name']!=''){$section_con = " and c.section_name='".$_POST['section_name']."'";};



		if($_POST['flat']!=''){$section_con = " and c.flat_no='".$_POST['flat']."'";};



		



		if(isset($t_date)) 



{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.rec_date between \''.$fr_date.'\' and \''.$to_date.'\'';}















	 $sql="select b.proj_name".$flat_show.",d.section_name,a.flat_no as Plot_no,a.rec_date as tr_date,a.cheq_no,a.rec_no as MRN,a.manual_no as Manual_MRN,a.bank_name,a.rec_amount as total_amt from tbl_receipt a,tbl_project_info b,tbl_flat_info c, add_section d where c.section_name=d.section_id and c.fid=a.fid and c.proj_code=b.proj_code ".$proj_con.$section_con.$date_con.$flat_con." order by Manual_MRN";



		break;



		



		



		



		case 7:



		



		$report="Payment Statement";



		if($_POST['f_date']!=''){ $report.='<h1 style="text-align: center; font-size: 15px;">Date Interval : '.$_POST['f_date'].' To '.$_POST['t_date'].'</h1><br><br>'; }



		



		



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



if($_POST['section_name']!=''){$section_con = ' and d.section_name="'.$_POST['section_name'].'"';}











echo $s="SELECT a.fid, a.`rec_date`,a.`rec_no` as m_r_no,a.`manual_no` as voucher_no,b.proj_name,road_no,a.flat_no as plot_no,(select section_name from add_section where section_id=d.section_name) as section_name,c.party_name,sum(a.`rec_amount`) as rec_amount,(select sum(rcv_amount) from tbl_flat_cost_installment where fid=a.fid group by fid) as flat_cost,



a.`bank_name` as detail







FROM tbl_receipt a, tbl_party_info c,tbl_project_info b, tbl_flat_info d   







WHERE b.proj_code=d.proj_code and d.fid=a.fid and a.party_code=c.party_code ".$proj_con.$date_con.$section_con.$flat_con.$party_con.$mr_con.' group by a.fid order by a.fid ';







$query = mysql_query($s);







echo '<h1 style="text-align: center; margin-top: 20px; ">Modhu City</h1><h3 style="text-align: center;">'.$report.'</h3>';



echo '<table cellpadding="2" cellspacing="0" width="100%" border="1">







<tr style="border-top: 1px solid black;"><td><strong>S/L</strong></td><td><strong>Fid</strong></td><td><strong>Rec Date</strong></td><td><strong>M R No</strong></td><td><strong>Manual No</strong></td><td><strong>Party Name</strong></td><td><strong>Project Name</strong></td><td><strong>Road No</strong></td><td><strong>Plot No</strong></td><td><strong>Section Name</strong></td><td><strong>Received Amount</strong></td><td><strong>Received flat cost</strong></td><td><strong>Difference</strong></td><td><strong>Detail</strong></td></tr>';







$s = 1;



while($r = mysql_fetch_object($query)){



if($r->detail==''){$b_type = 'Cash';}else{ $b_type = $r->detail; };







echo '<tr><td>'.$s++.'</td><td>'.$r->fid.'</td><td>'.$r->rec_date.'</td><td><a href="../../common/voucher_print_report.php?rec_no='.$r->m_r_no.'" target="_blank">'.$r->m_r_no.'</a></td><td>'.$r->voucher_no.'</td><td>'.$r->party_name.'</td><td>'.$r->proj_name.'</td><td>'.$r->road_no.'</td><td>'.$r->plot_no.'</td><td>'.$r->section_name.'</td><td>'.number_format($r->rec_amount).'</td><td>'.number_format($r->flat_cost).'</td><td>'.number_format($r->rec_amount-$r->flat_cost).'</td><td>'.$b_type.'</td></tr>';







$tot_rec_amt += $r->rec_amount;

$tot_flat_amt += $r->flat_cost;

}































echo '



<tr><td colspan="9"></td><td align="right"><b>Total : </b></td><td><b>'.number_format($tot_rec_amt).'</b></td><td><b>'.number_format($tot_flat_amt).'</b></td><td></td></tr>



</table>';



















		break;



		



		



		



			case 70:



		



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



{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.rcv_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



if($_POST['section_name']!=''){$section_con = ' and d.section_name="'.$_POST['section_name'].'"';}


if($_POST['party_code']!=''){$party_con = ' and a.party_code="'.$_POST['party_code'].'" ';}








 $sql=" SELECT a.party_code,(select party_name from tbl_party_info where party_code=a.party_code) as party_name ,SUM(a.inst_amount) as total_price, SUM(a.rcv_amount) as received_amount,(SUM(a.inst_amount)-SUM(a.rcv_amount)) as receivable_amount   FROM tbl_flat_cost_installment a WHERE 1 ".$party_con." group by a.fid order by party_code";











































		break;



		



		



		



		case 700:



		



		$report="Sales Summary Report";



		if($_POST['f_date']!='' && $_POST['t_date']!=''){



		$report.= '<h1 style="text-align: center; font-size: 15px;">Date Interval : '.$_POST['f_date'].' To '.$_POST['t_date'].'</h1>';



		}



		



		if($_POST['proj_code']!=''){ $proj_con = ' and b.proj_code= "'.$_POST['proj_code'].'" ';}



		if($_POST['section_name']!=''){ $section_con = ' and b.section_name= "'.$_POST['section_name'].'" ';}



	if($_POST['f_date']!='' && $_POST['t_date']!=''){ $date_con = " and a.rcv_date  between '".$_POST['f_date']."' and '".$_POST['t_date']."'"; $interval = 'Date Interval: '.$_POST['f_date'].' To '.$_POST['t_date'].'';}











 $sqll="select a.fid,a.flat_no,sum(b.flat_size) as tot_f,b.road_no,b.party_code from tbl_flat_cost_installment a, tbl_flat_info b where 1 and a.fid=b.fid and a.pay_code='99' and b.flat_size!='0' and a.rcv_amount!='0' ".$date_con.$proj_con.$section_con."  group by a.fid order by a.fid";







$query = mysql_query($sqll);







echo '<h1 style="text-align: center; margin-top: 30px; ">Sales Summary Report</h1> <h2 style="text-align: center;">'.$interval.'</h2>';







echo '<table cellpadding="2" cellspacing="0" width="100%" border="1" style="margin-top: 50px;">';







echo '<tr style="text-align: center; font-size: 14px; font-weight: bold;"><td style="padding: 5px;">fid</td><td style="padding: 5px;">Flat Size</td><td style="padding: 5px;">Total Price</td><td style="padding: 5px;">Received Amount</td><td>Pending Amount</td></tr>';







while($row = mysql_fetch_object($query)){











$sql2 = "select fid, sum(inst_amount) as total_amt, sum(rcv_amount) as total_rcv_amount from tbl_flat_cost_installment where 1 and fid='".$row->fid."' group by fid";







$q =  mysql_query($sql2);



while($r = mysql_fetch_object($q)){







echo '<tr><td>'.$row->fid.'</td><td>'.$row->tot_f.'</td><td>'.$r->total_amt.'</td><td>'.$r->total_rcv_amount.'</td><td>'.$pending = ($r->total_amt-$r->total_rcv_amount).'</td></tr>';















$tot_f_amt +=$r->total_amt;



$tot_rcv_amt +=$r->total_rcv_amount;



$tot_pending +=$pending;



}







$tot_flat_size +=$row->tot_f;



}







echo '<tr style="font-weight: bold;"><td>Total </td><td>'.$tot_flat_size.'</td><td>'.$tot_f_amt.'</td><td>'.$tot_rcv_amt.'</td><td>'.$tot_pending.'</td></tr>';



echo '</table>';































		break;



		



		



		



	case 11:



        $report="Outstanding Dues";



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



{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.inst_date between \''.$fr_date.'\' and \''.$to_date.'\'';}







		 $sql="select c.proj_name as project_name,a.flat_no as Plot_no,CONCAT('R.No - ',road_no) as road_no,(select section_name from add_section where section_id=a.section_name) as section_name,b.party_name as client_name,a.inst_date as installment_date, a.inst_amount as payable_amt,a.rcv_amount as received_amt 



		



		from tbl_flat_cost_installment a, tbl_party_info b, tbl_project_info c,tbl_flat_info d 



		



		where a.proj_code=c.proj_code and d.party_code=b.party_code 



		and a.fid=d.fid and rcv_status=0 ".$proj_con.$date_con.$section_con.$flat_con.$party_con." order by a.inst_date";



		break;



	case 12:



        $report="Expected Collection";



if(isset($proj_code)) 



		if(!isset($fid))



		



{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and a.proj_code='.$proj_code;}















		else



{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); 



$allotment_no=$fid; $flat_show=',a.flat_no as Plot_no'; $flat_con=' and a.proj_code='.$proj_code.' and a.fid=\''.$fid.'\' ';}



		if(isset($party_code))



{$client_name=find_a_field('tbl_party_info','party_name','party_code='.$party_code); $party_con=' and b.party_code='.$party_code;}







		if(isset($t_date)) 



{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.inst_date between \''.$fr_date.'\' and \''.$to_date.'\'';}











if($_POST['section_name']!=''){$section_con = ' and s.section_id="'.$_POST['section_name'].'"';};







	 echo $sql="select b.party_name as client_name, c.proj_name as project_name, (select section_name from add_section where section_id=a.section_name) as section_name, road_no, a.flat_no as Plot_no, a.inst_date as installment_date,a.inst_amount as payable_amt, a.rcv_amount as received_amt,a.`rec_no` as m_r_no 



		



		from tbl_flat_cost_installment a,add_section s, tbl_party_info b, tbl_project_info c,tbl_flat_info d 



		



		where a.section_name=s.section_id and a.proj_code=c.proj_code and a.party_code=b.party_code and a.proj_code=d.proj_code and a.fid=d.fid ".$proj_con.$date_con.$section_con.$flat_con.$party_con." order by a.inst_date";



		break;



		



		



   



	case 13:



        $report="Payment Schedule";



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



		$sql="SELECT e.pay_desc,a.inst_no,c.proj_name AS project_name,a.flat_no AS Plot_no,road_no,(select section_name from add_section where section_id=a.section_name) as section_name,  a.inst_date, a.inst_amount AS payable_amt, a.rcv_date AS receive_date, a.rcv_amount AS receive_amt



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



		$sql="select d.party_code, d.party_name, a.rec_date as transaction_date,b.proj_name as project_name".$flat_show.", c.flat_no as plot_no, c.road_no, a.rec_amount as total_amt from tbl_receipt a,tbl_project_info b,tbl_flat_info c,tbl_party_info d where a.party_code=d.party_code and c.fid=a.fid and a.pay_mode=0 and c.proj_code=b.proj_code ".$proj_con.$date_con.$flat_con." order by a.rec_date";



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



	 $sql="select d.party_name".$flat_show.", a.rec_date as tr_date,a.cheq_no,a.cheq_date,b.proj_name, c.flat_no as plot_no, c.road_no, sum(a.rec_amount) as total_amt from tbl_receipt a,tbl_project_info b,tbl_flat_info c,tbl_party_info d where a.party_code=d.party_code and c.fid=a.fid and a.pay_mode=1 and c.proj_code=b.proj_code ".$proj_con.$date_con.$flat_con." group by a.cheq_no order by a.rec_date";



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



	 $sql="SELECT i.fid,b.proj_name,a.flat_no as Plot_no,a.flat_size as Plot_size,(select section_name from add_section where section_id=a.section_name) as section_name,i.sr_executive_commission,i.team_leader_commission,i.group_leader_commission,i.other_commission,



	  



	(i.sr_executive_commission+i.team_leader_commission+i.group_leader_commission+i.other_commission) as total_commission,

	

	((i.rcv_amount/100)*1) as sr_com,

	

	((i.sr_executive_commission+i.team_leader_commission+i.group_leader_commission+i.other_commission)-((i.rcv_amount/100)*1)) as diff,

	

	sum(i.rcv_amount) as receive_amount,

	

	

	a.total_price,(select PBI_NAME from personnel_basic_info where PBI_ID=c.sr_executive) as sr_executive_name,(select PBI_NAME from personnel_basic_info where PBI_ID=c.team_leader) as team_leader,(select PBI_NAME from personnel_basic_info where PBI_ID=c.group_leader) as group_leader, a.status,a.booked_on,c.party_name FROM `tbl_flat_info` a,tbl_project_info b,tbl_party_info c,tbl_flat_cost_installment i WHERE (i.sr_executive_commission+i.team_leader_commission+i.group_leader_commission+i.other_commission)!='' and a.party_code=i.party_code and a.proj_code=b.proj_code and a.party_code=c.party_code ".$proj_con.$date_con.$flat_con.$party_con." group by i.id";



	



	break;



	



	



	 case 1111:



		$report="Sr Commission Report ";



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















	 $sql="SELECT b.proj_name,(select section_name from add_section where section_id=a.section_name) as section_name,a.flat_no as Plot_no,a.flat_size as Plot_size,(select PBI_NAME from personnel_basic_info where PBI_ID=c.sr_executive) as sr_executive_name,i.sr_executive_commission,i.rcv_amount as receive_amount,a.total_price, a.status,a.booked_on,c.party_name FROM `tbl_flat_info` a,tbl_project_info b,tbl_party_info c,tbl_flat_cost_installment i WHERE i.sr_executive_commission!='' and  a.party_code=i.party_code and a.proj_code=b.proj_code and a.party_code=c.party_code ".$emp_con.$proj_con.$date_con.$flat_con.$party_con." group by i.id";



	



	break;



		



		



		case 1112:



		$report="Team Leader Commission Report ";



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















	  $sql="SELECT b.proj_name,(select section_name from add_section where section_id=a.section_name) as section_name,a.flat_no as Plot_no,a.flat_size as Plot_size,(select PBI_NAME from personnel_basic_info where PBI_ID=c.team_leader) as team_leader,i.team_leader_commission,i.other_commission,i.rcv_amount as receive_amount,a.total_price, a.status,a.booked_on,c.party_name FROM `tbl_flat_info` a,tbl_project_info b,tbl_party_info c,tbl_flat_cost_installment i WHERE i.team_leader_commission!='' and  a.party_code=i.party_code and a.proj_code=b.proj_code and a.party_code=c.party_code ".$emp_con.$proj_con.$date_con.$flat_con.$party_con." group by i.id";



	



	break;



	



	



	



	case 1113:



		$report="Group Leader Commission Report ";



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















	 $sql="SELECT b.proj_name,(select section_name from add_section where section_id=a.section_name) as section_name,a.flat_no as Plot_no,a.flat_size as Plot_size,(select PBI_NAME from personnel_basic_info where PBI_ID=c.group_leader) as group_leader,i.group_leader_commission,i.other_commission,i.rcv_amount as receive_amount, a.total_price, a.status,a.booked_on,c.party_name FROM `tbl_flat_info` a,tbl_project_info b,tbl_party_info c,tbl_flat_cost_installment i WHERE  i.group_leader_commission and a.party_code=i.party_code and a.proj_code=b.proj_code and a.party_code=c.party_code ".$emp_con.$proj_con.$date_con.$flat_con.$party_con." group by i.id";



	



	break;



		



		



		//ROW_NUMBER() OVER(ORDER BY Id) AS Row



}



}







?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">











<html xmlns="http://www.w3.org/1999/xhtml">



<head>



<meta http-equiv="content-type" content="text/html; charset=utf-8" />



<title><?=$report?></title>



<link href="../../css/report.css" type="text/css" rel="stylesheet" />



<script language="javascript">



function hide()



{



document.getElementById('pr').style.display='none';



}



</script>



</head>



<body>



<div align="center" id="pr">



<input type="button" value="Print" onclick="hide();window.print();"/>



</div>



<div class="main">



<?



		$str 	.= '<div class="header">';



		if(isset($_SESSION['company_name'])) 



		$str 	.= '<h1>'.$_SESSION['company_name'].'</h1>';



		if(isset($report)) 



		$str 	.= '<h2>'.$report.'</h2>';



		if(isset($to_date)) 



		$str 	.= '<h2>'.$fr_date.' To '.$to_date.'</h2>';



		$str 	.= '</div>';



		if(isset($_SESSION['company_logo'])) 



		//$str 	.= '<div class="logo"><img height="60" src="'.$_SESSION['company_logo'].'"</div>';



		$str 	.= '<div class="left">';



		if(isset($project_name)) 



		$str 	.= '<p>Project Name: '.$project_name.'</p>';



		if(isset($allotment_no)) 



		$str 	.= '<p>Allotment No.: '.$allotment_no.'</p>';



		$str 	.= '</div><div class="right">';



		if(isset($client_name)) 



		$str 	.= '<p>Client Name: '.$client_name.'</p>';



		$str 	.= '</div><div class="date">Reporting Time: '.date("h:i A d-m-Y").'</div>';







if(isset($sql)&&$sql!='') echo report_create($sql,1,$str);



?></div>



</body>



</html>











