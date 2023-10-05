<?php 
 include './config/myjob.configdb.php';

 if(isset($_POST['submit-login-user'])){
    if(empty($_POST['email']) || empty($_POST['password'])){
        header('Location:./user-login.php?error=MissingInputFields');
        exit();
    }
    else{
       $email = $_POST['email'];
       $password = $_POST['password'];

       $sql_verify_user = "SELECT * FROM users WHERE email='$email'";
       $res = mysqli_query($conn,$sql_verify_user);
       $user = mysqli_fetch_assoc($res);

       if(!$user){
        header('Location:./user-login.php?error=UserDoesNotExist');
        exit();
       }
       else{
          if(!password_verify($password,$user['password'])){
            header('Location:./user-login.php?error=WrongPassword');
            exit();
          }
          else{
            session_start();
            $_SESSION['user_session'] = $user['email'];
            setcookie("name","User",time() + (86400 * 30), "/");
            header('Location:./index.landingpage.php?login=success');
            exit();
          }
       }
    }
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>JobFinder | Login</title>
    <link rel="stylesheet" href="./styles.css"/>
</head>
<style>
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
<body>
    <section class="user-login">
        <?php include './header.php'?>
        <form action="./user-login.php" method="POST" class="form">
            <h2>User Login</h2>
            <label>Email</label>
            <br/>
            <input name="email" type="email" placeholder="Email address"/>
            <br/>
            <label>Password</label>
            <br/>
            <input name="password" type ="password" placeholder="Password"/>
            <br/>
            <button type="submit" name = "submit-login-user">Login</button>
            <br/>
            <p>No Account?<a href="./user-register.php">Register Here</a></p>
        </form>
    </section>
</body>
</html>