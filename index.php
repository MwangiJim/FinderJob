<?php 
 session_start();
 include './config/myjob.configdb.php';


 $sql = "SELECT * FROM job_post";
 $response = mysqli_query($conn,$sql);
 $posts = mysqli_fetch_all($response,MYSQLI_ASSOC);
 //echo $posts[9]['date_posted'];
 $job;
 $job_posts_search;
 if(isset($_POST['submit-job-details'])){
  $id = $_POST['job-id-to-submit'];
  $sql_job_details = "SELECT * FROM job_post WHERE id = $id";
  $res = mysqli_query($conn,$sql_job_details);
  $job = mysqli_fetch_assoc($res);
  $company_name = $job['company'];

  $sql_reviews_fetch = "SELECT * FROM reviews WHERE company_name = '$company_name'";
  $response = mysqli_query($conn,$sql_reviews_fetch);
  $reviews = mysqli_fetch_all($response,MYSQLI_ASSOC);
  $review = mysqli_fetch_assoc($response);

  $sql_company_details = "SELECT * FROM company WHERE company_name='$company_name'";
  $comp_response = mysqli_query($conn,$sql_company_details);
  $company_details = mysqli_fetch_assoc($comp_response);
 }
 else{
    $id_of_first_post = $posts[0]['id'];
    $sql_job_details = "SELECT * FROM job_post WHERE id = $id_of_first_post";
    $res = mysqli_query($conn,$sql_job_details);
    $job = mysqli_fetch_assoc($res);

    $company_name = $job['company'];

    $sql_reviews_fetch = "SELECT * FROM reviews WHERE company_name = '$company_name'";
    $response = mysqli_query($conn,$sql_reviews_fetch);
    $reviews = mysqli_fetch_all($response,MYSQLI_ASSOC);
    //print_r($reviews);

    $sql_company_details = "SELECT * FROM company WHERE company_name='$company_name'";
    $comp_response = mysqli_query($conn,$sql_company_details);
    $company_details = mysqli_fetch_assoc($comp_response);
 }

 if(isset($_POST['submit-search-value'])){
    if(empty($_POST['search-keyword'])){
        header('Location:./index.php?error=SearchValueNull');
        exit();
    }
    else{
        $keyword = $_POST['search-keyword'];
        $location = $_POST['Location'];
        //echo $keyword;

         $sql_search_val = "SELECT * FROM job_post WHERE position = '$keyword'";
         if(!mysqli_query($conn,$sql_search_val)){
            header('Location:./index.php?error=Errorsearch&CouldntFind');
            exit();
        }
        else{
            $res = mysqli_query($conn,$sql_search_val);
            $job_posts_search = mysqli_fetch_all($res,MYSQLI_ASSOC);
           // header('location:./index.landingpage.php?msg=true&found=true');
          //  print_r($job_posts_search);
            //exit();
        }
    }
 }
 if(isset($_SESSION['user_session'])){
    $email_check = $_SESSION['user_session'];
    $sql_check_applied = "SELECT * FROM jop_application WHERE email='$email_check'";
    $response = mysqli_query($conn,$sql_check_applied);
    $applications = mysqli_fetch_all($response,MYSQLI_ASSOC);
 }
 //number of applicants
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FinderJob</title>
    <link rel="icon" href="./images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="./styles.css"/>
    <style>
        .select_area{
            display:flex;
            justify-content: space-between;
            align-items: center;
        }
        .select_area select{
            width:300px;
            height:45px;
            border-radius: 10px;
            padding: 0 15px;
        }
        .select_area img{
            width: 20px;
            height: 20px;
            transform:rotate(30deg);
        }
        .select_area a{
            text-decoration: none;
            color: rgb(25, 197, 25);
        }
        .body{
            background-color: #d3d3d3;
            height: 100vh;
        }
        .jobs_info_area{
          width:94%;
          margin: 2%;
          padding: 10px 12px;
          background-color: #fff;
        }
        .box_jobs{
            display:flex;
            justify-content: space-between;
            margin-top: 1%;
        }
        .search-box{
            width:500px;
        }
        @media screen and (max-width:500px){
            .box_jobs{
                display:block;
            }
            .left_info_area{
                flex-basis: 100%;
            }
            .right_info_area{
                flex-basis: 100%;
            }
            .select_area{
                display: none;
            }
            .search_bar .search-box{
                width:350px;
                height:35px;
            }
            .search_bar .search-box .input-location{
                width:60px;
            }
            .top_header_box .right_area button{
                padding: 9px 35px;
                font-size: 14px;
            }
            .right_info_area{
                background-color: #fff;
            }
        }
        .left_info_area{
            flex-basis: 35%;
            width:100%;
            height:50vh;
            max-height: 50vh;
            overflow-y: scroll;
        }
        .left_info_area::-webkit-scrollbar{
            width:5px;
            background-color: #fff;
        }
        .left_info_area::-webkit-scrollbar-track{
            width:5px;
            background-color: #fff;
        }
        .left_info_area::-webkit-scrollbar-thumb{
            width:5px;
            background-color: #333;
        }
        .right_info_area{
            flex-basis: 60%;
            width:100%;
            height:50vh;
            max-height: 50vh;
            overflow: scroll;
        }
        .right_info_area::-webkit-scrollbar{
            width:5px;
            background-color: #fff;
        }
        .right_info_area::-webkit-scrollbar-track{
            width:5px;
            background-color: #fff;
        }
        .right_info_area::-webkit-scrollbar-thumb{
            width:5px;
            background-color: #333;
        }
        .post_template{
            padding: 10px 5px;
            margin: 5px 0;
            border-bottom: 1px solid #000;
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
        .top_bar{
            background-color: #fff;
            width:100%;
            padding: 4px 0px;
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
        .top_header_box{
            display: flex;
            justify-content: space-between;
        }
        .top_header_box .left_box_area{
            flex-basis: 45%;
        }
        .top_header_box .left_box_area h1{
            margin: 2% 0;
        }
        .top_header_box .left_box_area p{
            margin: 1% 0;
        }
        .head_logo{
            display: flex;
            justify-content: left;
            align-items: center;
        }
        .head_logo img{
            width:40px;
            height: 40px;
            object-fit: cover;
            border-radius: 20px;
        }
        .top_header_box .left_area small{
            padding:12px 0 20px;
        }
        .top_header_box .right_area{
            flex-basis: 40%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .top_header_box .right_area button{
           background-color: green;
           border: none;
           cursor:pointer;
            padding: 12px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color:#fff;
            border-radius: 10px;
        }
        .top_header_box .right_area button img{
        width:15px;
        height:15px;
        }
        .job_description{
            margin-top: 15px;
        }
        .search-box button{
            border:none;
            background: transparent;
            outline: none;

        }
        .review_company{
            margin:2% 0;
        }
        .bar_area_view{
            display:flex;
            justify-content: space-between;
            align-items: center;
            margin: 4% 0;
        }
        .green-bar{
            height:15px;
            width:90%;
            background-color: green;
        }
        .pay-range{
            flex-basis: 70%;
        }
        .pay{
            display:flex;
            justify-content: space-between;
            align-items: center;
        }
        .company_box{
            display: flex;
            justify-content: space-between;
            margin: 3% 0;
        }
        .company_box h4{
            font-size: 18px;
            font-weight: bold;
        }
        .company_box h5{
            font-size: 15px;
            font-weight: 300;
        }
        .company_left{
            flex-basis: 45%;
        }
        .company_right{
            flex-basis: 45%;
        }
        .ratings_box{
            display: flex;
            justify-content: space-between;
            margin: 3% 0;
        }
        .ratings_left{
            flex-basis: 45%;
            display: flex;
            justify-content: space-between;
            flex-direction: column;
        }
        .ratings_right{
            flex-basis: 45%;
        }
        .company_reviews_box{
            display:flex;
            justify-content: space-between;
            align-items: center;
        }
        .rating_col{
            margin: 3% 0;
        }
        .rating_col h3{
            font-size: 15px;
            font-weight:300;
        }
    </style>
</head>
<body>
    <?php if(isset($_SESSION['user_session']) || isset($_SESSION['company_session'])):?>
        <section class="body">
        <?php include './header.php'?>
       <div class="top_bar">
       <div class="search_bar">
               <form action="./index.php" method = "post">
               <div class="search-box">
                     <button type="submit" name="submit-search-value"><img src="./images/search.png"/></button>
                    <input class ="input-search" type="text" name="search-keyword" placeholder="Find You Job ...Type All"/>
                    <img src="./images/location.png"/>
                    <input class ="input-location" type="text" name="Location" placeholder="Location"/>
                </div>
               </form>
        </div>
        <div class="user_bar">
            <li><a href="#">For You</a></li>
            <li><a href="#">Activity</a></li>
            <li><a href="#">Search</a></li>
        </div>
       </div>
        <div class="jobs_info_area">
            <div class="select_area">
                <select name="job-type">
                    <option value="full time">Full Time</option>
                    <option value="Part time">Part Time</option>
                    <option value="Contract">Contract</option>
                    <option value="Internship">Internship</option>
                </select>
                <select name="post-time">
                    <option value="Posted Any Time">Posted Any Time</option>
                    <option value="3 days ago">3 days ago</option>
                    <option value="1 week ago">1 week ago</option>
                    <option value="2 week ago">2 week ago</option>
                    <option value="30 days ago">30 days ago</option>
                    <option value="2 months ago">2 months ago</option>
                </select>
                <select name="salary-range">
                    <option>--Salary Range----</option>
                    <option value="$25k-$30k">$25k-$30k</option>
                    <option value="$35k-$40k">$35k-$40k</option>
                    <option value="$45k-$50k">$45k-$50k</option>
                    <option value="$55k-$60k">$55k-$60k</option>
                    <option value="$65k-$70k">$65k-$70k</option>
                    <option value="$75k-$80k">$75k-$80k</option>
                    <option value="$85k-$90k">$85k-$90k</option>
                    <option value="$95k-$100k">$95k-$100k</option>
                    <option value="$125k-$230k">$125k-$230k</option>
                </select>
                <div class="alert-box">
                    <img src="./images/bell_plus.png"/>
                    <a href="#">Create Alert</a>
                </div>
            </div>
          <div class="box_jobs">
            <div class="left_info_area">
               <?php if($job_posts_search) :?>
                <?php foreach($job_posts_search as $post) : ?>
                    <form action="./index.php" method="POST">
                    <div class="post_template">
                        <div class="top_head">
                            <div class="top_head_left">
                                <img src="<?php echo $post['company_logo']?>"/>
                                <h2 style="margin-left:7px;"><?php echo $post['company']?></h2>
                                <img src="./images/star.png" style="width:10px;height:10px;border:none;"/>
                            </div>
                            <img src="./images/bookmark.png" style="height:20px;width:20px;"/>
                        </div>
                        <div class="post_info">
                            <h3><?php echo $post['position']?></h3>
                            <p><?php echo $post['job_location'] . ',' . $post['company_location']?></p>
                            <h2>$<?php echo $post['salary_lowest'].'-'.'$'.$post['salary_highest']?></h2><small>[Employer est]</small>
                            <br/>
                            <small>Posted on <?php echo $post['date_posted']?></small>
                        </div>
                        <input type="hidden" name="job-id-to-submit" value="<?php echo $post['id']?>">
                        <button type="submit" name="submit-job-details"><img src="./images/srike.png"/>Apply</button>
                     </div>    
                    </form>
                    <?php endforeach?>
               <?php else  :?>
                <?php foreach($posts as $post) : ?>
                    <form action="./index.php" method="POST">
                    <div class="post_template">
                        <div class="top_head">
                            <div class="top_head_left">
                                <img src="<?php echo $post['company_logo']?>"/>
                                <h2 style="margin-left:7px;"><?php echo $post['company']?></h2>
                                <img src="./images/star.png" style="width:10px;height:10px;border:none;"/>
                            </div>
                            <img src="./images/bookmark.png" style="height:20px;width:20px;"/>
                        </div>
                        <div class="post_info">
                            <h3><?php echo $post['position']?></h3>
                            <p><?php echo $post['job_location'] . ',' . $post['company_location']?></p>
                            <h2>$<?php echo $post['salary_lowest'].'-'.'$'.$post['salary_highest']?></h2><small>[Employer est]</small>
                            <br/>
                            <small>Posted on <?php echo $post['date_posted']?></small>
                        </div>
                        <input type="hidden" name="job-id-to-submit" value="<?php echo $post['id']?>">
                        <button type="submit" name="submit-job-details"><img src="./images/srike.png"/>Apply</button>
                     </div>    
                    </form>
                    <?php endforeach?>
               <?php endif?>
            </div>
            <div class="right_info_area">
              <div class="top_header_box">
                 <div class="left_box_area">
                    <div class="head_logo">
                        <img src="<?php echo $job['company_logo']?>"/>
                        <form action="./company.overview.php" method = "POST">
                            <input type="hidden" name="company-id" value="<?php echo $job['company']?>"/>
                           <button type="submit" name="company-to-view" 
                           style="border:none;outline:none;background:transparent;cursor:pointer"
                           ><h2><?php echo $job['company']?></h2></button>
                        </form>
                    </div>
                     <h1><?php echo $job['position']?></h1>
                     <p><?php echo $job['company_location'] . '-' . $job['job_location']?></p>
                     <small>$<?php echo $job['salary_lowest'] . '-'.'$' . $job['salary_highest']?>[FinderJob . Est]</small>
                 </div>
                 <div class="right_area">
                 <?php if(isset($_SESSION['user_session'])) :?>
                  <?php foreach($applications as $application) :?>
                    <?php if($application['company_name'] === $job['company'] && $application['date_applied']) :?>
                             <h4>Applied on <?php echo $application['date_applied']?></h4>
                        <?php else :?>
                            <form action="./job_application.php" method="POST">
                                <input type="hidden" name="company-id" value="<?php echo $job['id'] ?>"/>
                                <button type="submit" name="submit-job-application"><img src="./images/srike.png"/>FinderApply</button>
                            </form>
                             
                     <?php endif?>
                        <?php endforeach?>
                     <?php endif?>
                    <button>Save</button>
                 </div>
              </div>
              <div class="job_description">
                <h4>Job Description</h4>
                <?php echo $job['job_description']?>
              </div>
              <div class="review_company">
                <h2 style="margin:5px 0">Average base salary estimate</h2>
                <small>Estimate Provided by Employer</small>
                <div class="bar_area_view">
                    <div>
                    <h1 style = "color:green;flex-basis:20%;font-weight:bolder">$<?php echo ($job['salary_highest'] + $job['salary_lowest'])/2?><small style="font-weight:300;color:black;font-size:12px">/yr [Est]</small></h1>
                    </div>
                    <div class="pay-range">
                        <div class="green-bar"></div>
                        <div class="pay">
                            <small>$<?php echo $job['salary_lowest']?></small>
                            <small>$<?php echo $job['salary_highest']?></small>
                        </div>
                     </div>
                </div>
                <h2>Company Overview</h2>
                <div class="company_box">
                    <div class="company_left">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin:2% 0">
                            <h4>Size</h4>
                            <h5><?php echo $company_details['global_company_size']?></h5>
                        </div>
                        <div style="display:flex;justify-content:space-between;align-items:center;margin:2% 0">
                            <h4>Industry</h4>
                            <h5><?php echo $company_details['company_type']?></h5>
                        </div>
                        <div style="display:flex;justify-content:space-between;align-items:center;margin:2% 0">
                            <h4>Location</h4>
                            <h5><?php echo $company_details['company_location']?></h5>
                        </div>
                    </div>
                    <div class="company_right">
                         <div style="display:flex;justify-content:space-between;align-items:center;margin:2% 0">
                            <h4>Founded</h4>
                            <h5><?php echo $company_details['date_founded']?></h5>
                         </div>
                        <div style="display:flex;justify-content:space-between;align-items:center;margin:2% 0">
                            <h4>Revenue</h4>
                            <h5><?php echo $company_details['revenue']?></h5>
                        </div>
                    </div>
                </div>
                <div class="company_reviews">
                    <h2><?php echo $company_details['company_name']?> Ratings</h2>
                    <?php foreach($reviews as $review) :?>
                        <?php
                         $recommendations_count = 0;
                         $ceo_approval = 0;
                         if($review['recommend'] === 'yes'){
                            $recommendations_count += 1;
                         }
                         if($review['ceo_approval'] === 'yes'){
                            $ceo_approval += 1;
                         }
                        ?>
                   <div class="ratings_box">
                    <div class="ratings_left">
                        <div class="stars" style="display:flex;justify-content:left;align-items:center;margin:2% 0">
                            <?php echo $review['rating'] . '.' . '0'?>
                              <div class="stars" style="display:flex;justify-content:space-between;align-items:center;">
                                <?php for($i=1;$i<=$review['rating'];$i++) {?>
                                    <img src="./images/star.png" style="height:17px;width:17px;margin:0 5px"/>
                                    <?php }?>
                              </div>
                        </div>
                        <div class="company_reviews_box">
                              <div class="review_box">
                                <div class="circle" style="align-items:center;height:80px;width:80px;border-radius:50%;border:5px solid #000;">
                                    <h1 style="text-align:center;margin-top:25px"><?php echo $recommendations_count/count($reviews) * 100 . '%'?></h1>  
                                </div>
                                <h5>Recommend A Friend</h5>
                              </div>
                              <div class="review_box">
                                <div class="circle" style="height:80px;width:80px;border-radius:50%;border:5px solid #000;">
                                <h1 style="text-align:center;margin-top:25px"><?php echo $ceo_approval/count($reviews) * 100 . '%'?></h1> 
                                </div>
                                <h5>Approve of CEO</h5>
                              </div>
                              <div class="review_box">
                                <img src="./images/profile.png" style="height:90px;width:90px;"/>
                                <h5>CEO ,<?php echo $company_details['company_name'] ?></h5>
                              </div>
                        </div>
                    </div>
                    <div class="ratings_right">
                        <div class="rating_col">
                            <h3>Career Opportunities</h3>
                        </div>
                        <div class="rating_col">
                            <h3>Comp & Benefits</h3>
                        </div>
                        <div class="rating_col">
                            <h3>Culture & Values</h3>
                        </div>
                        <div class="rating_col">
                            <h3>Senior Management</h3>
                        </div>
                        <div class="rating_col">
                            <h3>Work/Life Balance</h3>
                        </div>
                    </div>
                   </div>
                   <?php endforeach?>
                </div>
                <div class="company_rev" style="margin:2% 0">
                   <h2><?php echo $company_details['company_name']?> Reviews</h2>
                   <div class="rate_box" style="display:flex;justify-content:space-between;margin-top:15px;">
                    <div class="rate_left" style="flex-basis:45%">
                        <h5 style="color:#000;padding:3px 5px;border-radius:5px;width:10%;font-weight:200;background:rgb(99, 175, 99);">Pros</h5>
                       <?php foreach($reviews as $rev) :?>
                          <p><?php echo '"' . $rev['pros'] . '"'?></p>
                        <?php endforeach ?>
                    </div>
                    <div class="rate_right"  style="flex-basis:45%">
                       <h5 style="color:#000;padding:3px 5px;border-radius:5px;width:10%;font-weight:200;background:#f44336;">Cons</h5>
                       <?php foreach($reviews as $rev) :?>
                          <p><?php echo '"' . $rev['cons'] . '"'?></p>
                        <?php endforeach ?>
                    </div>
                   </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </section>
        <?php else: ?>
            <?php include './user-login.php';?>
        <?php endif ?>
</body>
</html>