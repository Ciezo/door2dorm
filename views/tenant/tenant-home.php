<?php
require("../../config.php");
session_start(); 
// Check if tenant is logged in.
if (!isset($_SESSION["tenant-username"])) {
    // If not logged in, then redirect to log-in page.
    header("location: tenant-login.php");
}

// Values to retrieve to render tenant account information
$tenant_id =  $tenant_full_name = $tenant_number = $tenant_emergNum = $tenant_email = $tenant_room_assign = $tenant_photo = ""; 
$tenant_username = $_SESSION["tenant-username"] ;
// Create a query to select tenant_acc 
$sql = "SELECT * FROM TENANT WHERE username = '$tenant_username'";

// Begin fetching results
$results = mysqli_query($conn, $sql);
// Fetch as rows 
if($results->num_rows > 0) {
    while ($rows = mysqli_fetch_array($results)) {
        $tenant_id = $rows["tenant_id"];
        $tenant_full_name = $rows["full_name"];
        $tenant_number = $rows["mobile_num"];
        $tenant_emergNum = $rows["emergency_contact_num"];
        $tenant_email = $rows["email"];
        $tenant_room_assign = $rows["room_assign"];
        $tenant_photo = $rows["tenant_photo"];

        // Load up Tenant session variables
        require("../sessions/tenant_session_vars.php");
        set_TenantSessionVars("tenant-id", $tenant_id); 
        set_TenantSessionVars("tenant-Fname", $tenant_full_name); 
        set_TenantSessionVars("tenant-number", $tenant_number); 
        set_TenantSessionVars("tenant-emergencyNum", $tenant_emergNum); 
        set_TenantSessionVars("tenant-email", $tenant_email); 
        set_TenantSessionVars("tenant-room", $tenant_room_assign); 
    }
}

// Values to retrieve for tenant assigned room
$room_number = $room_type = $room_category = $room_details = $room_pricing = $room_no_of_occupants = "";
// Create a query to select a room
$sql = "SELECT * FROM AVAILABLE_ROOMS WHERE room_number = '$tenant_room_assign'";

// Begin fetching results
$results = mysqli_query($conn, $sql);
// Fetch as rows 
if($results->num_rows > 0) {
    while ($rows = mysqli_fetch_array($results)) {
        $room_number = $rows["room_number"];
        $room_type = $rows["room_type"];
        $room_category = $rows["room_category"];
        $room_details = $rows["details"];
        $room_pricing = $rows["pricing"];
        $room_no_of_occupants = $rows["num_of_occupants"];
    }
}
$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

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
            box-shadow: 0 5px 10px rgb(0 0 0 / 0.2);
        }
        .tenant-acc-overview {
            padding-bottom: 50px;
        }
        .tenant-balances-overview {
            padding-bottom: 50px;
        }
    </style>
</head>
<body>
    <!-- Bootstrap navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary px-3">
        <a class="navbar-brand" href="#">      
            <i class="fa-solid fa-house-user"></i>
                Welcome, <?php echo $_SESSION["tenant-username"]?>! 
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="true" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-item nav-link active px-2" href="#">Home <span class="sr-only"></span></a>
                <a class="nav-item nav-link px-2" href="tenant-account.php">My Account </span></a>
                <a class="nav-item nav-link px-2" href="tenant-payment.php">Payment </span></a>
                <a class="nav-item nav-link px-2" href="tenant-securityLogs.php">Security Logs </span></a>
                <a class="nav-item nav-link px-2" href="tenant-messages.php">Message </span></a>
                <a class="nav-item nav-link px-2" href="../../components/custom/logout.php">Logout </span></a>
            </div>
        </div>
    </nav>

    <!-- Content goes here -->
    <div class="container px-5">
       <!-- Tenant Account Overview -->
       <div class="tenant-acc-overview">
            <h2>My Account</h2>
            <p>Account overview</p>
            <div class="card-body">
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1"><?php echo $tenant_full_name; ?></h5>
                            <small>Tenant ID: <?php echo $tenant_id; ?></small>
                        </div>
                        <i class="fa-solid fa-person-shelter pb-3"></i>
                        Room: <?php echo $tenant_room_assign; ?>
                        <div class="card px-2">
                            <label for="Room details">Room details:</label>
                            <p class="mb-1"><?php echo $room_details; ?></p>
                        </div>
                    </a>
                </div>
            </div> 
       </div>
       
       <!-- Tenant Balances overview -->
       <div class="tenant-balances-overview">
            <h2>My Balances</h2>
            <p>List of my current balances</p>
            <table class="table">
                <thead class="thead-dark">
                    <tr class="table-dark">
                        <th scope="col">Type</th>
                        <th scope="col">Charges</th>
                        <th scope="col">Due Date</th>
                        <th scope="col">Payment Status</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Rental billings -->
                    <tr>
                        <td>Rental</td>
                        <td>Php 99.999</td>
                        <td>MM-DD-YY</td>
                        <td>Paid or Unpaid</td>
                    </tr>

                    <!-- Electricity Billings -->
                    <tr>
                        <td>Electricity</td>
                        <td>Php 99.999</td>
                        <td>MM-DD-YY</td>
                        <td>Paid or Unpaid</td>
                    </tr>

                    <!-- Water Billings -->
                    <tr>
                        <td>Water</td>
                        <td>Php 99.999</td>
                        <td>MM-DD-YY</td>
                        <td>Paid or Unpaid</td>
                    </tr>

                </tbody>
            </table>
       </div>
    </div>
</body>
</html>