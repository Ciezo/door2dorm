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
    <title>Payments</title>

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
        .navbar .collapse .navbar-nav .logout:hover {
            background-color: red;
            color: white; 
            border-radius: 5px;
        }
        table tr td {
            width: auto;
        }
        .dynamic-tenant-selector {
            margin-bottom: 20px;
        }
        .dynamic-tenant-selector label {
            transform: translate(0%, -50%);
        }
        .dynamic-tenant-selector .tenant-btn {
            margin-top: 20px;
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
                <a class="nav-item nav-link active" href="#">Payment</a>
                <a class="nav-item nav-link" href="admin-tenants.php">Tenants</a>
                <a class="nav-item nav-link" href="admin-securityLogs.php">Security Logs</a>
                <a class="nav-item nav-link" href="admin-facenet.php">FaceNet</a>
                <a class="nav-item nav-link" href="admin-messages.php">Messages</a>
                <a class="nav-item nav-link logout" href="../../components/custom/logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Content goes here -->
    <div class="wrapper">
        <!-- Current outstanding each tenant payments table -->
        <div id="periodic-refresh5secs-tenants-payments" class="current-tenants-payments">
            <h2>Payments</h2>
            <p>This section presents the outstanding balances of tenants</p>

            <div class="dynamic-tenant-selector">
                <label for="Tenant's balances">Choose a tenant</label>
                <!-- Dynamic options listing based on registered tenants -->
                <select name="" id="tenant-selector" class="form-control">
                    <option value="dyanamic-tenantName-listings">Tenant Name</option>
                    <option value="dyanamic-tenantName-listings">Tenant Name</option>
                    <option value="dyanamic-tenantName-listings">Tenant Name</option>
                    <option value="dyanamic-tenantName-listings">Tenant Name</option>
                    <option value="dyanamic-tenantName-listings">Tenant Name</option>
                </select>
                <button class="btn btn-outline-primary tenant-btn">Review tenant payment</button>
            </div>
            <!-- Editable table with live reflected changed to the database -->
            <table class="table table-striped">
                <thead class="thead-dark">
                    <tr class="table-dark">
                        <th scope="col">Tenant ID</th>
                        <th scope="col">Bill Type</th>
                        <th scope="col">Charges</th>
                        <th scope="col">Due Date</th>
                        <th scope="col">Payment Status</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Rental row billing type-->
                    <tr>
                        <td>Tenant ID</td>
                        <td>Rental</td>
                        <td>Php 999.99</td>
                        <td>MM-DD-YY</td>
                        <td>
                            <select name="payment-status-option" id="" class="form-control">
                                <option value="Paid">Paid</option>
                                <option value="Unpaid">Unpaid</option>
                                <option value="Overdue">Overdue</option>
                            </select>
                        </td>
                    </tr>
                    <!-- Electricty row billing type -->
                    <tr>
                        <td>Tenant ID</td>
                        <td>Electricity</td>
                        <td>Php 999.99</td>
                        <td>MM-DD-YY</td>
                        <td>
                            <select name="payment-status-option" id="" class="form-control">
                                <option value="Paid">Paid</option>
                                <option value="Unpaid">Unpaid</option>
                                <option value="Overdue">Overdue</option>
                            </select>
                        </td>
                    </tr>
                    <!-- Water row billing type -->
                    <tr>
                        <td>Tenant ID</td>
                        <td>Water</td>
                        <td>Php 999.99</td>
                        <td>MM-DD-YY</td>
                        <td>
                            <select name="payment-status-option" id="" class="form-control">
                                <option value="Paid">Paid</option>
                                <option value="Unpaid">Unpaid</option>
                                <option value="Overdue">Overdue</option>
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <br>
        <!-- Payment history of each tenant. Displays all previous transactions which are paid -->
        <div id="periodic-refresh5secs-payment-history" class="tenant-payment-history">
            <h2>Payment History</h2>
            <p>This section displays all paid transactions from the tenant</p>

            <!-- This table will load and refresh based on the selected tenant from the tenant-selector -->
            <table class="table table-striped">
                <thead class="thead-dark">
                    <tr class="table-dark">
                        <th scope="col">Tenant ID</th>
                        <th scope="col">Bill Type</th>
                        <th scope="col">Charges</th>
                        <th scope="col">Due Date</th>
                        <th scope="col">Payment Status</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Rental row billing type-->
                    <tr>
                        <td>Tenant ID</td>
                        <td>Rental</td>
                        <td>Php 999.99</td>
                        <td>MM-DD-YY</td>
                        <td>Paid</td>
                    </tr>
                    <!-- Electricty row billing type -->
                    <tr>
                        <td>Tenant ID</td>
                        <td>Electricity</td>
                        <td>Php 999.99</td>
                        <td>MM-DD-YY</td>
                        <td>Paid</td>
                    </tr>
                    <!-- Water row billing type -->
                    <tr>
                        <td>Tenant ID</td>
                        <td>Water</td>
                        <td>Php 999.99</td>
                        <td>MM-DD-YY</td>
                        <td>Paid</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

</body>
</html>