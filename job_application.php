<?php 
 session_start();
 include './config/myjob.configdb.php';
   //print_r($job_description);
   $id = $_POST['company-id'];
  // echo $id;
  if(isset($_POST['submit-job-application'])){
    $sql ="SELECT * FROM job_post WHERE id = $id";
    $res = mysqli_query($conn,$sql);
    $job_desc = mysqli_fetch_assoc($res);
    //print_r($job_desc);
  }

 if(isset($_POST['submit-application'])){
    if(empty($_POST['email']) || empty($_POST['full_name']) || empty($_POST['phone'])||
    empty($_POST['years']) || empty($_POST['curr_position']) || empty($_POST['employer']) || empty($_POST['pay_per_annum'])){
        header('Location:./job_application.php?error=MissingInputFields');
        exit();
    }
    else{
        $email = $_POST['email'];
        $full_name = $_POST['full_name'];
        $phone = $_POST['phone'];
        $years = $_POST['years'];
        $curr_position = $_POST['curr_position'];
        $employer = $_POST['employer'];
        $pay_per_annum = $_POST['pay_per_annum'];
        $company_name = $_POST['company_name'];

        $email = mysqli_real_escape_string($conn,$email);
        $full_name = mysqli_real_escape_string($conn,$full_name);
        $phone = mysqli_real_escape_string($conn,$phone);
        $years = mysqli_real_escape_string($conn,$years);
        $curr_position = mysqli_real_escape_string($conn,$curr_position);
        $employer = mysqli_real_escape_string($conn,$employer);
        $pay_per_annum = mysqli_real_escape_string($conn,$pay_per_annum);
        $company_name = mysqli_real_escape_string($conn,$company_name);

        $resume_file = $_FILES['file_resume'];
        $resume_name = $resume_file['name'];
        $resume_type = $resume_file['type'];
        $resume_tmpName = $resume_file['tmp_name'];
        $resume_size = $resume_file['size'];
        $resume_error = $resume_file['error'];

        $allowedExts = array('pdf','doc','docx');

        $cover_letter_file = $_FILES['file_cover'];
        $cover_name = $cover_letter_file['name'];
        $cover_type = $cover_letter_file['type'];
        $cover_tmpName = $cover_letter_file['tmp_name'];
        $cover_size = $cover_letter_file['size'];
        $cover_error = $cover_letter_file['error'];

        $ResumeExt = explode('.',$resume_name);
        $ResumeActualExt = strtolower(end($ResumeExt));

        $CoverExt = explode('.',$cover_name);
        $CoverActualExt = strtolower(end($CoverExt));

        if(in_array($ResumeActualExt,$allowedExts) && in_array($CoverActualExt,$allowedExts)){
            if($resume_error === 0 && $cover_error === 0){
               if($resume_size <= 1000000 && $cover_size <= 500000){
                  $resumeActualName = str_replace(" ","-",$full_name) . "." . $ResumeActualExt;
                  $resumeDestination = "./resumefiles/" . $resumeActualName;

                  $coverActualName = str_replace(" ","-",$full_name) . "." . $CoverActualExt;
                  $coverDestination = "./coverletterfiles/" . $coverActualName;

                  $sql_apply = "INSERT INTO jop_application(full_name,email,pay_per_annum,current_employer,phone,resume_file,cover_letter,current_position
                  ,years_of_exp,date_applied,company_name) VALUES('$full_name','$email','$pay_per_annum','$employer','$phone',
                  '$resumeDestination','$coverDestination','$curr_position','$years',NOW(),'$company_name')";
                  if(mysqli_query($conn,$sql_apply)){
                    move_uploaded_file($resume_tmpName,$resumeDestination);
                    move_uploaded_file($cover_tmpName,$coverDestination);
                    header('Location:./successapply_page.php');
                    exit();
                  }
               }
               else{
                header('Location:./job_application.php?error=FileSizeExceededLimit&&fSize <=1MB');
                exit();
               }
            }else{
                header('Location:./job_application.php?error=FileCorrupted');
                exit();
            }
        }else{
            header('Location:./job_application.php?error=ExtensionNotAllowed&&Only Pdf && Docx');
            exit();
        }
    }
 }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FinderJob | Application</title>
    <style>
      *{
        margin: 0;
        padding: 0;
        font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
      }
      .application_body{
        width:100%;
        height:100vh;
      }
      .line-green{
        background-color: green;
        height:10px;
        width:100%;
      }
      @media (max-width:500px) {
        .form-box{
        width:200px;
        height: max-content;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 0 2px 2px #000;
        margin: 3% 0;
      }
        .form-box .input{
         border:2px solid #000;
         border-radius: 15px;
         margin: 10px 0;
         padding: 0 10px;
         height:25px;
         width: 150px;
      }
      .form-box select{
        border:2px solid #000;
         border-radius: 15px;
         margin: 10px 0;
         padding: 0 10px;
         height:25px;
         width: 150px;
      }
      .form-box .input:focus{
        border: 2px solid green;
      }
      .form-box select:focus{
        border: 2px solid green;
      }
      .form-box button{
        width:100%;
        background-color: green;
        height: 35px;
        color: #fff;
        border:none;
        outline: none;
        border-radius: 20px;
        cursor: pointer;
      }  
      }
      .application-form{
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
      }
      .application-form .form-box{
        width:500px;
        height: max-content;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 0 2px 2px #000;
        margin: 3% 0;
      }
      .form-box .input{
         border:2px solid #000;
         border-radius: 15px;
         margin: 10px 0;
         padding: 0 10px;
         height:45px;
         width: 96%;
      }
      .form-box select{
        border:2px solid #000;
         border-radius: 15px;
         margin: 10px 0;
         padding: 0 10px;
         height:45px;
         width: 100%;
      }
      .form-box .input:focus{
        border: 2px solid green;
      }
      .form-box select:focus{
        border: 2px solid green;
      }
      .form-box button{
        width:100%;
        background-color: green;
        height: 35px;
        color: #fff;
        border:none;
        outline: none;
        border-radius: 20px;
        cursor: pointer;
      }
      .input-files{
        border: 2px dotted green;
        border-radius: 20px;
        cursor: pointer;
        width:100%;
        height:35px;
        margin: 2% 0;
      }
      .input-files::-webkit-file-upload-button{
        background:linear-gradient(45deg,green,#000);
        padding: 10px 40px;
        color: #fff;
        border-radius: 20px;
        outline:none;
        border:none;
      }
      .exit_btn{
        color: green;
        text-decoration: none;
        cursor: pointer;
        font-size: 25px;
        left:90%;
        top:4%;
        position: relative;
      }
      .exit_btn:hover{
        color:#f44336;
      }
    </style>
</head>
<body>
    <section class="application_body">
        <div class="line-green"></div>
        <h1 style="font-size:45px;color:green;">FinderJob</h1>
        <div class="application-form">
            <div class="form-box">
            <div class="line-green"></div>
             <a href="./index.php" class="exit_btn">Exit</a>
             <small><?php echo $job_desc['position'] . ' ' . "application" . " " . "at" . " " . $job_desc['company'] ?></small>
            <form action="./job_application.php" method="POST" style="padding:8px;margin:10px 0" enctype="multipart/form-data">
                <label>Company Name</label>
                <br/>
                <input class = "input" name="company_name" type = "Text" placeholder="e.g Amazon,Google,etc"/>
                <label>Full Name</label>
                <br/>
                <input  class="input" name="full_name" type="text" placeholder="Full Name"/>
                <br/>
                <label>Phone Number</label>
                <br/>
                <input  class="input" name="phone" type="text" placeholder = "Phone Number"/>
                <br/>
                <label>Email Address</label>
                <br/>
                <input  class="input" name="email" type="email" placeholder="Email Address"/>
                <br/>
                <label>How many years of experience do you have?</label>
                <br/>
                <select name="years">
                    <option>---Years of Experience</option>
                    <option value="0-3 years">0-3 years</option>
                    <option value="3-5 years">3-5 years</option>
                    <option value="5-8 years">5-8 years</option>
                    <option value="8-10 years">8-10 years</option>
                    <option value="10-12 years">10-12 years</option>
                    <option value="12 + years">12 + years</option>
                </select>
                <br/>
                <label>Current Employer</label>
                <br/>
                <input  class="input" name="employer" type="text" placeholder="Current Employer"/>
                <br/>
                <label>Current Position</label>
                <br/>
                <input  class="input" name="curr_position" type="text" placeholder="Current Position"/>
                <br/>
                <label>Desired Pay $/annum</label>
                <br/>
                <input  class="input" type="text" name="pay_per_annum" placeholder="$/annum"/>
                <br/>
                <label>Resume (.pdf and .docx allowed)</label>
                <br/>
                <input name="file_resume" type="file" class="input-files"/>
                <br/>
                <label>Cover Letter (.pdf and .docx allowed)</label>
                <br/>
                <input name="file_cover" type="file" class="input-files"/>
                <br/> 
                <button type="submit" name="submit-application">Apply</button>
            </form>
            </div>
        </div>
    </section>
</body>
</html>