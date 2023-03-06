<?php
require("../config.php");
session_start(); 
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
        .rooms-avail-table {
            padding-bottom: 50px;
        }
        .rooms-avail-table table {
            margin-top: 22px;
        }
        table tr td {
            width: auto;
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
                <a class="nav-item nav-link active" href="#">Home <span class="sr-only">(current)</span></a>
                <a class="nav-item nav-link" href="tenant/tenant-login.php">Tenant</a>
                <a class="nav-item nav-link" href="admin/admin-login.php">Admin</a>
            </div>
        </div>
    </nav>

    <!-- Content Wrapper -->
    <div class="wrapper">
        
        <div class="rooms-avail-table">
            <h1>List Of Available Rooms</h1>
            <!-- Dynamic Table: Listing of Available rooms -->
            <!-- Create a query to select all available rooms -->
            <?php
                //  Select statement to fetch all available rooms
                $sql = "SELECT * FROM AVAILABLE_ROOMS where occupancy_status = 'Available'";
                $results = mysqli_query($conn, $sql);

                if ($results->num_rows > 0) {
                    echo    '<table class="table table-striped">';
                    echo        '<thead class="thead-dark">';
                    echo            '<tr class="table-dark">';
                    echo                '<th scope="col">Room No.</th>';
                    echo                '<th scope="col">Room Type</th>';
                    echo                '<th scope="col">Pricing per month</th>';
                    echo                '<th scope="col">Details</th>';
                    echo                '<th scope="col"></th>';
                    echo            '</tr>';
                    echo        '</thead>';

                    // Begin retrieving all entries as rows in a while loop
                    while ($row = mysqli_fetch_array($results)) {
                        echo '<tbody>';
                        echo    '<td>'.$row['room_number'].'</td>';         // Room No.
                        echo    '<td>'.$row['room_type'].'</td>';          // Room Type
                        echo    '<td>'.$row['pricing'].'</td>';            // Pricing per month
                        echo    '<td>'.$row['details'].'</td>';            // Room Details
                        
                        // Actions to View More
                        echo    '<td>';
                        echo        '<a class="btn btn-outline-primary" href="../api/rooms/read.php?id='.$row['room_id'].'">More details</a>';
                        echo    '</td>';         
                        echo '</tbody>';
                    }
                    echo '</table>';
                }

                else {
                    echo '<div class="alert alert-danger"><em>There are no records found for available rooms!</em></div>';
                }

            ?>
        </div>

        <div class="request-visit">
            <h1>Schedule Visits</h1>
            <!-- Fill up form for a visitor -->
        </div>
        
    </div>
</body>
</html>