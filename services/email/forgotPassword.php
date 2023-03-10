<?php
require("../../config.php");
session_start(); 
error_reporting(0);

$emailAdd_recovery =  $_SESSION["email-recovery"];
$username_recovery = $_SESSION["username-recovery"];
$send_acc_info = $send_acc_pw = "";
$accessible = "";

// Create a query to retrieve tenant account details
$sql = "SELECT * FROM TENANT WHERE email = '$emailAdd_recovery' AND username = '$username_recovery'";
$results = mysqli_query($conn, $sql);

if (mysqli_query($conn, $sql)) {
    $cursor = mysqli_fetch_assoc($results);
    $send_acc_info = $cursor["username"];
    $send_acc_pw = $cursor["password"];
    $accessible = true; 
}

else {
    $accessible = false; 
}



// Prepare the PHPMailer Service
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load up Composer autoloader
require '../../vendor/autoload.php';

// Now, create an instance of the PHP Mailer
$mail = new PHPMailer(true); 

try {
    //Server settings
    $mail->isSMTP();                                                        //Send using SMTP
    $mail->Host       = 'smtp.gmail.com.';                                  //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                               //Enable SMTP authentication
    $mail->Username   = 'noreplydoordorm.service@gmail.com';                //SMTP username
    $mail->Password   = 'ddmpcedxpgxouksn';                                 //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;                     //Enable implicit TLS encryption
    $mail->Port       = 587;                                                //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    /**
     * List of working domains
     * 1. @gmail.com
     * 2. @yahoo.com
     * 3. @mymail (outlook)
     */
    $mail->setFrom('noreplydoordorm.service@gmail.com');                    // my gmail (sender)

    $mail->addAddress($emailAdd_recovery);                                  // receiver email             

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Door2Dorm - Account Recovery   '. $username_recovery;
    $mail->Body    = '<h2>Your Account Credentials: </h2>
                    <table>
                        <thead>
                            <tr>
                                <th scope="col">Your Username:</th>
                                <th scope="col">Your Password:</th>
                            </tr>
                        </thead>
                        <tbody>
                            <td>'.$send_acc_info.'</td>
                            <td>'.$send_acc_pw.'</td>
                        </tbody>
                    </table>
                    <p><b>Please, use the following information to login to your account!</b></p>
                    ';

    $mail->send();
    
} 

catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot password</title>

    <!-- Bootstrap from https://getbootstrap.com/ -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/c36559a51c.js" crossorigin="anonymous"></script>

    <!-- CSS Global theming and styles -->
    <link href="../../css/globals.css" rel="stylesheet">

    <!-- jQuery-->
    <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/b
    ootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <style>
        .container {
            padding-top: 50px;
        }
        .navbar .navbar-brand {
            padding-left: 35px;
        }
    </style>
</head>
<body>
    <!-- Bootstrap navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">      
            <i class="fa-solid fa-building-user"></i>
                Door2Dorm 
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="true" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-item nav-link" href="../../views/landing_page.php">Home <span class="sr-only"></span></a>
                <a class="nav-item nav-link active" href="../../views/tenant/tenant-login.php">Tenant</a>
                <a class="nav-item nav-link" href="../../views/admin/admin-login.php">Admin</a>
            </div>
        </div>
    </nav>

    <!-- Content goes here -->
    <div class="container px-5">
        <center>
            <img src="../../assets/images/checkmark_email_notif.png" alt="" width="auto" height="50%">
        </center>
        <!-- If an account exists -->
        <?php 
            if ($accessible == true) {
                echo '<div class="card">';
                echo    '<div class="card-header"><h2>Check your email!</h2></div>';
                echo    '<div class="card-body">';
                echo        '<p>Your account information and recovery is sent to you via <b>'.$emailAdd_recovery.'</b></p>';
                echo    '</div>';
                echo    '<div class="card-footer">';
                echo        date("d-m-Y");
                echo    '</div>';
                echo '</div>';
            }
        ?>
        
         <!-- Create an error handler if an account does not exist -->
         <?php 
            if($accessible == false) {
                echo '<div class="card">';
                echo    '<div class="card-header"><h2>No accounts retrieved</h2></div>';
                echo        '<div class="card-body">';
                echo            '<p>
                                    <b>The account you are trying to retrieve does not exist!</b> 
                                </p>';
                echo        '</div>';
                echo        '<div class="card-footer">';
                echo            date("d-m-Y");
                echo        '</div>';
                echo '</div>';
            }
        ?>
        <br>
        <a href="../../views/tenant/tenant-login.php" class="btn btn-outline-success form-control">Login to my account</a>
    </div>
</body>
</html>