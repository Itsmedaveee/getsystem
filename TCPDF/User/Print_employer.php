<?php
require_once('tcpdf_include.php');
include_once '../../includes/connection.php';

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Administrator');
$pdf->SetTitle('Graduates Employability Tracer System');
$pdf->SetSubject('Summary Report');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}


$pdf->SetFont('dejavusans', '', 10);


$pdf->AddPage('P');

if (!empty($_GET['EMPID']) && !empty($_GET['GID'])) {
$GID = $_GET['GID'];
$EMPID = $_GET['EMPID'];
$querygrad = mysqli_query($conn, "SELECT * FROM graduates_infotbl WHERE GID = '$GID'");
$resultgrad = mysqli_fetch_assoc($querygrad);
$fullname = $resultgrad['firstname']." ".$resultgrad['middlename']." ".$resultgrad['lastname'];
$queryrespondent = mysqli_query($conn, "SELECT * FROM employer_respondenttbl WHERE EMP_ID = '$EMPID'");
$resultres = mysqli_fetch_assoc($queryrespondent);
$EMP_RID = $resultres['EMP_RID'];
$datetime = $resultres['date']." ".$resultres['time'];
$queryemp = mysqli_query($conn, "SELECT * FROM employertbl WHERE EMPID = '$EMPID'");
$resultemp = mysqli_fetch_assoc($queryemp);
$company = $resultemp['Company'];
$company_add = $resultemp['Company_Address'];
$type = $resultemp['Type_Company'];
$emp_name = $resultemp['Employer_Name'];
$jobtitle = $resultemp['Job_Title'];
$html2 = "";
$html= "";
$html .= '<table border="0">
            <tr><td>Graduates Name: <b>'.$fullname.'</b></td></tr>
            <tr><td></td></tr>
            <tr style="line-height: 100%"><td>Company Name: <b>'.$company.'</b></td></tr>
            <tr><td></td></tr>
            <tr><td>Company Address: <b>'.$company_add.'</b></td></tr>
            <tr><td></td></tr>
            <tr><td>Type of Company: <b>'.$type.'</b></td></tr>
            <tr><td></td></tr>
            <tr><td>Employers Name: <b>'.$emp_name.'</b></td></tr>
            <tr><td></td></tr>
            <tr><td>Job Title: <b>'.$jobtitle.'</b></td></tr>
            </table>';
$html2 .= '<table border="1">';
$queryemp = mysqli_query($conn, "SELECT * FROM employer_responsetbl WHERE EMP_RID = '$EMP_RID'");
while ($resultemp = mysqli_fetch_assoc($queryemp)) {
    $QID = $resultemp['QID'];
    $response = $resultemp['Response'];
    $queryresponse = mysqli_query($conn, "SELECT * FROM questiontbl WHERE QuestionID = '$QID'");
    $resultresponse = mysqli_fetch_assoc($queryresponse);
    $Question = $resultresponse['Question'];

    $html2 .= '<tr><td> '.$Question.' </td><td><b> '.$response.' </b></td></tr>';

} 

$html2 .= '</table>';

$pdf->SetFont('Helvetica','B',12);
$pdf->Cell(180,10,"Employer Feedback Survey",0,1,'C');
$pdf->SetFont('Helvetica','',11);
$pdf->Cell(180,0,"In order to assess the abilities of our B.S. IT graduates, we would ask you",0,1,'C');
$pdf->Cell(180,0,"to please complete this survey with regard to following graduate of the",0,1,'C');
$pdf->Cell(180,0,"Don Honorio Ventura State University. Thank you.",0,1,'C');
$pdf->writeHTML('<br/>', true, false, true, false, '');

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->SetFont('Helvetica','B',12);
$pdf->Cell(180,8,"Evaluation of employer to ".$fullname.".",0,1,'');
$pdf->SetFont('Helvetica','',11);
$pdf->writeHTML($html2, true, false, true, false, '');
$pdf->writeHTML('<br/><br/>', true, false, true, false, '');
$pdf->SetFont('Helvetica','',12);
$pdf->Cell(180,0,$datetime."  ",0,1,'R');
$pdf->SetFont('Helvetica','B',12);
$pdf->Cell(180,0,"_________________",0,1,'R');
$pdf->Cell(180,0,"Date Submitted    ",0,1,'R');
//start displaying report






}



$pdf->lastPage();

$pdf->Output('GETSummaryReport.pdf', 'I');

