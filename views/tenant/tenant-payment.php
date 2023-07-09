<?php
require("../../config.php");
session_start(); 
// Check if tenant is logged in.
if (!isset($_SESSION["tenant-username"])) {
    // If not logged in, then redirect to log-in page.
    header("location: tenant-login.php");
}

// Initialize existing session variables
$tenant_full_name = $_SESSION["tenant-Fname"];
$tenant_id = $_SESSION["tenant-id"];

// Initialize form values 
$proof_bill_type = $payment_ref_code = $img_proof = $date_uploaded = $proof_by = "";
$_err_proof_bill_type = $_err_payment_ref_code = $_err_img_proof = $_err_date_uploaded = $_err_proof_by = "";

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



// Check if there is any file uploaded from form
if (isset($_POST["upload-proof-payment"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate bill type
    $input_bill_type = trim($_POST["bill-type-option"]);
    if (empty($input_bill_type)) {
        $proof_bill_type = $input_bill_type;
    }

    else {
        $proof_bill_type = $input_bill_type;
    }



    // Validate reference code
    $input_ref_code = trim($_POST["payment-ref-code"]);
    if (empty($input_bill_type)) {
        $payment_ref_code = $input_ref_code;
    }
    
    else if (!filter_var($input_ref_code, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z0-9\s+]+$/"))) || preg_match("/[-!$%^&*()_|~=`{}\[\]:\";'<>?,.\/]/", $input_ref_code)) {
        $_err_payment_ref_code = "Special characters such as periods, commas, hyphens are not allowed. Examples: [-!$%^&*()_+|~=`{}\[\]:";
    }

    else { 
        $payment_ref_code = $input_ref_code;
    }



    // Validate file uploaded (.jpg, .png only and less than 5 MB)
    if (isset($_FILES["file-proof-payment"])) {
        if ($_FILES["file-proof-payment"]["size"] > 5242880) {
            $_err_img_proof = "Less than 5 MB only!";
        }
        $img_proof = addslashes(file_get_contents($_FILES["file-proof-payment"]["tmp_name"]));
    }



    // Valdate the fetched date 
    if (isset($_POST["date_uploaded"])) {
        $get_current_date = date("d-m-y");
        $date_uploaded = $get_current_date; 
    }
    
    else {
        // If for some reason we cannot get the current date
        date_default_timezone_set('Asia/Manila');
        $get_current_date = date("d-m-y");
        $date_uploaded = $get_current_date; 
    }



    // Validate the fetched tenant name as proof_by (or the one who uploaded)
    if (isset($_POST["proof_by"])) {
        $get_name_as_proofBy = trim($_POST["proof_by"]);
        $proof_by =  $get_name_as_proofBy; 
    } 
    
    else {
        $tenant_full_name = $_SESSION["tenant-Fname"];
        $get_name_as_proofBy = $tenant_full_name;
        $proof_by =  $get_name_as_proofBy; 
    }



    // Check error variables 
    // $_err_proof_bill_type = $_err_payment_ref_code = $_err_img_proof = $_err_date_uploaded = $_err_proof_by
    if (empty($_err_proof_bill_type) && empty($_err_payment_ref_code) && empty($_err_img_proof) && 
        empty($_err_date_uploaded) && empty($_err_proof_by)) {
            
            // Check existing data
            $sql_check_if_somethingExists = "SELECT * FROM PROOF_OF_PAYMENT where tenant_id = $tenant_id AND bill_type = '$proof_bill_type'";
            $results_check = mysqli_query($conn, $sql_check_if_somethingExists);
            $results_check = mysqli_fetch_assoc($results_check);

            if (empty($results_check) || !isset($results_check) || $results_check->num_rows < 0) {
                // Create a query to insert proof of payment into the database
                $sql = "INSERT INTO PROOF_OF_PAYMENT (tenant_id, bill_type, paid_ref_code, proof_by, date_uploaded, img_proof) 
                        VALUES
                            (
                                '$tenant_id',
                                '$proof_bill_type', 
                                '$payment_ref_code',
                                '$proof_by',
                                '$date_uploaded',
                                '$img_proof'
                            )";
                            
                            // Execute the query 
                            if (mysqli_query($conn, $sql)) {
                                header("location: tenant-payment.php");
                            }
            } 

            else {
                $sql = "UPDATE PROOF_OF_PAYMENT SET     
                            bill_type = '$proof_bill_type',
                            paid_ref_code = '$payment_ref_code',
                            proof_by = '$proof_by',
                            date_uploaded = '$date_uploaded',
                            img_proof = '$img_proof'
                        WHERE tenant_id = $tenant_id AND bill_type = '$proof_bill_type'";

                        // Execute the query 
                        if (mysqli_query($conn, $sql)) {
                            header("location: tenant-payment.php");
                        }
            }
        }
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
    
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-G774WB6BWG"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-G774WB6BWG');
    </script>
    <style>
        .container {
            padding-top: 50px;
            max-width: 1500px;
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

        .tenant-billing-information {
            padding-bottom: 50px;
        }
        
        .upload-proof-of-payment {
            padding-bottom: 50px;
        }
        
        .payment-history {
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
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary px-3">
        <a class="navbar-brand" href="#">      
                Hi <i class="fa-regular fa-hand fa-shake"></i> Welcome, <?php echo $_SESSION["tenant-username"]?>! 
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="true" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-item nav-link px-2" href="tenant-home.php">Home <span class="sr-only"></span></a>
                <a class="nav-item nav-link px-2" href="tenant-account.php">My Account </span></a>
                <a class="nav-item nav-link active px-2" href="#"><i class="fa-solid fa-money-bill-wave"></i> Payment </span></a>
                <a class="nav-item nav-link px-2" href="tenant-securityLogs.php">Security Logs </span></a>
                <a class="nav-item nav-link px-2" href="tenant-messages.php">Message </span></a>
                <a class="nav-item nav-link px-2" href="../../components/custom/logout.php">Logout </span></a>
            </div>
        </div>
    </nav>

    <!-- Content goes here -->
    <div class="container">
        <div class="row">
            <!-- Left side, Tenant Billing Information and Payment History-->
            <div class="col-lg-9">
                <!-- Tenant Billing Information -->
                <div class="tenant-billing-information">
                    <h2>Tenant Billing Information</h2>
                    <p>Listed in here are your current balanaces</p>
                   <table class="table">
                            <thead class="thead-dark">
                                <tr class="table-dark">
                                    <th scope="col">Tenant ID</th>
                                    <th scope="col">Payment ID</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Charges</th>
                                    <th scope="col">Due Date</th>
                                    <th scope="col">To be paid by</th>
                                    <th scope="col">Payment Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Rental billings -->
                                <tr>
                                    <td><?php echo $tenant_id ?></td>
                                    <td>
                                        <?php 
                                            if (!(empty($results_rental_payments["payment_id"]))) {
                                                echo $results_rental_payments["payment_id"];
                                            } else {
                                                echo "<b style='color:red'>Waiting for updates...<b>";
                                            }
                                        ?>
                                    </td>
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
                                            if (!(empty($results_rental_payments["to_be_paid_by"]))) {
                                                echo $results_rental_payments["to_be_paid_by"]; 
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
                                    <td><?php echo $tenant_id ?></td>
                                    <td>
                                        <?php
                                            if (!(empty($results_electricity_payments["payment_id"]))) {
                                                echo $results_electricity_payments["payment_id"]; 
                                            } else {
                                                echo "<b style='color:red'>Waiting for updates...<b>";
                                            } 
                                        ?>
                                    </td>
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
                                            if (!(empty($results_electricity_payments["to_be_paid_by"]))) {
                                                echo $results_electricity_payments["to_be_paid_by"]; 
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
                                    <td><?php echo $tenant_id ?></td>
                                    <td>
                                        <?php 
                                            if (!(empty($results_water_payments["payment_id"]))) { 
                                                echo $results_water_payments["payment_id"]; 
                                            } else {
                                                echo "<b style='color:red'>Waiting for updates...<b>";
                                            }
                                        ?>
                                    </td>
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
                                            if (!(empty($results_water_payments["to_be_paid_by"]))) {
                                                echo $results_water_payments["to_be_paid_by"]; 
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
                
                <!-- Payment History -->
                <div class="payment-history">
                    <h2>Payment History</h2>
                    <p>Here you can have an overview of all your paid and successful transactions</p>
                    <table class="table">
                            <thead class="thead-dark">
                                <tr class="table-dark">
                                    <th scope="col">Type</th>
                                    <th scope="col">Charges</th>
                                    <th scope="col">Payment Status</th>
                                    <th scope="col">Date Paid</th>
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
                                            if (!(empty($results_rental_payments["payment_status"]))) {
                                                echo $results_rental_payments["due_date"]; 
                                            } else {
                                                echo "<b style='color:red'>Waiting for updates...<b>";
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php 
                                            if (!(empty($results_rental_payments["to_be_paid_by"]))) {
                                                echo $results_rental_payments["date_paid"]; 
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
                                            if (!(empty($results_electricity_payments["payment_status"]))) {
                                                echo $results_electricity_payments["payment_status"];
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
                                            if (!(empty($results_water_payments["payment_status"]))) {
                                                echo $results_water_payments["payment_status"]; 
                                            } else {
                                                echo "<b style='color:red'>Waiting for updates...<b>";
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php 
                                            if (!(empty($results_water_payments["date_paid"]))) {
                                                echo $results_water_payments["date_paid"]; 
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

            <div class="col-lg-3 shadow-border">
                <!-- Uploading proof of payment -->
                <div class="upload-proof-of-payment">
                    <h2>Proof of payment</h2>
                    <p>You can upload an image attachment for your proof of payments</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="POST" enctype="multipart/form-data">
                        <!-- Choose Bill Type -->
                        <div class="form-group">
                            <label>Choose a bill type</label>
                            <select name="bill-type-option" class="form-control">
                                <option value="Rental">Rental</option>
                                <option value="Electricity">Electricity</option>
                                <option value="Water">Water</option>
                            </select>
                        </div>
                        <br>
                        <div class="form-group">
                            <label>Put the reference code here</label>
                            <p><i>Write here your reference code billing</i></p>
                            <small>Example: Meralco Reference Billing Code</small>
                            <input type="text" name="payment-ref-code" placeholder="000AAABBBCCC" class="form-control <?php echo (!empty($_err_payment_ref_code)) ? 'is-invalid' : ''; ?>" value="<?php echo $payment_ref_code ; ?>">
                            <span class="invalid-feedback"><?php echo $_err_payment_ref_code ;?></span>
                        </div>
                        <br>
                        <!-- Upload photo -->
                        <div class="form-group">
                            <label>Upload your proof of payment here</label>
                            <input type="file" name="file-proof-payment" class="form-control <?php echo (!empty($_err_img_proof)) ? 'is-invalid' : ''; ?>" value="<?php echo $img_proof ; ?>" required>
                        </div>
                        <br>
                        <!-- Submit -->
                        <!-- Default values to submit as hidden -->
                        <input type="hidden" name="date_uploaded" value="<?php echo date("m-d-Y"); ?>">
                        <input type="hidden" name="proof_by" value="<?php echo $tenant_full_name; ?>">
                        <input type="submit" name="upload-proof-payment" class="btn btn-primary">
                    </form>
                </div>
            </div>
        </div>

    </div>
</body>
</html>