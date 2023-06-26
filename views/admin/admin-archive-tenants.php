<?php
require("../../config.php");
session_start(); 
// Check if admin is logged in.
if (!isset($_SESSION["admin-username"])) {
    // If not logged in, then redirect to log-in page.
    header("location: admin-login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenant Archives</title>

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
        .navbar .navbar-brand {
            padding-left: 35px;
        }
        .navbar .collapse .navbar-nav .active {
            background-color: white;
            border-radius: 5px;
            color:black;
        }
        .navbar .collapse .navbar-nav .logout:hover {
            background-color: red;
            color: white; 
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <!-- Bootstrap navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
        <a class="navbar-brand" href="#">      
            <i class="fa-solid fa-building-user"></i>
                Welcome, Admin! 
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="true" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-item nav-link px-2" href="admin-home.php">Home <span class="sr-only"></span></a>
                <a class="nav-item nav-link px-2" href="admin-payment.php">Payment</a>
                <a class="nav-item nav-link px-2" href="admin-tenants.php">Tenants</a>
                <a class="nav-item nav-link px-2" href="admin-securityLogs.php">Security Logs</a>
                <a class="nav-item nav-link px-2" href="admin-facenet.php">FaceNet</a>
                <a class="nav-item nav-link px-2" href="admin-messages.php">Messages</a>
                <a class="nav-item nav-link active px-2" href="#"><i class="fa-solid fa-box-archive"></i> Tenant Archives</a>
                <a class="nav-item nav-link px-2" href="admin-archive-visitors.php">Visitor Archives</a>
                <a class="nav-item nav-link logout px-2" href="../../components/custom/logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Content goes here -->
    <div class="container">
        <div class="tenant-archives">
            <h2>Tenant Archives</h2>
            <p>Here are the removed records from the database which are archived for safety purposes</p>
            
            <!-- Tenant archive profiles are listed as cards -->
            <?php 
                $sql = "SELECT * FROM TENANT";
                $results = mysqli_query($conn_bk, $sql);
                
                if($results->num_rows > 0) {
                    while($rows = mysqli_fetch_assoc($results)) {
                        echo '<div class="profile card mx-2 px-2 mb-3">';
                        echo    '<div class="card-header">';
                        echo        '<span><b>'.$rows["full_name"].'</b></span>';
                        echo    '</div>';
                        echo    '<div class="card-body">';
                        echo        '<ul class="list-group list-group-flush">';
                        echo            '<li class="list-group-item">Mobile: '.$rows["mobile_num"].'</li>';
                        echo            '<li class="list-group-item">Email: '.$rows["email"].'</li>';
                        echo            '<li class="list-group-item">Emergency Contact No.: '.$rows["emergency_contact_num"].'</li>';
                        echo            '<li class="list-group-item">Assigned Room: '.$rows["room_assign"].'</li>';
                        echo        '</ul>';
                        echo    '</div>';
                        echo    '<div class="card-footer">';
                        echo        '<p>Account Credentials: <br>';
                        echo        'Username: '.$rows["username"]. '<br>';
                        echo        'Password: '.$rows["password"].'</p>';
                        echo    '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<div class="alert alert-danger" role="alert">No archive records found! </div>';
                }
            ?>
        </div>
    </div>
    
</body>
</html>