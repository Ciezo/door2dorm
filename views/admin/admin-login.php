<?php
require("../../config.php");
session_start(); 

error_reporting(0);
if(isset($_POST['admin-login']) && $_SERVER["REQUEST_METHOD"] == "POST") {    
    $username = ($_POST["admin-username"]);
    $password = ($_POST["admin-password"]);

    // Create a query to select a single entry from the USERS table
    $query = "SELECT * FROM ADMIN WHERE username='$username' AND password='$password'"; 
    $results = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($results);

    // If all input credentials are matched from the database then
    if ($username == $row["username"] && $password == $row["password"]) {
        // Set up SESSION VARIABLES
        $_SESSION["admin-username"] = $username; 
        $_SESSION["admin-password"] = $password; 
        /** Redirect to admin session checking */
        header("location: ../sessions/admin_session_check.php");
    }

    else {
        Print '<script>alert("Incorrect Username or Password!");</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login, Administrator</title>

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
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <style>
        .container {
            padding-top: 50px;
        }
        .container .admin-login-form  {
            width: 50%;
        }
        .container .admin-login-form label {
            font-size: 20px;
            padding-bottom: 15px;
        }
        .container .admin-login-form input:focus {
            box-shadow: 0px 0px 10px 0px #333;
        }
        .container .admin-login-form .btn.btn-primary {
            margin-top: 50px;
            width: 100%;
        }
        .navbar .navbar-brand {
            padding-left: 35px;
        }
    </style>
</head>
<body>
    <!-- Bootstrap navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
        <a class="navbar-brand" href="#">      
            <i class="fa-solid fa-building-user"></i>
                Door2Dorm 
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="true" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav px-2">
                <a class="nav-item nav-link px-2" href="../landing_page.php">Home <span class="sr-only"></span></a>
                <a class="nav-item nav-link px-2" href="../tenant/tenant-login.php">Tenant</a>
                <a class="nav-item nav-link active px-2" href="#">Admin</a>
            </div>
        </div>
    </nav>

    <!-- Content goes here -->
    <div class="container px-5">
        <center>
            <img src="../../assets/images/admin-vector.png" alt="Friendly Admin Image Icon" width="250" height="250">
            <form action="admin-login.php" class="admin-login-form" method="POST">
                <h1>Welcome, Admin</h1>
                <label>Username</label>
                <input type="text" class="form-control" name="admin-username" placeholder="" required="">
                <br>
                <label>Password</label>
                <input type="password" class="form-control" name="admin-password" placeholder="" required="">
                <input class="btn btn-primary" name="admin-login" type="submit" value="LOGIN"><br>
            </form>
        </center>
    </div>
    </body>
</html>