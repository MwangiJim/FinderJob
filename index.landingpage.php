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
 }
 else{
    $id_of_first_post = $posts[0]['id'];
    $sql_job_details = "SELECT * FROM job_post WHERE id = $id_of_first_post";
    $res = mysqli_query($conn,$sql_job_details);
    $job = mysqli_fetch_assoc($res);
 }

 if(isset($_POST['submit-search-value'])){
    if(empty($_POST['search-keyword'])){
        header('Location:./index.landingpage.php?error=SearchValueNull');
        exit();
    }
    else{
        $keyword = $_POST['search-keyword'];
        $location = $_POST['Location'];
        //echo $keyword;

         $sql_search_val = "SELECT * FROM job_post WHERE position = '$keyword'";
         if(!mysqli_query($conn,$sql_search_val)){
            header('Location:./index.landingpage.php?error=Errorsearch&CouldntFind');
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FinderJob</title>
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
        .top_header_box .left_area{
            flex-basis: 40%;
        }
        .top_header_box .left_area h1{
            margin: 2% 0;
        }
        .top_header_box .left_area p{
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
           background-color: aqua;
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
    </style>
</head>
<body>
    <?php if(isset($_SESSION['user_session']) || isset($_SESSION['company_session'])):?>
        <section class="body">
        <?php include './header.php'?>
       <div class="top_bar">
       <div class="search_bar">
               <form action="./index.landingpage.php" method = "post">
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
                    <form action="./index.landingpage.php" method="POST">
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
                        </div>
                        <input type="hidden" name="job-id-to-submit" value="<?php echo $post['id']?>">
                        <button type="submit" name="submit-job-details"><img src="./images/srike.png"/>Apply</button>
                     </div>    
                    </form>
                    <?php endforeach?>
               <?php else  :?>
                <?php foreach($posts as $post) : ?>
                    <form action="./index.landingpage.php" method="POST">
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
                 <div class="left_area">
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
                    <button disabled=<?php isset($_SESSION['company_session'])?true:false ?>><img src="./images/srike.png"/>FinderApply</button>
                    <button>Save</button>
                 </div>
              </div>
              <div class="job_description">
                <h4>Job Description</h4>
                <?php echo $job['job_description']?>
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