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
    <title>Security Loggings</title>

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
        .security-logs {
            padding-bottom: 50px;
        }
        .log-table {
            padding-bottom: 50px;
        }
        .shadow-border {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            padding: 20px;
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
                <a class="nav-item nav-link" href="admin-tenants.php">Tenants</a>
                <a class="nav-item nav-link active px-2" href="#"><i class="fa-solid fa-shield-halved"></i> Security Logs</a>
                <a class="nav-item nav-link px-2" href="admin-facenet.php">FaceNet</a>
                <a class="nav-item nav-link px-2" href="admin-messages.php">Messages</a>
                <a class="nav-item nav-link logout px-2" href="../../components/custom/logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Content goes here -->
    <div class="container">
        <div class="security-logs">
            <h2>Security Logs</h2>
            <p>Here is the section where security loggings are present using biometric security measures</p>
            <div class="row shadow-border">
            
                <!-- Filter -->
                <div class="row">
                    <div class="col-lg-10"></div>
                    <div class="col-lg-2">
                        <div class="d-flex justify-content-end">
                            <div class="input-group">
                                <div class="d-flex justify-content-end">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-transparent border-0">
                                                <i class="fa-solid fa-filter"></i>
                                                <span style="padding-left: 5px;">Filter by:</span>
                                            </span>
                                            <input type="text" class="form-control" id="room-filter" placeholder="Room no.">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6" id="room-table">
                    <!-- Time-in log tables -->
                    <h4>Time-ins</h4>
                    <p>These are entries for authorized tenants who checked-in within the premises</p>
                    <div class="card px-2">
                        <div class="log-table time-ins pt-1" id="time-in-securityLog">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" id="room-table">
                    <!-- Time-out log tables -->
                    <h4>Time-outs</h4>
                    <p>These are entries for authorized tenants who checked out from the premises</p>
                    <div class="card px-2">
                        <div class="log-table time-outs" id="time-out-securityLog">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Script to load time-ins -->
    <script type="text/javascript" src="../../js/dynamic-load-TimeIns.js"></script>
    <!-- Script to load time-outs -->
    <script type="text/javascript" src="../../js/dynamic-load-TimeOuts.js"></script>

    <!-- Filter -->
    <script>
        $(document).ready(function () {
            $('#room-filter').keyup(function () {
                var value = $(this).val().toLowerCase();
                $('#room-table tbody tr').filter(function () {
                    var roomNumber = $(this).find('td:nth-child(4)').text().toLowerCase();
                    return roomNumber.indexOf(value) === -1;
                }).toggle();
                
                if (value === "") {
                    $('#room-table tbody tr').show();
                }
        });
        });
    </script>

</body>
</html>