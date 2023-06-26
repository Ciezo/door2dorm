<?php
require("../../config.php");
session_start(); 

// Check if admin is logged in.
if (!isset($_SESSION["admin-username"])) {
    // If not logged in, then redirect to error page
    header("location: ../../views/error/error.php");
}

// Values to retrieve 
$tenant_full_name = $contactNum  = $emergencyContact = $email = $username = $password = $assigned_room = $tenant_photo = "";

// Try and fetch the ID of a tenant
if(isset($_POST["id"]) && !empty(trim($_POST["id"]))) {
    // Get hidden input value
    $id = $_POST["id"];

    // Create a query to retrieve a single report record
    $sql = "SELECT * FROM TENANT WHERE tenant_id=$id";
    $result = mysqli_query($conn, $sql); 

    // Fetch the results as rows 
    while($rows = mysqli_fetch_array($result)) {
        $tenant_full_name = $rows["full_name"];
        $contactNum = $rows["mobile_num"];
        $emergencyContact = $rows["emergency_contact_num"];
        $email = $rows["email"];
        $username = $rows["username"];
        $password = $rows["password"];
        $assigned_room = $rows["room_assign"];
        $tenant_photo = $rows["tenant_photo"];
    }

    // Close connection
    $conn->close();
    
}

// Forcefully, extract the ID from URL
else {
    // Check existence of ID again.
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Extracting ID parameter from URL
        $id =  trim($_GET["id"]);

        // Now, create a query to select a report content based on id
        $sql = "SELECT * FROM TENANT WHERE tenant_id=$id";
        $result = mysqli_query($conn, $sql); 

        // Fetch the results as rows 
        while($rows = mysqli_fetch_array($result)) {
            $tenant_full_name = $rows["full_name"];
            $contactNum = $rows["mobile_num"];
            $emergencyContact = $rows["emergency_contact_num"];
            $email = $rows["email"];
            $username = $rows["username"];
            $password = $rows["password"];
            $assigned_room = $rows["room_assign"];
            $tenant_photo = $rows["tenant_photo"];
        }
    }  
    
    else {
        echo "Oops! Something went wrong. Please try again later.";
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Tenant Account</title>

    <!-- Bootstrap from https://getbootstrap.com/ -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/c36559a51c.js" crossorigin="anonymous"></script>

    <!-- CSS Global theming and styles -->
    <link href="../../css/globals.css" rel="stylesheet">

    <!-- jQuery -->
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
        .card {
            top: 50%;
            left: 50%;
            transform: translate(-50%, 0%);
            margin-bottom: 50px;
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
                <a class="nav-item nav-link px-2" href="../../views/admin/admin-home.php">Home <span class="sr-only"></span></a>
                <a class="nav-item nav-link px-2" href="../../views/admin/admin-payment.php">Payment</a>
                <a class="nav-item nav-link active px-2" href="#"><i class="fa-solid fa-person-shelter"></i>  Tenants</a>
                <a class="nav-item nav-link px-2" href="../../views/admin/admin-securityLogs.php">Security Logs</a>
                <a class="nav-item nav-link px-2" href="../../views/admin/admin-facenet.php">FaceNet</a>
                <a class="nav-item nav-link px-2" href="../../views/admin/admin-messages.php">Messages</a>
                <a class="nav-item nav-link px-2" href="../../views/admin/admin-archive-tenants.php">Tenant Archives</a>
                <a class="nav-item nav-link px-2" href="../../views/admin/admin-archive-visitors.php">Visitor Archives</a>
                <a class="nav-item nav-link logout px-2" href="../../components/custom/logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Content goes here -->
    <div class="container">
        <div class="card" style="width: 45%;">
            <div class="card">
                <?php echo '<img class="card-img-top" src="data:image/png;base64,'.base64_encode($tenant_photo).'" alt="Tenant Photo">'; ?>
            </div>
            <div class="card-header" id=""><?php echo $tenant_full_name; ?></div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item" id="">Email: <b><?php echo $email; ?></b></li>
                    <li class="list-group-item" id="">Mobile: <b> <?php echo $contactNum; ?></b></li>
                    <li class="list-group-item" id="">Emergency Contact No.: <b><?php echo $emergencyContact; ?></b></li>
                    <li class="list-group-item" id="">Assigned Room: <b><?php echo $assigned_room; ?></b></li>
                </ul>
            </div>
            <div class="card-footer">
                <b>Account Credentials</b>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item" id="">Username: <b><?php echo $username; ?></b></li>
                    <li class="list-group-item" id="">Password: <b><?php echo $password; ?></b></li>
                </ul>
            </div>
            
            <div class="card-body">
                <a href="../../views/admin/admin-tenants.php" class="btn btn-outline-primary">Back</a>
                <?php echo '<a class="btn btn-outline-success" href="update.php?id='.$id.'">Update Account</a>';  ?>
                <?php echo '<a class="btn btn-outline-danger" href="delete.php?id=' . $id . '&name=' . $tenant_full_name . '&mobile_num=' . $contactNum . '&username='. $username . '&email=' . $email . '&password=' . $password . '&emerg=' . $emergencyContact . '&room=' . $assigned_room .'"><i class="fa-solid fa-trash"></i> Remove Account</a>'; ?>
            </div>
        </div>
    </div>
    <br><br>
</body>
</html>