<?php
require("../../config.php");
session_start(); 
// Check if tenant is logged in.
if (!isset($_SESSION["tenant-username"])) {
    // If not logged in, then redirect to log-in page.
    header("location: tenant-login.php");
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
    <link href="https://cdn.jsdelivr.net/npm/daisyui@2.51.6/dist/full.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>

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
    </style>
</head>
<body>
    <!-- Bootstrap navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary px-3">
        <a class="navbar-brand" href="#">      
                Hi <i class="fa-regular fa-hand fa-shake ml-2 mr-2"></i> Welcome, <?php echo $_SESSION["tenant-username"]?>! 
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="true" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-item nav-link px-2" href="tenant-home.php">Home <span class="sr-only"></span></a>
                <a class="nav-item nav-link px-2" href="tenant-account.php">My Account </span></a>
                <a class="nav-item nav-link px-2" href="tenant-payment.php">Payment </span></a>
                <a class="nav-item nav-link active px-2" href="#"><i class="fa-solid fa-fingerprint"></i> Security Logs </span></a>
                <a class="nav-item nav-link px-2" href="tenant-messages.php">Message </span></a>
                <a class="nav-item nav-link px-2" href="../../components/custom/logout.php">Logout </span></a>
            </div>
        </div>
    </nav>

    <!-- Content goes here -->
    <div class="container">
        <div class="hero mt-6">
            <div class="hero-content text-center">
                <div class="max-w-md">
                    <h1 class="text-5xl font-bold">Security Logs</h1>
                    <p class="py-6">Here are your security logging check-ins and check-outs based on facial recognition</p>
                </div>
            </div>
       </div>
        <div id="tenant-security-logs" class="tenant-security-logs">
            <table class="table table-striped">
                <thead class="thead-dark">
                    <tr class="table-dark">
                        <th scope="col">Name</th>
                        <th scope="col">Room No.</th>
                        <th scope="col">Time-in</th>
                        <th scope="col">Time-out</th>
                        <th scope="col">Status</th>
                    </tr>
                    <tbody>
                        <?php
                            // Select only the tables based on who is logged-in.
                            // We want to get all security loggings based on who is logged-in
                            // And retrieve those occupants assigned in the room
                            $current_room = $_SESSION["tenant-room"];

                            // Create queries to select all time-in and time-out tables from the current_room
                            $get_time_ins = "SELECT * FROM SECURITY_LOGS_TIME_IN WHERE tenant_name = '$current_room'";
                            $get_time_outs = "SELECT * FROM SECURITY_LOGS_TIME_OUT WHERE tenant_name = '$current_room'";
                            $results_time_ins = mysqli_query($conn, $get_time_ins);
                            $results_time_outs = mysqli_query($conn, $get_time_outs);
                            
                            // Check if there are data 
                            /** Time-ins */
                            if ($results_time_ins->num_rows > 0) {
                                while($rows = mysqli_fetch_assoc($results_time_ins)) {
                                    echo "<tr>";
                                    echo    "<td>".$rows["tenant_name"]."</td>";
                                    echo    "<td>".$rows["tenant_room"]."</td>";
                                    echo    "<td>".$rows["time_in"]."</td>";
                                    echo    "<td>"."</td>";
                                    echo    "<td>".$rows["status"]."</td>";
                                    echo "</tr>";
                                }   
                            }

                            else {
                                echo "<small><i>No data on check-ins found...</i></small>";
                            }

                            /** Time-outs */
                            if ($results_time_outs->num_rows > 0) {
                                while($rows = mysqli_fetch_assoc($results_time_ins)) {
                                    echo "<tr>";
                                    echo    "<td>".$rows["tenant_name"]."</td>";
                                    echo    "<td>".$rows["tenant_room"]."</td>";
                                    echo    "<td>"."</td>";
                                    echo    "<td>".$rows["time_out"]."</td>";
                                    echo    "<td>".$rows["status"]."</td>";
                                    echo "</tr>";
                                }   
                            }

                            else {
                                echo "<br><small><i>No data on check-outs found...</i></small>";
                            }
                        ?>
                    </tbody>
                </thead>
            </table>
        </div>
    </div>
</body>
</html>