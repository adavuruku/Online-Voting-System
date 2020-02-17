<?php
require_once('tcpdf_include.php');
session_start();
require_once '../settings/connection.php';
require_once '../settings/filter.php';
$user_name = $profile_Pics =$email=$phone_no =$phone_no =$dateprint =$id_count=$total_amount_summary="";



if(!isset($_SESSION['Admin_user_name']) AND !isset($_SESSION['Admin_user_full_name']))
{
	header("location: ../sign_logout.php");
}
		
		$date500 = new DateTime("Now");
		$J = date_format($date500,"D");
		$Q = date_format($date500,"d-F-Y, h:i:s A");
		$dateprint = "Printed On: ".$J.", ".$Q;	

		
// create new PDF document

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF 
{
	// Page footer
		public function Footer() {
		// Position at 15 mm from bottom
		$this->SetY(-15);
		// Set font
		$this->SetFont('dejavusans', 'I', 8);
		// Page number
		$this->Cell(0, 10, '| ATBU - S U G E-Voting - 2016 / 2017 | - Page '.$this->getAliasNumPage().' Of '.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	}
}



$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Abdulraheem Sherif A');
$pdf->SetTitle('Sherif Online Marketing System');
$pdf->SetSubject('Customer Purchase Order Slip');

$pdf->SetKeywords('Pesoka, Computers, Nigeia, Limited, Ajaokuta');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// to remove default header use this
$pdf->setPrintHeader(false);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('dejavusans', '', 10);

// add a page
$pdf->AddPage();
// set alpha to semi-transparency


$html = '<table cellspacing="0" cellpadding="1" border="0" align="center">
	<tr >
        <td colspan="2" ><img src="../settings/images/headlogo.jpg" height="200" /></td>
    </tr>
</table>';
$pdf->writeHTML($html, true, false, true, false, '');

$html ='<table cellspacing="0" cellpadding="1" border="0" align="center">
    <tr style="bottom-border:1 solid;">
		<td align="Left" style="font-size:8;font-weight:bold;color:brown">2016 /2017 ATBU - S.U.G Election  Result </td> 
		<td  align="Right" style="font-size:8;">'.$dateprint.'</td> 
    </tr>
</table><hr>';

$pdf->writeHTML($html, true, false, false, false, '');


// -----------PERSONALINFORMATION GOODS DETAIL TABLE----------------------------------------------
$pdf->SetAlpha(0.3);
$img_file = K_PATH_IMAGES.'title.jpg';
$pdf->Image($img_file, 55, 85, 100, 100, '', '', '', false, 300, '', false, false, 0);
$pdf->SetAlpha(1);

$html1 ="";

			$stmt2 = $conn->prepare("SELECT * FROM contestant_list where c_vote_id=? and del_status=? Limit 1");
			$stmt2->execute(array($_SESSION['c_vote_id_A'],"0"));
			if ($stmt2->rowCount () >= 1)
			{
				$id2=0;
				$total_vote =0;
				$row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
				
					$id2 = $id2 + 1;
					//$id3 = $id3 + 1;
					$total_vote = $total_vote + $row2['c_vote'];
					$Pasport=str_replace("/","",$row2['c_vote_id']).$row2['pics_ext'];
					$Pasport="stud_pass/contestant/".$Pasport;
					$html1 .= '<tr  >
									<td rowspan="24" width="20px">'.$id2.'</td>
									<td align="Center" rowspan="24" style="font-size:8;"><img width="100" height="100" border="0" src="'.$Pasport.'"/></td>
									<td align="right" colspan="2" >Name :</td>
									<td width="125px" colspan="2" width="300px" >'.$row2['c_name'].'</td>
								</tr>
								<tr  >
									<td align="right" colspan="4"></td>
								</tr>
								<tr  >
									<td align="right" colspan="2">Registration N<u>o</u> :</td>
									<td colspan="2">'.$row2['c_regno'].'</td>
								</tr>
								<tr  >
									<td align="right" colspan="4"></td>
								</tr>
								<tr  >
									<td align="right" colspan="2">Faculty :</td>
									<td colspan="2">'.$row2['c_faculty'].'</td>
								</tr>
								<tr  >
									<td align="right" colspan="4"></td>
								</tr>
								<tr  >
									<td align="right" colspan="2">Department :</td>
									<td colspan="2" >'.$row2['c_dept'].'</td>
								</tr>
								<tr  >
									<td align="right" colspan="4"></td>
								</tr>
								
								<tr  >
									<td align="right" colspan="2" >Level :</td>
									<td colspan="2">'.$row2['c_level'].' Level </td>
								</tr>
								<tr  >
									<td align="right" colspan="4"></td>
								</tr>
								<tr  >
									<td align="right" colspan="2" >State :</td>
									<td colspan="2">'.$row2['c_state'].'</td>
								</tr>
								<tr  >
									<td align="right" colspan="4"></td>
								</tr>
								<tr>
									<td align="right" colspan="2" >Address :</td>
									<td colspan="2">'.$row2['c_address'].'</td>
								</tr>
								<tr  >
									<td align="right" colspan="4"></td>
								</tr>
								<tr>
									<td align="right" colspan="2" >Email :</td>
									<td colspan="2">'.$row2['c_email'].'</td>
								</tr>
								<tr  >
									<td align="right" colspan="4"></td>
								</tr>
								<tr>
									<td colspan="2" align="right" >Phone :</td>
									<td colspan="2">'.$row2['c_phone'].'</td>
								</tr>
								<tr  >
									<td align="right" colspan="4"></td>
								</tr>
								<tr>
									<td colspan="2" align="right" >Gender :</td>
									<td colspan="2">'.$row2['c_gender'].'</td>
								</tr>
								<tr  >
									<td align="right" colspan="4"></td>
								</tr>
								<tr style="background-color:black;color:yellow;font-weight:bold;">
									<td colspan="2" align="right" >Portfolio :</td>
									<td colspan="2">'.$row2['c_position'].'</td>
								</tr>
								<tr  >
									<td align="right" colspan="4"></td>
								</tr>
								<tr style="background-color:black;color:yellow;font-weight:bold;">
									<td colspan="2" align="right" >Vote Gained :</td>
									<td colspan="2">'.number_format($row2['c_vote'],2).' Votes !</td>
								</tr>
								<tr  >
									<td align="right" colspan="4"></td>
								</tr>
								<tr width="400">
									<td align="Center" colspan ="6" style="font-size:8;"></td>
								</tr>';
				
				
			}else{
					$id2=0;$total_vote=0;
				$html1 .= '<tr  >
							<td >'.$id2.'</td>
							<td colspan="5">No Contestant for these portfolio !</td>
						</tr>';
			
			}
		$html  = '<table border="1" cellpadding="1" width="100%">'.$html1.'
		</table>';
		// output the HTML content
		$pdf->writeHTML($html, true, false, false, false, '');
$pdf->Output('All_Single_Portfolio_result.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

