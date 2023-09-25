<?php
  session_start();
  include './config/myjob.configdb.php';

  $sql = "SELECT * FROM company";
  $res = mysqli_query($conn,$sql);
  $companies = mysqli_fetch_all($res,MYSQLI_ASSOC);
//print_r($companies[0]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FinderJob | Companies</title>
    <style>
        *{
         font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
        }
        .companies_view{
            width:100%;
            height: 100vh;
        }
        .textbox{
            display:flex;
            justify-content: space-between;
            align-items: center;
            margin:3% 5%;
        }
        .left_view{
            flex-basis: 50%;
            background-image: url('./images/bg_companies.jpg');
            background-position: center;
            background-size: cover;
            height: 35vh;
        }
        .right_view{
            flex-basis:45%;
            text-align:left;
        }
        .right_view .info{
            text-align: left;
            margin-top: 10px;
        }
        .right_view .info p{
            line-height: 30px;
        }
        .search-input-box{
            display:flex;
            justify-content: center;
            align-items: center;
        }
        .search-input-box input{
            width:300px;
            height:40px;
            border:2px solid grey;
            outline:none;
            border-radius:10px;
            padding:0 10px;
        }
        .search-input-box button{
            background-color: aqua;
            outline:none;
            padding:10px 20px;
            color:#fff;
            cursor: pointer;
            border-radius:5px;
            border:none;
        }
        .companies-list-box{
            display:flex;
            justify-content: center;
            align-items: center;
        }
        .left-companies-list-box{
            flex-basis:35%;
        }
        .right-companies-list-box{
            flex-basis: 60%;
        }
        .company-box{
            padding:7px 6px;
            width:100%;
            border-radius:5px;
            cursor:pointer;
        }
        .company-box:hover{
            box-shadow: 3px 3px 6px #333;
        }
        .company-top-box{
            display:flex;
            justify-content: space-between;
            align-items: center;
            padding:10px 12px;
            margin: 3% 0;
        }
        .company-box-left{
            flex-basis:40%;
            display:flex;
            justify-content: left;
            align-items: center;
        }
        .company-box-left img{
            width:45px;
            height:45px;
            border-radius:10px;
            object-fit: cover;
            border: 2px solid #000;
        }
        .company-box-right{
            flex-basis: 30%;
            display:flex;
            justify-content: space-between;
            align-items: center;
        }
        .company-info{
            text-align: left;
            margin-left: 5px;
        }
        .location-info{
            display:flex;
            justify-content: space-between;
            align-items: center;
        }
        .location-info div{
            flex-basis: 33%;
        }
        .location-info h3{
            font-weight: bolder;
        }
        .description p{
        color: grey;
        font-size: 17px;
        font-weight:300;
        }
    </style>
</head>
<body>
    <section class="companies_view">
        <?php include './header.php'?>
        <div class="textbox">
            <div class="left_view"></div>
            <div class="right_view">
                <h2>Get the Right Company For You</h2>
                <div class="info">
                    <p>Discover what an employer is really like before you make your next move.</p>
                    <p>Search reviews and ratings, and filter companies based on the qualities that matter most to your job search.</p>
                </div>
            </div>
        </div>
        <div class="search-input-box">
            <p>Looking up an Employer?</p>
            <form action="./companies.view.php" method="POST">
                <input type="text" name="search-name" placeholder="Search Company"/>
                <button type="submit" name="submit-search">Search</button>
            </form>
        </div>
        <div class="companies-list-box">
            <div class="left-companies-list-box"></div>
            <div class="right-companies-list-box">
                 <?php foreach($companies as $company) :?>
                    <div class="company-box">
                        <div class="company-top-box">
                            <div class="company-box-left">
                                <img src="<?php echo $company['company_logo_img_path']?>"/>
                                <div class="company-info">
                                    <h2><?php echo $company['company_name']?></h2>
                                    <p>3.8</p>
                                </div>
                            </div>
                            <div class="company-box-right">
                                <div><h3>181.1K</h3><p>Reviews</p></div>
                                <div><h3>43.8K</h3><p>Jobs</p></div>
                                <div><h3>191.8K</h3><p>Salaries</p></div>
                            </div>
                        </div>
                        <div class="location-info">
                                <div><h3>Location</h3><p><?php echo $company['company_location']?></p></div>
                                <div><h3>Global Company Size</h3><?php echo $company['global_company_size']?></div>
                                <div><h3>Industry</h3><p><?php echo $company['company_type']?></p></div>
                        </div>
                        <div class="description">
                            <h3>Description</h3>
                            <p><?php echo $company['company_description']?></p>
                        </div>
                    </div>
                 <?php endforeach?>
            </div>
        </div>
    </section>
</body>
</html>