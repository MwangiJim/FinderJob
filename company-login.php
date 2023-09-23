<?php 
include './config/myjob.configdb.php';

if(isset($_POST['submit-login-company'])){
    if(empty($_POST['email']) || empty($_POST['password'])){
        header('Location:./comapny-login.php?error=MissingInputFields');
        exit();
    }
    else{
        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM company WHERE email = '$email'";
        $res = mysqli_query($conn,$sql);
        $company = mysqli_fetch_assoc($res);

        if(!$company){
            header('Location:./company-login.php?error=UserDoesntExist');
            exit();
        }
        else{
            if(!password_verify($password,PASSWORD_DEFAULT)){
                header('Location:./company-login.php?error=WrongPassword');
                exit();
            }
            else{
                session_start();
                $_SESSION['company_session'] = $company['$company_email'];
                header('Location:./index.company.php?login=success');
                exit();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FinderJob | Company</title>
    <style>
        .company-login{
        width:100%;
        height:100vh;
        top:0;
        left:0;
        position: absolute;
        }
        .company-login .form{
            top:50%;
            left:50%;
            transform: translate(-50%,-50%);
            position: absolute;
            width:450px;
            height: max-content;
        }
        .company-login .form input{
            height: 45px;
            width:95%;
            outline: none;
            border: 1px solid #000;
            border-radius: 8px;
            margin: 15px 0;
            padding: 0 15px;
        }
        .company-login .form label{
            font-weight: bolder;
        }
        .company-login .form input:focus{
        border: 2px solid rgb(25, 197, 25);
        }
        .company-login .form h2{
            text-align: center;
        }
        .company-login .form button{
            width:100%;
            padding: 12px 30px;
            color: #fff;
            font-weight: bold;
            outline: none;
            border: none;
            cursor: pointer;
            border-radius: 15px;
            background-color: rgb(25, 197, 25);
        }
        .company-login .form p{
            text-align: center;
        }
    </style>
</head>
<body>
    <section class="company-login">
        <?php include './header.php'?>
        <form action="./company-login.php" method="POST" class="form">
            <h2>Company Login</h2>
            <label>Email</label>
            <br/>
            <input name="email" type="email" placeholder="Email address"/>
            <br/>
            <label>Password</label>
            <br/>
            <input name="password" type ="password" placeholder="Password"/>
            <br/>
            <button type="submit" name = "submit-login-company">Login</button>
            <br/>
            <p>No Account?<a href="./company-register.php">Register Here</a></p>
        </form>
    </section>
</body>
</html>