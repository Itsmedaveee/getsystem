<?php
session_start();
if (isset($_SESSION["email"])) {
    $email = $_SESSION["email"];
}else{
    echo "<script>window.location.href='../Login';</script>";
}

include_once '../includes/connection.php';

$sql_query = mysqli_query($conn, "SELECT Name, account_type, Password from userstb WHERE Email='$email'");
$fetch = mysqli_fetch_assoc($sql_query);
$db_name = ucfirst($fetch['Name']);
$db_account_type = $fetch['account_type'];
$db_pass = $fetch['Password'];
$db_email = $email;

if ($db_account_type == 2) {
    $account_type = "Data Processor/Encoder";
    
}else{
    echo "<script>window.location.href='../Login';</script>";
}

$currentpwerr = $newemailerr = "";
$currentpw = $newemail = "";
if (isset($_POST['submit_btn'])) {
   
    //*********************Validation************************************* */
    if (empty($_POST["current"])) {
        $currentpwerr = "Field Required!";
        
    } else {
        $currentpw = $_POST["current"];
    }
      
    if (empty($_POST["email"])) {
        $newemailerr = "Please enter new Email";
        
    } else {
        $newemail = $_POST["email"];
    }

if ($newemail != "" && $currentpw != "") {

    if ($db_pass != $currentpw) {
        $currentpwerr = "You enter wrong password";
    }else{
        if (!filter_var($newemail, FILTER_VALIDATE_EMAIL)) {
            $newemailerr = "You must provide valid email";
        } else {
            $query = mysqli_query($conn, "SELECT * FROM userstb WHERE Email='$newemail'");
            $result = mysqli_fetch_assoc($query);
            if ($result != 0) {
                $newemailerr = "Email already Registered";
            }else{

                    mysqli_query($conn, "UPDATE userstb SET 
                    Email = '$newemail' WHERE Email = '$db_email'
                    ");
                 $_SESSION["email"] = $newemail;
                 $encrypted = md5(rand(1,9));
                 if ($db_account_type == 2) {
                    echo "<script>window.location.href='user_page?$encrypted&&notify=Email Changed Successfully!';</script>";
                 }else{
                    echo "<script>window.location.href='./Login?$encrypted';</script>";
                 }        
          
        }
       }
     }
   }    
 }

if (isset($_POST['cancel_btn'])) {
    $encrypted = md5(rand(1,9));
    if ($db_account_type == 2) {
        echo "<script>window.location.href='user_page?$encrypted';</script>";
    }else{
        echo "<script>window.location.href='./Login?$encrypted';</script>";
    }
}



?>
<style>
.emailphoto{
    width: 298px;
    height: 159px;
    position:absolute;
    box-shadow: 0 5px 15px #5a5c5f;
    
}
.accphoto{
    position:relative;
}
.emailacc{
    position:relative;
}
.hnoti{
    margin:0;
    padding:0;
}
.cpasspanel{
    width: 100%;
    height: 350px;
    margin-left:60px;
    margin-top:20px;
}
.cinput, .ninput, .rinput{
    font-family: "roboto", sans-serif;
    outline: 1;
    background: aliceblue; 
    border:1px solid rgba(0,0,0,0.250);
    width: 500px;
    border-radius: 5px 5px 5px 5px;
    margin: 0 0 15px;
    padding: 15px;
    box-sizing: border-box;
    font-size: 15px;
    
    
}
.submit-btn{
    border-radius:3px;
    font-family: "roboto", sans-serif;
    outline: 0;
    height: 25px;
    width: 80px;
    background: #2e68aa;
    color: #fff;
    font-size: 14px;
    cursor: pointer;
    border: none;
    margin-top: 0;
}
.navpanel {
    overflow-y:hidden;
}
.cancel-btn{
    border-radius:3px;
    font-family: "roboto", sans-serif;
    outline: 0;
    height: 25px;
    width: 80px;
    background: aliceblue;
    color: #2e68aa;
    font-size: 14px;
    cursor: pointer;
    border: 1px solid #2e68aa;
    margin-top: 3.5px;
    margin-left: 5px;
    font-weight:600;
}
.error{
    color:red;
}
.tag{
   color: #6f797e;
}
.btn-container{
    background:lightgrey;
    margin-top:30px;
    height:30px;
    width:100%;
}
.div-tab{
    margin-top:9px;
    border-radius:0 0  5px 5px;
    background:rgba(0,0,0,0.03);
    width:775px;
    border:1px solid rgba(0,0,0,0.120);
}
.title-tab{
    border-radius:5px 5px 0 0;
    color:rgba(16, 94, 238, 0.500);
    border:1px solid rgba(0,0,0,0.120);
    background:#e0edf5ea;
    padding:10px;
    margin:none;
    font-weight: 400;
    border-bottom:1px solid #e0edf5ea;
}
</style>


<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../fonts/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../css/main.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GETSysytem | Welcome</title>
</head>
<body>
    <header>
        <div class="container">
            <div id="title">
                <h2><span class="highlights">G</span>raduates <span class="highlights">E</span>mployability <span class="highlights">T</span>racer <span class="highlights">S</span>ystem</h2>
            </div>
            <nav>
                <ul>
                   <li class="current"><a href="../logout"><i class="fa fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    
        <div class="navbox">

                <div class="sidepanel">
                    <img src="../img/images 7.jpeg" class="emailphoto">
                        <div class="photo">
                            <img src="../img/photo10.png" class="accphoto">
                            <label for="" class="fullname"><?php echo $db_name; ?></label>

                        </div>

                        <div class="emailacc">
                        
                            <p class="email-user"><b><?php echo $email; ?></b><br>
                            <i><font color="#ffffff"><?php echo $account_type; ?></font></i>
                            
                            
                           
                            </p>
                            
                          
                        </div>
                            
                    </div>
            
                    
                          
            <div class="navpanel">

                <div class="multi-level">
                    
                </div>

                <div class="item">
                    <input type="checkbox" id="B">
                    <img src="../img/emaildropdown5.png" class="arrow"><label for="B"><i class="fa fa-pen"></i> SURVEYS</label>
                    <ul>
                        <li><a href="add_usersurvey"><i class="fa fa-plus"></i> Add Survey</a></li>
                        <li><a href="user_survey"><i class="fa fa-pen"></i> My Surveys</a></li>
                    </ul>
                </div>

                
                
            </div>
         </div>
         <div class="dropdownnav">
         <input type="checkbox" id="D">
         <label for="D"><img class="emaildropdown" src="../img/emaildropdown5.png"></label>
                            <ul>
                                <li><a href="change_userpass"><i class="fa fa-lock"></i> Change password</a></li>
                                <li><a href="change_useremail"><i class="fa fa-at"></i> Update Email</a></li>
                                <li><a href="change_usercontact"><i class="fa fa-phone"></i> Update Contact</a></li>
                            </ul>

                            </ul>
        </div>

         <div class="mainpanel">
         <div class="statuspanel">
            <?php 
            if (empty($_GET['notify'])) {
                        
                echo "";
            } else {
                echo "<br><h5 class='hnoti'><font color='green'>". $_GET['notify'] ."</font></h5>";
                unset($_GET['notify']);
            }
            ?>
            </div>
           <div class="datapanel">
           
           <span class="title-tab">Change Email</span><br>
           <div class="div-tab">
                <div class="cpasspanel">
                    <form action="" method="POST">

                    <span class="tag">Enter Password*</span><br>
                    <input type="password" name="current" class="cinput" placeholder="Enter Password" value="<?php echo $currentpw; ?>">
                    <span class="error"><?php echo $currentpwerr; ?></span>
                    <br><br>
                    <span class="tag">New Email*</span><br>
                    <input type="email" name="email" class="ninput" placeholder="Enter New Email" value="<?php echo $newemail; ?>">
                    <span class="error"><?php echo $newemailerr; ?></span>
                    <br><br>
                    
                </div>
                <div class="btn-container">
                                <span style="margin-left:590px;">
                    <input type="submit" name="submit_btn" class="submit-btn" value="Save">
                    <input type="submit" name="cancel_btn" class="cancel-btn" Value="Cancel">

                    </form>
                    </div>

                </div>
            </div>
                
         </div>
  

</body>
</html>