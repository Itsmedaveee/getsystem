<?php
include '../includes/connection.php';
$db_id = $_GET['del_id'];

       mysqli_query($conn, "DELETE FROM employertbl WHERE EMPID=$db_id");
        echo "<script>window.location.href='employer_survey?notify=Employer Successfully Deleted!';</script>";
 ?>   
