<?php 
 $conn = mysqli_connect('localhost','jimmy','test123','find_job_db');
 if(!$conn){
    echo 'Error Connecting Db' . mysqli_connect_error();
 }
?>