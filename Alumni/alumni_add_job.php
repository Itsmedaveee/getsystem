<?php
 $encrypted = md5(rand(1,9));
session_start();
if (isset($_SESSION["email"])) {
    $email = $_SESSION["email"];
}else{
    echo "<script>window.location.href='../Login';</script>";
    
}

include_once '../includes/connection.php';

$sql_query = mysqli_query($conn, "SELECT ID, Name, account_type, Password from userstb WHERE Email='$email'");
$fetch = mysqli_fetch_assoc($sql_query);
$db_name = ucfirst($fetch['Name']);
$db_account_type = $fetch['account_type'];
$db_pass = $fetch['Password'];
$ID = $fetch['ID'];
$db_email = $email;
$sql = mysqli_query($conn, "SELECT Stud_No,firstname,middlename,lastname from graduates_infotbl WHERE UID='$ID'");
$fetchSN = mysqli_fetch_assoc($sql);
$SN = $fetchSN['Stud_No'];
$fullname = $fetchSN['firstname']." ".$fetchSN['middlename']." ".$fetchSN['lastname'];
if ($db_account_type == 3) {
    $account_type = "Alumni / ".$SN;
    
}else{
    echo "<script>window.location.href='../Login';</script>";
    
}
$Allerror = "";
$title = $company = $location = $description = $qualify = $date_needed = "";
if (isset($_POST['submit_btn'])) {
   
    //*********************Validation************************************* */
    date_default_timezone_set('Asia/Manila');
    $date = date('Y-m-d');
    

    if (empty($_POST["jobtitle"])) {
        $Allerror = "Please fill all REQUIRED field(s)";
        
    } else {
        $title = $_POST["jobtitle"];
        if (empty($_POST["company"])) {
            $Allerror = "Please fill all REQUIRED field(s)";
            
        } else {
            $company = $_POST["company"];
            if (empty($_POST["location"])) {
                $Allerror = "Please fill all REQUIRED field(s)";
                
            } else {
                $location = ucfirst($_POST["location"]);
                if (empty($_POST["jobdesc"])) {
                    $Allerror = "Please fill all REQUIRED field(s)";
                    
                } else {
                    $description = ucfirst($_POST["jobdesc"]);
                    if (empty($_POST["qualify"])) {
                        $Allerror = "Please fill all REQUIRED field(s)";
                        
                    } else {
                        $qualify = $_POST["qualify"];
                        if (empty($_POST["dateneeded"])) {
                            $Allerror = "Please fill all REQUIRED field(s)";
                            
                        } else {
                                    $date_needed = $_POST["dateneeded"];
                           
                                            mysqli_query($conn, "INSERT INTO job_offeringtbl(UID,title,company,location,description,qualification,date_needed,date_posted,posted_by) 
                                            VALUES('$ID','$title','$company','$location','$description','$qualify','$date_needed','$date','$fullname')");
                                            
                                            $success = "Posted Successfully!";
                                            $title = $company = $location = $description = $qualify = $date_needed = "";
                                            
                        }
                    }
                }
            }
        }
    }
      
 }

if (isset($_POST['cancel_btn'])) {
    
   
        echo "<script>window.location.href='alumni_my_post?$encrypted';</script>";
    
}






?>

<Script type="application/javascript">
function isNumberKey(evt){

    var charCode = (evt.which) ? evt.which : event.keycode

    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    
        return true;
    }
    
}

</Script>
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
.cpasspanel{
    width: 700px;
    height: 350px;
    margin-left:60px;
    margin-top:20px;
}
.cinput, .infos{
    font-family: "roboto", sans-serif;
    outline: 1;
    background: aliceblue; 
    border:1px solid rgba(0,0,0,0.450);
    width: 500px;
    max-width: 500px;
    min-width: 500px;
    border-radius: 5px 5px 5px 5px;
    margin: 0 0 15px;
    padding: 3.5px;
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
.submit-btn:hover, .cancel-btn:hover{
    opacity:0.7;
}
.error{
    font-size:14px;
    padding:0;
    color:red;
}
.tag{
   color: rgba(0,0,0,0.8);
   font-weight:600;
   font-size:13px;
}
.tag1{
   color: rgba(0,0,0,0.8);
   font-size:13;
   padding:0;
   margin:0;
   line-height:2;
}
.datapanel{
    border-radius: 5px 5px 5px 5px;
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
    color:rgba(16, 94, 238, 0.600);
    border:1px solid rgba(0,0,0,0.120);
    background:#e0edf5ea;
    padding:10px;
    margin:none;
    font-weight: 400;
    border-bottom:1px solid #e0edf5ea;
    letter-spacing:.5px;
}
.req{
   
    color:red;
    font-size:13px;
}
.success{
    color:green;
    font-size:14px;
    margin:0;
    padding:0;
}
.table-form{
    margin-left:65px;
}
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../fonts/font-awesome.min.css">
    <link rel="stylesheet" href="../fonts/fontawesome/css/all.min.css">
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
                    
                    <label for="E" style="margin:0; padding:0;"><a href="alumni_page" style="text-decoration:none; color:#0c1c22; padding:200px 150px 15px 30px;"><i class="fa fa-home"></i> Dashboard</a></label> 
                 
                  </div>
                </div>

                <div class="item">
                    <input type="checkbox" id="A">
                    <img src="../img/emaildropdown5.png" class="arrow"><label for="A"><i class="fa fa-pen"></i> Surveys</label>
                    <ul>
                        <li><a style="padding-top:20px; padding-bottom:20px;" href="alumni_surveys"><i class="fa fa-pen"></i> Surveys</a></li>
                    </ul>
                </div>
                <div class="item">
                    <input type="checkbox" id="B">
                    <img src="../img/emaildropdown5.png" class="arrow"><label for="B"><i class="fa fa-briefcase"></i> Jobs</label>
                    <ul>
                        <li><a style="padding-top:20px; padding-bottom:20px;" href="alumni_add_job"><i class="fa fa-briefcase-medical"></i> Post Jobs</a></li>
                        <li><a style="padding-top:20px; padding-bottom:20px;" href="alumni_job_offerings"><i class="fa fa-briefcase"></i> Job Offerings</a></li>
                    </ul>
                </div>
               

            </div>
         </div>
         <div class="dropdownnav">
         <input type="checkbox" id="D">
         <label for="D"><img class="emaildropdown" src="../img/emaildropdown5.png"></label>
            <ul>
                <li><a href="alumni_changepass"><i class="fa fa-user-lock"></i> Change password</a></li>
                <li><a href="alumni_personal_info"><i class="fa fa-user-cog"></i> Personal Info</a></li>
            </ul>

        </div>

        <div class="mainpanel">
        <div class="statuspanel">
        <?php
        
        if (!empty($success)) {

?>
           <label class='success'><i class='fa fa-check-circle'></i> <?php echo $success; ?></label> 
           <?php
           $success = "";
        }else{
            if (!empty($Allerror)) {
                ?>
                <label class='error'><i class='fa fa-exclamation-circle'></i> <?php echo $Allerror; ?></label>
                <?php
                $Allerror = "";
             }
        }
        
        ?>

        </div>

           <div class="datapanel">

           
           <span class="title-tab">Add Jobs</span>
           <span style="margin-left:30px; font-weight:500; font-size:15px; letter-spacing:1.5px;"><i class="fa fa-warning"></i> <i>Note: Form fields with ( <span class="req">*</span> ) means Required.</i></span><br>
           <div class="div-tab">
                <div class="cpasspanel">
                    <form action="" method="POST" autocomplete="off">
                    <table class="table-form">
                    <tr><td>
                    <span class="tag">Job Title <span class="req">*</span></span><br>
                    <span><input type="text" name="jobtitle" class="cinput" placeholder="Enter Job Title" value="<?php echo $title; ?>"></span>
                    
                    <br>
                    <span class="tag">Company <span class="req">*</span></span><br>
                    <input type="text" name="company"  class="infos" placeholder="Enter Company" value="<?php echo $company; ?>" >
                    
                    <br>
                    <span class="tag">Location <span class="req">*</span></span><br>
                    <input type="text" name="location" class="infos" placeholder="Enter Location" value="<?php echo $location; ?>">
                    
                    <br>
                    <span class="tag">Job Description <span class="req">*</span></span><br>
                    <textarea style="max-height:45px; height:45px;" name="jobdesc" id="" class="infos" placeholder="Enter Job Description"><?php echo $description; ?></textarea>
                    
                    <br>
                    <span class="tag">Qualification <span class="req">*</span></span><br>
                   
                    <textarea style="max-height:45px; height:45px;" name="qualify" id="" class="infos" placeholder="Enter Qualification"><?php echo $qualify; ?></textarea>
                    
                    <br>
                    <span class="tag">Date Needed <span class="req">*</span></span><br>
                    <input type="date"  name="dateneeded" class="infos"  value="<?php echo $date_needed; ?>">
                    
                    </td>
                    </tr>
                    </table>
                  
                </div>
                            <div class="btn-container">
                                <span style="margin-left:590px;">
                                <input type="submit" name="submit_btn" class="submit-btn" value="Post">
                                <input type="submit" name="cancel_btn" class="cancel-btn" Value="Cancel">
                                </span>
                                </form>
                            </div>
                </div>
            </div>


         </div>
  

</body>
</html>