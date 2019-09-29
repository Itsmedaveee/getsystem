<?php
$host = 'localhost';
$username ='root';
$pword = '';
$db = 'getsdb';
  $conn = mysqli_connect($host, $username, $pword, $db);
     if ($conn-> connect_error) {
        die("connection failed:". $conn-> connect_error);

         }

?>
