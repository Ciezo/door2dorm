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
    <title>Viewing all tenant captures</title>

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
        .row {
            padding-top: 50px;
        }
        #tenantFacePhoto:hover {
            width: 110%;
            height: auto;
            transition: width 0.5s;
        }
        #tenantFacePhoto {
            width: 100%;
            height: auto;
            transition: width 0.5s;
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
                <a class="nav-item nav-link active px-2" href="admin-facenet.php"><i class="fa-regular fa-id-badge"></i> FaceNet</a>
                <a class="nav-item nav-link px-2" href="admin-messages.php">Messages</a>
                <a class="nav-item nav-link px-2" href="admin-archive-tenants.php">Tenant Archives</a>
                <a class="nav-item nav-link px-2" href="admin-archive-visitors.php">Visitor Archives</a>
                <a class="nav-item nav-link logout px-2" href="../../components/custom/logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Content goes here -->
    <div class="container">
        <div class="table">
            <?php 
                // Fetch all tenant face captures from the database
                $sql = "SELECT * FROM FACE_IMG"; 
                $results = mysqli_query($conn, $sql);
                if ($results->num_rows > 0) {
                    $i = 0;
                    while ($rows = mysqli_fetch_assoc($results)) {
                        if ($i % 4 == 0 ) {     // Start a new row every fourth column
                            echo '<div class="row">';
                        }
                        echo    '<div class="col-3">';
                        echo        '<div class="card" style="width: 100%;">';
                        echo            '<div class="card-header">';
                        echo                '<h6 style="text-align: center;"><b>'.$rows["tenant_name"].'</b></h6>';
                        echo            '</div>';
                                        /** Hide the overlapping images inside the fixed height of the card-body */
                        echo            '<div class="card-body" style="height: 250px; overflow: hidden;">';
                        echo                '<img id="tenantFacePhoto" class="card-img-top" src="data:image/png;base64,'.base64_encode($rows["face_capture"]).'"'; echo 'alt="Tenant face photo" style="object-fit: cover;">'; // set object-fit to cover
                        echo            '</div>';
                        echo            '<div class="card-footer"></div>';
                        echo        '</div>';
                        echo    '</div>';
                        if ($i % 4 == 3 || $i == $results->num_rows - 1) {
                            // Close the row after fourth column
                            echo '</div>';
                        }
                        $i++;
                    }
                } else {
                    // Load up unique error results
                    include ("../error/emptyFaceDatabase.php");
                }
            ?>
        </div>
        <br><br>
        <a href="admin-facenet.php" class="btn btn-outline-primary mb-5">Back</a>
    </div>
</body>
</html>