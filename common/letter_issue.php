<?php
session_start();
function address_code($proj_code='',$flat_no='',$party_code='')
{
$con='';
if($proj_code>0) $con.=" and b.proj_code='".$proj_code."'";
if($flat_no!='') $con.=" and b.flat_no='".$flat_no."'";
if($party_code>0) $con.=" and b.party_code='".$party_code."'";
$sql="select a.* from tbl_party_info a, tbl_flat_info b where a.party_code=b.party_code and a.party_code>0 ".$con." group by party_code";
$query=mysql_query($sql);
$count=0;
$letter_content='';
if(mysql_num_rows($query)>0)
{
$letter_content .= '<table width="60%" border="0" cellspacing="0" cellpadding="0" align="center"><tr>';
while($data=mysql_fetch_object($query))
{
$count++;
$letter_content .= '<td width="50%"><table width="100%" height="100px" border="1" cellspacing="5" cellpadding="10"><tr><td>';
$letter_content .= '<b>'.$data->party_name.', </b><br>'.$data->per_add;
$letter_content .= '</p></td></tr></table></td>';
if($count==2) {$count=0;$letter_content .='</tr><tr>';}
}
$letter_content .= '</tr></table>';
}
return $letter_content;
}
function offer_letter($date='',$name='',$address='',$company_name='')
{
$letter_content= '<table width="100%" border="0" cellpadding="2" cellspacing="0" align="center">
        <caption>
        Date:
        </caption>
        <thead>
            <tr>
                <th><table width="20%" border="0" cellspacing="0" cellpadding="0" align="left">
                  <tr>
                    <td>Manual Name</td>
                  </tr>
                  <tr>
                    <td><a href="#">Address</a></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                </table></th>
            </tr>
        </thead>
       
        <tbody>
            <tr><td>&nbsp;</td></tr>
            <tr>
              <td>Subject: <span class="sub"> Exclusive Shop/ Office space in '.$_SESSION['company_name'].' </span></td>
            </tr>
            <tr><td>&nbsp;</td></tr>            
            <tr><td>Dear Sir/Madam</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>Thank you very much for sparing your valuable time and generous courtesy shown by you during telephonic discussion with the under signed regarding the above-mentioned developments. It is an immense pleasure to discuss such a personality and also thanks for showing interest on '.$_SESSION['company_name'].'`s prestigious developments.</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>Brochure, Price List and latest booking chart are attached herewith for your kind perusal. We value your ideas, opinions and suggestions if any in this regard which are always welcome.</td></tr>
		    <tr><td>&nbsp;</td></tr>
		    <tr><td>Thanking you again</td></tr>
		    <tr>
		      <td>And assuring you our best services and cooperation always</td>
	      </tr>
		    <tr>
		      <td>&nbsp;</td>
	      </tr>
		    <tr>
		      <td>Very Truly Yours</td>
	      </tr>
		  <tr>
		      <td>For <strong>'.$_SESSION['company_name'].'</strong></td>
	      </tr>
		    <tr><td style="padding-left:0px; text-align:left;"><table width="25%" border="0" cellspacing="0" cellpadding="0" align="left">
              <tr>
                <td>Name & Design</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td></tr>
           </tbody>
		   
		   <tfoot>
		   </tfoot>
    </table>';
	return $letter_content;
}
function pay_due_installment()
{
$letter_content= '<table width="100%" border="0" cellpadding="2" cellspacing="0" align="center">
        <caption>
        Date:
		<br />
		Ref: Ref: '.$_SESSION['company_name'].'/ CSD/GDN/07/06
        </caption>
        <thead>
            <tr>
                <th>
				<table width="20%" border="0" cellspacing="0" cellpadding="0" align="left">
                  <tr>
                    <td>To,</td>
                  </tr>
                  <tr>
                    <td><a href="#"><strong>Nasreen Sultana</strong></a></td>
                  </tr>
                  <tr>
                    <td>Apartment no. A-3</td>
                  </tr>
                  <tr>
                    <td>'.$_SESSION['company_name'].' GARDEN</td>
                  </tr>
                </table>				</th>
            </tr>
        </thead>
       
        <tbody>
            <tr><td>&nbsp;</td></tr>
            <tr>
              <td>Subject: <span class="sub"> Request to pay your Dues installment (Including July)</span></td>
            </tr>
            <tr><td>&nbsp;</td></tr>            
            <tr><td>Assalamu Alaikum.</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>We are very happy to have you as a valued client of our project <strong>'.$_SESSION['company_name'].' GARDEN</strong> at Wari, Dhaka, as well as well – wisher of our company.</td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <tr>
              <td>From our Customer Service Department we would like to inform you that, there is an amount of <strong>TK. 162000</strong> only dues against your apartment No. <strong>A-3</strong> but till now we haven’t received that amount. Now you are requested to pay the mentioned amount within<strong> August 05, 2006</strong> for which we shall be thankful to you, other wise we will have no other options but compelled to take necessary action as per company rules and regulation.</td>
            </tr>
		    <tr><td>&nbsp;</td></tr>
		    <tr><td>Please disregard this letter if you have already paid the mentioned amount.</td></tr>
		    <tr>
		      <td>&nbsp;</td>
	      </tr>
		    <tr>
		      <td>Thanking you with best regards.  </td>
	      </tr>
		    <tr>
		      <td>&nbsp;</td>
	      </tr>
		    <tr>
		      <td>Sincerely yours,</td>
	      </tr>
		    <tr><td style="padding-left:0px; text-align:left;"><table width="20%" border="0" cellspacing="0" cellpadding="0" align="left">
              <tr>
                <td>On behalf of  '.$_SESSION['company_name'].'</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td></tr>
		    <tr><td>&nbsp;</td></tr>
           </tbody>
		   
		   <tfoot>
		   <tr>
		   <td class="title1">(Head of Marketing) </td>
		   </tr>
		   </tfoot>
    </table>';
	return $letter_content;
}
function possession_letter()
{
$letter_content= '<table width="100%" border="0" cellpadding="2" cellspacing="0" align="center">
         <caption>
        Date:
		<br />
		Ref: 
        </caption>
        <thead>
            <tr>
                <th class="title">POSSESSION LETTER</th>
            </tr>
        </thead>
       
        <tbody>
            <tr><td>&nbsp;</td></tr>
            <tr><td><strong>I, Engr. Md. Eskander Ali Khan, Managing Director of '.$_SESSION['company_name'].'</strong> have the pleasure to handover the possession of the following apt shop containing size 6887 sft at floor including proportionate undivided and undemacated share of land at “'.$_SESSION['company_name'].' Elysiumproject” in habitable condition in all respect.</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>THAT, After handover the possession of the shop, the owners shall pay all kinds of service charges of their respective shops and '.$_SESSION['company_name'].' shall not be responsible for any such payment.</td></tr>
		    <tr><td>&nbsp;</td></tr>
		    <tr><td>All kinds of utility i.e. Electricity, Gas and WASA Bill shall be paid by the apartment shop owners from the data of taking-over the possession of the shops.</td></tr>
		    <tr>
		      <td>&nbsp;</td>
	      </tr>
		    <tr>
		      <td>After taking-over the possession of the apt shop owners may do some carpentry works or any other works at their own risk. If any damages occur (i.e. damages/cracks in floor tiles, wall painting or any other fitting fixtures or etc.) due to mishandle/misuse of  the above-mentioned work, '.$_SESSION['company_name'].' will not be responsible for such damages.</td>
	      </tr>
		    <tr>
		      <td>&nbsp;</td>
	      </tr>
		    <tr>
		      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td valign="top" width="50%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td>Possession Handed-over by:</td>
                    </tr>
                    <tr>
                      <td><strong>Engr. Md. Eskander Ali Khan</strong></td>
                    </tr>
                    <tr>
                      <td>Managing Director</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>Witness:</td>
                    </tr>
                    <tr>
                      <td>1. Marketing Department</td>
                    </tr>
                    <tr>
                      <td>2. Engineering Department</td>
                    </tr>
                    <tr>
                      <td>3. Accounts Department</td>
                    </tr>
                  </table></td>
                  <td valign="top" width="50%">
				  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td>Possession Taken-over by:</td>
                    </tr>
                    <tr>
                      <td><strong>1.Afser Jahan Siddiqi</strong></td>
                    </tr>
					<tr>
                      <td><strong>2. Gulerana Siddiqui</strong></td>
                    </tr>
					<tr>
                      <td><strong>3. Mr. Mushfiqua Siddiui</strong></td>
                    </tr>
                  </table>
				  </td>
                </tr>
              </table></td>
	      </tr>
		  <tr>
		      <td>&nbsp;</td>
	      </tr>
		    <tr><td style="padding-left:0px; text-align:left;">&nbsp;</td></tr>
           </tbody>
		   
		   <tfoot>
		   </tfoot>
    </table>';
	return $letter_content;
}
function due_installment()
{
$letter_content= '<table width="100%" border="0" cellpadding="2" cellspacing="0" align="center">
        <caption>
        Date:
		<br />
		Ref: CSD/GDN/A-15/05/06
        </caption>
        <thead>
            <tr>
                <th>
				<table width="20%" border="0" cellspacing="0" cellpadding="0" align="left">
                  <tr>
                    <td>To,</td>
                  </tr>
                  <tr>
                    <td><a href="#"><strong>Mrs. Salma Ahmed</strong></a></td>
                  </tr>
                  <tr>
                    <td>Apartment no. A-15</td>
                  </tr>
                  <tr>
                    <td>'.$_SESSION['company_name'].' GARDEN</td>
                  </tr>
                </table>				</th>
            </tr>
        </thead>
       
        <tbody>
            <tr><td>&nbsp;</td></tr>
            <tr>
              <td>Subject: <span class="sub"> Request to pay your Dues installment.</span></td>
            </tr>
            <tr><td>&nbsp;</td></tr>            
            <tr><td>Assalamu Alaikum.</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr>
              <td>We are very happy to have you as a valued client of our project <strong>'.$_SESSION['company_name'].' GARDEN</strong> at <strong>Wari, Dhaka.</strong> as well as well – wisher of our company.</td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <tr>
              <td>It is very regret for us to inform you that, there is an outstanding amount of   <strong>TK. 162000/=</strong> Installment of 6 Month @ 15,139 only dues against your apartment No. <strong>A-3</strong> </td>
            </tr>
		    <tr><td>&nbsp;</td></tr>
		    <tr><td>what has been informed you several times over phone & official letter but till now we haven’t received that amount even you did not show proper response to us.</td></tr>
		    <tr>
		      <td>&nbsp;</td>
	      </tr>
		    <tr>
		      <td>So once again, you are requested to pay the mentioned amount within  <strong>September 07, 2006</strong> for which we shall be thankful to you, other wise we will have no other options but compelled to cancel your apartment & take necessary action as per company rules and regulations and then 10% total price will be deducted from your deposited amount as service charge.  You will have no any claim on this apartment after <strong>15th September 2006.</strong></td>
	      </tr>
		    <tr>
		      <td>&nbsp;</td>
	      </tr>
		    <tr>
		      <td>Please disregard this letter if you have already paid the mentioned amount.</td>
	      </tr>
		    <tr>
		      <td>&nbsp;</td>
	      </tr>
		    <tr>
		      <td>Thanking you with best regards.  </td>
	      </tr>
		    <tr>
		      <td>&nbsp;</td>
	      </tr>
		    <tr>
		      <td>Sincerely yours,</td>
	      </tr>
		    <tr><td style="padding-left:0px; text-align:left;"><table width="20%" border="0" cellspacing="0" cellpadding="0" align="left">
              <tr>
                <td>On behalf of  '.$_SESSION['company_name'].'</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td></tr>
		    <tr><td>&nbsp;</td></tr>
           </tbody>
		   
		   <tfoot>
		   <tr>
		   <td> Head of Marketing </td>
		   </tr>
		   </tfoot>
    </table>';
	return $letter_content;
}
function thanks_letter()
{
$letter_content= '<table width="100%" border="0" cellpadding="2" cellspacing="0" align="center">
        <caption>
        Date:
		<br />
		Ref: '.$_SESSION['company_name'].'/ CSD/Cong. /06
        </caption>
        <thead>
            <tr>
                <th><table width="20%" border="0" cellspacing="0" cellpadding="0" align="left">
                  <tr>
                    <td>To,</td>
                  </tr>
                  <tr>
                    <td><a href="#">The Honorable Client</a></td>
                  </tr>
                  <tr>
                    <td>'.$_SESSION['company_name'].'</td>
                  </tr>
                </table></th>
            </tr>
        </thead>
       
        <tbody>
            <tr><td>&nbsp;</td></tr>
            <tr>
              <td>Subject: <span class="sub"> Thanks Letter</span></td>
            </tr>
            <tr><td>&nbsp;</td></tr>            
            <tr><td>Assalamu Alaikum.</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>It is our great pleasure to have you as a respected and esteemed client in our institution as well as well – wisher.</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>From our customer service division we would like to congratulate you for maintaining regularity in paying your installments as schedule against your cooperation and assistance will continue which will inspire us to provide you best service.</td></tr>
		    <tr><td>&nbsp;</td></tr>
		    <tr><td>Wishing a sane & sound mind and peace & prosperous time in the coming days.</td></tr>
		    <tr>
		      <td>&nbsp;</td>
	      </tr>
		    <tr>
		      <td>Best regards,</td>
	      </tr>
		    <tr><td style="padding-left:0px; text-align:left;"><table width="25%" border="0" cellspacing="0" cellpadding="0" align="left">
              <tr>
                <td>On behalf of  '.$_SESSION['company_name'].'</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td></tr>
		    <tr><td>&nbsp;</td></tr>
           </tbody>
		   
		   <tfoot>
		   <tr>
		   <td> Head of Marketing </td>
		   </tr>
		   </tfoot>
    </table>';
	return $letter_content;
}
function request_due()
{
$letter_content= '<table width="100%" border="0" cellpadding="2" cellspacing="0" align="center">
        <caption>
        Date:
		<br />
		Ref: '.$_SESSION['company_name'].'/ CSD/GDN/D/02/06
        </caption>
        <thead>
            <tr>
                <th>
				<table width="20%" border="0" cellspacing="0" cellpadding="0" align="left">
                  <tr>
                    <td>To,</td>
                  </tr>
                  <tr>
                    <td><a href="#">Abul Basher Bhuiyan</a></td>
                  </tr>
                  <tr>
                    <td>Apartment no. C-2</td>
                  </tr>
                  <tr>
                    <td>'.$_SESSION['company_name'].' GARDEN.</td>
                  </tr>
                </table>				</th>
            </tr>
        </thead>
       
        <tbody>
            <tr><td>&nbsp;</td></tr>
            <tr>
              <td>Subject: <span class="sub"> Request to pay your Dues installment (Including current month)</span></td>
            </tr>
            <tr><td>&nbsp;</td></tr>            
            <tr><td>Assalamu Alaikum.</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>We are very happy to have you as a valued client of our project <strong>'.$_SESSION['company_name'].' GARDEN</strong> at Wari, Dhaka, as well as well – wisher of our company.</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr>
              <td>From our Customer Service Department we would like to inform you that, there is an amount of <strong>TK. 21208.00</strong> only dues against your apartment No. <strong>C-2</strong> but till now we haven’t received that amount. Now you are requested to pay the mentioned amount within <strong>June 27, 2006</strong> for which we shall be thankful to you.</td>
            </tr>
		    <tr><td>&nbsp;</td></tr>
		    <tr><td>Please disregard this letter if you have already paid the mentioned amount.</td></tr>
		    <tr>
		      <td>&nbsp;</td>
	      </tr>
		    <tr>
		      <td>If you have any query then you can contact with Mr. Monir over this number 0187-048599</td>
	      </tr>
		    <tr>
		      <td>&nbsp;</td>
	      </tr>
		    <tr>
		      <td>Thanking you with best regards.  </td>
	      </tr>
		    <tr>
		      <td>&nbsp;</td>
	      </tr>
		    <tr>
		      <td>Sincerely yours,</td>
	      </tr>
		    <tr><td style="padding-left:0px; text-align:left;"><table width="20%" border="0" cellspacing="0" cellpadding="0" align="left">
              <tr>
                <td>On behalf of  '.$_SESSION['company_name'].'</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td></tr>
		    <tr><td>&nbsp;</td></tr>
           </tbody>
		   
		   <tfoot>
		   <tr>
		   <td> Head of Marketing </td>
		   </tr>
		   </tfoot>
    </table>';
	return $letter_content;
}

?>