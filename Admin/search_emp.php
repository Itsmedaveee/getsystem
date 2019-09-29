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
        exit();
}


if (isset($_GET['page'])) {
    $page = $_GET['page'];
    
}else {
    $page = 1;
}
if (isset($_POST['search'])) {
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
    padding: 4 5 5 5;
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
    border-radius: 3px 3px 3px 3px;
    font-family: Georgia;
    color: #ffffff;
    background: #ff4949;
    padding: 6 6 6 6;
    text-decoration: none;
    border:none;
    cursor: pointer;
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
.divLName{
    width:80px;
    text-overflow: ellipsis;
    overflow: hidden;
    margin:0;
    padding:0;
}
.divFName{
    width:80px;
    text-overflow: ellipsis;
    overflow: hidden;
    margin:0;
    padding:0;
}
.divMName{
    width:80px;
    text-overflow: ellipsis;
    overflow: hidden;
    margin:0;
    padding:0;
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
.divText{
    width:180px;
    text-overflow: ellipsis;
    overflow: hidden;
    padding:none;
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
#filter{
    height:21px;
    outline:none;
    border:1px solid #2e68aa;
    color: #2e68aa;
}
.tooltipsend{
    display:none;
}
.toolsend:hover ~ .tooltipsend{
    font-weight:bold;
    display:block;
    position:absolute;
    color:black;
    background: #f8fbfc81;
    border: 1px solid grey;
    margin-left:25px;
    margin-top:10px;
}
.toolsend{
    border-radius: 3px 3px 3px 3px;
    color: #ffffff;
    font-size: 13px;
    background: #2e68aa;
    padding: 6px 8px 6px 8px;
    text-decoration: none;
    border:none;
    cursor: pointer;
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
                            <label for="" class="fullname"><?php echo ucfirst($db_name); ?></label>
                            
                        </div>

                        <div class="emailacc">
                            
                            <p class="email-user" ><b><?php echo $email; ?></b><br><i><font color="#ffffff"><?php echo $account_type; ?></font></i>
                            </p>
                        </div>
                            
                    </div>
            
        
            <div class="navpanel">

                <div class="multi-level">
                    <div class="item">
                        <input type="checkbox"  id="A">
                        <img src="../img/emaildropdown5.png" class="arrow"><label for="A">Users</label>
                        <ul>
                            <li><a style="padding-top:20px; padding-bottom:20px;" href="account_request"><i class="fa fa-user-plus"></i> Account Requests</a></li>
                            <li ><a style="padding-top:20px; padding-bottom:20px;" href="manageusers"><i class="fa fa-users-cog"></i> Manage Users</a></li>
                            <li class="active"><a style="padding-top:20px; padding-bottom:20px;" href="Manage_enumerator"><i class="fa fa-users"></i> Enumerators</a></li>
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
         <input type="checkbox" id="D">
         <label for="D"><img class="emaildropdown" src="../img/emaildropdown5.png"></label>
                            <ul>
                                <li><a href="change_adminpass"><i class="fa fa-lock"></i> Change password</a></li>
                                <li><a href="change_adminemail"><i class="fa fa-at"></i> Update Email</a></li>
                                <li><a href="change_admincontact"><i class="fa fa-phone"></i> Update Contact</a></li>
                            </ul>

                            </ul>
        </div>

         <div class="mainpanel">
         <div class="statuspanel">
           
            </div>
           <div class="datapanel">

           

           <CAPTION><h3>List of Employers</h3></CAPTION>
            <?php
            
            if (isset($_POST['search'])) {
                $filter = $_POST['filter'];
                $a = $_POST['searchbox'];
                $searchdb = preg_replace("#[^0-9a-z@.]#i","",$a);
            }else{
                if(empty($_GET["getUpdate"])){

                    if (isset($_GET['filt'])) {
                        
                        $a = $_GET['filt'];
                        $filter = $_GET['cat'];
                        $searchdb = preg_replace("#[^0-9a-z@.]#i","",$a);
                    }
                    
                    }else{
                        $searchdb = "";
                    }
            }
        
            ?>
            <script>
            function Addgrad(){
                window.location.href='Add_graduates';
            }
            
  
            </script>
            <center><table border="0" class="searchtable" width="770">
            <tr><td>
            <form align="right"class="searchform" action="" method="POST">
            <input type="text" name="searchbox" placeholder="Filter here.." value="<?php echo $searchdb; ?>">
            <select name="filter" id="filter">
                                            
            <option value="Employer_Name">Employer Name</option>
            <option value="Job_Title">Job Title</option>
            <option value="Company">Company</option>
            </select>
            <input type="submit" class="searchbtn" name="search" value="Filter">
            </td></tr>
            </form>
            </table></center>

            <a href='emp_question?SID=38' class='print_grad' style=''><i class='fa fa-edit'></i> Modify Questions</a>
            <a onClick="sendall()" class='print_grad' style=''><i class='fa fa-paper-plane'></i> Send to all</a>
            <table border="0" width="500" align="center"class="table-stripped" >

                    

            <thead>
                        <tr height="35"> 
                            
                            
                            <th >Employer Name</th>
                            <th >Job Title</th>
                            <th >Company</th>
                            <th >Actions</th>

                        </tr>
                    </thead>

                    
                                <?php

                            
                            
                                
                               
                                 
                //***************************Update button code start here */ 
                
                                if (empty($_GET["getUpdate"])) {
                                
                                


                                ?>

                                    
                        <?php 

                    
                    if(isset($_POST['search'])){
                     $searchdb = $_POST['searchbox'];
                     $filter = $_POST['filter'];
                     $searchdb = preg_replace("#[^0-9a-z@.]#i","",$searchdb);
                    }else{
                    if(isset($_GET['filt'])) {
                        $searchdb = $_GET['filt'];
                        $filter = $_GET['cat'];
                        $searchdb = preg_replace("#[^0-9a-z@.]#i","",$searchdb);
                    }
                }     
            

                    $query = mysqli_query($conn, "SELECT * FROM employertbl WHERE $filter LIKE '%$searchdb%'");
                    $total_count = mysqli_num_rows($query);
                
                    if ($total_count == 0) {
                        echo "<tr><td colspan='7'>
                        <center><b>No Record Found</b></center>
                        </td> </tr>"; 
                                      
                        } else {
                    
                        

                    $sql = "SELECT * from employertbl WHERE $filter LIKE '%$searchdb%' order by EMPID desc limit $start_from,$num_per_page ";
                    $result = $conn-> query($sql);
                    $showcount = 0;
                    //******************************SHOWING Searchbox TABLE(userstb)   */
                    if ($result-> num_rows > 0){
                        while ($fetch = $result-> fetch_assoc()){
                            $showcount = $showcount + 1;
                            $EMP_ID = $fetch['EMPID'];
                            $GID = $fetch['GID'];
                            $jobtitle = $fetch['Job_Title'];
                            $company = $fetch['Company'];
                            $emp_name = $fetch['Employer_Name'];
                            
                            
                            $queryemp = mysqli_query($conn, "SELECT * FROM employer_respondenttbl WHERE EMP_ID = '$EMP_ID'");
                            $respondentcount = mysqli_num_rows($queryemp);
                            if ($respondentcount > 0) {
                                $plane = "hidden";
                              
                            }else{
                                $plane = "";
                               
                            }
                            
                            $jScript = md5(rand(1,9));
                            $newScript = md5(rand(1,9));
                            $getResponse = md5(rand(1,9));
                            $getQuestion = md5(rand(1,9));
                            $getEdit = md5(rand(1,9));
                            $getDelete = md5(rand(1,9));
                        
            
                        echo "<tbody><tr height=30>

                        <td><div class='divText'>$emp_name</div></td>
                        <td><div class='divText'>$jobtitle</div></td>
                        
                        <td><div class='divText'>$company</div></td>
                       
                      
                        <td width='100px'>
                        <a $plane class='toolsend' href='send_emp_survey?jScript=$jScript && newScript=$newScript && getQuestion=$getQuestion && EMPID=$EMP_ID && GID=$GID' >
                        <i class='fa fa-paper-plane'></i></a>
                        <span class='tooltipsend'>Send Survey</span>

                       <a class='toolr' href='employer_feedback?jScript=$jScript && newScript=$newScript && getQuestion=$getQuestion && EMPID=$EMP_ID && GID=$GID' >
                       <i class='fa fa-eye'></i></a>
                       <span class='tooltips'>Send Survey</span>
                      
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
                            if ($page >=1) {
                                $start_from = $start_from + 1;
                            }
                                echo "</table>
                                <span class='showentries'>Showing $start_from to $count_to of  $total_count entries</span>";
                                
                                echo "<span class='pagination'>";

                                if (isset($_POST['searchbox'])) {
                                    if (isset($_GET['filt'])) {
                                    
                                    $filt = $_POST['searchbox'];
                                    $filt = preg_replace("#[^0-9a-z@. ]#i","",$filt);
                                    $cat = $_POST['filter'];
                                    }                                  
                                }else{
                                    $filt = $searchdb;
                                    $cat = $filter;
                                }
                    
                                if ($page > 1) {
                                    echo "<a href='?page=".($page - 1)."&&filt=".$filt."&&cat=".$cat."' class='prev-button'>Previous</a>";
                                }


                                echo "<button disabled class='page-active'>".$page."<br><span class='mini-page'>Page</span></button>";


                                if ($page != $total_page) {
                                    echo "<a href='?page=".($page + 1)."&&filt=".$filt."&&cat=".$cat."' class='next-button'>Next</a>";
                                }

                                
                            echo "</span>";
                            }
                    }
            
               
                
                ?>
                        
                        <?php
                        } else{
                        
                        include 'updating_enum.php';
                        }
                                
                        ?>

        
                        <script language="javascript">
                        function sendall(){

                        if (confirm("Send feedback Survey to all Employers? Confirm..")) {

                                window.location.href='send_emp_all.php';
                                    return true;
                                    }
                                }
                       
                        //delete modal functions
                        var span = document.getElementsByClassName("close")[0];
                        var modal = document.getElementsByClassName("modal")[0];
                        var btn = document.getElementsByClassName("btn-confirm")[0];
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

                                window.location.href='delete_employer?del_id='+delid+'';
                                    return true;
                                    }
                                }

                        </script>
                       
         
            </div>
                
         </div>
  

</body>
</html>