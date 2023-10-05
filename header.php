<?php 
   if(isset($_POST['submit=logout'])){
      session_unset();
      session_destroy();
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
    .menu{
        display: none;
    }
    @media (max-width:500px){
        .menu{
            display: block;
            position: relative;
            z-index: 5;
        }
        .right_nav .img{
            display: none;
        }
        .nav-bar .nav{
            flex-direction: column;
            background-color: aliceblue;
            width:100%;
            height:100vh;
            top:0;
            right:0;
            position: absolute;
            z-index: 2;
            display: none;
        }
        .nav li{
            padding: 10px 30px;
            margin: 2%;
            border-bottom: 1px solid #d3d3d3;

        }
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
            <img src = "./images/search.png" style="margin-right:10px;"/>
            <h4 class="img">Search</h4>
            <img src="./images/bell_plus.png" class="img"/>
            <img src="./images/profile.png" class="img"/>
            <?php if(isset($_SESSION['user_session']) || isset($_SESSION['company_session'])) : ?>
                <form action="./header.php" method="POST">
                    <button type="submit" name="submit-logout"  style="margin-right:15px;"><img src="./images/logout.png"/></button>
                </form>
                <?php else :?>
            <?php endif ?>
            <img src="./images/menu.png" style="cursor:pointer;" class = "menu"/>
        </div>
    </div>
    <script>
        let nav = document.querySelector('.nav');
        let menu = document.querySelector('.menu');

        menu.onclick=()=>{
            if(nav.style.display === "none"){
                nav.style.display = "block";
                menu.src = "./images/close.png";
            }
            else{
                nav.style.display = "none";
                menu.src = "./images/menu.png";
            }
        }
    </script>
</body>
</html>