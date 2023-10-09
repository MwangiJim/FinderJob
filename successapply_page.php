<?php ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FinderJob</title>
    <style>
        *{
            margin: 0;
            padding: 0;
            font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
        }
        .success{
            width:100%;
            height:100vh;
            top:0;
            left:0;
            position: absolute;
        }
        .box{
            top:50%;
            left:50%;
            transform:translate(-50%,-50%);
            position: absolute;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        .box img{
            width:30px;
            height:30px;
        }
        .box p{
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .box h1{
            font-size:40px;
        }
        .box a:hover{
            color: #f44336;
        }
    </style>
</head>
<body>
    <section class="success">
        <div class="box">
            <a href="./index.php" style="color:green;font-size:17px;text-decoration:none">Back to Home Page</a>
        <h1>Application Successfull</h1>
        <p style="color:green"><img src="./images/check.png"/> Your application has been sent</p>
        </div>
    </section>
</body>
</html>