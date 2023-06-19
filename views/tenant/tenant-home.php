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

// Retrieve payments and billings 
$_sql_rental_payments = "SELECT * FROM PAYMENTS_RENTAL WHERE payment_by='$tenant_full_name'";
$_sql_electricity_payments = "SELECT * FROM PAYMENTS_ELECTRICITY WHERE payment_by='$tenant_full_name'";
$_sql_water_payments = "SELECT * FROM PAYMENTS_WATER WHERE payment_by='$tenant_full_name'";

// Results 
$results_rental_payments = mysqli_query($conn, $_sql_rental_payments);
$results_electricity_payments = mysqli_query($conn, $_sql_electricity_payments);
$results_water_payments = mysqli_query($conn, $_sql_water_payments);

// Assign as iterable 
$results_rental_payments = mysqli_fetch_assoc($results_rental_payments);
$results_electricity_payments = mysqli_fetch_assoc($results_electricity_payments);
$results_water_payments = mysqli_fetch_assoc($results_water_payments);

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
    <link href="../../css/tenant-home.css" rel="stylesheet">

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
                Hi <i class="fa-regular fa-hand fa-shake"></i> Welcome, <?php echo $_SESSION["tenant-username"]?>! 
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="true" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-item nav-link active px-2" href="#"><i class="fa-solid fa-house-lock"></i> Home <span class="sr-only"></span></a>
                <a class="nav-item nav-link px-2" href="tenant-account.php">My Account </span></a>
                <a class="nav-item nav-link px-2" href="tenant-payment.php">Payment </span></a>
                <a class="nav-item nav-link px-2" href="tenant-securityLogs.php">Security Logs </span></a>
                <a class="nav-item nav-link px-2" href="tenant-messages.php">Message </span></a>
                <a class="nav-item nav-link px-2" href="../../components/custom/logout.php">Logout </span></a>
            </div>
        </div>
    </nav>

    <!-- Content goes here -->
    <div class="container-fluid"
        style="background-image: url('../../assets/images/bedroom_sample.jpg'); background-size: cover; background-repeat: no-repeat; background-position: center center;">
        <div class="container">
            <!-- Tenant Account Overview -->
            <div class="tenant-acc-overview">
                <div class="card-body">
                    <div class="list-group list-group-transparent">
                        <div class="list-group-item list-group-item-action flex-column align-items-start border-0 custom-height"
                            style="background-color: rgba(37, 51, 67, 0.384);">
                            <div class="d-flex flex-row bd-highlight custom-margin-left custom-margin-top">
                            <?php echo '<img class="tenant-pic d-none d-sm-flex" src="data:image/png;base64,'.base64_encode($tenant_photo).'" alt="Tenant Photo" style="margin-right: 25px; max-width: 20%;">'; ?>
                                <div>
                                    <i class="fa-solid fa-person-shelter pb-3" style="color: white;"></i>
                                    <span style="margin-right: 10px; color: white;">Room: <?php echo $tenant_room_assign; ?></span>
                                    <i class="fa-solid fa-key" style="color: white;"></i>
                                    <small style="color: white;">Tenant ID: <?php echo $tenant_id; ?></small>
                                    <h5 class="display-3" style="font-weight: bold; color: white;"><?php echo $tenant_full_name; ?></h5>
                                    <div class="card px-2 border-0 bg-transparent"
                                        style="margin-right: 5px; color: white;">
                                        <label for="Room details" style="color: white;">Room details:</label>
                                        <p class="mb-1" style="color: white;"><?php echo $room_details; ?></p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tenant Balances overview -->
    <div class="container">
        <div class="modern-table mx-5 px-4">
            <div class="tenant-balances-overview">
                 <h2>My Balances</h2>
                 <p>List of my current balances</p>
                 <table class="table">
                     <thead class="thead-dark">
                         <tr class="table-dark">
                             <th scope="col">Bill Type</th>
                             <th scope="col">Charges</th>
                             <th scope="col">Due Date</th>
                             <th scope="col">Payment Status</th>
                         </tr>
                     </thead>
                     <tbody>
                         <!-- Rental billings -->
                         <tr>
                             <td>Rental</td>
                             <td> 
                                 <?php
                                     if (!(empty($results_rental_payments["charges"]))) {
                                         echo "Php ".$results_rental_payments["charges"]; 
                                     } else {
                                         echo "<b style='color:red'>Waiting for updates...<b>";
                                     }
                                 ?>
                             </td>
                             <td>
                                 <?php 
                                     if (!(empty($results_rental_payments["due_date"]))) {
                                         echo $results_rental_payments["due_date"]; 
                                     } else {
                                         echo "<b style='color:red'>Waiting for updates...<b>";
                                     }
                                 ?>
                             </td>
                             <td>
                                 <?php 
                                     if (!(empty($results_rental_payments["payment_status"]))) {
                                         echo $results_rental_payments["payment_status"]; 
                                     } else {
                                         echo "<b style='color:red'>Waiting for updates...<b>";
                                     }
                                 ?>
                             </td>
                         </tr>
        
                         <!-- Electricity Billings -->
                         <tr>
                             <td>Electricity</td>
                             <td> 
                                 <?php 
                                     if (!(empty($results_electricity_payments["charges"]))) {
                                         echo "Php ".$results_electricity_payments["charges"]; 
                                     } else {
                                         echo "<b style='color:red'>Waiting for updates...<b>";
                                     }
                                 ?>
                             </td>
                             <td>
                                 <?php 
                                     if (!(empty($results_electricity_payments["due_date"]))) {
                                         echo $results_electricity_payments["due_date"];
                                     } else {
                                         echo "<b style='color:red'>Waiting for updates...<b>";
                                     }
                                 ?>
                             </td>
                             <td>
                                 <?php 
                                     if (!(empty($results_electricity_payments["payment_status"]))) {
                                         echo $results_electricity_payments["payment_status"]; 
                                     } else {
                                         echo "<b style='color:red'>Waiting for updates...<b>";
                                     }
                                 ?>
                             </td>
                         </tr>
        
                         <!-- Water Billings -->
                         <tr>
                             <td>Water</td>
                             <td> 
                                 <?php
                                     if (!(empty($results_water_payments["charges"]))) {
                                         echo "Php ".$results_water_payments["charges"]; 
                                     } else {
                                         echo "<b style='color:red'>Waiting for updates...<b>";
                                     }
                                 ?>
                             </td>
                             <td>
                                 <?php
                                     if (!(empty($results_water_payments["due_date"]))) {
                                         echo $results_water_payments["due_date"]; 
                                     } else {
                                         echo "<b style='color:red'>Waiting for updates...<b>";
                                     }
                                 ?>
                             </td>
                             <td>
                                 <?php 
                                     if (!(empty($results_water_payments["payment_status"]))) {
                                         echo $results_water_payments["payment_status"]; 
                                     } else {
                                         echo "<b style='color:red'>Waiting for updates...<b>";
                                     }
                                 ?>
                             </td>
                         </tr>
                     </tbody>
                 </table>
            </div>
        </div>
    </div>
</body>
</html>