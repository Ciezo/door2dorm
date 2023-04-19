<?php
require("../../config.php");
session_start(); 
// Check if admin is logged in.
if (!isset($_SESSION["admin-username"])) {
    // If not logged in, then redirect to log-in page.
    header("location: admin-login.php");
}

// Initialize fetching variables
$selected_tenant = $tenant_id = "";
$results_tenant_profile = "";
$results_rental_payments = "";
$results_electricity_payments = "";
$results_water_payments = "";

// Check if form is submitted
if (isset($_POST["select-tenant"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch the name of the selected tenant based on the form
    $selected_tenant = $_POST["tenant-selected"]; 

    // Create a query to fetch all payment types 
    $_sql_tenant_profile = "SELECT * FROM TENANT WHERE full_name='$selected_tenant'";
    $_sql_rental_payments = "SELECT * FROM PAYMENTS_RENTAL WHERE payment_by='$selected_tenant'";
    $_sql_electricity_payments = "SELECT * FROM PAYMENTS_ELECTRICITY WHERE payment_by='$selected_tenant'";
    $_sql_water_payments = "SELECT * FROM PAYMENTS_WATER WHERE payment_by='$selected_tenant'";
    $_sql_get_proof_payment_forRentalType = "SELECT * FROM PROOF_OF_PAYMENT WHERE proof_by='$selected_tenant' AND bill_type='Rental'";
    $_sql_get_proof_payment_forElectricType = "SELECT * FROM PROOF_OF_PAYMENT WHERE proof_by='$selected_tenant' AND bill_type='Electricity'";
    $_sql_get_proof_payment_forWaterType = "SELECT * FROM PROOF_OF_PAYMENT WHERE proof_by='$selected_tenant' AND bill_type='Water'";

    // Results 
    $results_tenant_profile = mysqli_query($conn, $_sql_tenant_profile);
    $results_rental_payments = mysqli_query($conn, $_sql_rental_payments);
    $results_electricity_payments = mysqli_query($conn, $_sql_electricity_payments);
    $results_water_payments = mysqli_query($conn, $_sql_water_payments);
    $results_proof_payment_forRentalType = mysqli_query($conn, $_sql_get_proof_payment_forRentalType);
    $results_proof_payment_forElectricType = mysqli_query($conn, $_sql_get_proof_payment_forElectricType);
    $results_proof_payment_forWaterType = mysqli_query($conn, $_sql_get_proof_payment_forWaterType);

    // Assign as iterable 
    $results_tenant_profile = mysqli_fetch_assoc($results_tenant_profile);
    $results_rental_payments = mysqli_fetch_assoc($results_rental_payments);
    $results_electricity_payments = mysqli_fetch_assoc($results_electricity_payments);
    $results_water_payments = mysqli_fetch_assoc($results_water_payments);
    $results_proof_payment_forRentalType = mysqli_fetch_assoc($results_proof_payment_forRentalType);
    $results_proof_payment_forElectricType = mysqli_fetch_assoc($results_proof_payment_forElectricType);
    $results_proof_payment_forWaterType = mysqli_fetch_assoc($results_proof_payment_forWaterType);
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
        table tr td {
            margin: 0px; 
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
                <a class="nav-item nav-link active px-2" href="#"><i class="fa-solid fa-credit-card"></i> Payment</a>
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
        <!-- Current outstanding each tenant payments table -->
        <div id="periodic-refresh5secs-tenants-payments" class="current-tenants-payments">
            <h2>Payments</h2>
            <p>This section presents the outstanding balances of tenants</p>

            <div class="dynamic-tenant-selector">
                <!-- This is a form that submits a tenant name as an input which is used to dynamically
                    generate a payments table. 
                -->
                <form action="admin-payment.php" method="POST" enctype="multipart/form-data">
                    <label for="Tenant's balances">Choose a tenant</label>
                    <!-- Dynamic options listing based on registered tenants -->
                    <select name="tenant-selected" id="tenant-selector" class="form-control">
                        <?php 
                            // Create a query to fetch all Tenants
                            $sql = "SELECT * FROM TENANT";
                            $results = mysqli_query($conn, $sql);
    
                            // Check returned results
                            if ($results->num_rows > 0) {
                                while($rows = mysqli_fetch_array($results)) {
                                    echo    '<option value="'.$rows["full_name"].'">'.$rows["full_name"].'</option>';
                                }
                            }
                        ?>
                    </select>
                    <input type="submit" name="select-tenant" class="btn btn-outline-primary tenant-btn" value="Review tenant payment"></input>
                </form>
            </div>
            <!-- Editable table with live reflected changed to the database -->
            <h5><?php error_reporting(0); echo $results_tenant_profile["full_name"]."'s Balances" ?></h5>
            <table class="table table-striped">
                <thead class="thead-dark">
                    <tr class="table-dark">
                        <th scope="col">Tenant ID</th>
                        <th scope="col">Bill Type</th>
                        <th scope="col">Charges</th>
                        <th scope="col">Due Date</th>
                        <th scope="col">Payment Status</th>
                        <th scope="col">Set Billings</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Rental row billing type-->
                    <tr>
                        <td><?php echo $results_tenant_profile["tenant_id"] ?></td>
                        <td>Rental</td>
                        <td>
                            <?php 
                                if (!(empty($results_rental_payments["charges"]))) {
                                    echo "Php ".$results_rental_payments["charges"];
                                } else {
                                    echo '<p class="bg-danger text-white px-2" style="border-radius: 10px;">Unassigned</p';
                                }
                            ?>
                        </td>
                        <td>
                            <?php 
                                if (!(empty($results_rental_payments["due_date"]))) {
                                    echo $results_rental_payments["due_date"];
                                } else {
                                    echo '<p class="bg-danger text-white px-2" style="border-radius: 10px;">Unassigned</p';
                                }
                            ?>
                        </td>
                        <td>
                            <?php 
                                if (!(empty($results_rental_payments["payment_status"]))) {
                                    echo $results_rental_payments["payment_status"];
                                } else {
                                    echo '<p class="bg-danger text-white px-2" style="border-radius: 10px;">Unassigned</p';
                                }
                            ?>
                        </td>
                        <td>
                            <!-- Trigger a modal for inputs -->
                            <button id="modal_rental_updates" class="btn btn-outline-dark" data-toggle="modal" data-target="#modal_rental_charges">Update charges</button>
                            <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#modal_rental_payment_acknowledgement">Review payments</button>
                        </td>
                    </tr>
                    <!-- Electricty row billing type -->
                    <tr>
                        <td><?php echo $results_tenant_profile["tenant_id"] ?></td>
                        <td>Electricity</td>
                        <td>
                            <?php 
                                if (!(empty($results_electricity_payments["charges"]))) {
                                    echo "Php ".$results_electricity_payments["charges"];
                                } else {
                                    echo '<p class="bg-danger text-white px-2" style="border-radius: 10px;">Unassigned</p';
                                }
                            ?>
                        </td>
                        <td>
                            <?php 
                                if (!(empty($results_electricity_payments["due_date"]))) {
                                    echo $results_electricity_payments["due_date"];
                                } else {
                                    echo '<p class="bg-danger text-white px-2" style="border-radius: 10px;">Unassigned</p';
                                }
                            ?>
                        </td>
                        <td>
                            <?php 
                                if (!(empty($results_electricity_payments["payment_status"]))) {
                                    echo $results_electricity_payments["payment_status"];
                                } else {
                                    echo '<p class="bg-danger text-white px-2" style="border-radius: 10px;">Unassigned</p';
                                }
                            ?>
                        </td>
                        <td>
                            <!-- Trigger a modal for inputs -->
                            <button id="modal_electricity_updates" class="btn btn-outline-dark" data-toggle="modal" data-target="#modal_electricity_charges">Update charges</button>
                            <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#modal_electricity_payment_acknowledgement">Review payments</button>
                        </td>
                    </tr>
                    <!-- Water row billing type -->
                    <tr>
                        <td><?php echo $results_tenant_profile["tenant_id"] ?></td>
                        <td>Water</td>
                        <td>
                            <?php 
                                if (!(empty($results_water_payments["charges"]))) {
                                    echo "Php ".$results_water_payments["charges"];
                                } else {
                                    echo '<p class="bg-danger text-white px-2" style="border-radius: 10px;">Unassigned</p';
                                }
                            ?>
                        </td>
                        <td>
                            <?php 
                                if (!(empty($results_water_payments["due_date"]))) {
                                    echo $results_water_payments["due_date"];
                                } else {
                                    echo '<p class="bg-danger text-white px-2" style="border-radius: 10px;">Unassigned</p';
                                }
                            ?>
                        </td>
                        <td>
                            <?php 
                                if (!(empty($results_water_payments["payment_status"]))) {
                                    echo $results_water_payments["payment_status"];
                                } else {
                                    echo '<p class="bg-danger text-white px-2" style="border-radius: 10px;">Unassigned</p';
                                }
                                ?>
                        </td>
                        <td>
                            <!-- Trigger a modal for inputs -->
                            <button id="modal_water_updates" class="btn btn-outline-dark" data-toggle="modal" data-target="#modal_water_charges">Update charges</button>
                            <button class="btn btn-outline-success" data-toggle="modal" data-target="#modal_water_payment_acknowledgement">Review payments</button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Modal view for updating Rental Charges -->
            <div id="modal_rental_charges" class="modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            Rental Charges for
                            <?php echo $results_tenant_profile["full_name"]?>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="../../api/payments/set_billings_rental.php" method="POST">
                            <div class="form-group">
                                <label>Rental Charges</label>
                                <small><i>Set the pricing for monthly rentals</i></small>
                                <input name="rental_charges" type="text" class="form-control" placeholder="0.00" value="<?php echo $results_rental_payments["charges"]; ?>">
                            </div>
                            <br>
                            <div class="form-group">
                                <label>Set a due date</label>
                                <small><i>Remind your tenant about their due date billings</i></small>
                                <input name="rental_due_date" type="date" class="form-control" value="<?php echo $results_rental_payments["due_date"]; ?>">
                            </div>
                            <br>
                            <div class="form-group">
                                <label>Payment status</label>
                                <small><i>Paid, Unpaid, Late, Overdue</i></small>
                                <select name="rental_payment_status" class="form-control">
                                    <option value="Paid">Paid</option>
                                    <option value="Unpaid">Unpaid</option>
                                    <option value="Late">Late</option>
                                    <option value="Overdue">Overdue</option>
                                </select>
                            </div>
                            <br>
                                <!-- Submit these values along with the form -->
                                <input type="hidden" name="tenant_id" value="<?php echo $results_tenant_profile["tenant_id"]; ?>">
                                <input type="hidden" name="tenant_fullName" value="<?php echo $results_tenant_profile["full_name"]; ?>">
                                <input type="hidden" name="tenant_phoneNumber" value="<?php echo $results_tenant_profile["mobile_num"]; ?>">
                                <input type="hidden" name="tenant_email" value="<?php echo $results_tenant_profile["email"]; ?>">
                                <!-- Submit modal form -->
                                <input type="submit" name="billings_rentals" class="btn btn-primary" value="Update and set new billings"></input>
                                
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <!-- A button to set a value for marking payments as 'Paid'  -->
                        <form action="../../api/payments/set_billings_rental.php" method="POST">
                            <input type="hidden" name="tenant_id" value="<?php echo $results_tenant_profile["tenant_id"]; ?>">
                            <input name="mark-paid-rental" type="submit" class="btn btn-outline-success" style="display:inline;" value="Mark as Paid"></input>
                        </form>
                    </div>
                    </div>
                </div>
            </div>


            <!-- Modal view for updating Electricity Charges -->
            <div id="modal_electricity_charges" class="modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            Electricity Charges for
                            <?php echo $results_tenant_profile["full_name"]?>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="../../api/payments/set_billings_electricity.php" method="POST">
                            <div class="form-group">
                                <label>Electricity Charges</label>
                                <small><i>Set the pricing for monthly electricity billings</i></small>
                                <input name="electricity_charges" type="text" class="form-control" placeholder="0.00" value="<?php echo $results_electricity_payments["charges"]; ?>">
                            </div>
                            <br>
                            <div class="form-group">
                                <label>Set a due date</label>
                                <small><i>Remind your tenant about their due date billings</i></small>
                                <input name="electricity_due_date" type="date" class="form-control" value="<?php echo $results_electricity_payments["due_date"]; ?>">
                            </div>
                            <br>
                            <div class="form-group">
                                <label>Payment status</label>
                                <small><i>Paid, Unpaid, Late, Overdue</i></small>
                                <select name="electricity_payment_status" class="form-control">
                                    <option value="Paid">Paid</option>
                                    <option value="Unpaid">Unpaid</option>
                                    <option value="Late">Late</option>
                                    <option value="Overdue">Overdue</option>
                                </select>
                            </div>
                            <br>
                                <!-- Submit these values along with the form -->
                                <input type="hidden" name="tenant_id" value="<?php echo $results_tenant_profile["tenant_id"]; ?>">
                                <input type="hidden" name="tenant_fullName" value="<?php echo $results_tenant_profile["full_name"]; ?>">
                                <input type="hidden" name="tenant_phoneNumber" value="<?php echo $results_tenant_profile["mobile_num"]; ?>">
                                <input type="hidden" name="tenant_email" value="<?php echo $results_tenant_profile["email"]; ?>">
                                <!-- Submit modal form -->
                                <input type="submit" name="billings_electricity" class="btn btn-primary" value="Update and set new billings"></input>
                                
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <!-- A button to set a value for marking payments as 'Paid'  -->
                        <form action="../../api/payments/set_billings_electricity.php" method="POST">
                            <input type="hidden" name="tenant_id" value="<?php echo $results_tenant_profile["tenant_id"]; ?>">
                            <input name="mark-paid-electricity" type="submit" class="btn btn-outline-success" style="display:inline;" value="Mark as Paid"></input>
                        </form>
                    </div>
                    </div>
                </div>
            </div>


            <!-- Modal view for updating Water Charges -->
            <div id="modal_water_charges" class="modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            Water Charges for
                            <?php echo $results_tenant_profile["full_name"]?>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="../../api/payments/set_billings_water.php" method="POST">
                            <div class="form-group">
                                <label>Water Charges</label>
                                <small><i>Set the pricing for monthly water billings</i></small>
                                <input name="water_charges" type="text" class="form-control" placeholder="0.00" value="<?php echo $results_water_payments["charges"]; ?>">
                            </div>
                            <br>
                            <div class="form-group">
                                <label>Set a due date</label>
                                <small><i>Remind your tenant about their due date billings</i></small>
                                <input name="water_due_date" type="date" class="form-control" value="<?php echo $results_water_payments["due_date"]; ?>">
                            </div>
                            <br>
                            <div class="form-group">
                                <label>Payment status</label>
                                <small><i>Paid, Unpaid, Late, Overdue</i></small>
                                <select name="water_payment_status" class="form-control">
                                    <option value="Paid">Paid</option>
                                    <option value="Unpaid">Unpaid</option>
                                    <option value="Late">Late</option>
                                    <option value="Overdue">Overdue</option>
                                </select>
                            </div>
                            <br>
                                <!-- Submit these values along with the form -->
                                <input type="hidden" name="tenant_id" value="<?php echo $results_tenant_profile["tenant_id"]; ?>">
                                <input type="hidden" name="tenant_fullName" value="<?php echo $results_tenant_profile["full_name"]; ?>">
                                <input type="hidden" name="tenant_phoneNumber" value="<?php echo $results_tenant_profile["mobile_num"]; ?>">
                                <input type="hidden" name="tenant_email" value="<?php echo $results_tenant_profile["email"]; ?>">
                                <!-- Submit modal form -->
                                <input type="submit" name="billings_water" class="btn btn-primary" value="Update and set new billings"></input>
                                
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <!-- A button to set a value for marking payments as 'Paid'  -->
                        <form action="../../api/payments/set_billings_water.php" method="POST">
                            <input type="hidden" name="tenant_id" value="<?php echo $results_tenant_profile["tenant_id"]; ?>">
                            <input name="mark-paid-water" type="submit" class="btn btn-outline-success" style="display:inline;" value="Mark as Paid"></input>
                        </form>
                    </div>
                    </div>
                </div>
            </div>


            <!-- Modal view for payment acknowledgement to Rental -->
            <div id="modal_rental_payment_acknowledgement" class="modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                Payments submitted by
                                <?php echo $results_tenant_profile["full_name"]?>
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <?php 
                                if (!(empty($results_proof_payment_forRentalType))) {
                                    echo '<img class="card-img-top" src="data:image/png;base64,'.base64_encode($results_proof_payment_forRentalType["img_proof"]).'" alt="Proof of payment">'; 
                                } else {
                                    echo '<div class="alert alert-danger"><em><b>'. $results_tenant_profile["full_name"]. '</b> has not submitted any proof of payment yet!</em></div>';
                                }
                            ?>
                            <hr>
                            <div class="card px-2">
                                <p>
                                    By viewing this content, you are reviewing the payments made by the tenant. Once verified, please set the payment status to <b>Paid</b>
                                </p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Modal view for payment acknowledgement to Electricity -->
            <div id="modal_electricity_payment_acknowledgement" class="modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                Payments submitted by
                                <?php echo $results_tenant_profile["full_name"]?>
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <?php 
                                if (!(empty($results_proof_payment_forElectricType))) {
                                    echo '<img class="card-img-top" src="data:image/png;base64,'.base64_encode($results_proof_payment_forElectricType["img_proof"]).'" alt="Proof of payment">'; 
                                } else {
                                    echo '<div class="alert alert-danger"><em><b>'. $results_tenant_profile["full_name"]. '</b> has not submitted any proof of payment yet!</em></div>';
                                }
                            ?>
                            <hr>
                            <div class="card px-2">
                                <p>
                                    By viewing this content, you are reviewing the payments made by the tenant. Once verified, please set the payment status to <b>Paid</b>
                                </p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Modal view for payment acknowledgement to Water -->
            <div id="modal_water_payment_acknowledgement" class="modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                Payments submitted by
                                <?php echo $results_tenant_profile["full_name"]?>
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <?php 
                                if (!(empty($results_proof_payment_forWaterType))) {
                                    echo '<img class="card-img-top" src="data:image/png;base64,'.base64_encode($results_proof_payment_forWaterType["img_proof"]).'" alt="Proof of payment">'; 
                                } else {
                                    echo '<div class="alert alert-danger"><em><b>'. $results_tenant_profile["full_name"]. '</b> has not submitted any proof of payment yet!</em></div>';
                                }
                            ?>
                            <hr>
                            <div class="card px-2">
                                <p>
                                    By viewing this content, you are reviewing the payments made by the tenant. Once verified, please set the payment status to <b>Paid</b>
                                </p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <!-- Payment history of each tenant. Displays all previous transactions which are paid -->
        <div id="periodic-refresh5secs-payment-history" class="tenant-payment-history">
            <h2>Payment History</h2>
            <p>This section displays all paid transactions from <b><?php echo $results_tenant_profile["full_name"]; ?></p></b>

            <!-- This table will load and refresh based on the selected tenant from the tenant-selector -->
            <table class="table table-striped">
                <thead class="thead-dark">
                    <tr class="table-dark">
                        <th scope="col">Payment ID</th>
                        <th scope="col">Tenant ID</th>
                        <th scope="col">Bill Type</th>
                        <th scope="col">Charges</th>
                        <th scope="col">Due Date</th>
                        <th scope="col">Date Paid</th>
                        <th scope="col">Payment Status</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Rental row billing type-->
                    <tr>
                        <?php 
                            $tenant_id = $results_tenant_profile["tenant_id"];
                            $sql_fetch_payments_rental = "SELECT * FROM PAYMENTS_RENTAL WHERE tenant_id=$tenant_id AND payment_status='Paid' or 'Overdue'";
                            $results_rental_history = mysqli_query($conn, $sql_fetch_payments_rental);
                            $results_rental_history = mysqli_fetch_assoc($results_rental_history);
                        ?>
                        <td>
                                <?php 
                                    if (!(empty($results_rental_payments["payment_id"]))) {
                                        echo $results_rental_payments["payment_id"];
                                    } else {
                                        echo "<b style='color:red'>Waiting for updates...<b>";
                                    }
                                ?>
                        </td>
                        <td><?php echo $results_tenant_profile["tenant_id"]; ?></td>
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
                                    if (!(empty($results_rental_payments["date_paid"]))) {
                                        echo $results_rental_payments["date_paid"]; 
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
                    <!-- Electricty row billing type -->
                    <tr>
                        <?php 
                            $tenant_id = $results_tenant_profile["tenant_id"];
                            $sql_fetch_payments_electricity = "SELECT * FROM PAYMENTS_ELECTRICITY WHERE tenant_id = $tenant_id AND payment_status='Paid' or 'Overdue'";
                            $results_electricity_history = mysqli_query($conn, $sql_fetch_payments_electricity);
                            $results_electricity_history = mysqli_fetch_assoc($results_electricity_history);
                        ?>
                        <td>
                                <?php
                                    if (!(empty($results_electricity_payments["payment_id"]))) {
                                        echo $results_electricity_payments["payment_id"]; 
                                    } else {
                                        echo "<b style='color:red'>Waiting for updates...<b>";
                                    } 
                                ?>
                        </td>
                        <td><?php echo $results_tenant_profile["tenant_id"]; ?></td>
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
                                    if (!(empty($results_electricity_payments["date_paid"]))) {
                                        echo $results_electricity_payments["date_paid"];
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
                    <!-- Water row billing type -->
                    <tr>
                        <?php 
                            $tenant_id = $results_tenant_profile["tenant_id"];
                            $sql_fetch_payments_water = "SELECT * FROM PAYMENTS_WATER WHERE tenant_id = $tenant_id AND payment_status='Paid' or 'Overdue'";
                            $results_water_history = mysqli_query($conn, $sql_fetch_payments_water);
                            $results_water_history = mysqli_fetch_assoc($results_water_history);
                        ?>
                        <td>
                                <?php 
                                    if (!(empty($results_water_history["payment_id"]))) { 
                                        echo $results_water_history["payment_id"]; 
                                    } else {
                                        echo "<b style='color:red'>Waiting for updates...<b>";
                                    }
                                ?>
                        </td>
                        <td><?php echo $results_tenant_profile["tenant_id"]; ?></td>
                        <td>Water</td>
                        <td>
                                <?php 
                                    if (!(empty($results_water_history["charges"]))) {
                                        echo "Php ".$results_water_history["charges"]; 
                                    } else {
                                        echo "<b style='color:red'>Waiting for updates...<b>";
                                    }
                                ?>
                        </td>
                        <td>
                                <?php 
                                    if (!(empty($results_water_history["due_date"]))) {
                                        echo $results_water_history["due_date"]; 
                                    } else {
                                        echo "<b style='color:red'>Waiting for updates...<b>";
                                    }
                                ?>
                        </td>
                        <td>
                                <?php 
                                    if (!(empty($results_water_history["date_paid"]))) {
                                        echo $results_water_history["date_paid"]; 
                                    } else {
                                        echo "<b style='color:red'>Waiting for updates...<b>";
                                    }
                                ?>
                        </td>
                        <td>
                                <?php
                                    if (!(empty($results_water_history["payment_status"]))) {
                                        echo $results_water_history["payment_status"]; 
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
</body>
</html>