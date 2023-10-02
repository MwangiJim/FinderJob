<?php 
   if(isset($_POST['submit=logout'])){
      session_unset();
      session_destroy();
      header('Location:./user-login.php?logout=true');
      exit();
   }
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="./styles.css"/>
<style>
    .mid{
        display:flex;
        justify-content: space-between;
        align-items: center;
    }
    .mid li{
        list-style: none;
        padding: 10px 12px;
        font-weight: bolder;
    }
    .mid li a{
        text-decoration: none;
        color: #000;
    }
    .right_nav button{
        background-color: transparent;
        border:none;
        outline:none;
    }
    .nav-bar h2 a{
        text-decoration: none;
        color: rgb(25, 197, 25);
    }
</style>
</head>
<body>
    <div class="nav-bar">
        <h2><a href="<?php isset($_SESSION['user_session'])
        || isset($_SESSION['company_session'])?'./index.landingpage.php':'#'?>">FINDERJOB</a></h2>
        <div class="nav">
            <li><a href="#">Community</a></li>
            <li><a href="./index.landingpage.php">Jobs</a></li>
            <li><a href="./companies.view.php">Companies</a></li>
            <li><a href="#">Salaries</a></li>
        </div>
        <?php if(isset($_SESSION['user_session']) || isset($_SESSION['company_session'])) :?>
            <?php else : ?>
                <div class="mid">
                    <li><a href="#">Admin</a></li>
                    <li><a href="./company-login.php">Post Job</a></li>
                    <li><a href="./user-login.php">User</a></li>
                </div>
            <?php endif ?>
            <?php if(isset($_SESSION['company_session'])):?>
                <a href="./index.company.php">Post Job</a>
                <?php else :?>
                    
                <?php endif?>
        <div class="right_nav">
            <img src = "./images/search.png"/>
            <h4>Search</h4>
            <img src="./images/bell_plus.png"/>
            <img src="./images/profile.png"/>
            <?php if(isset($_SESSION['user_session']) || isset($_SESSION['company_session'])) : ?>
                <form action="./header.php" method="POST">
                    <button type="submit" name="submit-logout"><img src="./images/logout.png"/></button>
                </form>
                <?php else :?>
            <?php endif ?>
        </div>
    </div>
</body>
</html>