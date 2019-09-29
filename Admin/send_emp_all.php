<?php
session_start();
include_once '../includes/connection.php';

$employer_emails = array();
$get_record = mysqli_query($conn, "SELECT * FROM employertbl");
while($result = mysqli_fetch_Assoc($get_record)){
    $employer_emails[] = $result['Employer_Email'];
}



//sending email to selected batch 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require '../PHPMailer/vendor/autoload.php';
$jScript = md5(rand(1,9));
$newScript = md5(rand(1,9));
foreach ($employer_emails as $employer_email) {
$query = mysqli_query($conn, "SELECT * FROM employertbl WHERE Employer_Email = '$employer_email'");
$fetch = mysqli_fetch_assoc($query);
$GID = $fetch['GID'];
$EMPID = $fetch['EMPID'];
$employer_name = $fetch['Employer_Name'];
$queryalumni = mysqli_query($conn, "SELECT * FROM graduates_infotbl WHERE GID = '$GID'");
$fetchalumni = mysqli_fetch_assoc($queryalumni);
$alumni_name = $fetchalumni['firstname']." ".$fetchalumni['middlename']." ".$fetchalumni['lastname'];
$mail = new PHPMailer(true);   
$queryrespondent = mysqli_query($conn, "SELECT * FROM employer_respondenttbl WHERE EMP_ID = '$EMPID'");
$respondentcount = mysqli_num_rows($queryrespondent);
if ($respondentcount == 0) {
try {

   
    $mail->isSMTP();                                    
    $mail->Host = 'smtp.gmail.com';  
    $mail->SMTPAuth = true;                               
    $mail->Username = 'joshcanlas2017@gmail.com';     // email ng sender 
    $mail->Password = 'incorrect101';      // email password ng sender                      
    $mail->SMTPSecure = 'tls';                           
    $mail->Port = 587;         
	
    $mail->setFrom('joshcanlas2017@gmail.com', 'GETSystem(Administrator)'); 
  
    $mail->addAddress($employer_email); // email ng pag sesendan               
   
    $mail->isHTML(true);                                 
	
    $mail->Header = 'MIME-Version: 1.0\r\nt Content-Type: text/plain; charset=utf-8\r\n
	X-Priority: 1\r\n'; 
	
    
    
    $message = "Good Day Ma'am/Sir <b>$employer_name,</b><br> Don Honorio Ventura State University College of Computing Studies currently conducting Employer Feedback Survey<br>
    In order to assess the abilities of our B.S. IT graduates, we would ask you to please complete this survey with regard to <b>$alumni_name</b> graduate of the Don Honorio Ventura State University. Thank you.
	Please click link below.<br><a href='http://ccsgetsystem.info/Employer/employer_feedback_page?jScript=$jScript && newScript=$newScript && GID=$GID && EMPID=$EMPID'>CCS Employer Feedback Form</a>";
        
        
		$mail->Subject = 'DHVSU-CCS Employer Feedback Survey';
		$mail->Body   = $message;
	
		$mail->send();
		echo "<script>window.location.href='employer_survey?&&notify=Survey Successfully Sent to all Employers';</script>";
	} catch (Exception $e) {
        
        echo "<script>window.location.href='employer_survey?&&errors=Message could not be sent. Mailer Error: $mail->ErrorInfo';</script>";
	}
}
}
?>