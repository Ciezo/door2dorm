<?php
require("../../config.php");
session_start(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login, Tenant</title>

    <!-- Bootstrap from https://getbootstrap.com/ -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/c36559a51c.js" crossorigin="anonymous"></script>

    <!-- CSS Global theming and styles -->
    <link href="../../css/globals.css" rel="stylesheet">

    <style>
        .container {
            padding-top: 50px;
        }
        .container .tenant-login label {
            font-size: 20px;
            padding-bottom: 15px;
        }
        .container .tenant-login {
            width: 50%;
        }
        .container .tenant-login input:focus {
            box-shadow: 0px 0px 10px 0px #333;
        }
        .container .tenant-login .btn.btn-primary {
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
                <a class="nav-item nav-link" href="../landing_page.php">Home <span class="sr-only"></span></a>
                <a class="nav-item nav-link active" href="#">Tenant</a>
                <a class="nav-item nav-link" href="../admin/admin-login.php">Admin</a>
            </div>
        </div>
    </nav>

    <!-- Content goes here -->
    <div class="container px-5">
        <center>
            <img src="../../assets/images/resident-vector.png" alt="Friendly Admin Image Icon" width="250" height="250">
                <form action="tenant-login.php" class="tenant-login" method="POST">
                    <h1>Welcome, Tenant</h1>
                    <label>Username</label>
                    <input type="text" class="form-control" name="tenant-username" placeholder="" required="">
                    <br>
                    <label>Password</label>
                    <input type="password" class="form-control" name="tenant-password" placeholder="" required="">
                    <a href="tenant-forgot-pw.php" class="btn btn-outline-danger mt-2">Forgot password?</a>
                    <input class="btn btn-primary" name="tenant-login" type="submit" value="LOGIN"><br>
                </form>
        </center>
    </div>
</body>
</html>

<?php
error_reporting(0);
if(isset($_POST['tenant-login']) && $_SERVER["REQUEST_METHOD"] == "POST") {    
    $username = ($_POST["tenant-username"]);
    $password = ($_POST["tenant-password"]);

    // Create a query to select a single entry from the USERS table
    $query = "SELECT * FROM TENANT WHERE username='$username' AND password='$password'"; 
    $results = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($results);

    // If all input credentials are matched from the database then
    if ($username == $row["username"] && $password == $row["password"]) {
        // Set up SESSION VARIABLES
        $_SESSION["tenant-username"] = $username; 
        $_SESSION["tenant-password"] = $password; 
        /** Redirect to admin session checking */
        header("location: ../sessions/tenant_session_check.php");
    }

    else {
        Print '<script>alert("Incorrect Username or Password!");</script>';
    }
}
?>