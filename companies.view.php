<?php
  session_start();
  include './config/myjob.configdb.php';

  $sql = "SELECT * FROM company";
  $res = mysqli_query($conn,$sql);
  $companies = mysqli_fetch_all($res,MYSQLI_ASSOC);
//print_r($companies[0]);
$company_found;
if(isset($_POST['submit-search'])){
    if(empty($_POST['search-name'])){
        header('Location:./companies.view.php?error=NoSearchValue');
    }
    else{
        $search_value = $_POST['search-name'];
        //echo $search_value;
        $sql_search = "SELECT * FROM company WHERE company_name = '$search_value'";
        if(!mysqli_query($conn,$sql_search)){
           header('Location:./companies.view.php?error=CompanyNotFound');
           exit();
        }
        else{
            $response = mysqli_query($conn,$sql_search);
            $company_found = mysqli_fetch_assoc($response);
            //print_r($company_found);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FinderJob | Companies</title>
    <link rel="icon" href="./images/favicon.ico" type="image/x-icon">
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
        }
        .left_view img{
            width:100%;
            height:35vh;
            object-fit: cover;
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
        @media (max-width:500px) {
            .companies-list-box{
                flex-direction: column;
            }
            .right-companies-list-box{
                flex-basis: 100%;
            }
            .textbox{
                flex-direction: column;
            }
            .left_view{
                flex-basis: 100%;
            }
            .left_view img{
                width:400px;
                height:20vh;
            }
            .right_view{
                flex-basis: 100%;
            }
            .search-input-box p{
              font-size: 13px;
              display: none;
            }
            .search-input-box input{
                width: 200px;
            }
            .search-input-box button{
                padding: 7px 20px;
            }
            .company-box-right div{
                margin: 0 5px;
            }
            .company-box-right div h3{
              font-size: 16px;
            }
            .company-box-right div p{
                font-size: 12px;
            }
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
            <div class="left_view">
                <img src="./images/bg_companies.jpg"/>
            </div>
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
                <input type="text" name="search-name" placeholder="Search Company..Type All to View All"/>
                <button type="submit" name="submit-search">Search</button>
            </form>
        </div>
        <div class="companies-list-box">
            <div class="left-companies-list-box"></div>
            <div class="right-companies-list-box">
                 <?php if(isset($_POST['submit-search']) && !empty($_POST['search-name'])):?>
                    <div class="company-box">
                        <div class="company-top-box">
                            <div class="company-box-left">
                                <img src="<?php echo $company_found['company_logo_img_path']?>"/>
                                <div class="company-info">
                                <form action="./company.overview.php" method="POST">
                                        <input type="hidden" name="company-id" value="<?php echo $company_found['company_name']?>"/>
                                        <button style="outline:none;border:none;background:transparent;cursor:pointer;" type="submit" name="company-to-view"><h2><?php echo $company_found['company_name']?></h2></button>
                                    </form>
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
                                <div><h3>Location</h3><p><?php echo $company_found['company_location']?></p></div>
                                <div><h3>Global Company Size</h3><?php echo $company_found['global_company_size']?></div>
                                <div><h3>Industry</h3><p><?php echo $company_found['company_type']?></p></div>
                        </div>
                        <div class="description">
                            <h3>Description</h3>
                            <p><?php echo $company_found['company_description']?></p>
                        </div>
                    </div>
                    <?php else :?>
                    <?php foreach($companies as $company) :?>
                    <div class="company-box">
                        <div class="company-top-box">
                            <div class="company-box-left">
                                <img src="<?php echo $company['company_logo_img_path']?>"/>
                                <div class="company-info">
                                    <form action="./company.overview.php" method="POST">
                                        <input type="hidden" name="company-id" value="<?php echo $company['company_name']?>"/>
                                        <button style="outline:none;border:none;background:transparent;cursor:pointer;" type="submit" name="company-to-view"><h2><?php echo $company['company_name']?></h2></button>
                                    </form>
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
                    <?php endif?>
            </div>
        </div>
    </section>
</body>
</html>