<?php
require("../../config.php");
session_start(); 
// Check if admin is logged in.
if (!isset($_SESSION["admin-username"])) {
    // If not logged in, then redirect to log-in page.
    header("location: admin-login.php");
}

// Values to retrieve
$visitor_fullName = $visit_purpose = $visit_date = $visit_time = $visitor_ID = "";
// Try and fetch the ID of a report
if(isset($_POST["id"]) && !empty(trim($_POST["id"]))) {
    // Get hidden input value
    $id = $_POST["id"];

    // Create a query to retrieve a single report record
    $sql = "SELECT * FROM VISITOR WHERE visitor_id=$id";
    $result = mysqli_query($conn, $sql); 

    // Fetch the results as rows 
    while($rows = mysqli_fetch_array($result)) {
        $visitor_fullName = $rows["full_name"];
        $visitor_contact = $rows["contact_no"]; 
        $visit_purpose = $rows["visit_purpose"];
        $visit_date = $rows["date_visit"];
        $visit_time = $rows["time_visit"];
        $visitor_ID = $rows["id_visitor_photo"];
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
        $sql = "SELECT * FROM VISITOR WHERE visitor_id=$id";
        $result = mysqli_query($conn, $sql); 

        // Fetch the results as rows 
        while($rows = mysqli_fetch_array($result)) {
            $visitor_fullName = $rows["full_name"];
            $visitor_contact = $rows["contact_no"]; 
            $visit_purpose = $rows["visit_purpose"];
            $visit_date = $rows["date_visit"];
            $visit_time = $rows["time_visit"];
            $visitor_ID = $rows["id_visitor_photo"];
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
    <title>View Visitor</title>

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
                <a class="nav-item nav-link active px-2" href="#">Home <span class="sr-only"></span></a>
                <a class="nav-item nav-link px-2" href="../../views/admin/admin-payment.php">Payment</a>
                <a class="nav-item nav-link px-2" href="../../views/admin/admin-tenants.php">Tenants</a>
                <a class="nav-item nav-link px-2" href="../../views/admin/admin-securityLogs.php">Security Logs</a>
                <a class="nav-item nav-link px-2" href="../../views/admin/admin-facenet.php">FaceNet</a>
                <a class="nav-item nav-link px-2" href="../../views/admin/admin-messages.php">Messages</a>
                <a class="nav-item nav-link logout px-2" href="../../components/custom/logout.php">Logut</a>
            </div>
        </div>
    </nav>

    <!-- Content goes here -->
    <div class="container px-5">
        <div class="card" style="width: 50%;">
            <?php echo '<img class="card-img-top" src="data:image/png;base64,'.base64_encode($visitor_ID).'"'; 
                  echo 'alt="Visitor ID">'; ?>
            <div class="card-body" >
                <h5 class="card-title"><?php echo $visitor_fullName; ?></h5>
                <p class="card-text"><?php echo $visit_purpose; ?></p>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <b>Scheduled to visit on: <?php echo $visit_date; ?></b>
                </li>
                <li class="list-group-item">
                    <b>Time: <?php echo $visit_time; ?></b>
                </li>
            </ul>
            <div class="card-body">
               <b>Contact No.: <?php echo $visitor_contact; ?></b>
            </div>
            <div class="card-footer">
                <a href="../../views/admin/admin-home.php" class="btn btn-outline-primary">Back</a>
                <?php echo '<a class="btn btn-outline-danger" href="delete.php?id='.$id.'">Remove</a>';  ?>
            </div>
        </div>

    </div>

</body>
</html>