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
        
        .tenant-account-information {
            padding-bottom: 50px;
        }
        .tenant-assigned-room {
            padding-bottom: 50px;
        }
        .tenant-eContract {
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
                <a class="nav-item nav-link px-2" href="tenant-home.php">Home <span class="sr-only"></span></a>
                <a class="nav-item nav-link active px-2" href="#">My Account </span></a>
                <a class="nav-item nav-link px-2" href="tenant-payment.php">Payment </span></a>
                <a class="nav-item nav-link px-2" href="tenant-securityLogs.php">Security Logs </span></a>
                <a class="nav-item nav-link px-2" href="tenant-messages.php">Message </span></a>
                <a class="nav-item nav-link px-2" href="../../components/custom/logout.php">Logout </span></a>
            </div>
        </div>
    </nav>

    <!-- Content goes here -->
    <div class="container px-5">
       <!-- Tenant Account Information  -->
       <div id="periodic-refresh10secs-tenant-acc-info" class="tenant-account-information">
            <h2>Tenant Account Information</h2>
            <p>This is your profile where your personal information resides</p>
            <div class="card" style="width: 50%">
                <div class="card-header"><?php echo $tenant_full_name; ?></div>
                <!-- Tenant Photo -->
                <div class="card">
                    <?php '<img class="card-img-top" src="data:image/png;base64,'.base64_encode($tenant_photo).'" alt="Tenant Photo">'; ?>
                </div>
                <!-- Tenant Info -->
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Tenant ID: <?php echo $tenant_id; ?></li>
                        <li class="list-group-item">Email: <?php echo $tenant_email; ?></li>
                        <li class="list-group-item">Mobile No.: <?php echo $tenant_number; ?></li>
                        <li class="list-group-item">Emergency Contact No.: <?php echo $tenant_emergNum; ?></li>
                    </ul>
                </div>
            </div>
       </div>

       <!-- Tenant Assigned Rooms -->
       <div id="periodic-refresh10secs-tenant-room" class="tenant-assigned-room">
            <h2>My Room</h2>
            <p>This is your current occupying room</p>
            <table class="table">
                <thead class="thead-dark">
                    <tr class="table-dark">
                        <th>Room No.</th>
                        <th>Type</th>
                        <th>Category</th>
                        <th>Details</th>
                        <th>Monthly Pricing</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $room_number ?></td>
                        <td><?php echo $room_type ?></td>
                        <td><?php echo $room_category ?></td>
                        <td><?php echo $room_details ?></td>
                        <td><?php echo $room_pricing ?></td>
                    </tr>
                </tbody>
            </table>
       </div>

       <!-- Tenant E-contract -->
       <div class="tenant-eContract">
            <h2>Review your contact</h2>
            <p>You can review your signed contract here</p>
            <button class="btn btn-outline-primary">Download Copy</button>
            <button class="btn btn-outline-primary">View E-contract</button>
       </div>
    </div>
</body>
</html>