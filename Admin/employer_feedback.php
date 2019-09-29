<?php
session_start();


if (isset($_SESSION["email"])) {
    $email = $_SESSION["email"];
}else{
    echo "<script>window.location.href='../Login';</script>";
}
include_once '../includes/connection.php';


if (isset($_GET['page'])) {
    $page = $_GET['page'];
}else {
    $page = 1;
}
$num_per_page = 10;
$start_from = ($page - 1)*10;


  

$sql_query = mysqli_query($conn, "SELECT ID, Name, account_type from userstb WHERE Email='$email'");
$fetch = mysqli_fetch_assoc($sql_query);
$db_name = ucfirst($fetch['Name']);
$db_account_type = $fetch['account_type'];
$db_id = $fetch['ID'];
$db_email = $email;
if ($db_account_type == 1) {
    $account_type = "Administrator";
}else{
    echo "<script>window.location.href='../Login';</script>";
}  

/**** 
if (isset($_POST['btn-send'])) {
    if (!empty($_POST['emp_checked'])) {
        $EMPIDs = $_POST['emp_checked'];
    foreach ($EMPIDs as $EMPID) {
        $sqlemp = mysqli_query($conn, "SELECT * from employertbl WHERE EMPID='$EMPID'");
        $fetchemp = mysqli_fetch_assoc($sqlemp);
        $empemail = $fetchemp['Employer_Email'];
        echo $empemail;
    }
}
}
**/




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
.table-stripped{
    border-collapse: collapse; 
    margin: 10px 0;
    font-size: 0.9em;
    max-width: 80%;
    
    box-shadow: 0 0 20px rgba(0,0,0,0.20);
    text-align: left;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
   
}
.tabl-modal{
    border-collapse: collapse; 
    margin: 10px 0;
    margin-left:20px;
    font-size: 0.9em;
    max-width: 80%;
    box-shadow: 0 0 20px rgba(0,0,0,0.20);
    text-align: left;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.tabl-modal th{
    background:#b5c0cce7;
    font-size: 1em;
}
.tabl-modal tbody td{
    border-bottom: 1px solid #7887966c;   
}
.tabl-modal tbody tr:hover{
    background-color: #bcbcbd88;
}





.table-stripped tbody tr td{
    text-overflow: hidden;
}
.table-stripped th{
    font-size: 1em;
    color:#191f25;
}
.table-stripped tbody td{
    border-bottom: 1px solid #7887966c;   
}
.table-stripped tbody tr:hover{
    background-color: #bcbcbd88;
}
.searchbtn{
    cursor:pointer;
    border-radius: 3px 3px 3px 3px;
    background: #2e68aa;
    text-decoration:none;
    border:none;
    padding: 3.5px 5px 3.2px 5px;
    color: #ffffff;
}
.searchbtn:hover{
    opacity:0.7;
}
.searchform{
    align: right;
}
.showentries{
    font-size: 0.9em;
    color: rgb(42, 47, 49);   
}
.btn-update{
    background: #4cbd3dfb;
    border-radius: 3px 3px 3px 3px;
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
.tooltip{
    display:none;
}
.toolq:hover ~ .tooltip{
    font-weight:bold;
    display:block;
    position:absolute;
    color:black;
    background: #f8fbfc81;
    border: 1px solid grey;
    margin-top:10px;
}
.tooltips{
    display:none;
}

.toolr:hover ~ .tooltips{
    font-weight:bold;
    display:block;
    position:absolute;
    color:black;
    background: #f8fbfc81;
    border: 1px solid grey;
    margin-left:30px;
    margin-top:10px;
    
}
.tooltipe{
    display:none;
}
.toole:hover ~ .tooltipe{
    font-weight:bold;
    display:block;
    position:absolute;
    color:black;
    background: #f8fbfc81;
    border: 1px solid grey;
    margin-left:55px;
    margin-top:10px;
}
.toole{
    padding: 5px 5px 5px 5px;
    border-radius: 3px 3px 3px 3px;
    color: #ffffff;
    font-size: 16px;
    background: #2e68aa;
    text-decoration: none;
    border:none;
    cursor: pointer;
}
.tooltipd{
    display:none;
}
.toold:hover ~ .tooltipd{
    font-weight:bold;
    display:block;
    position:absolute;
    color:black;
    background: #f8fbfc81;
    border: 1px solid grey;
    margin-left:65px;
    margin-top:10px;
}
.toold{
    border-radius: 3px 3px 3px 3px;
    color: #ffffff;
    font-size: 13px;
    background: #ff4949;
    padding: 6px 8px 6px 8px;
    text-decoration: none;
    border:none;
    cursor: pointer;
}
.toolprnt{
    border-radius: 3px 3px 3px 3px;
    color: #ffffff;
    font-size: 13px;
    background: #2e68aa;
    padding: 5 7 5 7;
    text-decoration: none;
    border:none;
    cursor: pointer;
   
}
.tooltiprnt{
    display:none;
}
.toolprnt:hover ~ .tooltiprnt{
    font-weight:bold;
    display:block;
    position:absolute;
    color:black;
    background: #f8fbfc81;
    border: 1px solid grey;
    margin-left:65px;
    margin-top:10px;
}
.toolr:hover, .toole:hover, .toolq:hover, .toold:hover{
    opacity:0.7;
}
.toolr{
    border-radius: 3px 3px 3px 3px;
    color: #ffffff;
    font-size: 13px;
    background: #2e68aa;
    padding: 5 7 5 7;
    text-decoration: none;
    border:none;
    cursor: pointer;
   
}

.toole{
    border-radius: 3px 3px 3px 3px;
    color: #ffffff;
    font-size: 13px;
    background: #2e68aa;
    padding: 5px 6px 5px 7px;
    text-decoration: none;
    border:none;
    cursor: pointer;
}
.toolq{
    border-radius: 3px 3px 3px 3px;
    color: #ffffff;
    font-size: 13px;
    background: #2e68aa;
    padding: 5px 7px 5px 7px;
    text-decoration: none;
    border:none;
    cursor: pointer;
}
.divText{
    width:170px;
    text-overflow: ellipsis;
    overflow: hidden;
}
#filter{
    height:21px;
    outline:none;
    border:1px solid #2e68aa;
    color: #2e68aa;
}
.print_grad{
    letter-spacing:0.2;
    margin:0; 
    padding:4; 
    background:#ff4949;
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
.modal{
    display:none;
    position:fixed;
    z-index: 1;
    Padding-top: 300px;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0,0,0);
    background-color: rgba(0,0,0,0.4);
}
.modal-content{
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    padding-top:0;
    padding-right:10px;
    border: 1px solid #888;
    width: 30%;
}
.close{
    padding:2px 6px 2px 6px;
    background:#2e68aa;
    color: #aaaaaa;
    float:right;
    font-size: 25px;
    font-weight: bold;
    margin-right:-10px;
}
.close:hover,
.close:focus{
    color:#000;
    text-decoration: none;
    cursor:pointer;
}
.btn-confirm{
    border-color: #fff;
    font-size:15px;
    font-weight:500;
    color:rgba(0,0,0,0.750);
}
.btn-confirm:hover{
    cursor:pointer;
}
.pw{
    width:300px;
}
.modal-send{
    display:none;
    position:fixed;
    z-index: 1;
    Padding-top: 200px;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0,0,0);
    background-color: rgba(0,0,0,0.4);
}
.modal-content-send{
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    padding-top:0;
    padding-right:10px;
    border: 1px solid #888;
    width: 50%;
    max-height:200px;
}
.close-send{
    padding:2px 6px 2px 6px;
    background:#2e68aa;
    color: #aaaaaa;
    float:right;
    font-size: 25px;
    font-weight: bold;
    margin-right:-10px;
}
.close-send:hover,
.close-send:focus{
    color:#000;
    text-decoration: none;
    cursor:pointer;
}
.btn-confirm-send{
    border-radius:3px;
    border:none;
    background: #2e68aa;
    font-size:13px;
    font-weight:500;
    color:aliceblue;
    padding:4px;
}
.btn-confirm-send:hover{
    cursor:pointer;
}
#batch{
    width:150px;
    margin-left:5px;
}

.modal-delall{
    display:none;
    position:fixed;
    z-index: 1;
    Padding-top: 300px;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0,0,0);
    background-color: rgba(0,0,0,0.4);
    
}
.modal-content-delall{
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    padding-top:0;
    padding-right:10px;
    border: 1px solid #888;
    width: 30%;
}
.close-delall{
    padding:2px 6px 2px 6px;
    background:#2e68aa;
    color: #aaaaaa;
    float:right;
    font-size: 25px;
    font-weight: bold;
    margin-right:-10px;
}
.close-delall:hover,
.close-delall:focus{
    color:#000;
    text-decoration: none;
    cursor:pointer;
}
.btn-confirm-delall{
    border-radius:3px;
    border:none;
    background: #2e68aa;
    font-size:13px;
    font-weight:500;
    color:aliceblue;
    padding:4px;
}
.btn-confirm-delall:hover{
    cursor:pointer;
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

            <!--Modal for delete -->
                    <div class="modal">
                    <div class="modal-content">
                    <span class="close">&times;</span>
                    <p style="color:rgba(0,0,0,0.750); font-size:16px; font-weight:600;">
                    Enter your password to continue..</p>
                    <input type="password" name="pw" id="pw" class="pw" placeholder="enter password here.." autofocus>
                    <button class="btn-confirm" >Confirm</button>
                    </div>
                    </div>

                <!--Modal for delete all-->
                <div class="modal-delall">
                    <div class="modal-content-delall">
                    <span class="close-delall">&times;</span>
                    <p style="color:rgba(0,0,0,0.750); font-size:16px; font-weight:600;">
                    Enter your password to continue..</p>
                    <input type="password" name="pw" id="pww" class="pw" placeholder="enter password here.." autofocus>
                    <button class="btn-confirm-delall" >Confirm</button>
                    </div>
                    </div>

    
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
            if (!empty($_GET['notify'])) {
                echo "<br><h5 class='hnoti'><font color='green'><i class='fa fa-check-circle'></i> ". $_GET['notify'] ."</font></h5>";
                unset($_GET['notify']);
            } 
            if (!empty($_GET['errors'])) {
                echo "<br><h5 class='hnoti'><font color='red'><i class='fa fa-exclamation-circle'></i> ". $_GET['errors'] ."</font></h5>";
                unset($_GET['errors']);
            } 
            ?>
            </div>
           <div class="datapanel">
                
           <CAPTION><h3>Employers Feedback</h3></CAPTION>
           
            <center><table border="0" class="searchtable" width="770">
            <tr><td>
            <form align="right"class="searchform" action="" method="POST">
            <input type="text" name="searchbox" placeholder="Filter here..">
            <select name="filter" id="filter">
            
            <option value="Employer_Name">Employer Name</option>
            <option value="Company">Company</option>
            <option value="date">Date</option>
            <option value="time">Time</option>
            </select>
            <input type="submit" class="searchbtn" name="search" value="Filter">
            </td></tr>
            </form>
            </table></center>

            
            <a onclick="deleteall()" class='print_grad' style=''><i class='fa fa-trash-alt'></i> Delete all</a>
                <table border="0" width="100%" align="center" class="table-stripped" >

                    

                    <thead>
                        <tr height="35"> 
                            
                            <th >Employer Name</th>
                            <th >Company</th>
                            <th >Graduates</th>
                            <th >Date</th>
                            <th >Time</th>
                            <th >Actions</th>

                        </tr>
                    </thead>
                      


                            <?php
                //**************************Search button */
                                if (!isset($_POST['search'])) {
                                    
                            ?>
                        
                                <?php
                //***************************Edit button */        
                                if (empty($_GET["getEdit"])) {
                                
                                


                                ?>

                                    
                        <?php 
                //***************************Showing all Surveys  */ 
                                    
                        $query = mysqli_query($conn, "SELECT * FROM employer_respondenttbl");
                        $total_count = mysqli_num_rows($query);
                        if ($total_count == 0) {
                            echo "<tr><td colspan='6'>
                            <center><b>No Record Found</b></center>
                            </td></tr></table>";
                        } else {
            
                        $sql = "SELECT * FROM employer_respondenttbl ORDER BY EMP_ID DESC limit $start_from,$num_per_page";
                        $result = $conn-> query($sql);

                        if ($result-> num_rows > 0){
                            $showcount = 0;
                            while ($fetch = $result-> fetch_assoc()){
                                $EMP_ID = $fetch['EMP_ID'];
                                $date = $fetch['date'];
                                $time = $fetch['time'];
                                $queryemp = mysqli_query($conn, "SELECT * FROM employertbl WHERE EMPID = '$EMP_ID'");
                                $fetchemployer = mysqli_fetch_assoc($queryemp);
                                $GID = $fetchemployer['GID'];
                                $company = $fetchemployer['Company'];
                                $emp_name = $fetchemployer['Employer_Name'];
                                $type = $fetchemployer['Type_Company'];
                                $emp_email = $fetchemployer['Employer_Email'];
                                $querygrad = mysqli_query($conn, "SELECT * FROM graduates_infotbl WHERE GID = '$GID'");
                                $res = mysqli_fetch_assoc($querygrad);
                                $name = $res['firstname']." ".$res['middlename']." ".$res['lastname'];

                            $jScript = md5(rand(1,9));
                            $newScript = md5(rand(1,9));
                            $getResponse = md5(rand(1,9));
                            $getQuestion = md5(rand(1,9));
                            $getEdit = md5(rand(1,9));
                            $getDelete = md5(rand(1,9));

                          

                //******************************SHOWING Survey TABLE <img src='../img/responsewhite.png'> <img  src='../img/questionwhite.png'>  <img src='../img/Addreswhite.png'> <img src='../img/delete1.png'>*/
                            
                            echo "<tbody><tr height='30'>

                                    <td><div class='divText' style='width:120px;'>$emp_name</div></td>
                                    <td><div class='divText' style='width:150px;'>$company</div></td>
                                    <td><div class='divText'style='width:150px;'>$name</div></td>
                                    <td>$date</td>
                                    <td>$time</td>
                                  
                                   <td width='80px'>
                                   
                                  
                                  
                                   <a class='toolprnt' href='../TCPDF/User/Print_employer?jScript=$jScript && newScript=$newScript && getQuestion=$getQuestion && EMPID=$EMP_ID && GID=$GID' target='_blank'>
                                   <i class='fa fa-print'></i></a>
                                   <span class='tooltiprnt'>Print Feedback</span>
                                   
                                   <button class='toold' onClick='deleteme($EMP_ID)'>
                                   <i class='fa fa-trash-alt'></i></button>
                                   <span class='tooltipd'>Delete</span>
                                   </td>                         
                                 </tr>
                                 </tbody>
                                 
                                 ";
                                 
                
                            }

                            $total_page = ceil($total_count/$num_per_page);
                                
                                $count_to = $showcount + $start_from;
                                if ($page >= 1) {
                                    $start_from = $start_from + 1;
                                }
                                    echo "</table>
                                    <span class='showentries'>Showing $start_from to $count_to of  $total_count entries</span>";
                                    
                                    echo "<span class='pagination'>";
                        
                                    if ($page > 1) {
                                        echo "<a href='manageusers?page=".($page - 1)."' class='prev-button'>Previous</a>";
                                    }


                                    echo "<button disabled class='page-active'>".$page."<br><span class='mini-page'>Page</span></button>";


                                    if ($page != $total_page) {
                                        echo "<a href='manageusers?page=".($page + 1)."' class='next-button'>Next</a>";
                                    }

                                  
                                echo "</span>";



                    }
                }
                ?>
                        
                        <?php
                        /**Edit button */
                        }else{
                            include 'updating_users.php';
                        }
                        ?>
                        
                        <?php
                        /**Search button */
                        }else{
                            $preg_rep = $_POST['searchbox'];
                            $preg_rep = preg_replace("#[^0-9a-z@. ]#i","",$preg_rep);
                            echo "<script>window.location.href='search_feedback?filt=".$preg_rep."&&cat=".$_POST['filter']."';</script>";
                        }
                        ?>
                      

                        


                      <script language="javascript">
                        var span = document.getElementsByClassName("close")[0];
                        var modal = document.getElementsByClassName("modal")[0];
                        var btn = document.getElementsByClassName("btn-confirm")[0];
                        var spandel = document.getElementsByClassName("close-delall")[0];
                        var modaldel = document.getElementsByClassName("modal-delall")[0];
                        var btndel = document.getElementsByClassName("btn-confirm-delall")[0];
                        //close button
                        span.onclick = function(){
                            modal.style.display = "none";
                        }
                        window.onclick = function(event){
                            if(event.target == modal){
                                modal.style.display = "none";
                            }
                        }
                        //delete/confirm button
                         function deleteme(delid){

                        if (confirm("Youre about to delete Employer, continue?")) {

                                window.location.href='del_feedback?del_id='+delid+'';
                                    return true;
                                    }
                                }
                         //close button
                         spandel.onclick = function(){
                            modaldel.style.display = "none";
                        }
                        window.onclick = function(event){
                            if(event.target == modaldel){
                                modaldel.style.display = "none";
                            }
                        }
                            function deleteall(){

                                    modaldel.style.display = "block";
                                    
                                    btndel.onclick = function(){    
                                    var pw = document.getElementById("pww").value;
                                    if (pw != "") {
                                        window.location.href='delete_all_feedback?pw='+pw+'';
                                    }
                                    
                                }

                        }

                        </script>

                
            </div>
                
         </div>
  

</body>
</html>