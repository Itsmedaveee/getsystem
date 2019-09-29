<?php
include '../includes/connection.php';
$db_id = $_GET['del_id'];

       mysqli_query($conn, "DELETE FROM employer_respondenttbl WHERE EMP_ID=$db_id");
        echo "<script>window.location.href='employer_feedback?notify=Employer Successfully Deleted!';</script>";
 ?>   
