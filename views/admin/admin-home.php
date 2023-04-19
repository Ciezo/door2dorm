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
        }
        .admin-avail-rooms-list table {
            margin-top: 22px;
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
                <a class="nav-item nav-link active px-2" href="#"><i class="fa-solid fa-house-user"></i> Home <span class="sr-only"></span></a>
                <a class="nav-item nav-link px-2" href="admin-payment.php">Payment</a>
                <a class="nav-item nav-link px-2" href="admin-tenants.php">Tenants</a>
                <a class="nav-item nav-link px-2" href="admin-securityLogs.php">Security Logs</a>
                <a class="nav-item nav-link px-2" href="admin-facenet.php">FaceNet</a>
                <a class="nav-item nav-link px-2" href="admin-messages.php">Messages</a>
                <a class="nav-item nav-link logout px-2" href="../../components/custom/logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Content goes here -->
    <div class="container">
        <!-- Admin creates list of available rooms -->
        <div class="admin-avail-rooms-list">
            <h2>Available Rooms/Units</h2>
            <p>You may set to list or post your available rooms/units here</p>
            <a class="btn btn-outline-primary" href="../../api/rooms/create.php">Set an available room</a>
            
            <!-- Get a local list of rooms/units in a table -->
            <table class="container-fluid px-auto table table-striped">
                <!-- Table headers -->
                <!-- Table body in a loop. Data is fetched from the database -->
                <?php
                // Create a query to fetch all data for available rooms
                $sql = "SELECT * FROM AVAILABLE_ROOMS";
                $results = mysqli_query($conn, $sql); 

                if ($results->num_rows > 0) {

                    echo '<thead class="thead-dark">';
                    echo    '<tr class="table-dark">';
                    echo        '<th scope="col">#</th>';
                    echo        '<th scope="col">Room No.</th>';
                    echo        '<th scope="col">Room Type</th>';
                    echo        '<th scope="col">Room Category</th>';
                    echo        '<th scope="col">Genders Assigned</th>';
                    echo        '<th scope="col">Pricing per month</th>';
                    echo        '<th scope="col">No. Of Occupants</th>';
                    echo        '<th scope="col">Status</th>';
                    echo        '<th scope="col">Actions</th>';
                    echo    '</tr>';
                    echo '</thead>';

                    echo '<tbody>';
                    // Begin fetching the results as rows
                    while($row = mysqli_fetch_array($results)) {
                        echo '<tr>';    // A row entry
                        echo    '<td>'.$row['room_id'].'</td>';                      // ID 
                        echo    '<td>'.$row['room_number'].'</td>';             // Room No.
                        echo    '<td>'.$row['room_type'].'</td>';               // Room Type
                        echo    '<td>'.$row['room_category'].'</td>';           // Room Category
                        echo    '<td>'.$row['gender_assign'].'</td>';           // Genders Assigned
                        echo    '<td>'.$row['details'].'</td>';                 // Pricing
                        echo    '<td>'.$row['num_of_occupants'].'</td>';        // No. of occupants
                        echo    '<td>'.$row['occupancy_status'].'</td>';        // Status

                        // Actions to Update or Remove a Room
                        echo    '<td>';
                        echo        '<a class="btn btn-outline-success" href="../../api/rooms/update.php?id='.$row['room_id'].'">Update</a>';    // Update room  api/rooms/update
                        echo        '<a class="btn btn-outline-danger" href="../../api/rooms/delete.php?id='.$row['room_id'].'">Remove</a>';     // Remove room  api/rooms/delete
                        echo    '</td>';
                        echo '</tr>'; 
                    }

                    echo '</tbody>';
                    // echo '</table>';
                }

                else {
                    echo '<br>';
                    echo '<br>';
                    echo '<div class="alert alert-danger"><em>There are no records found for available rooms!</em></div>';
                }
                ?>
            </table>
        </div>
        <br>
        <!-- Overview of Tenants Listing and Balances -->
        <h2>Overview of Tenants' Balances</h2>
        <p>This is where you can see all your tenants' balances both paid and unpaid</p>
        <div id="periodic-refresh5secs-overviewBalances" class="admin-listAll-tenants-balances">
            <!-- Dynamic Content, loads every 5 secs -->
            <div id="loadingDiv"><img src="../../assets/images/Ellipsis-1s-200px.gif" alt="" width="50" height="50"></div>
        </div>
        <br>
        <!-- Security logs -->
        <div class="admin-viewAll-securityLogs">
            <h2>Security Logs</h2>
            <p>This section presents the security loggings retrieved by FaceNet</p>

            <table class="table table-striped">
                <thead class="thead-dark">
                    <tr class="table-dark">
                        <th scope="col">Name</th>
                        <th scope="col">Room No.</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Sample Name 1</td>
                        <td>Sample Room 1</td>
                        <td>Checked In or Checked Out</td>
                    </tr>
                    <tr>
                        <td>Sample Name 1</td>
                        <td>Sample Room 1</td>
                        <td>Checked In or Checked Out</td>
                    </tr>
                    <tr>
                        <td>Sample Name 1</td>
                        <td>Sample Room 1</td>
                        <td>Checked In or Checked Out</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <br>
        <!-- Messages overview -->
        <h2>Messages</h2>
        <p>Overview of all messages from tenants</p>
        <div id="periodic-refresh5secs-overviewMessages" class="admin-viewAll-messages">
            <!-- Dynamic content, load every 5 secs -->
            <div id="loadingDiv"><img src="../../assets/images/Ellipsis-1s-200px.gif" alt="" width="50" height="50"></div>
        </div>
        <br>
        <!-- Scheduled Visits -->
        <div id="refresh-5secs-bookings" class="admin-listAll-sched-booked-visits">
            <!-- Dyanmic content, loads every 5 secs -->
            <div id="loadingDiv"><img src="../../assets/images/Ellipsis-1s-200px.gif" alt="" width="50" height="50"></div>
        </div>

    </div>
    <!-- Script src to dynamically refresh and load bookings -->
    <script type="text/javascript" src="../../js/dynamic-load-Bookings.js"></script>
    <!-- Script src to dynamically load billings overview -->
    <script type="text/javascript" src="../../js/dynamic-load-adminBillingsOverview.js"></script>
    <!-- Script src to dynamically laod messages -->
    <script type="text/javascript" src="../../js/dynamic-load-adminAllMsgOverview.js"></script>
</body>
</html>