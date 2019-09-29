<?php
session_start();
include_once '../includes/connection.php';
$GID = $_GET['GID'];
$EMPID = $_GET['EMPID'];
date_default_timezone_set('Asia/Manila');
$date_now = date('Y-m-d');
$time_now = date('h:i A');

$get_record = mysqli_query($conn, "SELECT GID,Employer_Email, Employer_Name FROM employertbl WHERE EMPID='$EMPID'");
$result = mysqli_fetch_Assoc($get_record);
$emp_email = $result['Employer_Email'];
$emp_name = $result['Employer_Name'];
$GID = $result['GID'];
$query = mysqli_query($conn, "SELECT * FROM graduates_infotbl WHERE GID='$GID'");
$fetch = mysqli_fetch_Assoc($query);
$alumni_name =  $fetch['firstname']." ".$fetch['middlename']." ".$fetch['lastname'];
//sending email to selected batch 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/vendor/autoload.php';
$jScript = md5(rand(1,9));
$newScript = md5(rand(1,9));
$mail = new PHPMailer(true);                              
try {

	
    $mail->isSMTP();                                    
    $mail->Host = 'smtp.gmail.com';  
    $mail->SMTPAuth = true;                               
    $mail->Username = 'joshcanlas2017@gmail.com';     //  email ng sender 
    $mail->Password = 'incorrect101';      // password ng sender                      
    $mail->SMTPSecure = 'tls';                           
    $mail->Port = 587;         
	
    $mail->setFrom('joshcanlas2017@gmail.com', 'GETSystem(Administrator)'); 
  
    $mail->addAddress($emp_email); // email ng pag sesendan               
   
    $mail->isHTML(true);                                 
	
    $mail->Header = 'MIME-Version: 1.0\r\nt Content-Type: text/plain; charset=utf-8\r\n
	X-Priority: 1\r\n'; 
	
    $message = "Good Day Ma'am/Sir <b>$emp_name,</b><br> Don Honorio Ventura State University College of Computing Studies currently conducting Employer Feedback Survey<br>
    In order to assess the abilities of our B.S. IT graduates, we would ask you to please complete this survey with regard to <b>$alumni_name</b> graduate of the Don Honorio Ventura State University. Thank you.
	Please click link below.<br><a href='http://ccsgetsystem.info/Employer/employer_feedback_page?jScript=$jScript && newScript=$newScript && GID=$GID && EMPID=$EMPID'>CCS Employer Feedback Form Link</a>";
		
		$mail->Subject = 'DHVSU-CCS Employer Feedback Survey';
		$mail->Body   = $message;
	
		$mail->send();
		echo "<script>window.location.href='employer_survey?&&notify=Survey sent Successfully!';</script>";
	} catch (Exception $e) {
        
        echo "<script>window.location.href='employer_survey?&&errors=Message could not be sent. Mailer Error: $mail->ErrorInfo';</script>";
	}







?>