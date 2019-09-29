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



if (isset($_GET['page'])) {
    $page = $_GET['page'];
}else {
    $page = 1;
}
$num_per_page = 10;
$start_from = ($page - 1)*10;
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
.table-stripped tbody tr:hover{
    background-color: #bcbcbd88;
}
.searchbtn{
    
    border-radius: 3px 3px 3px 3px;
    background: #2e68aa;
    text-decoration:none;
    border:none;
    padding: 3.5px 5px 3.2px 5px;
    color: #ffffff;
    
}
.searchbtn:hover{
    opacity:0.7;
    cursor:pointer;
    text-decoration:none;
    
}
.searchform{
    align: right;
}
.showentries{
    font-size: 0.9em;
    color: rgb(42, 47, 49);   
}
.bt-update {
    background: #2e68aa;
    border-radius: 3px 3px 3px 3px;
    padding: 12 6 0 6;
}
.bt-update:hover {
    opacity:0.7;
}

.pagination{
    text-align:center;
    float:right;
    margin-right: 22px;
}
.prev-button{
    border-radius: 3px 3px 3px 3px;
    
    padding: 3px 5px 3px 5px;
    color:grey;
    text-decoration:underline;
    font-family: Helvetica, sans-serif;
    font-size: 0.9em;
    border:none;
    font-weight: bold;
}
.next-button{
    border-radius: 3px 3px 3px 3px;
    
    padding: 3px 5px 10px 5px;
    color:grey;
    text-decoration:underline;
    font-family: Helvetica, sans-serif;
    font-size: 0.9em;
    border:none;
    font-weight: bold;
   
}
.page-active{
    padding: 1px 12px 1px 12px;
    background:none;
    font-size:1em;
    border:none;
    border-radius: 3px 3px 3px 3px;
       
}
.mini-page{
    font-size:0.5em;
     
}
.active{
    background:#03254c;
}
.tooltipv{
    display:none;
}
.bt-view{
    background: #2e68aa;
    color:aliceblue;
    border-radius: 3px 3px 3px 3px;
    padding: 5 5 3 5;
}
.bt-view:hover{
    opacity:0.7;
}
.bt-view:hover ~ .tooltipv{
    font-weight:bold;
    display:block;
    position:absolute;
    color:black;
    background: #f8fbfc81;
    border: 1px solid grey;
    margin-top:10px;
}
.tooltipu{
    display:none;
}
.bt-update:hover ~ .tooltipu{
    font-weight:bold;
    display:block;
    position:absolute;
    color:black;
    background: #f8fbfc81;
    border: 1px solid grey;
    margin-top:10px;
}
.tooltipd{
    display:none;
}
.bt-delete{
    padding: 7 6 5 6;
    border-radius: 3px 3px 3px 3px;
    font-family: Georgia;
    color: #ffffff;
    background: #ff4949;
    text-decoration: none;
    border:none;
    cursor: pointer;
}
.bt-delete:hover{
    opacity:0.7;
}
.bt-delete:hover ~ .tooltipd{
    font-weight:bold;
    display:block;
    position:absolute;
    color:black;
    background: #f8fbfc81;
    border: 1px solid grey;
    margin-left:30px;
    margin-top:10px;
}
.divId{
    width:100px;
    text-overflow: ellipsis;
    overflow: hidden;
    margin:0;
    padding-right:-10;
    
}
.divText{
    width:170px;
    text-overflow: ellipsis;
    overflow: hidden;
    margin:none;
    padding:none;
}

.print_grad{
    letter-spacing:0.2;
    margin:0; 
    padding:4; 
    background:#2e68aa; 
    color:aliceblue; 
    border:0; 
    border-radius: 3px 3px 3px 3px; 
    cursor:pointer;
    font-size:13px;
    font-weight:500;
    text-decoration:none;
}
.print_grad:hover{
    opacity:0.7;
}
.addenum:hover{
    opacity:0.7;
}
#filter{
    height:21px;
    outline:none;
    border:1px solid #2e68aa;
    color: #2e68aa;
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
                ?>
            </div>
                <div class="datapanel">
                
                <CAPTION><h3>Job Offerings</h3></CAPTION>
          

            <center><table border="0" class="searchtable" width="770">
            <tr><td>
            
            <form align="right"class="searchform" action="" method="POST">
            
            <input type="text" name="searchbox" placeholder="Filter here..">
            <select name="filter" id="filter">
            <option value="title">Job Title</option>
            <option value="company">Company</option>
            <option value="location">Location</option>
           
            </select>
            <input type="submit" class="searchbtn" name="search" value="Filter">
            
            </td></tr>
            </form>
            </table></center>

            <button onclick="Addgrad()" class="addenum" style="margin:0; padding:4; background:#2e68aa; color:aliceblue; border:0; border-radius: 3px 3px 3px 3px; cursor:pointer;"><img src="" alt=""><i class="fa fa-briefcase"></i> My Job Offerings</button>
            
           
                <table border="0" width="500" align="center"class="table-stripped" >

                    

                    <thead>
                        <tr height="30"> 
                            <th >Job Title</th>
                            <th>Company</th>
                            <th >Location</th>
                            <th >Actions</th>
                        </tr>
                    </thead>

                            <?php
                //**************************Filtering code start here */
                                if (!isset($_POST['search'])) {
                                    
                            ?>
                        
                                <?php
                //***************************Update button code start here */        
                                if (empty($_GET["getUpdate"])) {
                                
                                


                                ?>

                                    
                        <?php 
                //***************************Showing all enumerators */ 
                        $query = mysqli_query($conn, "SELECT * FROM job_offeringtbl");
                        $total_count = mysqli_num_rows($query);
                        if ($total_count == 0) {
                            echo "<tr><td colspan='4'>
                            <center><b>No Record Found</b></center>
                            </td></tr></table>";
                        } else {

                        $sql = "SELECT * FROM job_offeringtbl order by JID desc limit $start_from,$num_per_page ";
                        $result = $conn-> query($sql);

                        if ($result-> num_rows > 0){
                            
                            $showcount = 0;
                            while ($row = $result-> fetch_assoc()){
                                $showcount = $showcount + 1;
                                $JID = $row['JID'];
                                $title = $row['title'];
                                $company = ucfirst($row['company']);
                                $location = $row["location"];
                               
                                

                            $jScript = md5(rand(1,9));
                            $newScript = md5(rand(1,9));
                            $getUpdate = md5(rand(1,9));
                            $getDelete = md5(rand(1,9));
                                
                
                            echo "<tbody><tr height=30>
                                    <td ><div class='divText'>$title</div></td>
                                    <td ><div class='divText'>$company</div></td>
                                    <td ><div class='divText'>$location</div></td>
                                    
                                  
                                   <td width='50px'>
                                   <a href='job_details?jScript=$jScript && newScript=$newScript && view=$getUpdate && JID=$JID' class='bt-view'>
                                   <i class='fa fa-eye'></i></a>
                                   <span class='tooltipv'>View more details</span>
                                   <button onClick='deleteme($JID)' class='bt-delete'>
                                   <i class='fa fa-trash-alt'></i></button>
                                   <span class='tooltipd'>Delete</span>
                                   </td>                         
                                 </tr>
                                 </tbody>
                                 
                                 ";
                                 
                
                            }

                        //Next And Prev buttons
                            $total_page = ceil($total_count/$num_per_page);
                                
                                $count_to = $showcount + $start_from;
                                if ($page >= 1) {
                                    $start_from = $start_from + 1;
                                }
                                    echo "</table>
                                    <span class='showentries'>Showing $start_from to $count_to of  $total_count entries</span>";
                                    
                                    echo "<span class='pagination'>";
                        
                                    if ($page > 1) {
                                        echo "<a href='Manage_enumerator?page=".($page - 1)."' class='prev-button'>Previous</a>";
                                    }


                                    echo "<button disabled class='page-active'>".$page."<br><span class='mini-page'>Page</span></button>";


                                    if ($page != $total_page) {
                                        echo "<a href='Manage_enumerator?page=".($page + 1)."' class='next-button'>Next</a>";
                                    }

                                  
                                echo "</span>";


                                
                        

                    }else{
                        echo "<tr><td>
                            <center><b>No Record Found</b></center>
                            </td></tr></table>";
                    }
                }
                ?>
                        
                        <?php
                        }else{

                        include 'updating_enum.php';
                        }
                        ?>

                        <?php

                        }else{

                            $preg_rep = $_POST['searchbox'];
                            $preg_rep = preg_replace("#[^0-9a-z@. ]#i","",$preg_rep);
                            echo "<script>window.location.href='search_jobs?filt=".$preg_rep."&&cat=".$_POST['filter']."';</script>";

                            } 
                        
                    
                        ?>
        
                        <script language="javascript">

                        function deleteme(delid){

                        if (confirm("Youre about to delete Alumni, continue?")) {

                                window.location.href='del_job?del_id='+delid+'';
                                    return true;
                                    }
                                }

                            function Addgrad(){
                                window.location.href='my_post_jobs';
                            }
                            

            </script>


                
                </div>
                
        </div>
  

</body>
</html>