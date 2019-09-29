<?php
include_once '../includes/connection.php';
include_once '../includes/secondaryConnection.php';



date_default_timezone_set('Asia/Manila');

$date_now = date('m/d/y');
$time_now = date('h:i A');

//create dynamic function
$sqlfunction = "SELECT * FROM questiontbl WHERE Survey_ID='38'";
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
            

//Iserting All inputs to database **************************

if (isset($_POST['addAllbtn'])) {

    include_once '../includes/secondaryConnection.php';
    $EMPID = $_GET['EMPID'];
    mysqli_query($conn2, "INSERT INTO employer_respondenttbl(Survey_ID,EMP_ID,date,time) VALUES('38','$EMPID','$date_now','$time_now')");
    $ERID = $conn2-> insert_id;


    $sql = "SELECT * FROM questiontbl WHERE Survey_ID='38'";
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
                        mysqli_query($conn, "INSERT INTO employer_responsetbl(EMP_RID,QID,Response) VALUES('$ERID','$QID','$Response')");

                        }
                    

                 if ($QType == "LongAnswer") {
                    $postAnswer = "AnswerforQ".$count;
                    if (!empty($_POST[$postAnswer])) {
                        $Response = $_POST[$postAnswer];
                    }else{
                        $Response = "Not Answered";
                    }
                        mysqli_query($conn, "INSERT INTO employer_responsetbl(EMP_RID,QID,Response) VALUES('$ERID','$QID','$Response')");
                                    
                        }
                
                        if ($QType == "Date") {
                            $postAnswer = "AnswerforQ".$count;                  
                            if (!empty($_POST[$postAnswer])) {
                                $Response = $_POST[$postAnswer];
                            }else{
                                $Response = "Not Answered";
                            }
                                mysqli_query($conn, "INSERT INTO employer_responsetbl(EMP_RID,QID,Response) VALUES('$ERID','$QID','$Response')");
                            
                                    
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
                        mysqli_query($conn, "INSERT INTO employer_responsetbl(EMP_RID,QID,Response) VALUES('$ERID','$QID','$Response')");
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

                        mysqli_query($conn, "INSERT INTO employer_responsetbl(EMP_RID,QID,Response) VALUES('$ERID','$QID','$Response')");
                    }
                }

                   
                    if (!empty($_POST[$postAnswer])) {
                        $Responses = $_POST[$postAnswer];
                        foreach ($Responses as $Response) {

                        mysqli_query($conn, "INSERT INTO employer_responsetbl(EMP_RID,QID,Response) VALUES('$ERID','$QID','$Response')");
                        }

                    }else{
                        if (!isset($_POST[$postOtherAnswer]) && !isset($_POST[$postOthersAnswer])) {
                            $Response = "Not Answered";
                            mysqli_query($conn, "INSERT INTO employer_responsetbl(EMP_RID,QID,Response) VALUES('$ERID','$QID','$Response')");
                        }
                        
                    }
                }else{
                    $Response = "Not Answered";
                            mysqli_query($conn, "INSERT INTO employer_responsetbl(EMP_RID,QID,Response) VALUES('$ERID','$QID','$Response')");
                }

            }





        }
        
                echo "<script>window.location.href='Success?';</script>";
            

            
        }
            
    


}
?>
<style>
.error{
    color:orange;
    font-family:sans-serif;
}
body{
    background-image: linear-gradient(#1167b1,aliceblue);
    height: auto;
    background-size: cover;
    background-position: center;
}

.head{
    margin: auto;
    width: 360px;
    height: 150px;
    
}
.header h2{
    padding-top: 20px;
    height: 50px;
    
}
.datapanel{
    font-family:sans-serif;
    position: relative;
    z-index: 1;
    width: 800px;
    height:auto;
    max-width: 800px;
    margin: 0 auto 50px;
    margin-top:-70px;
    background: aliceblue;
    box-shadow: 0px 0px 10px rgba(0,0,0,.400);
    border-radius: 5px 5px 5px 5px;
}

h2{
    color: aliceblue;
}
h3{
    color: aliceblue;
}
span{
    color: #1fb8cc;
    font-weight: bold;
   
}
.datapanel h3{
    font-size:1.3em;
    font-weight:400;
    color: rgba(0,0,0,.9);
    margin: 0;
}
.datapanel th{
    background:#b5c0cce7;
}
.labeled{
    color:rgba(0,0,0,0.750);
    margin-left:50px;
    font-size:.9em;
    font-weight:600;
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
    width:690;
    text-overflow:ellipsis;
    overflow:hidden;
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
    margin-left:50px;
    box-shadow: 0 0 3px rgba(0,0,0,0.705);
    max-width:700px;
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
    min-width:800px;
    max-width:800px;
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
    border:3px;
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
.details{
    font-weight:500;
    font-size:15px;
    line-height:1.3;
}
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="fonts/fontawesome/css/all.min.css">
    <title>GETSystem | Employer</title>
</head>
<body>

    <div class="head">
        <div class="header">
            <center> <h2> <span>GETS</span>ystem</h2></center>
        </div>
    </div>


     <div class="datapanel">
     
      <br><center><label style="color:rgba(0,0,0,0.850); font-size:1.2em; position:relative;"><img src="../img/dhvsubg.png" alt="" style="width:90px; position:absolute; margin-left:-160px; margin-top:-8px; opacity:0.7;"><b>Don Honorio Ventura State University</b> <img src="../img/CcsLogo.png" alt="" style="width:90px; position:absolute; margin-left:70px; margin-top:-10px; opacity:0.7;">
                    </label>
                    <p style="color:rgba(0,0,0,0.650); font-size:1em;">COLLEGE OF COMPUTING STUDIES<br>Bacolor, Pampanga</p>
                    <hr>
                    <?php
                    if (!empty($_GET['EMPID']) && !empty($GID = $_GET['GID'])) {
                        $EMPID = $_GET['EMPID'];    
                        $GID = $_GET['GID'];
                    
                   
                    
                    $empquery = mysqli_query($conn, "SELECT * FROM employertbl WHERE EMPID='$EMPID' AND GID='$GID'");
                    $empcount = mysqli_num_rows($empquery);
                    if ($empcount == 0) {
                        echo "<h1>Sorry you have no access to this Page/Content.</h1>
                        ";
                    }else{
                    $querycheck = mysqli_query($conn, "SELECT * FROM employer_respondenttbl WHERE EMP_ID='$EMPID'");
                    $checkcount = mysqli_num_rows($querycheck);
                    if ($checkcount > 0) {
                        echo "<h1>Sorry you already Submitted your Feedback</h1>
                        ";
                    }else{

                    if (!empty($_GET['GID'])) {
                        
                       
                        $query = mysqli_query($conn, "SELECT * FROM graduates_infotbl WHERE GID='$GID'");
                        $fetch = mysqli_fetch_assoc($query);
                        $fullname = $fetch['firstname']." ".$fetch['middlename']." ".$fetch['lastname'];
                        $queryemp = mysqli_query($conn, "SELECT * FROM employertbl WHERE EMPID='$EMPID'");
                        $fetchemp = mysqli_fetch_assoc($queryemp);
                        $company = $fetchemp['Company'];
                        $company_add = $fetchemp['Company_Address'];
                        $type = $fetchemp['Type_Company'];
                        $emp_name = $fetchemp['Employer_Name'];
                        $job = $fetchemp['Job_Title'];
                        
                        

                    ?>

                    <h3>Employer Feedback Survey</h3>
                    <p style="color:rgba(0,0,0,0.650); font-size:1em;">In order to assess the abilities of our B.S. IT graduates, we would ask you<br> to please complete this survey  with regard to following graduate of the<br> Don Honorio Ventura State University. Thank you.</p>
                    </center> 
                    <form action="" method="POST">
                    <br>
                    <label class="labeled">Graduates Name : <span class="details"><?php echo $fullname; ?></span></label><br><br>
                    <label class="labeled">Company Name : <span class="details"><?php echo $company; ?></span></label><br><br>
                    <label class="labeled">Company Address : <span class="details"><?php echo $company_add; ?></span></label><br><br>
                    <label class="labeled">Type of Company : <span class="details"><?php echo $type; ?></span></label><br><br>
                    <label class="labeled">Employer Name/Job Title : <span class="details"><?php echo $emp_name; ?></span> / <span class="details"><?php echo $job; ?></span></label><br><br>
                    <br>
                    <span class="details" style="margin-left:50px;">Please answer the following questions base on your evaluation.</span>
                    <br>

                            

                            <form action="" method="POST">
                          <?php 
                             
                            $sql = "SELECT * FROM questiontbl WHERE Survey_ID='38'";
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
                                            $hide = "";
                                        }else{
                                            $hide = "hidden";
                                            $style = "style='border-bottom:3px solid #1166b1c2;'";
                                            $req = "";
                                        }
                             
                            ?> 
                        
                            
                        <!---================================== Question No. 1 Short Answer =============================--->
                            <div style="position:relative;" class="shadowbox">

                            <div <?php echo $style; ?> class="question-row">
                                    
                            <input readonly class="MainQuestion" type="text" name="Question[]" value="<?php echo "Q".$count.") ". $Question; ?>">
                            <span <?php echo $hide; ?> style="position:absolute; margin-left:636px; margin-top:13px; color:aliceblue; background:#ff4949; font-weight:500; font-size:12px; border-radius:0 0 0 3px; padding:3px;">Required</span>                                                                    
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
                                    $hide = "";
                                }else{
                                    $hide = "hidden";
                                    $style = "";
                                    $req = "";
                                }
                            ?>

                        <!---================================== Question Type No. 2 Long Answer =============================--->
                            <div style="position:relative;" class="shadowbox">

                                    <div <?php echo $style; ?> class="question-row">
                                            
                                    <input readonly class="MainQuestion" type="text" name="Question[]" value="<?php echo "Q".$count.") ". $Question; ?>">
                                    <span <?php echo $hide; ?> style="position:absolute; margin-left:636px; margin-top:13px; color:aliceblue; background:#ff4949; font-weight:500; font-size:12px; border-radius:0 0 0 3px; padding:3px;">Required</span>                                                                           
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
                                    $hide = "";
                                }else{
                                    $hide = "hidden";
                                    $style = "style='border-bottom:3px solid #1166b1c2;'";
                                    $req = "";
                                    
                                }
                                if ($other == "no") {
                                    $oth = "style='display:none;'";  
                                }else{
                                    $oth = "";
                                }
                            ?>

                        <!---================================== Question Type No. 3 Multiplechoice =============================--->
                            <div style="position:relative;" class="shadowbox">

                            <div <?php echo $style; ?> class="question-row" >
                            <div class="MainQuestion"><?php echo "Q".$count.") ". $Question; ?></div>        
                            
                            <span <?php echo $hide; ?> style="position:absolute; margin-left:636px; margin-top:13px; color:aliceblue; background:#ff4949; font-weight:500; font-size:12px; border-radius:0 0 0 3px; padding:3px;">Required</span>                                                                   
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
                            
                            <input onchange="focus<?php echo $count; ?>();"  <?php echo $req; ?> type="radio" class="radiobtn" name="AnswerforQ<?php echo $count; ?>" value="<?php echo $Answer; ?>" > <span class="details"><?php echo $Answer; ?></span> 
                            
                            </label><br>
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
                                    $hide = "";
                                }else{
                                    $hide = "hidden";
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
                            <div style="position:relative;" class="shadowbox">

                            <div <?php echo $style; ?> class="question-row">
                                    
                            <input readonly class="MainQuestion" type="text" name="Question[<?php echo $count; ?>]" value="<?php echo "Q".$count.") ". $Question; ?>">
                            <span <?php echo $hide; ?> style="position:absolute; margin-left:636px; margin-top:13px; color:aliceblue; background:#ff4949; font-weight:500; font-size:12px; border-radius:0 0 0 3px; padding:3px;">Required</span>                                                                               
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
                                    $hide = "";
                                }else{
                                    $hide = "hidden";
                                    $style = "";
                                    $req = "";
                                }
                        ?>
                    <!---================================== Question Type No. 5 Date =============================--->
                        <div style="position:relative;" class="shadowbox">

                            <div <?php echo $style; ?> class="question-row">
                                    
                            <input readonly class="MainQuestion" type="text" name="Question[<?php echo $count; ?>]" value="<?php echo "Q".$count.") ". $Question; ?>">
                            <span <?php echo $hide; ?> style="position:absolute; margin-left:636px; margin-top:13px; color:aliceblue; background:#ff4949; font-weight:500; font-size:12px; border-radius:0 0 0 3px; padding:3px;">Required</span>                                                                             
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
                                <input Style="background:#2e68aa; height:39px; cursor:pointer;" type="submit" name='addAllbtn' class='savebtn' value="Submit">
                                <input Style="background:aliceblue; color:#2e68aa; border:2px solid #2e68aa;height:39px; cursor:pointer;" type="reset" class='savebtn' value="Reset">
                                
                                
                            </div>
                           
       



                    <?php
                  
                       

                    }else{
                       echo "<h1>SORRY THIS PAGE IS CURRENTLY NOT AVAILABLE</h1>
                       "; 
                    }
                }
            }
        }
                    ?>
                    </form>
       
                   

       
   
    </div>
    
    
</body>
</html>