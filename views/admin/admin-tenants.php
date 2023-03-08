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
    <title>Tenants</title>

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
        .wrapper {
            padding-top: 50px;
            margin: 0 auto;
            width: 1050px;
        }
        .navbar .navbar-brand {
            padding-left: 35px;
        }
        .navbar .collapse .navbar-nav .active {
            background-color: white;
            border-radius: 5px;
            color:black;
        }
        .all-tenants-balances {
            margin-bottom: 50px;
        }
        .list-of-all-registered-tenants, 
        .list-of-all-registered-tenants table {
            margin-bottom: 50px;
        }
        .create-tenant-profile {
            margin-bottom: 50px;
        }
        
    </style>
</head>
<body>
    <!-- Bootstrap navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">      
            <i class="fa-solid fa-building-user"></i>
                Welcome, Admin! 
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="true" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-item nav-link" href="admin-home.php">Home <span class="sr-only"></span></a>
                <a class="nav-item nav-link" href="admin-payment.php">Payment</a>
                <a class="nav-item nav-link active" href="#">Tenants</a>
                <a class="nav-item nav-link" href="admin-securityLogs.php">Security Logs</a>
                <a class="nav-item nav-link" href="admin-facenet.php">FaceNet</a>
                <a class="nav-item nav-link" href="admin-messages.php">Messages</a>
                <a class="nav-item nav-link logout" href="../../components/custom/logout.php">Logut</a>
            </div>
        </div>
    </nav>

    <!-- Content goes here -->
    <div class="wrapper">
        <!-- List of tenants balances -->
        <div id="periodic-refresh10secs-all-TenantsBalances" class="all-tenants-balances">
            <h2>Tenants Balances</h2>
            <p>This section presents all the unpaid balances from all tenants</p>

            <!-- Dynamic table with 10 seconds periodic refresh -->
            <!-- To retrieve all tenants' unpaid balances of all bill types -->
            <table class="table table-striped">
                <thead class="thead-dark">
                    <tr class="table-dark">
                        <th scope="col">Name</th>
                        <th scope="col">Room No.</th>
                        <th scope="col">Rental Bills</th>
                        <th scope="col">Electricity Bills</th>
                        <th scope="col">Water Bills</th>
                        <th scope="col">Payment status</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Per row is for each tenant balance -->
                    <tr>
                        <td>Tenant 1</td>
                        <td>Room No.</td>
                        <td>Php 999.99</td>
                        <td>Php 999.99</td>
                        <td>Php 999.99</td>
                        <td>Unpaid</td>
                    </tr>
                    <tr>
                        <td>Tenant 2</td>
                        <td>Room No.</td>
                        <td>Php 999.99</td>
                        <td>Php 999.99</td>
                        <td>Php 999.99</td>
                        <td>Unpaid</td>
                    </tr>
                    <tr>
                        <td>Tenant 3</td>
                        <td>Room No.</td>
                        <td>Php 999.99</td>
                        <td>Php 999.99</td>
                        <td>Php 999.99</td>
                        <td>Unpaid</td>
                    </tr>
                    <tr>
                        <td>Tenant N..++</td>
                        <td>Room No.</td>
                        <td>Php 999.99</td>
                        <td>Php 999.99</td>
                        <td>Php 999.99</td>
                        <td>Unpaid</td>
                    </tr>
                </tbody>
            </table>

        </div>

        <!-- List of all tenants -->
        <div id="periodic-refresh10secs-ListAll-Tenants" class="list-of-all-registered-tenants">
            <h2>List of All Tenants</h2>
            <p>This section displays all registered tenants and their personal information</p>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Your Tenants</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Dynamic tenant listings to select -->
                    <tr>
                        <!-- Tenant name -->
                        <td>
                            <input type="button" name="tenant-modal-selector" data-toggle="modal" data-target="#exampleModalCenter" class="btn btn-outline-dark" value="Tenant Name">
                        </td>
                    </tr>
                    <tr>
                        <!-- Tenant name -->
                        <td>
                            <input type="button" name="tenant-modal-selector" data-toggle="modal" data-target="#exampleModalCenter" class="btn btn-outline-dark" value="Tenant Name">
                        </td>
                    </tr>
                    <tr>
                        <!-- Tenant name -->
                        <td>
                            <input type="button" name="tenant-modal-selector" data-toggle="modal" data-target="#exampleModalCenter" class="btn btn-outline-dark" value="Tenant Name">
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Tenant Information modal -->
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle">Tenant Information</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card" style="width: 100%;">
                                <img class="card-img-top" src="../../assets/images/placeholder_img.png" alt="Tenant ID" align="center" id="">
                                <div class="card-header" id="">Tenant Full Name</div>
                                <div class="card-body">
                                    <p id=""></p>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item" id=""><b>Email: username@domain.com</b></li>
                                        <li class="list-group-item" id=""><b>Mobile No.: 09XXXXXXXXX</b></li>
                                        <li class="list-group-item" id=""><b>Emergency Contact No.: 09XXXXXXXXX</b></li>
                                        <li class="list-group-item" id=""><b>Assigned Room</b></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="modal-footer">
                            </div>
                        </div>
                    </div>
                </div>
        </div>

        <!-- Creating Tenant Profile -->
        <div id= "tenant-acc-form" class="create-tenant-profile">
            <h2>Create Tenant Profile</h2>
            <p>This section is where an admin can create an account for an inquiring tenant</p>
            <!-- Fill up form for a tenant account -->
            <form action="admin-tenants.php" action="POST">
                <!-- Tenant Full Name -->
                <div class="form-group">
                    <label for="Tenant's full name">Full name</label>
                    <input type="text" name="tenant-full-name" placeholder="Tenant Full Name" class="form-control">
                </div>
                <br>
                <!-- Tenant Mobile Number -->
                <div class="form-group">
                    <label for="Tenant's mobile number">Mobile Number</label>
                    <input type="text" name="tenant-num" placeholder="09XXXXXXXXX" class="form-control">
                </div>
                <br>
                <!-- Tenant Emergency Contact No. -->
                <div class="form-group">
                    <label for="Tenant's emergency contact number">Emergency Contact Number.</label>
                    <input type="text" name="tenant-emergency-num" placeholder="09XXXXXXXXX" class="form-control">
                </div>
                <br>
                <!-- Tenant Email -->
                <div class="form-group">
                    <label for="Tenant's email">Email</label>
                    <input type="text" name="tenant-email" placeholder="username@domain.com" class="form-control">
                </div>
                <br>
                <!-- Tenant Username -->
                <div class="form-group">
                    <label for="Tenant's username">Username</label>
                    <input type="text" name="tenant-username" placeholder="tenant_username" class="form-control">
                </div>
                <br>
                <!-- Tenant Password -->
                <div class="form-group">
                    <label for="Tenant's password">Password</label>
                    <input type="password" name="tenant-password" placeholder="" class="form-control">
                </div>
                <br>
                <!-- Tenant assigned room -->
                <div class="form-group">
                    <label for="Tenant's room">Assign a room</label>
                    <input type="text" name="tenant-assigned-room" placeholder="000" class="form-control">
                </div>
                <br>
                <!-- Tenant facial photo -->
                <div class="form-group">
                    <label for="Tenant's photo">Upload a tenant's face photo</label>
                    <input type="file" class="form-control" name="tenant-face-photo">
                </div>
                <br>
                <!-- Submit form -->
                <div class="form-group">
                    <input type="submit" class="btn btn-primary form-control" name="create-tenant-acc-submit-form"  value="Finish Creating Tenant Profile">
                </div>
            </form>
        </div>

    </div>

</body>
</html>