<?php
session_start();


if (isset($_SESSION["email"])) {
    $email = $_SESSION["email"];
}else{
    echo "<script>window.location.href='../Login';</script>";
}
include_once '../includes/connection.php';

   

$sql_query = mysqli_query($conn, "SELECT Name, account_type from userstb WHERE Email='$email'");
$fetch = mysqli_fetch_assoc($sql_query);
$db_name = ucfirst($fetch['Name']);
$db_account_type = $fetch['account_type'];
$db_email = $email;
if ($db_account_type == 1) {
    $account_type = "Administrator";
}else{
    echo "<script>window.location.href='../Login';</script>";
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
.labels{
    text-align:right;
    width:150px;
    height:40px;
    font-size:16px;
    font-weight:600;
}
.table-details{
    margin-left:110px;
    border-collapse: collapse;
   
}
.details{
    margin-left:10px;

}
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../fonts/fontawesome/css/all.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title>GETSysytem | Welcome</title>
 <style>

 </style>

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
                    
                    <div class="item">
                        <input type="checkbox"  id="A">
                        <img src="../img/emaildropdown5.png" class="arrow"><label for="A">Users</label>
                        <ul>
                            <li><a style="padding-top:20px; padding-bottom:20px;" href="account_request"><i class="fa fa-user-plus"></i> Account Request</a></li>
                            <li><a style="padding-top:20px; padding-bottom:20px;" href="manageusers"><i class="fa fa-users-cog"></i> Manage Users</a></li>
                            <li><a style="padding-top:20px; padding-bottom:20px;" href="Manage_enumerator"><i class="fa fa-users"></i> Enumerators</a></li>
                        </ul>
                    </div>
                </div>

                <div class="item">
                    <input type="checkbox" id="B">
                    <img src="../img/emaildropdown5.png" class="arrow"><label for="B">Data Encoders</label>
                    <ul>
                    <li><a style="padding-top:20px; padding-bottom:20px;" href="Allsurveys"><i class="fa fa-pen"></i> Surveys</a></li>
                    <li><a style="padding-top:20px; padding-bottom:20px;" href="Logs"><i class="fa fa-history"></i> Logs</a></li>
                    </ul>
                </div>

                <div class="item">
                    <input type="checkbox" id="c">
                    <img src="../img/emaildropdown5.png" class="arrow"><label for="c">Graduates</label>
                    <ul>
                    <li><a style="padding-top:20px; padding-bottom:20px;" href="graduates_survey"><i class="fa fa-pen"></i> Surveys</a></li>
                    <li><a style="padding-top:20px; padding-bottom:20px;" href="List_graduates"><i class="fa fa-user-graduate"></i> List of Graduates</a></li>
                    <li><a style="padding-top:20px; padding-bottom:20px;" href="admin_reports"><i class="fa fa-chart-bar"></i> Reports</a></li>
                    </ul>
                </div>

                <div class="item">
                    <input type="checkbox" id="f">
                    <img src="../img/emaildropdown5.png" class="arrow"><label for="f">Employers</label>
                    <ul>
                    <li><a style="padding-top:20px; padding-bottom:20px;" href="employer_survey"><i class="fa fa-user-tie"></i> List of Employers</a></li>
                    <li><a style="padding-top:20px; padding-bottom:20px;" href="employer_feedback"><i class="fa fa-comment"></i> Feedback</a></li>
                    </ul>
                </div>
                <div class="item">
                    <input type="checkbox" id="j">
                    <img src="../img/emaildropdown5.png" class="arrow"><label for="j">Job Offerings</label>
                    <ul>
                    <li><a style="padding-top:20px; padding-bottom:20px;" href="add_jobs"><i class="fa fa-briefcase-medical"></i> Post Jobs</a></li>
                    <li><a style="padding-top:20px; padding-bottom:20px;" href="job_offerings"><i class="fa fa-briefcase"></i> Job Offerings</a></li>
                    </ul>
                </div>
                
            </div>
         </div>
         <div class="dropdownnav">
         <input type="checkbox" id="E">
         <label for="E"><img class="emaildropdown" src="../img/emaildropdown5.png"></label>
                            <ul>
                                <li><a href="change_adminpass"><i class="fa fa-lock"></i> Change password</a></li>
                                <li><a href="change_adminemail"><i class="fa fa-at"></i> Update Email</a></li>
                                <li><a href="change_admincontact"><i class="fa fa-phone"></i> Update Contact</a></li>
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
            if (!empty($_GET['EMPID']) && !empty($_GET['GID'])) {
               $EMPID = $_GET['EMPID'];
               $GID = $_GET['GID'];
               $querygrad = mysqli_query($conn, "SELECT * FROM graduates_infotbl WHERE GID='$GID'");
               $resultgrad = mysqli_fetch_assoc($querygrad);
               $fullname = $resultgrad['firstname']." ".$resultgrad['middlename']." ".$resultgrad['lastname'];
               $query = mysqli_query($conn, "SELECT * FROM employertbl WHERE EMPID = '$EMPID' AND GID='$GID'");
               $result = mysqli_fetch_assoc($query);
               $company = $result['Company'];
               $company_add = $result['Company_Address'];
               $typecom = $result['Type_Company'];
               $emp_name = $result['Employer_Name'];
               $emp_email = $result['Employer_Email'];
               $jobtitle = $result['Job_Title'];
              
            }
            if (isset($_POST['cancel_btn'])) {
                echo "<script>window.location.href='employer_survey';</script>";
            }
            ?>
            </div>
           <div class="datapanel">
           <span class="title-tab">Employer Details</span><br>
           <div class="div-tab">
                <div class="cpasspanel">
                    <form action="" method="POST" autocomplete="off">
                    <br>
                <table  class="table-details">
                <tr>
                <td class="labels"><span style="color:rgba(16, 94, 238, 0.650);font-weight:600;">Employer Name:</span></td>
                <td class="details"><span style="margin-left:20px;"><?php echo $emp_name; ?></span></td>
                </tr>

                <tr>
                <td class="labels"><span style="color:rgba(16, 94, 238, 0.650);font-weight:600;">Employer Email:</span></td>
                <td class="details"><span style="margin-left:20px;"><?php echo $emp_email; ?></span></td>
                </tr>

                <tr>
                <td class="labels"><span style="color:rgba(16, 94, 238, 0.650);font-weight:600;">Job Title:</span></td>
                <td class="details"><span style="margin-left:20px;"><?php echo $jobtitle; ?></span></td>
                </tr>
                <tr>
                <td class="labels"><span style="color:rgba(16, 94, 238, 0.650); font-weight:600;">Company:</span></td>
                <td class="details"><span style="margin-left:20px;"><?php echo $company; ?></span></td>
                </tr>

                <tr>
                <td class="labels"><span style="color:rgba(16, 94, 238, 0.650); font-weight:600;">Company Address:</span></td>
                <td class="details"><span style="margin-left:20px;"><?php echo $company_add; ?></span></td>
                </tr>

                <tr>
                <td class="labels"><span style="color:rgba(16, 94, 238, 0.650);font-weight:600;">Type of Company:</span></td>
                <td class="details"><span style="margin-left:20px;"><?php echo $typecom; ?></span></td>
                </tr>

               

                <tr>
                <td class="labels"><span style="color:rgba(16, 94, 238, 0.650);font-weight:600;">Graduates:</span></td>
                <td class="details"><span style="margin-left:20px;"><?php echo $fullname; ?></span></td>
                </tr>
                </table>
                    
                    
                </div>

                <div class="btn-container">
                                <span style="margin-left:670px;">
                    
                    <input type="submit" name="cancel_btn" class="cancel-btn" Value="Back">

                    </form>
                    </div>
                </div>
                
            </div>
                
         </div>
  
  

</body>
</html>