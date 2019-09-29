<?php
include '../includes/connection.php';


if(!empty($_GET['pw'])){
    $pw = $_GET['pw'];
    
//check password
$querypassword = mysqli_query($conn, "SELECT * FROM userstb WHERE account_type = '1' AND Password = '$pw'");
$numrows = mysqli_num_rows($querypassword);
if ($numrows == 0) {
    echo "<script>window.location.href='employer_feedback?errors=Incorrect password!';</script>";
}else{
    //delete feedback
        
        mysqli_query($conn, "DELETE FROM employer_respondenttbl");
            echo "<script>window.location.href='employer_feedback?notify=Feedback Successfully Deleted!&&clr=green';</script>";
}

}else{
    echo "<script>window.location.href='employer_feedback?errors=Invalid Inputs!';</script>";
}
 ?>   
