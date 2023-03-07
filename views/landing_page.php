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

    <!-- Loading screen animation -->
    <link href="../css/loading.css" rel="stylesheet">   

    <!-- jQuery-->
    <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
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
                <a class="nav-item nav-link active" href="#">Home <span class="sr-only">(current)</span></a>
                <a class="nav-item nav-link" href="tenant/tenant-login.php">Tenant</a>
                <a class="nav-item nav-link" href="admin/admin-login.php">Admin</a>
            </div>
        </div>
    </nav>

    <!-- Content Wrapper -->
    <div class="wrapper">
        <div id="loadingDiv"><img src="../assets/images/Rolling-1s-200px.gif" alt="Loading screen"></div>
        <div id="periodic-refresh-5secs" class="rooms-avail-table">
            <!-- Dynamic Table: Listing of Available rooms -->
            <!-- Create a query to select all available rooms -->
        </div>

        <div id="sched-book-visit" class="request-visit">
            <h1>Schedule Visits</h1>
            <!-- Fill up form for a visitor -->
            <form action="../api/visitor/create.php" method="POST">
                <!-- Visitor full name -->
                <div class="form-group">
                    <label for="Full name of visitor">Full Name</label>
                    <input type="text" name="visitor-full-name" placeholder="Juan Dela Cruz" class="form-control">
                </div>
                <br>
                <!-- Visitor purpose -->
                <div class="form-group">
                    <label for="Full name of visitor">Purpose of visit</label>
                    <input type="text" name="visitor-purpose" placeholder="Write here your visiting reasons" class="form-control">
                </div>
                <br>
                <!-- Visitor pick date -->
                <div class="form-group">
                    <label for="Full name of visitor">Pick a date</label>
                    <input type="date" name="visitor-date" placeholder="" class="form-control">
                </div>
                <br>
                <!-- Visitor pick time -->
                <div class="form-group">
                    <label for="Full name of visitor">Pick a time</label>
                    <input type="time" name="visitor-time" placeholder="" class="form-control">
                </div>
                <br>
                <!-- Visitor ID upload -->
                <div class="form-group">
                    <label for="Upload a photo">Upload a photo of your valid ID</label>
                    <input type="file" class="form-control" name="file_photo_upload">
                    <span class="invalid-feedback"></span>
                </div>
                <br>
                <!-- Submit form -->
                <div class="form-group">
                    <input type="submit" name="schedule-visit-submit-form" class="btn btn-primary" value="Book now!">
                </div>
            </form>
        </div>
        
    </div>
    <!-- Script file to dynamic load and refresh list of available rooms -->
    <script type="text/javascript" src="../js/dynamic-load-AvailableRooms.js"></script>
</body>
</html>