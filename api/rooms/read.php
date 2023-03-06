<?php
require("../../config.php");
session_start(); 
// Check if admin is logged in.
if (!isset($_SESSION["admin-username"])) {
    // If not logged in, then redirect to error page
    header("location: ../../views/error/error.php");
}

// Values to retrieve 
$room_number = $room_type  = $room_category = $gender_assign = $room_details = $pricing = $num_Of_occupants = $occupy_status = "";
// Try and fetch the ID of a report
if(isset($_POST["id"]) && !empty(trim($_POST["id"]))) {
    // Get hidden input value
    $id = $_POST["id"];

    // Create a query to retrieve a single report record
    $sql = "SELECT * FROM AVAILABLE_ROOMS WHERE room_id=$id";
    $result = mysqli_query($conn, $sql); 

    // Fetch the results as rows 
    while($rows = mysqli_fetch_array($result)) {
        $room_number = $rows["room_number"];
        $room_type = $rows["room_number"];
        $room_category = $rows["room_number"];
        $gender_assign = $rows["gender_assign"];
        $room_details = $rows["details"];
        $pricing = $rows["pricing"];
        $num_Of_occupants = $rows["num_of_occupants"];
        $occupy_status  = $rows["occupancy_status"];

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
        $sql = "SELECT * FROM AVAILABLE_ROOMS WHERE room_id=$id";
        $result = mysqli_query($conn, $sql); 

        // Fetch the results as rows 
        while($rows = mysqli_fetch_array($result)) {
            $room_number = $rows["room_number"];
            $room_type = $rows["room_type"];
            $room_category = $rows["room_category"];
            $gender_assign = $rows["gender_assign"];
            $room_details = $rows["details"];
            $pricing = $rows["pricing"];
            $num_Of_occupants = $rows["num_of_occupants"];
            $occupy_status  = $rows["occupancy_status"];

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
    <title>Door2Dorm Home</title>

     <!-- Bootstrap from https://getbootstrap.com/ -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/c36559a51c.js" crossorigin="anonymous"></script>

    <!-- CSS Global theming and styles -->
    <link href="../css/globals.css" rel="stylesheet">
    
    <style>
        .wrapper {
            padding-top: 50px;
            margin: 0 auto;
            width: 1050px;
        }
        .navbar .navbar-brand {
            padding-left: 35px;
        }
        .card {
            margin-bottom: 100px;
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
                <a class="nav-item nav-link active" href="../../views/landing_page.php">Home <span class="sr-only">(current)</span></a>
                <a class="nav-item nav-link" href="../../tenant/tenant-login.php">Tenant</a>
                <a class="nav-item nav-link" href="../../admin/admin-login.php">Admin</a>
            </div>
        </div>
    </nav>

    <!-- Content Wrapper -->
    <div class="wrapper">
        <div class="card" style="width: 70rem;">
            <div class="card-body">
                <!-- Room Image -->
                <img class="card-img-top" src="../../assets/images/placeholder_img.png" alt="Card image cap" width="auto" height="auto">
                <!-- Room Number -->
                <h5 class="card-title">Room Number: <?php echo $room_number; ?></h5>  
                <!-- Room type -->
                <h6 class="card-subtitle mb-2 text-muted"><?php echo $room_type; ?></h6>
                <!-- Room Category -->
                <h6 class="card-subtitle mb-2 text-muted"><b><?php echo $room_category;  ?></b></h6>
                <!-- Room Details -->
                <p class="card-text"><?php echo $room_details; ?></p>
                <ul class="list-group list-group-flush">
                    <!-- Room Genders assigned -->
                    <li class="list-group-item">Genders allowed: <?php echo $gender_assign; ?></li>
                    <!-- Maximum Number of Occupants -->
                    <li class="list-group-item">Number of occupants allowed: <?php echo $num_Of_occupants ; ?></li>
                    <!-- Room Availability Status -->
                    <li class="list-group-item"><?php echo $occupy_status; ?></li>
                </ul>
                <br>
                <!-- Room Pricing -->
                <a href="#" class="btn btn-outline-info">Php <?php echo $pricing ; ?></a>
                <a href="#" class="btn btn-outline-success">Book for unit visitation</a>
            </div>
            <a href="../../views/landing_page.php" class="btn btn-primary">Back</a>
        </div>
    </div>
</body>
</html>