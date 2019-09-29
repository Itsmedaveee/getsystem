<?php
$encrypted = md5(rand(1,9));
session_start();
if (isset($_SESSION["email"])) {
    $email = $_SESSION["email"];
}else{
    echo "<script>window.location.href='../Login';</script>";
    
}
include_once '../includes/connection.php';

$sql_query = mysqli_query($conn, "SELECT ID, Name, account_type from userstb WHERE Email='$email'");
$fetch = mysqli_fetch_assoc($sql_query);
$db_name = ucfirst($fetch['Name']);
$db_account_type = $fetch['account_type'];
$userID = $fetch['ID'];
$db_email = $email;
if ($db_account_type == 2) {
    $account_type = "Data Processor/Encoder";
    
}else{
    echo "<script>window.location.href='../Login';</script>";
    
}

if(!empty($_GET['SID']))
            {
            $surveyID = $_GET['SID'];
            
            
            $sql_query = mysqli_query($conn, "SELECT Title, Description from mysurveytbl WHERE Survey_ID='$surveyID'");
            $fetch = mysqli_fetch_assoc($sql_query);
            $SurveyTitle = $fetch['Title'];
            $Description = $fetch['Description'];
            }
            
//create dynamic function
$sqlfunction = "SELECT * FROM questiontbl WHERE Survey_ID='$surveyID'";
$resultfunction = $conn-> query($sqlfunction);
                        
    if ($resultfunction-> num_rows > 0){

        $countfunction = 0;
        while ($rowfunc = $resultfunction-> fetch_assoc()){
            $QsType = $rowfunc['QuestionType'];
            $reqq = $rowfunc['Required'];
            $otherOpt = $rowfunc['Others'];
            $countfunction = $countfunction + 1;


        //for multiplechoice function
            if ($QsType == "Multiplechoice") { 
                    $postAnswerf = "mult".$countfunction;
                    $postTextAnswerf = "multi".$countfunction;
                    echo "
            <script>
            function focus$countfunction(){
            var a = document.getElementById('$postAnswerf');
            var b = document.getElementById('$postTextAnswerf');
            if(a.checked){
                b.focus();
                if('$reqq' == 'yes'){
                    b.setAttribute('required','');
                    }
            }else{
                b.removeAttribute('required');
                
            }
        }
            </script>
            
            ";
            }
        //for checkbox function
        if ($QsType == "Checkbox") { 
                    $postAnswerf = "OthersChoiceforQ".$countfunction;
                    $postTextAnswerf = "OtherAnswerforQ".$countfunction;
                    $postAnswerff = "AnswerforQ".$countfunction."[]";
                    echo "
            <script>

            function focus$countfunction(){
                
                var chkbxs = document.getElementsByName('$postAnswerff');
                var len = chkbxs.length;
                var chk = false;
            var a = document.getElementById('$postAnswerf');
            var b = document.getElementById('$postTextAnswerf');
            if(a.checked){

                b.focus();
                if('$reqq' == 'yes'){
                    b.setAttribute('required','');
                    }
                
            }else{
                b.removeAttribute('required');

                 }

            if('$reqq' == 'yes'){

                 for(var i=0;i < len;i++){

                    if(chkbxs[i].checked){

                    chk = true;
                    break;

                    }
                }

                    if(chk){

                        for(var i=0;i < len;i++){

                            chkbxs[i].removeAttribute('required');
                            
                            }
                        }
                                if(chk == false){
                                    
                                for(var i=0;i < len;i++){

                                    if(a.checked){

                                        chkbxs[i].removeAttribute('required');
                                       
                                        }else{

                                            if('$reqq' == 'yes'){

                                                chkbxs[i].setAttribute('required','');

                                                }
                                        }
                                }
                            }
                        }
            }
        

            function valdis$countfunction(){
            var txtbx = document.getElementById('$postAnswerf');
            var chkbxs = document.getElementsByName('$postAnswerff');
            var len = chkbxs.length;
            var chk = false;
        
                for(var i=0;i < len;i++){
                    if(chkbxs[i].checked){
                    chk = true;
                    break;
                    }
                }
                if(chk){
                    
                    for(var i=0;i < len;i++){
                        chkbxs[i].removeAttribute('required');
                        }
                        
                    }

                               
                            if(chk == false){
                                for(var i=0;i < len;i++){
                                    if(txtbx.checked){
                                            chkbxs[i].removeAttribute('required');
                                        }else{
                                            if('$reqq' == 'yes'){
                                            chkbxs[i].setAttribute('required','');
                                            }
                                        }
                                    }
                                }
                
            }
            </script>
            
            ";
            }


        }

    }
            
//Cancel button **************************
if (isset($_POST['cancelQbtn'])) {
    echo "<script>window.location.href='user_survey';</script>";
}

//Iserting All inputs to database **************************

if (isset($_POST['addAllbtn'])) {

    include_once '../includes/secondaryConnection.php';

    if(!empty($_GET['SID']))
            {
            $surveyID = $_GET['SID'];
            }

    if (empty($_POST['Enumerators'])) {
        echo "<script>alert('Please Select Enumerator');</script>";
    }else{
        $EID = $_POST['Enumerators'];
        mysqli_query($conn2, "INSERT INTO Respondenttbl(Survey_ID,EnumeratorID) VALUES('$surveyID','$EID')");
        $RID = $conn2-> insert_id;


    $sql = "SELECT * FROM questiontbl WHERE Survey_ID='$surveyID'";
    $result = $conn-> query($sql);
                            
        if ($result-> num_rows > 0){

            $count = 0;
            while ($row = $result-> fetch_assoc()){
                $QID = $row['QuestionID'];
                $QType = $row['QuestionType'];
                $Question = $row['Question'];
                $Required = $row['Required'];
                $count = $count + 1;
            
                if ($QType == "ShortAnswer") {
                    $postAnswer = "AnswerforQ".$count;

                    if (!empty($_POST[$postAnswer])) {
                        $Response = $_POST[$postAnswer];
                    }else{
                        $Response = "Not Answered";
                    }
                        mysqli_query($conn, "INSERT INTO responsetbl(Question_ID,RespondentID,Response) VALUES('$QID','$RID','$Response')");

                        }
                    

                 if ($QType == "LongAnswer") {
                    $postAnswer = "AnswerforQ".$count;
                    if (!empty($_POST[$postAnswer])) {
                        $Response = $_POST[$postAnswer];
                    }else{
                        $Response = "Not Answered";
                    }
                        mysqli_query($conn, "INSERT INTO responsetbl(Question_ID,RespondentID,Response) VALUES('$QID','$RID','$Response')");
                                    
                        }
                
                        if ($QType == "Date") {
                            $postAnswer = "AnswerforQ".$count;                  
                            if (!empty($_POST[$postAnswer])) {
                                $Response = $_POST[$postAnswer];
                            }else{
                                $Response = "Not Answered";
                            }
                                mysqli_query($conn, "INSERT INTO responsetbl(Question_ID,RespondentID,Response) VALUES('$QID','$RID','$Response')");
                            
                                    
                        } 


        //Multiplechoice
                if ($QType == "Multiplechoice") {
                   
                    $postAnswer = "AnswerforQ".$count;
                    $postTextAnswer = "TextAnswerforQ".$count;
                
                    if (!empty($_POST[$postAnswer])) {
                        if ($_POST[$postAnswer] == "other") {
                                if (!empty($_POST[$postTextAnswer])) {
                                    $Response = $_POST[$postTextAnswer];
                                }else{
                                    $Response = "Not Answered";
                                } 
                        }else{
                            $Response = $_POST[$postAnswer];
                        }
                    }else{
                        $Response = "Not Answered";
                    }
                    if (!empty($Response)) {
                        mysqli_query($conn, "INSERT INTO responsetbl(Question_ID,RespondentID,Response) VALUES('$QID','$RID','$Response')");
                    }     
                        }
                
        //Checkbox
                if ($QType == "Checkbox") {
                   
                    $postOtherAnswer = "OtherAnswerforQ".$count;
                    $postOthersChoice = "OthersChoiceforQ".$count;
                    $postAnswer = "AnswerforQ".$count;
                    if (!empty($_POST[$postOtherAnswer]) || !empty($_POST[$postAnswer])) {
                        
                    if (!empty($_POST[$postOthersChoice])) {
                        
                    if (!empty($_POST[$postOtherAnswer])) {
                        $OtherAnswer = $_POST[$postOtherAnswer];

                        mysqli_query($conn, "INSERT INTO otherstbl(Question_ID,RespondentID,Response) VALUES('$QID','$RID','$OtherAnswer')");
                    }
                }

                   
                    if (!empty($_POST[$postAnswer])) {
                        $Responses = $_POST[$postAnswer];
                        foreach ($Responses as $Response) {

                        mysqli_query($conn, "INSERT INTO responsetbl(Question_ID,RespondentID,Response) VALUES('$QID','$RID','$Response')");
                        }

                    }else{
                        if (!isset($_POST[$postOtherAnswer]) && !isset($_POST[$postOthersAnswer])) {
                            $Response = "Not Answered";
                            mysqli_query($conn, "INSERT INTO responsetbl(Question_ID,RespondentID,Response) VALUES('$QID','$RID','$Response')");
                        }
                        
                    }
                }else{
                    $Response = "Not Answered";
                            mysqli_query($conn, "INSERT INTO responsetbl(Question_ID,RespondentID,Response) VALUES('$QID','$RID','$Response')");
                }

            }





        }
        date_default_timezone_set('Asia/Manila');
        $date_now = date('F d, Y');
        $time_now = date('h:i A');

        $query_account_type = mysqli_query($conn, "SELECT * FROM userstb WHERE Email='$db_email'");
        $get_account_type = mysqli_fetch_assoc($query_account_type);
        $UID = $get_account_type["ID"];
        $inserted = "Inserted Response to ".$SurveyTitle; 
        
        $check_log = mysqli_query($conn, "SELECT * FROM logstbl WHERE UID=$UID AND Date = '$date_now'");
        $rowscount = mysqli_num_rows($check_log);
        if ($rowscount == 0) {
            mysqli_query($conn, "INSERT INTO logstbl(UID,Date) VALUES($UID,'$date_now')");
            $LID =  $conn-> insert_id;
        }else{
            $log = mysqli_query($conn, "SELECT * FROM logstbl WHERE UID=$UID AND Date = '$date_now'");
            $rowLID = mysqli_fetch_assoc($log);
            $LID = $rowLID['LID'];
        }
        

        mysqli_query($conn, "INSERT INTO activity_log(LID,Activity,Time) VALUES('$LID','$inserted','$time_now')");
       
        
            
            $get_record = mysqli_query($conn, "SELECT * FROM respondenttbl WHERE Survey_ID=$surveyID");
            $Rescount = mysqli_num_rows($get_record);


            $get_respondents = mysqli_query($conn, "SELECT Respondents FROM mysurveytbl WHERE Survey_ID=$surveyID");
            $respondents = mysqli_fetch_assoc($get_respondents);
            $res = $respondents['Respondents'];

            if ($Rescount >= $res) {
                
                mysqli_query($conn, "UPDATE mysurveytbl SET Status = 'Completed' WHERE Survey_ID=$surveyID");
             
            
             echo "<script>window.location.href='Add_response?notify=Saved Successfully[This Survey is Completed!] && SID=$surveyID && ID=$userID';</script>";

            }else{
                echo "<script>window.location.href='Add_response?notify=Saved Successfully && SID=$surveyID && ID=$userID';</script>";
            }

            
        }
            
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
.datapanel{
   
   min-width: 850px;
   max-width: 850px;
   
}
.headcontainer{
    border-radius: 5px 5px 0px 0;
    min-width:800px;
    max-width:800px;
    background: #1166b1c2;
    padding: 14 2 14 0;
    
}
.headcontainer span{
    letter-spacing: 1px;
    font-size: 1em;
    color:rgba(0,0,0,0.705);
    padding-left: 7px;
    font-weight: 800;
}
.bodycontainer{
    padding-bottom: 9px;
    padding-top: 9px;
    padding-left: 2px;
    min-width:800px;
    max-width:800px;
   
    
    border-bottom:2px solid #1167b1;
}
.bodycontainer span{
    font-size: 0.8em;
    letter-spacing: 1px;
    padding-left: 5px;
    color:rgba(0,0,0,0.705);
    
}
.labelhead {
    text-align:center;
    color: grey;  
}

.question-row{
    padding: 10 10 10 10;
    background: #1166b1a2;
    max-width: 782px;
    margin-top: 10px;
    color:rgba(0,0,0,0.705);
    border-radius: 5px 5px 0 0;
    
    
}
.question-row label{
    padding:0;
    margin:0;
    line-height:0;
    text-overflow: ellipsis;
   
}
.question-row .MainQuestion{
    background:transparent;
    border:0;
    color:rgba(0,0,0,0.705);
    font-size:1em;
    font-weight:600;
    width:790;
    text-overflow:ellipsis;
    overflow:hidden;
}
.question-row:hover{
    font-size: 1.02em;
    
}

.question-row:hover label{
    font-size: 1.02em;
}
.questionnaires .Answer-text{
    margin-left:30px;
    color:rgba(0,0,0,0.705);
    background:transparent;
    border: 0;
    border-bottom: 2px solid lightblue;
    outline:none;
    font-size: 1.1em;
    font-weight: 500;
    width:250;   
}
.questionnaires .OtherAnswer-text{
    margin-left:30px;
    color:rgba(0,0,0,0.705);
    background:transparent;
    border: 0;
    outline:none;
    font-size: 1.1em;
    font-weight: 500;
    width:250;
}
.questionnaires .OtherAnswer-text:focus{
    border-bottom:2px solid #562af4de;
}
.questionnaires .Answer-text:focus{
    border-bottom:2px solid #562af4de;
}
.questionnaires .LongAnswer-text{
    margin-left:5px;
    color:rgba(0,0,0,0.705);
    background:transparent;
    border: 0;
    border-bottom: 2px solid lightblue;
    outline:none;
    font-size: 1.3em;
    font-weight: 500;
    width:400;
    height:80; 

}
.questionnaires .LongAnswer-text:focus{
    border-bottom:2px solid #562af4de;
}
#SubQs .SubQuestion-text{
    
    margin-top: 15px;
    color:rgba(0,0,0,0.705);
    background:transparent;
    border: 0;
    border-bottom: 1px solid grey;
    outline:none;
    font-size: 1em;
    font-weight: bold;
    width:350;
    
}
#SubQs .subanswer-text{
    color:rgba(0,0,0,0.705);
    background:transparent;
    border: 0;
    border-bottom: 2px solid lightblue;
    outline:none;
    font-size: 1.1em;
    font-weight: 500;
    width:250;
   
    margin-left: 15px;
}
#SubQs .subanswer-text:focus {
    border-bottom: 2px solid #562af4de;
    
}

.input-type{
    padding-top:20px;
}
.question-text{
    
    color:rgba(0,0,0,0.705);
    background:transparent;
    border: 0;
    border-bottom: 1px solid grey;
    outline:none;
    font-size: 1em;
    font-weight: 700;
    width:600;
    padding:0;
    margin:0;
}
.question-text:focus {
    border-bottom: 2px solid grey;
    
}
.questionnaires input{
    margin-left:10;
    font-size: 0.96em;
    letter-spacing: 1px;
    padding-left: 5px;
    color:rgba(0,0,0,0.705);
    font-weight:500;
   
    
}
.questionnaires{
    border-bottom:2px solid #1166b1a2;
    max-width: 782px;
    padding: 20 10 20 10;
    
}
.questionnaires .optionlbl{
    color:rgba(0,0,0,0.705);

}
.subquestion-text{
    margin-top: 15px;
    margin-left: 20px;
    color:rgba(0,0,0,0.705);
    background:transparent;
    border: 0;
    border-bottom: 1px solid grey;
    outline:none;
    font-size: 1em;
    font-weight: 700;
    width:290;
}
.subanswer-text{
    color:rgba(0,0,0,0.705);
    background:transparent;
    border: 0;
    border-bottom: 2px solid lightblue;
    outline:none;
    font-size: 1em;
    font-weight: 500;
    width:150;
   
    margin-left: 15px;
}
.subanswer-text:focus {
    border-bottom: 2px solid blue;
    
}
.prime-question{
    padding-left:none;
    margin-left: 140px;
    color:rgba(0,0,0,0.705);
    background:transparent;
    border: 0;
    border-bottom: 1px solid grey;
    outline:none;
    font-size: 1em;
    font-weight: 700;
    width:400;
}
.divNote{
    text-align:center;
    min-width:802px;
    max-width:802px;
    background:#ffb649;
    border-radius: 0px 0px 5px 5px;
}
.NoteText{
    margin:0;
    padding:0;
    color:rgba(0,0,0,0.705); 
    font-size: 1em;
    font-weight: 800; 
    font-style:italic;
    margin-left:40px;
}
.addbtn{
    border-radius: 5px 5px 5px 5px;
    border:solid aliceblue;
    background: orange;
    cursor:pointer;
}
.shadowbox{
    max-width:802px;
    border-radius: 5px 5px 0 0;
}
.shadowbox:hover{
    box-shadow: 0 0 3px rgba(0,0,0,0.705);
}
.actionbtn{
    float:right; 
    
}
.actionbtn .btnedit:hover{
    opacity:0.7;
    cursor:pointer;
}
.actionbtn .btndelete:hover{
    opacity:0.7;
    cursor:pointer;
}
.btnedit{
 
    margin-right:5;
    padding-right:3;
}
.divider{
    color:#1166b1a2;
    font-size:35px;
    font-weight:300;
}
.NoteText img{
    transform: rotateY(-180deg);
}
.divFooter{
    align:center;
    margin-top:10;
    Height:45px;
    text-align:center;
    min-width:802px;
    max-width:802px;
    background:#ffb649;
    border-radius: 0px 0px 5px 5px;
}
.savebtn{
    line-height:.9;
    margin-top:3px;
    border:2px solid aliceblue;
    color:aliceblue;
    text-decoration:none;
    padding: 10;
    width:80px;
    background:orange;
    border-radius: 5px 5px 5px 5px;
}
.savebtn a img{
    padding-top:4;
}
.savebtn:hover{
    opacity:0.5;
}

.addbtn a img{
    padding-top:4;
}
.addbtn a{
    line-height:1.5; 
    color:aliceblue;
    text-decoration:none;
    padding: 10;
}
.addbtn:hover{
    opacity:0.5;
}
label{
    max-width:700px;
}
.addSubbtn{
    border-radius: 5px 5px 5px 5px;
    border:solid aliceblue;
    background: #f4be2a;
    cursor:pointer;
    color:aliceblue;
    margin-left:300px;
}
#SelectEnum{
    border:none;
    outline:none;
    background:rgba(0,0,0,.09);
    padding:4px;
    font-weight:600;
    color:rgba(0,0,0,.750);
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
             
            }
            ?>
            </div>

           <div class="datapanel">
                <!-- <div class="headcontainer" style="background:none;" > 
                    <CAPTION><span style="text-decoration:underline;">Add Response</span></CAPTION>
                </div> <br> -->

                <div class="headcontainer">
                    <CAPTION><span><?php if(!empty($surveyID)){ echo ucfirst($SurveyTitle); }?></span></CAPTION>
                </div>

                <div class="bodycontainer">
                    <CAPTION><span><?php if(!empty($surveyID)){ echo ucfirst($Description);} ?></span></CAPTION>
                </div>
               
                    <?php 

                    
                            $query = mysqli_query($conn, "SELECT * FROM questiontbl where Survey_ID=$surveyID");
                            $result = mysqli_num_rows($query);
                            if ($result == 0) {
                        
                      echo  "<div class='divNote'>
                                        
                                    <label class='NoteText' ><img src='../img/note1.png'> Oops.. No Questionnaires</label>

                                    <button name='addQbtn' class='addbtn'><a href='Add_Questionnaire?$encrypted&&SID=$surveyID'><img src='../img/addQ.png' alt=''> Add Questionnaires</a></button>
 
                            </div>";


                    }else{

                        
                    ?>
                                 
                                

                            <div class="question-box">

                                    <form action="" method="POST">

                        <!---================================== Enumerator =============================--->
                            <div class="shadowbox">

                            <div style="background:orange;" class="question-row">
                                    
                            <input readonly  class="MainQuestion" style="height:14;" type="text" name="Question[]" value="ENUMERATOR">
                                                                                                           
                            </div>

                            <div class="questionnaires">
                                                
                                <select required name="Enumerators" id="SelectEnum">
                                <option value="">Please Select Enumerator</option>
                                <?php 
                                $sqlenum = "SELECT * FROM enumeratortbl";
                                $resultenum = $conn-> query($sqlenum);

                                    if ($resultenum-> num_rows > 0){
                                    
                                    while ($rowenum = $resultenum-> fetch_assoc()){
                                        $EID = $rowenum['EID'];
                                        $EName = ucfirst($rowenum['Name']);
                                        $EIDName = "[EID:".$EID."] ".$EName;

                                        echo "<option value='$EID'>$EIDName</option>
                                        ";

                                        }
                                    }
                                ?>
                
                                </select>  
                            
                            </div>

                            

                            </div>

                            <div class="scroller" style="overflow-y:scroll; height:250px;">

                          <?php 
                             
                            $sql = "SELECT * FROM questiontbl WHERE Survey_ID='$surveyID'";
                            $result = $conn-> query($sql);
                            
                            if ($result-> num_rows > 0){
                                    $count = 0;
                                    while ($row = $result-> fetch_assoc()){
                                            $QID = $row['QuestionID'];
                                            $QType = $row['QuestionType'];
                                            $Question = $row['Question'];
                                            $Required = $row['Required'];
                                            $other = $row['Others'];
                                            $count = $count + 1;
                                       if ($QType == "ShortAnswer") {
                                        if ($Required == "yes") {
                                            $req = "Required";
                                            $style = "style='border-bottom:3px solid #ff4949;'";
                                        }else{
                                            $style = "";
                                            $req = "";
                                        }
                             
                            ?> 
                        

                        <!---================================== Question No. 1 Short Answer =============================--->
                            <div class="shadowbox">

                            <div <?php echo $style; ?> class="question-row">
                                    
                            <input readonly class="MainQuestion" type="text" name="Question[]" value="<?php echo "Q".$count.") ". $Question; ?>">
                                                                                                           
                            </div>

                            <div class="questionnaires">
                                                
                                <input <?php echo $req; ?> type="text" class="Answer-text" name="AnswerforQ<?php echo $count; ?>" placeholder="Answer" ><br>
                            
                            
                            
                            </div>

                            

                            </div>
                            <?php 
                            }
                            if ($QType == "LongAnswer") {
                                if ($Required == "yes") {
                                    $req = "Required";
                                    $style = "style='border-bottom:3px solid #ff4949;'";
                                }else{
                                    $style = "";
                                    $req = "";
                                }
                            ?>

                        <!---================================== Question Type No. 2 Long Answer =============================--->
                            <div class="shadowbox">

                                    <div <?php echo $style; ?> class="question-row">
                                            
                                    <input readonly class="MainQuestion" type="text" name="Question[]" value="<?php echo "Q".$count.") ". $Question; ?>">
                                                                                                                
                                    </div>

                                    <div class="questionnaires">
                                                    
                                        <label>
                                        <textarea <?php echo $req; ?> type="text" class="LongAnswer-text" name="AnswerforQ<?php echo $count; ?>" placeholder="Answer" value=""></textarea>
                                        </label><br>
                                    
                                    
                                    </div>

                            

                            </div>
                            <?php 
                            }
                            if ($QType == "Multiplechoice") {
                                if (isset($_POST['AddAllbtn'])) {
                                    
                                }
                                if ($Required == "yes") {
                                    $req = "Required";
                                    $style = "style='border-bottom:3px solid #ff4949;'";
                                    
                                }else{
                                    $style = "";
                                    $req = "";
                                    
                                }
                                if ($other == "no") {
                                    $oth = "style='display:none;'";  
                                }else{
                                    $oth = "";
                                }
                            ?>

                        <!---================================== Question Type No. 3 Multiplechoice =============================--->
                            <div class="shadowbox">

                            <div <?php echo $style; ?> class="question-row">
                                    
                            <input readonly class="MainQuestion" type="text" name="Question[<?php echo $count; ?>]" value="<?php echo "Q".$count.") ". $Question; ?>">
                                                                                                           
                            </div>

                            <div class="questionnaires">
                            <?php 
                            $sql1 = "SELECT Answer FROM answertbl WHERE Question_ID='$QID'";
                            $result1 = $conn-> query($sql1);
                            
                            if ($result1-> num_rows > 0){
                                    
                                    while ($row1 = $result1-> fetch_assoc()){
                                            $Answer = $row1['Answer'];
                                            
                            
                            ?>
                            <label class="optionlbl" >
                            
                            <input onchange="focus<?php echo $count; ?>();"  <?php echo $req; ?> type="radio" class="radiobtn" name="AnswerforQ<?php echo $count; ?>" value="<?php echo $Answer; ?>" > <?php echo $Answer; ?>
                            
                            </label>
                            <?php } }?>
                            
                            <label <?php echo $oth; ?> class="optionlbl">
                            <input onchange="focus<?php echo $count; ?>();" type="radio" class="radiobtn" name="AnswerforQ<?php echo $count; ?>" value="other" id="mult<?php echo $count; ?>">  Other, Please specify:
                            <input type="text" class="OtherAnswer-text" name="TextAnswerforQ<?php echo $count; ?>" id="multi<?php echo $count; ?>"> 
                            </label>
                            
                            
                            
                            </div>

                            </div>
                            <?php 
                            }
                            if ($QType == "Checkbox") {
                                if ($Required == "yes") {
                                    $req = "required";
                                    $style = "style='border-bottom:3px solid #ff4949;'";
                                }else{
                                    $style = "";
                                    $req = "";
                                }
                                if ($other == "no") {
                                    $oth = "style='display:none;'";  
                                }else{
                                    $oth = "";
                                }
                            ?>
                            <!---================================== Question Type No. 4 Checkbox =============================--->
                            <div class="shadowbox">

                            <div <?php echo $style; ?> class="question-row">
                                    
                            <input readonly class="MainQuestion" type="text" name="Question[<?php echo $count; ?>]" value="<?php echo "Q".$count.") ". $Question; ?>">
                                                                                                           
                            </div>

                            <div class="questionnaires">
                            <?php 
                            $sql1 = "SELECT Answer FROM answertbl WHERE Question_ID='$QID'";
                            $result1 = $conn-> query($sql1);

                            if ($result1-> num_rows > 0){
                                    
                                    while ($row1 = $result1-> fetch_assoc()){
                                            $Answer = $row1['Answer'];
                                            
                            
                            ?>
                            <label class="optionlbl"><input onchange="valdis<?php echo $count; ?>();" <?php echo $req; ?> type="Checkbox" class="radiobtn" name="AnswerforQ<?php echo $count; ?>[]" value="<?php echo $Answer; ?>" > <?php echo $Answer; ?></label>
                            <?php } }?>
                            
                            <label <?php echo $oth; ?> class="optionlbl">
                            <input onchange="focus<?php echo $count; ?>();" type="checkbox" class="radiobtn" name="OthersChoiceforQ<?php echo $count; ?>"  value="others" id="OthersChoiceforQ<?php echo $count; ?>">  Other, Please specify
                            <input onchange="focus<?php echo $count; ?>();"  type="text" class="OtherAnswer-text" name="OtherAnswerforQ<?php echo $count; ?>" id="OtherAnswerforQ<?php echo $count; ?>"> 
                            </label>
                            
                            </div>

                            </div>
                        <?php 
                            }
                            if ($QType == "Date") {
                                if ($Required == "yes") {
                                    $req = "Required";
                                    $style = "style='border-bottom:3px solid #ff4949;'";
                                }else{
                                    $style = "";
                                    $req = "";
                                }
                        ?>
                    <!---================================== Question Type No. 5 Date =============================--->
                        <div class="shadowbox">

                            <div <?php echo $style; ?> class="question-row">
                                    
                            <input readonly class="MainQuestion" type="text" name="Question[<?php echo $count; ?>]" value="<?php echo "Q".$count.") ". $Question; ?>">
                                                                                                           
                            </div>

                            <div class="questionnaires">
                                                
                                <input <?php echo $req; ?> type="date" class="Answer-text" name="AnswerforQ<?php echo $count; ?>"><br>
                            
                            
                            
                            </div>

                            

                        </div>


                  <!--  end of loop -->      
                            <?php 
                            }

                    }
                }
            
                            ?>

                        
                <!--====================Footer buttons ------>
                            <div class='divFooter'>
                                        
                                   
                            <img src="" alt="">
                                <input Style="background:#2e68aa; height:39px; cursor:pointer;" type="submit" name='addAllbtn' class='savebtn' value="Save">
                                <a class='savebtn' style="padding:10 15 10 15; font-weight:500; font-size:.8em; background:aliceblue; color:#2e68aa; border:2px solid #2e68aa;" href='user_survey'>Cancel</a>
                                <input Style="background:#ff4949; height:39px; cursor:pointer;" type="reset" class='savebtn' value="Reset">
                                
                                
                            </div>
                            </div>
        <?php }?>

            </div>

            </div>
                
         </div>
     

</body>
</html>