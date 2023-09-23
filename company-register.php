<?php 
 include './config/myjob.configdb.php';

 $allowedExts;
 if(isset($_POST['submit-company-register'])){
    if(empty($_POST['company-name']) || empty($_POST['company-email']) || empty($_POST['company-location']) ||
     empty($_POST['company-size']) || empty($_POST['company-type']) || empty($_POST['date-founded']) ||
     empty($_POST['description']) || empty($_POST['revenue']) || empty($_POST['password'])){
        header('Location:./company-register.php?error=MissingInputFields');
        exit();
     }
     else{
        $company_name = $_POST['company-name'];
        $company_email = $_POST['company-email'];
        $company_location = $_POST['company-location'];
        $company_size = $_POST['company-size'];
        $company_type = $_POST['company-type'];
        $date_founded = $_POST['date-founded'];
        $description = $_POST['description'];
        $revenue = $_POST['revenue'];
        $password = $_POST['password'];

        if(!filter_var($company_email,FILTER_VALIDATE_EMAIL)){
            header('Location:./company-register.php?error=InvalidEmailFormat&name = ' . $company_name);
            exit();
        }
        else{
            $company_name = mysqli_real_escape_string($conn,$company_name);
            $company_email = mysqli_real_escape_string($conn,$company_email);
            $company_location = mysqli_real_escape_string($conn,$company_location);
            $company_size = mysqli_real_escape_string($conn,$company_size);
            $company_type = mysqli_real_escape_string($conn,$company_type);
            $date_founded = mysqli_real_escape_string($conn,$date_founded);
            $description = mysqli_real_escape_string($conn,$description);
            $revenue = mysqli_real_escape_string($conn,$revenue);
            $password = mysqli_real_escape_string($conn,$password);
            $hashPwd = password_hash($password,PASSWORD_DEFAULT);

            $file = $_FILES['file'];
            $fileName = $file['name'];
            $fileType = $file['type'];
            $fileTmpName = $file['tmp_name'];
            $fileError = $file['error'];
            $fileSize = $file['size'];

            $fileExt = explode('.',$fileName);
            $fileActualExt = strtolower(end($fileExt));

            $allowedExts = array('png','jpeg','jpg');
            if(in_array($fileActualExt,$allowedExts)){
                if($fileError === 0){
                    if($fileSize < 400000){
                          $fileActualName = strtolower(str_replace(' ','-',$company_name)) . "." . $fileActualExt;
                          $fileDestination = './company_images/gallery/' . $fileActualName;

                          $sql_company_check = "SELECT * FROM company WHERE company_email = ?";
                          $statement = mysqli_stmt_init($conn);
                          mysqli_stmt_prepare($statement,$sql_company_check);
                          mysqli_stmt_bind_param($statement,'s',$company_email);
                          mysqli_stmt_execute($statement);
                          mysqli_stmt_store_result($statement);
                          $row_users = mysqli_stmt_num_rows($statement);
                          if($row_users > 0){
                            header('Location:./company-register.php?error=CompanyEmailIdAlreadyExists');
                            exit();
                          }
                          else{
                            $sql = "INSERT INTO company(company_name,company_logo_img_path,company_location,global_company_size,revenue,
                            company_type,date_founded,company_description,company_email,password) 
                            VALUES('$company_name','$fileDestination','$company_location','$company_size','$revenue','$company_type','$date_founded','$description','$company_email','$hashPwd')";
                            if(mysqli_query($conn,$sql)){
                                header('Location:./company-login.php?companyAccountCreate==true');
                                move_uploaded_file($fileTmpName,$fileDestination);
                                exit();
                            }
                            else{
                                header('Location:./company-register.php?error=Error404DB');
                                exit();
                            }
                          }
                    }
                    else{
                       header('Location:./company-register.php?error=FileSizeExceededLimit&<4mB');
                       exit();
                    }
                }
                else{
                    header('Location:./company-register.php?error=FileCorrupted');
                    exit();
                }
            }else{
                header('Location:./company-register.php?error=ExtensionNotAllowed&&AllowedExts=[png,jpg,jpeg]');
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
    <link rel="stylesheet" href="./styles.css"/>
    <style>
        .company_body{
    width:100%;
    height:100vh;
    top:0;
    left:0;
    position: absolute;
    }
    .company_body .form{
        top:20%;
        left:30%;
        position: absolute;
        width:450px;
        height: max-content;
    }
    .company_body .form input{
        height: 45px;
        width:95%;
        outline: none;
        border: 1px solid #000;
        border-radius: 8px;
        margin: 15px 0;
        padding: 0 15px;
    }
    .company_body .form select{
        height: 50px;
        width:460px;
        outline: none;
        border: 1px solid #000;
        border-radius: 8px;
        margin: 15px 0;
        padding: 0 15px;
    }
    .company_body .form textarea{
        height: 100px;
        width:95%;
        outline: none;
        border: 1px solid #000;
        border-radius: 8px;
        margin: 15px 0;
        padding: 0 15px;
    }
    .company_body .form label{
        font-weight: bolder;
    }
    .company_body .form input:focus{
    border: 2px solid rgb(25, 197, 25);
    }
    .company_body .form h2{
        text-align: center;
    }
    .company_body .form button{
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
    .company_body .form p{
        text-align: center;
    }
    </style>
</head>
<body>
    <section class="company_body">
        <?php include './header.php'?>
        <form action="./company-register.php" method = "POST" class="form" enctype="multipart/form-data">
            <h2>Company Account</h2>
            <label>Company Name</label>
            <br/>
            <input type="text" name="company-name" placeholder="Company Name"/>
            <br/>
            <label>Company Email</label>
            <br/>
            <input type="email" name="company-email" placeholder="Company Name"/>
            <br/>
            <label>Company Location</label>
            <br/>
            <input type="text" name="company-location" placeholder="Company Location"/>
            <br/>
            <label>Global Company Size</label>
            <br/>
            <select name="company-size">
                <option>---Company Size----</option>
                <option value="1-5 employees">1-5 employees</option>
                <option value="5-10 employees">5-20 employees</option>
                <option value="20-70 employees">20-70 employees</option>
                <option value="100-500 employees">100-500 employees</option>
                <option value="500-1000 employees">500-1000 employees</option>
                <option value="1000 + employees">1000 + employees</option>
            </select>
            <br/>
            <label>Company Type</label>
            <br/>
           <select name="company-type">
             <option>---Select Company Type</option>
             <option value="IT Industry">IT Industry</option>
             <option value="Law Firm">Law Firm</option>
             <option value="Health Care">health Care</option>
             <option value="Betting Industry">Betting Industry</option>
             <option value="Investment Banking">Investement Banking</option>
             <option value="Insurance Company">Insurance Company</option>
             <option value="Production Company">Production Company</option>
             <option value="Game Industry">Game Industry</option>
           </select>
            <br/>
            <label>Date Founded</label>
            <br/>
            <input type="date" name="date-founded" />
            <br/>
            <label>Company Description</label>
            <br/>
            <textarea name="description"></textarea>
            <br/>
            <label>Company Revenue</label>
            <br/>
            <input type="text" name="revenue" placeholder="Company Revenue $/year"/>
            <br/>
            <label>Password</label>
             <br/>
             <input type="password" name="password"/>
             <br/>
            <label>Company Banner</label>
            <br/>
            <input type="file" name="file"/>
            <button name="submit-company-register" type ="submit">Create Employer Account</button>
            <br/>
            <p>Have Company Account?<a href="./company-login.php">Login Here</a></p>
        </form>
    </section>
</body>
</html>