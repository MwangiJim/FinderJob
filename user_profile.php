<?php
session_start();

require('./config/myjob.configdb.php');
$email_user = $_SESSION['user_session'];

$sql = "SELECT * FROM users WHERE email='$email_user'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);
//fetch job applications by user

$sql_applications = "SELECT * FROM jop_application WHERE email = '$email_user'";
$result_applications = mysqli_query($conn, $sql_applications);
$applications = mysqli_fetch_all($result_applications,MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FinderJob | Profile</title>
    <link rel="icon" href="./images/favicon.ico" type="image/x-icon"/>
    <style>
        .container{
            height:max-content;
            background-color: #d3d3d3;
            padding: 3px;
        }
        .section_box{
            margin:2% 4%;
            display:flex;
            justify-content: space-between;
        }
        @media (max-width:500px) {
            .section_box{
                flex-direction: column;
            }
            .right_container{
                flex-basis: 100%;
                margin-top: 10px;
            }
            .left_container{
                flex-basis: 100%;
            }
            .application{
                flex-direction: column;
            }
        }
        .left_container{
            border-radius: 15px;
            flex-basis: 20%;
            background-color: #fff;
            height:max-content;
            display:flex;
            justify-content: space-between;
            flex-direction: column;
            align-items: center;
            padding: 5px;
        }
        .left_container img{
            width:140px;
            height:140px;
        }
        .right_container{
          border-radius: 15px;
            flex-basis: 75%;
            padding: 5px 12px;
          height: max-content;
        }
        .application{
         display: flex;
         justify-content: space-between;
         padding: 6px 10px;
         background-color: #fff;
         border-radius: 5px;
         margin-bottom:20px
        }
    </style>
</head>
<body>
    <?php require('./header.php')?>
    <div class="container">
       <div class="section_box">
          <div class="left_container">
             <img src="./images/profile.png"/>
             <h2><?php echo $user['name']?></h2>
             <p><?php echo $user['email']?></p>
             <h4><?php echo $user['position']?></h4>
          </div>
          <div class="right_container">
            <h3>Jobs Applied</h3>
            <?php foreach ($applications as $application): ?>
                <?php 
                $company_name = $application['company_name'];
                    $sql_company = "SELECT * FROM company WHERE company_name = '$company_name'";
                    $res = mysqli_query($conn, $sql_company);
                    $company_img = mysqli_fetch_assoc($res);
                    ?>
                <div class="application">
                    <div class="left_appln">
                        <div class="company_details">
                            <h2>Position : <?php echo $application['current_position']?></h2>
                            <h6>Years of Experience : <?php echo $application['years_of_exp']?></h6>
                        </div>
                        <div class="details">
                            <img src="<?php echo $company_img['company_logo_img_path'] ?>" style="width:60px;height:60px;object-fit:contain;"/>
                            <h4>Company : <?php echo $application['company_name']?></h4>
                        </div>
                    </div>
                    <div class="right_appln">
                         <h5>Date Applied : <?php echo $application['date_applied']?></h5>
                         <div class="applied_box" style="display:flex;margin:30px 0;justify-content:space-between;flex-direction:column;align-items:center;">
                            <img src="./images/check.png" style="height:20px;width:20px;"/>
                            <h5 style="color:green">Applied</h5>
                         </div>
                    </div>
                </div>
                <?php endforeach ?>
          </div>
       </div>
    </div>
</body>
</html>