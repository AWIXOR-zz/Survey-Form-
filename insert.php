<?php
$firstName = $_POST['first_name'];
$lastName = $_POST['last_name'];
$email = $_POST['email'];
$job = $_POST['job'];
$rate = $_POST['rate'];
$userRecommend = $_POST['user_recommend'];
$suggestion = $_POST['suggestion'];

if (!empty($firstName) || !empty($lastName) || !empty($email) || !empty($job) || !empty($rate) || !empty($userRecommend) || !empty($suggestion)) {

    $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "survey";
    //create connection
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
    if (mysqli_connect_error()) {
        die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
       } else {
        $SELECT = "SELECT email From survey Where email = ? Limit 1";
        $INSERT = "INSERT Into survey (first_name, last_name, email, job, rate, user_recommend, suggestion) values(?, ?, ?, ?, ?, ?, ?)";
        //Prepare statement
        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($email);
        $stmt->store_result();
        $rnum = $stmt->num_rows;
        
        if ($rnum==0) {
            $stmt->close();
            $stmt = $conn->prepare($INSERT);
            $stmt->bind_param("ssssiss", $firstName, $lastName, $email, $job, $rate, $userRecommend, $suggestion);
            $stmt->execute();
            echo "New record inserted sucessfully";
        } else {
                echo "Someone already register using this email";
               }
               $stmt->close();
               $conn->close();
              }
          } else {
           echo "All field are required";
           die();
 }
          
 ?>