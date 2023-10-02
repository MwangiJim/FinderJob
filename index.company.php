<?php
 session_start();
 include './config/myjob.configdb.php';

 $email_company = $_SESSION['company_session'];
 $sql = "SELECT * FROM company WHERE company_email = '$email_company'";
 $res = mysqli_query($conn,$sql);
 $company = mysqli_fetch_assoc($res);

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
            width:100%;
            object-fit: cover;
            height:20vh;
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
    </style>
</head>
<body>
    <section class="company_page">
        <?php include './header.php'?>
        <div class="form-box">
            <div class="left-form-box">
               <img src="<?php echo $company['company_logo_img_path']?>"/>
               <h1><?php echo $company['company_name']?></h1>
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
            <h2>Post a Job Description</h2>
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