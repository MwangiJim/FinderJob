<?php 
 session_start();
 include './config/myjob.configdb.php';
 if(isset($_POST['company-to-view'])){
    $name = $_POST['company-id'];
    //echo $name;
    $sql = "SELECT * FROM company WHERE company_name = '$name'";
    $res = mysqli_query($conn,$sql);
    $company_info = mysqli_fetch_assoc($res);
    //print_r($company_info);
   // header('Location:./company.overview.php/Working-At-' . $name);
   $sql_jobs = "SELECT * FROM job_post WHERE company = '$name'";
   $response = mysqli_query($conn,$sql_jobs);
   $company_jobs = mysqli_fetch_all($response,MYSQLI_ASSOC);
   
  // print_r($company_jobs);
 }
 $sql_fetch_reviews="SELECT * FROM reviews WHERE company_name = '$name'";
 $res = mysqli_query($conn,$sql_fetch_reviews);
 $reviews = mysqli_fetch_all($res,MYSQLI_ASSOC);
 
 //echo date('Y/m/d');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Overview | FinderJob</title>
    <link rel="icon" href="./images/favicon.ico" type="image/x-icon">
    <style>
        .overview{
            width:100%;
            height:100vh;
        }
        .top_box{
            margin: 10px 5%;
            box-shadow: 2px 2px 4px #000;
            position: relative;
        }
        .container_cover{
            background-image: url('./images/bg.jpg');
            background-position: center;
            background-size: cover;
            width: 100%;
            height:20vh;
        }
        .container_mid{
            margin: 0 8px;
            display: flex;
            justify-content: left;
            padding: 5px 7px;
        }
        .container_mid img{
           border: 2px solid #d3d3d3;
           bottom: 30px;
           position: relative;
        }
        .container_bottom{
            padding: 5px 7px;
            display:flex;
            justify-content: space-between;
            align-items: center;
        }
        @media (max-width:500px) {
            .container_cover{
                height:10vh;
            }
            .container_bottom{
                display:flex;
                justify-content: center;
                align-items: center;    
                flex-direction: column;
            }
            .left_container div{
                padding: 5px 3px;
            }
            .left_container div h4{
                font-size: 12px;
            }
        }
        .left_container{
            flex-basis: 55%;
            display:flex;
            justify-content: space-between;
            align-items: center;
        }
        .left_container div{
            display: block;
            text-align: left;
            border-right: 1px solid #d3d3d3;
            padding: 10px 6px;
        }
        .left_container div h4{
            color: aqua;
            font-weight: 300;
        }
        .right_container{
            flex-basis: 13%;
            display:flex;
            justify-content: space-between;
            align-items: center;
        }
        .overview_box{
            margin: 10px 5%;
            box-shadow: 2px 2px 4px #000;
            padding: 8px 7px;
        }
        .overview_box h1{
            margin: 7px 0;
        }
        .preview_box{
            display:flex;
            justify-content: space-between;
            align-items: center;
        }
        .overview_left{
            text-align: left;
        }
        .preview_box h3{
          font-weight: 300;
          font-size: 15px;
          line-height: 30px;
        }
        .post_template{
            padding: 10px 5px;
            margin: 5px 0;
            border-bottom: 1px solid #000;
            width:100%;
            box-shadow: 2px 2px 4px #000;
        }
        .post_template button{
            border:2px solid #000;
            background: transparent;
            padding: 8px 30px;
            cursor: pointer;
            outline: none;
            display:flex;
            justify-content: center;
            align-items: center;
            border-radius: 10px;
            margin:10px 0;
        }
        .post_template button img{
            width:20px;
            height:20px;
        }
        .top_head{
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .top_head_left{
            display: flex;
            justify-content: space-between;
            align-items:center;
        }
        .top_head_left img{
            width:40px;
            height:40px;
            border-radius: 50%;
            cursor: pointer;
            border: 2px solid #000;
            object-fit: contain;
        }
        .top_head_left h2{
            font-size: 20px;
        }
        .post_info p{
            margin: 5px 0;
            font-weight: 500;
        }
        .post_info{
            text-align: left;
            margin-top: 10px;
        }
        .post_info h2{
            font-size: 18px;
        }
        .jobs_available{
            margin: 10px 5%;
            display:flex;
            justify-content: space-between;
        }
        @media(max-width:500px){
            .jobs_available{
                flex-direction: column;
            }
        }
        .left_jobs{
            flex-basis: 45%;
        }
        .right_jobs{
            flex-basis: 49%;
        }
        .container{
            width:90%;
            border-radius:10px;
            height:max-content;
            text-align: left;
            margin: 2% 0;
        }
        .template_review{
            box-shadow: 4px 4px 8px grey;
            border-radius:5px;
            padding:10px;
            margin: 1% 0;
        }
    </style>
</head>
<body>
    <section class="overview">
        <?php include './header.php'?>
        <div class="top_box">
            <div class="container_cover"></div>
            <div class="container_mid">
                <img style = "width:60px;height:60px;object-fit:cover;"src="<?php echo $company_info['company_logo_img_path']?>"/>
                <h2><?php echo $company_info['company_name']?></h2>
            </div>
            <div class="container_bottom">
               <div class="left_container">
               <div>Overview</div>
                <div><p>145K</p><h4>Reviews</h4></div>
                <div><p>10K</p><h4>Jobs</h4></div>
                <div><p>334K</p><h4>Salaries</h4></div>
                <div><p>80K</p><h4>Q&A</h4></div>
                <div><p>50K</p><h4>Interviews</h4></div>
                <div><p>37K</p><h4>Benefits</h4></div>
                <div><p>85K</p><h4>Diversity</h4></div>
               </div>
               <div class="right_container">
                   <button>Follow</button>
                  <form action="./review_company.php" method="POST">
                      <input type="hidden" value="<?php echo $company_info['company_name']?>" name="company_name">
                     <button type="submit" name="review_btn">Add A Review</button>
                  </form>
               </div>
            </div>
        </div>
        <div class="overview_box">
            <h1><?php echo $company_info['company_name']?> OverView</h1>
            <div class="preview_box">
              <div class="overview_left">
                <h3><?php echo $company_info['global_company_size']?></h3>
                <h3>Type : <?php echo $company_info['company_type']?></h3>
                <h3>Revenue : <?php echo $company_info['revenue']?></h3>
                </div>
                <div class="overview_right">
                    <h3>Location : <?php echo $company_info['company_location']?></h3>
                    <h3>Founded in : <?php echo $company_info['date_founded']?></h3>
                </div>
            </div>
            <div class="description">
                <p><?php echo $company_info['company_description']?></p>
            </div>
        </div>
        <div class="jobs_available">
            <div class="left_jobs">
            <h3 style="color:green">Jobs at <?php echo $company_info['company_name']?></h3>
            <div class="job_section">
              <?php foreach($company_jobs as $company_job) :?>
                <form action="./index.php" method="POST">
                    <div class="post_template">
                        <div class="top_head">
                            <div class="top_head_left">
                                <img src="<?php echo $company_job['company_logo']?>"/>
                                <h2 style="margin-left:7px;"><?php echo $company_job['company']?></h2>
                                <img src="./images/star.png" style="width:10px;height:10px;border:none;"/>
                            </div>
                            <img src="./images/bookmark.png" style="height:20px;width:20px;"/>
                        </div>
                        <div class="post_info">
                            <h3><?php echo $company_job['position']?></h3>
                            <p><?php echo $company_job['job_location'] . ',' . $company_job['company_location']?></p>
                            <h2>$<?php echo $company_job['salary_lowest'].'-'.'$'.$company_job['salary_highest']?></h2><small>[Employer est]</small>
                            <br/>
                            <small>Posted on <?php echo $company_job['date_posted']?></small>
                        </div>
                        <input type="hidden" name="job-id-to-submit" value="<?php echo $company_job['id']?>">
                        <button type="submit" name="submit-job-details"><img src="./images/srike.png"/>Apply</button>
                     </div>    
                    </form>
                <?php endforeach?>
            </div>
            </div>
            <div class="right_jobs">
                <h2 style="color:green"><?php echo $company_info['company_name']  . " "?>Reviews</h2>
                <?php foreach($reviews as $review):?>
                     <div class="template_review">
                    <div style="display:flex;justify-content:space-between;margin:2% 0;align-items:center;">
                    <div class="stars" style="display:flex;justify-content:space-between;width:max-content;align-items:center;">
                        <?php echo $review['rating'] . "." . "0" ?>
                        <div class="ratings" style="margin-left:5px">
                            <?php for($i = 1;$i <= $review['rating'];$i++){?>
                                  <img src="./images/star.png" style="width:20px;height:20px"/>
                               <?php }?> 
                        </div>
                     </div>
                     <p><?php echo $review['date_posted']?></p>
                    </div>
                     <h4 style="font-size:25px;font-weight:300;"><?php echo $review['headline']?></h4>
                        <div class="user_details">
                           <div style="display:flex;justify-content:left;margin:2% 0">
                            <img src="./images/profile.png" style="height:25px;width:25px;"/>
                            <div >
                            <h2 style="font-weight:400;margin-left:5px;font-size:17px">Anonymous User</h2>
                           <div style="display:flex;justify-content:space-between;margin:1% 0">
                            <small style="color:gray;font-size:11px;background-color:#d3d3d3;padding:5px 10px;border-radius:6px;margin:0 4px"><?php echo $review['employee_type']?></small>
                            <small style="color:gray;font-size:11px;background-color:#d3d3d3;padding:5px 10px;border-radius:6px;margin:0 4px"><?php echo $review['job_title']?></small>
                           </div>
                            </div>
                           </div>
                           <br/>
                        </div>
                        <div class="company_rating" style="margin:2% 0;width:70%;display:flex;justify-content:space-between;align-items:center">
                            <div style="display:flex;justify-content:space-between;align-items:center">
                                <img src="<?php echo $review['recommend'] === "yes"?'./images/check.png':'./images/cross.png' ?>" style="height:15px;width:15px;margin:0 2px;"/>
                                <h4 style="font-size:18px;font-weight:400">Recommend</h4>
                            </div>
                            <div style="display:flex;justify-content:space-between;align-items:center">
                                <img src="<?php echo $review['ceo_approval'] === "yes"?'./images/check.png':'./images/cross.png' ?>" style="height:15px;width:15px;margin:0 2px;" ?>
                                <h4 style="font-size:18px;font-weight:400">CEO Approval</h4>
                            </div>
                            <div style="display:flex;justify-content:space-between;align-items:center">
                                <img src="<?php echo $review['business_outlook'] === "yes"?'./images/check.png':'./images/cross.png' ?>" style="height:15px;width:15px;margin:0 2px;" ?>
                                <h4 style="font-size:18px;font-weight:400">Business Outlook</h4>
                            </div>
                        </div>
                        <h5 style="color:green;font-size:15px;font-weight:bold">Pros</h5>
                        <div class="container">
                          <p><?php echo $review['pros']?></p>
                        </div>
                        <h5 style="color:red;font-size:15px;font-weight:bold">Cons</h5>
                        <div class="container">
                          <p><?php echo $review['cons']?></p>
                        </div>
                        <h5 style="color:#333;font-size:15px;font-weight:bold">Recommended Advice</h5>
                        <div class="container">
                         <p><?php echo $review['advice']?></p>
                        </div>
                     </div>
                    <?php endforeach ?>
            </div>
        </div>
    </section>
</body>
</html>