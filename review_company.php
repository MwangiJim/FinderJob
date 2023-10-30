<?php 
session_start();
require "./config/myjob.configdb.php";
 if(isset($_POST['review_btn'])){
    $company_name = $_POST['company_name'];
    $sql = "SELECT company_logo_img_path,company_name FROM company WHERE company_name = '$company_name'";
    $res = mysqli_query($conn, $sql);
    $company_details = mysqli_fetch_array($res,MYSQLI_ASSOC);
  //  print_r($company_details);
 }
 if(isset($_POST["submit-review"])){
    if(empty($_POST['company_name']) || empty($_POST['rating']) || empty($_POST['employee']) || empty($_POST['status']) ||
    empty($_POST['job_title']) || empty($_POST['headline']) || empty($_POST['pros']) || empty($_POST['cons']) || empty($_POST['advice'])){
      header('Location:./review_company.php?error=MissingReviewFields');
    }
    else{
        $companyname = $_POST['company_name'];
        $rating = $_POST['rating'];
        $employee = $_POST['employee'];
        $status = $_POST['status'];
        $job_title = $_POST['job_title'];
        $headline = $_POST['headline'];
        $pros = $_POST['pros'];
        $cons = $_POST['cons'];
        $advice = $_POST['advice'];
        $ceo_approval = $_POST['ceo_approval'];
        $business_outlook = $_POST['business_outlook'];
        $recommend = $_POST['recommend'];

        $companyname = mysqli_real_escape_string($conn,$companyname);
        $rating = mysqli_real_escape_string($conn,$rating);
        $employee = mysqli_real_escape_string($conn,$employee);
        $status = mysqli_real_escape_string($conn,$status);
        $job_title = mysqli_real_escape_string($conn,$job_title);
        $headline = mysqli_real_escape_string($conn,$headline);
        $pros = mysqli_real_escape_string($conn,$pros);
        $cons = mysqli_real_escape_string($conn,$cons);
        $advice = mysqli_real_escape_string($conn,$advice);
        $date = date('Y/m/d');

        $sql_review = "INSERT INTO reviews(company_name,rating,employee_type,employment_status,job_title,headline,pros,cons,advice,date_posted,ceo_approval,recommend,business_outlook) 
        VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt,$sql_review);
        mysqli_stmt_bind_param($stmt,'sssssssssssss',$companyname,$rating,$employee,$status,$job_title,$headline,$pros,$cons,$advice,$date,$ceo_approval,$recommend,$business_outlook);
        mysqli_stmt_execute($stmt);
        header('Location:./index.php');
        exit();
    }
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FinderJob | Survey</title>
    <link rel="icon" href="./images/favicon.ico" type="image/x-icon">
    <style>
        *{
            margin: 0%;
            padding: 0%;
            font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
        }
        .top_header{
            padding: 15px 10px;
            background-color: #fff;
        }
        .top_header h1{
            color: green;
            font-size: 35px;
            font-weight: bold;
        }
        .reviews{
            background-color: #d3d3d3;
            height:max-content;
            width:100%;
            top:0;
            left:0;
            position: absolute;
        }
        .survey_box{
            display:flex;
            justify-content: space-between;
            margin:4% 13%;
        }
        @media(max-width:500px){
            .survey_box{
                flex-direction: column;
            }
            .right_survey{
                margin-top: 10px;
            }
        }
        .left_survey{
            background-color: #fff;
            flex-basis: 64%;
            height:max-content;
            padding: 10px;
        }
        .right_survey{
            background-color: #fff;
            flex-basis: 30%;
            height:max-content;
            padding: 10px;
        }
        .right_survey ul{
            margin:3% 15px;
        }
        .right_survey ul li{
          margin: 5px 0;
          list-style:circle;
        }
        .right_survey p{
            line-height: 25px;
        }
        .left_survey h2{
            font-size: 30px;
            font-weight:  bold;
        }
        .left_survey p{
            font-size: 14px;
            margin: 2% 0;
        }
        .left_survey form .input_col{
         display: flex;
         justify-content: left;
         align-items:center;
         margin: 1% 0;
        }
        .input_col img{
            height:50px;
            width:50px;
            object-fit: contain;
        }
        .input_col input{
            width:90%;
            outline:none;
            height: 40px;
            border:2px solid grey;
            padding: 0 10px;
            margin-left: 3%;
            border-radius: 4px;
        }
        .input_col input:focus{
            border:2px solid green;
        }
        .radio-inputs{
            display: flex;
            justify-content: left;
            align-items: center;
            margin: 2% 0;
        }
        .radio-inputs div{
            margin: 0 1%;
        }
        .left_survey .input{
            width:96%;
            height:40px;
            border:1px solid grey;
            padding: 0 10px;
            border-radius: 5px;
            outline:none;
            margin:2% 0;
        }
        .left_survey .input:hover{
            border: 1px solid green;
        }
        .left_survey select{
            height: 45px;
            width:50%;
            border:2px solid grey;
            border-radius: 5px;
        }
        .left_survey label{
            margin: 1% 0;
        }
        .left_survey textarea{
            width:96%;
            height:70px;
            border:1px solid grey;
            padding: 0 10px;
            border-radius: 5px;
            outline:none;
            margin:2% 0;
        }
        .box{
            border:0.5px solid grey;
            padding: 12px 20px;
            text-align: center;
        }
        .left_survey button{
            background-color: green;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-weight:bold;
            padding: 10px 40px;
            font-size: 20px;
        }
    </style>
</head>
<body>
    <section class="reviews">
        <div class="top_header">
            <h1>FinderJob</h1>
        </div>
       <div class="survey_box">
         <div class="left_survey">
            <h2>Rate a Company</h2>
            <p>It only takes a minute! And your anonymous review will help other job seekers.</p>
            <form action="./review_company.php" method="POST">
                <div class="input_col">
                    <img src="<?php echo $company_details['company_logo_img_path']?>"/>
                   <input type="text" name="company_name" value="<?php echo $company_details['company_name']?>"/>
                </div>
                <label>Overall Rating *</label>
                <br/>
                <input class="input" type="number" name="rating" placeholder="e.g 4/5">
                <br/>
                <label>Are you a current or former employee?</label>
                <br/>
                <div class="radio-inputs">
                    <div> 
                        <input type="radio" name="employee" value="Current Employee"/>
                        <label>Current Employee</label>
                    </div>
                    <div>
                        <input type="radio" name="employee" value="Former Employee"/>
                        <label>Former Employee</label>
                    </div>
                </div>
                <br/>
                    <label>Employment Status *</label>
                    <br/><br/>
                    <select name="status">
                        <option>Select your Option</option>
                        <option value="full Time">Full Time</option>
                        <option value="Part Time">Part Time</option>
                        <option value="Internship">Internship</option>
                        <option value="Contract">Contract</option>
                        <option value="Freelance">Freelance</option>
                    </select>
                    <br/><br/>
                    <label>Your Job Title at <?php echo $company_details['company_name']?></label>
                    <br/>
                    <input class="input" type="text" name="job_title"/>
                    <br/>
                    <label>Review Headline *</label>
                    <br/>
                    <input class="input" type="text" name="headline"/>
                    <br/>
                    <label>Pros *</label>
                    <br/>
                    <textarea  type="text" name="pros" placeholder="Share some of the best reasons to work at Company XYZ"></textarea>
                    <br/>
                    <small>10 words mininum</small>
                    <br/>
                    <label>Cons *</label>
                    <br/>
                    <textarea  type="text" name="cons" placeholder="Share some of the downsides to work at Company XYZ"></textarea>
                    <br/>
                    <small>10 words mininum</small>
                    <br/>
                    <label>Advice For Management </label>
                    <br/>
                    <textarea  type="text" name="advice" placeholder="Share some suggestions to the management at Company XYZ"></textarea>
                    <br/>
                    <label>Recommend</label>
                    <div style="display:flex;">
                    <input type="radio" name="recommend" value="yes"/>
                    <p>Yes</p>
                    <input style="margin-left:5px" type="radio" name="recommend" value="no"/>
                    <p>No</p>
                    </div>
                    <br/><br/>
                    <label>CEO Approval</label>
                    <div style="display:flex;">
                    <input type="radio" name="ceo_approval" value="yes"/>
                    <p>Yes</p>
                    <input style="margin-left:5px" type="radio" name="ceo_approval" value="no"/>
                    <p>No</p>
                    </div>
                    <br/><br/>
                    <label>Business Outlook</label>
                    <div style="display:flex;">
                    <input type="radio" name="business_outlook" value="yes"/>
                    <p>Yes</p>
                    <input style="margin-left:5px" type="radio" name="business_outlook" value="no"/>
                    <p>No</p>
                    </div>
                    <br/><br/>
                    <div class="box">
                        <small>All information contributed above will be visible to people who visit Glassdoor.</small>
                     </div>
                     <br/>
                     <input type="checkbox" name="check"/>
                     <label>I agree to the Glassdoor Terms of Use. This review of my experience at my current or former employer is truthful.</label>
                      <br/> <br/>
                     <button type="submit" name="submit-review">Submit Review</button>
                    </form>
         </div>
         <div class="right_survey">
            <h2>Be Factual</h2>
            <p>Thank you for contributing to the community. Your opinion will help others make decisions about jobs and companies.</p>
             <p style="font-weight:bold">Please stick to the Community Guidelines and do not post:</p>
             <ul>
                <li>Aggressive or discriminatory language</li>
                <li>Profanities</li>
                <li>Trade secrets/confidential information</li>
             </ul>
             <p>Thank you for doing your part to keep FinderJob the most trusted place to find a job and company you love. See the Community Guidelines for more details.</p>
        </div>
       </div>
    </section>
</body>
</html>
