<?php 
 include './config/myjob.configdb.php';

 if(isset($_POST['submit-user-register'])){
    if(empty($_POST['username']) || empty($_POST['email']) ||empty($_POST['password']) || empty($_POST['position'])){
        header('Location:./user-register.php?error=MissingInputFields');
        exit();
    }
    else{
        $name = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $position = $_POST['position'];

        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            header('Location:./user-register.php?error=InvalidEmailFormat&name =' . $name . "&position = " . $position);
            exit();
        }
        else{
            $name = mysqli_real_escape_string($conn,$name);
            $email = mysqli_real_escape_string($conn,$email);
            $password = mysqli_real_escape_string($conn,$password);
            $position = mysqli_real_escape_string($conn,$position);

            $hashPwd = password_hash($password,PASSWORD_DEFAULT);

            $sql_check_user = "SELECT * FROM users WHERE email = '$email'";
             $res = mysqli_query($conn,$sql_check_user);
             $row = mysqli_fetch_row($res);
            if($row > 0){
                header('Location:./user-register.php?error=UserAlreadyExists&email =' . $email . '&name = ' . $name);
                exit();
            }
            else{
                $sql = "INSERT INTO users(name,email,password,position) VALUES('$name','$email','$hashPwd','$position')";
                if(mysqli_query($conn,$sql)){
                    header('Location:./user-login.php?userCreate=Success');
                    exit();
                }
                else{
                    header('Location:./user-register.php?error=Error404DB');
                    exit();
                }
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
    <title>FinderJob | Register</title>
    <link rel="stylesheet" href="./styles.css"/>
    <link rel="icon" href="./images/favicon.ico" type="image/x-icon">
</head>
<body>
    <section class="register_form">
        <?php include './header.php'?>
        <form action="./user-register.php" method="POST" class="form">
            <h2>FinderJob Account</h2>
            <label>UserName</label>
            <br/>
            <input type="text" name="username" placeholder="User Name">
            <br/>
            <label>Email</label>
            <br/>
            <input type="email" name="email" placeholder="Email">
            <br/>
            <label>Position Title</label>
            <br/>
            <input type="text" name="position" placeholder="Position Title">
            <br/>
            <label>Password</label>
            <br/>
            <input type="password" name="password" placeholder="Password">
            <br/>
            <button type="submit" name="submit-user-register">Create Account</button>
            <p>Already have Account?<a href="./user-login.php">Login Here</a></p>
        </form>
    </section>
</body>
</html>