<?php 
 session_start();
 include './config/myjob.configdb.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FinderJob</title>
    <link rel="stylesheet" href="./styles.css"/>
</head>
<body>
    <?php if(isset($_SESSION['user_session']) || isset($_SESSION['company_session'])):?>
        <section class="body">
        <?php include './header.php'?>
        <div class="search_bar">
            <div class="search-box">
                <img src="./images/search.png"/>
                <input class ="input-search" type="text" name="search-keyword" placeholder="Find You Job"/>
                <img src="./images/location.png"/>
                <input class ="input-location" type="text" name="Location" placeholder="Location"/>
            </div>
        </div>
        <div class="user_bar">
            <li><a href="#">For You</a></li>
            <li><a href="#">Activity</a></li>
            <li><a href="#">Search</a></li>
        </div>
        <div class="jobs_info_area">

        </div>
    </section>
        <?php else: ?>
            <?php include './user-login.php';?>
        <?php endif ?>
</body>
</html>