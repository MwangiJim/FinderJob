<?php
 session_start();
 include './config/myjob.configdb.php';

 $email_company = $_SESSION['company_session'];
 $sql = "SELECT * FROM company WHERE company_email = '$email_company'";
 $res = mysqli_query($conn,$sql);
 $company = mysqli_fetch_assoc($res);
// print_r($company);
$name_of_company = $company['company_name'];
$sql_applicants = "SELECT * FROM jop_application WHERE company_name = '$name_of_company'";
$response = mysqli_query($conn,$sql_applicants);
$applicants = mysqli_fetch_all($response,MYSQLI_ASSOC);
//print_r($applicants);

 if(isset($_POST['create-job-post'])){
    if(empty($_POST['position']) || empty($_POST['salary-lowest'])
     || empty($_POST['salary-highest']) || empty($_POST['description'])
     || empty($_POST['location'])){
     header('Location:./index.company.php?error=MissingInputFields');
     }
     else{
        $position = $_POST['position'];
        $salary_lowest = $_POST['salary-lowest'];
        $salary_highest = $_POST['salary-highest'];
        $description = $_POST['description'];
        $location = $_POST['location'];

        $position = mysqli_real_escape_string($conn,$position);
        $salary_lowest = mysqli_real_escape_string($conn,$salary_lowest);
        $salary_highest = mysqli_real_escape_string($conn,$salary_highest);
        $description = mysqli_real_escape_string($conn,$description);
        $location = mysqli_real_escape_string($conn,$location);
        $company_name = $company['company_name'];
        $company_location = $company['company_location'];
        $company_logo = $company['company_logo_img_path'];

        $sql_post = "INSERT INTO job_post(position,job_location,salary_highest,salary_lowest,job_description,company,company_location,company_logo,date_posted)
         VALUES('$position','$location','$salary_highest','$salary_lowest','$description','$company_name','$company_location','$company_logo', NOW())";
         if(mysqli_query($conn,$sql_post)){
            header('Location:./index.landingpage.php?createPost==true');
            exit();
         }
         else{
            header('Location:./index.company.php?error=Error404DB');
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
    <title>Company | Page</title>
    <link rel="stylesheet" href="./styles.css"/>
    <style>
            .company_page{
        width:100%;
        height:100vh;
        top:0;
        left:0;
        position: absolute;
        }
        .company_page h2{
            text-align: left;
            margin:8px 0;
        }
        .form_box{
            margin: 0 4%;
        }
        .form_box .form{
            width:450px;
            height: max-content;
        }
        .form_box .form input{
            height: 45px;
            width:95%;
            outline: none;
            border: 1px solid #000;
            border-radius: 8px;
            margin: 15px 0;
            padding: 0 15px;
        }
        .form_box .form select{
            height: 50px;
            width:460px;
            outline: none;
            border: 1px solid #000;
            border-radius: 8px;
            margin: 15px 0;
            padding: 0 15px;
        }
        .form_box .form textarea{
            height: 100px;
            width:95%;
            outline: none;
            border: 1px solid #000;
            border-radius: 8px;
            margin: 15px 0;
            padding: 0 15px;
        }
        .form_box .form label{
            font-weight: bolder;
        }
        .form_box .form input:focus{
        border: 2px solid rgb(25, 197, 25);
        }
        .form_box .form h2{
            text-align: center;
        }
        .form_box .form button{
            width:100%;
            padding: 12px 30px;
            color: #fff;
            font-weight: bold;
            outline: none;
            border: none;
            cursor: pointer;
            border-radius: 15px;
            background-color: rgb(25, 197, 25);
        }
        .form-box{
            display:flex;
            justify-content: space-between;
            flex-direction: column;
        }
        @media (max-width:500px) {
            .form-box{
                display:flex;
                justify-content: space-between;
                align-items: center;
                flex-direction: column;
            }
            .left-form-box{
                flex-basis: 100%;
            }
            .right-form-box{
                flex-basis: 100%;
            }
            .left-form-box .bg{
                height:15vh;
            }
            .left-form-box img{
                width:50px;
            object-fit: cover;
            height:50px;
            position: absolute;
            top: 60px;
            left:10px;
            }
            .description p{
                font-size:13px;
                color:gray;
            }
            .arrow_down{
                left:10%;
                position: relative;
            }
            .application-box{
                flex-direction: column;
            }
            .application-box .box-left{
                flex-basis:100%
            }
            .application-box .box-right{
                flex-basis:100%
            }
        }
        .left-form-box{
            flex-basis: 35%;
            padding: 10px;
        }
        .right-form-box{
            flex-basis: 60%;
            display:block;
        }
        .left-form-box img{
            width:80px;
            object-fit: cover;
            height:80px;
            border:2px solid #d3d3d3;
        }
        .overview{
            box-shadow: 2px 2px 7px #000;
            border-radius: 5px;
            background-color: #fff;
            padding: 10px;
        }
        .overview-info{
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
        }
        .left-overview h4{
            line-height: 30px;
            font-weight: 300;
        }
        .right-overview h4{
            line-height: 30px;
            font-weight: 300;
        }
        .arrow_down{
            width:30px;
            height:30px;
            transform: rotate(-90deg);
            animation: updown linear infinite 1s;
            position: relative;
            left:50%;
        }
        @keyframes updown {
            0%{
               bottom: 0; 
            }
            100%{
                bottom: 10px;
            }
        }
        .bg{
            background-image: url('./images/bg.jpg');
            background-position: center;
            background-size: cover;
            height: 30vh;
            width: 100%;
            position:relative;
        }
        .applicants_view{
            height: 60vh;
            max-height: 60vh;
            overflow-y: scroll;
        }
        .application-box{
            display: flex;
            justify-content: left;
            margin: 0 10px;
            box-shadow: 0 0 3px 3px #000;
            border-radius:8px;
            padding:5px;
        }
        .application-box .box-left{
            flex-basis: 40%;
        }
        .application-box .box-left h2{
           line-height:  30px;
           font-weight: 300;
           font-size: 14px;
        }
        .application-box .box-right{
            flex-basis: 40%;
        }
        .application-box button{
            background-color: #f44336;
            color: #fff;
            border: none;
            outline:none;
            cursor:pointer;
            border-radius: 10px;
            padding: 10px 35px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 2% 0;
        }
        .application-box .box-right a{
           background-color: bisque;
           border: 1px dashed green;
           height:10vh;
          border-radius: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            color: #000;
            width:50%;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <section class="company_page">
        <?php include './header.php'?>
        <div class="form-box">
            <h1 style="text-align:center;">Welcome <?php echo $company['company_name']?></h1>
            <img src="./images/office_work.jpg" style="width:100%;height:40vh;object-fit:contain;"/>
            <img src="./images/angle_left.png" class="arrow_down"/>
            <div class="left-form-box">
                <div class="bg">
                <img src="<?php echo $company['company_logo_img_path']?>"/>
                </div>
               <h1 style="margin-top:2%"><?php echo $company['company_name']?></h1>
               <div class="overview">
                <h1><?php echo $company['company_name']?> Overview</h1>
                <div class="overview-info">
                    <div class="left-overview">
                        <h4><?php echo $company['global_company_size']?> Employees</h4>
                        <h4>Type : <?php  echo $company['company_type']?></h4>
                        <h4>Revenue : <?php echo $company['revenue']?></h4>
                    </div>
                    <div class="right-overview">
                        <h4>Location : <?php echo $company['company_location']?></h4>
                        <h4>Founded in <?php echo $company['date_founded']?></h4>
                    </div>
                </div>
                <div class="description">
                    <p><?php echo $company['company_description']?></p>
                </div>
               </div>
            </div>
            <div class="right-form-box">
                <h3 style="margin:1% 10px">Job Applicants</h3>
                <div class="applicants_view">
                    <?php foreach($applicants as $applicant) :?>
                         <div class="application-box">
                            <div class="box-left">
                                <h2>Name : <?php echo $applicant['full_name']?></h2>
                                <h2>Email : <?php echo $applicant['email']?></h2>
                                <h2>Phone Number : <?php echo $applicant['phone']?></h2>
                                <h2>$/Annum : <?php echo $applicant['pay_per_annum']?></h2>
                                <h2>Years of Experience : <?php echo $applicant['years_of_exp']?></h2>
                                <h2>Current Employer : <?php echo $applicant['current_employer']?></h2>
                                <h2>Current Position : <?php echo $applicant['current_position']?></h2>
                                <h2>Date Applied : <?php echo $applicant['date_applied']?></h2>
                            </div>
                            <div class="box-right">
                                <h2>Resume File</h2>
                                <br/>
                                <a href="<?php echo $applicant['resume_file']?>" download>
                                <div>
                                <img style="width:15px;height:15px;margin-right:4px" src="./images/download.png"/>
                                Download Resume 
                                </div>
                                <img src="./images/pdf.png" style="width:30px;height:30px;object-fit:contain"/>
                                </a>
                                <h2>Cover Letter File</h2>
                                <br/>
                                <a href="<?php echo $applicant['cover_letter']?>" download>
                                <div>
                                <img style="width:15px;height:15px;margin-right:4px" src="./images/download.png"/>
                                Download Cover Letter 
                                </div>
                                <img src="./images/doc.png" style="width:30px;height:30px;object-fit:contain"/>
                                </a>
                                <form action="./index.company.php" method="POST">
                                    <button type="submit" name="delete-application">
                                     <img src="./images/bin.png" style="width:15px;height:15px"/>    
                                    Delete</button>
                                </form>
                            </div>
                         </div>
                    <?php endforeach?>
                </div>
            <h2 style="margin:0 20px">Post a Job Description</h2>
              <div class="form_box">
                <form action="./index.company.php" method="POST" class="form">
                    <label>Position</label>
                    <br/>
                    <input type="text" name="position" placeholder="Job Position">
                    <br/>
                    <label>Salary Lowest $/year</label>
                    <br/>
                    <input type="number" name="salary-lowest" placeholder="Salary Lowest $/year">
                    <br/>
                    <label>Salary Highest $/year</label>
                    <br/>
                    <input type="number" name="salary-highest" placeholder="Salary Highest $/year">
                    <br/>
                    <label>Position</label>
                    <br/>
                    <textarea type="text" name="description" placeholder="Job Description"></textarea>
                    <br/>
                    <label>Location</label>
                    <br/>
                    <select name="location">
                        <option>---Choose Location---</option>
                        <option value="Remote">Remote</option>
                        <option value="Onsite">Onsite</option>
                        <option value="Hybrid">Hybrid</option>
                    </select>
                    <br/>
                    <button type="submit" name="create-job-post">Create Job Post</button>
                </form>
                </div>
            </div>
        </div>
    </section>
</body>
</html>