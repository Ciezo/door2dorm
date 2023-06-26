<?php
require("../../config.php");
session_start(); 
// Check if admin is logged in.
if (!isset($_SESSION["admin-username"])) {
    // If not logged in, then redirect to log-in page.
    header("location: admin-login.php");
}

// Values to retrieve
$tenant_fullName = $tenant_num = $tenant_emergencyNum = $tenant_email = $tenant_username = $tenant_pass = $tenant_room = "";
$_err_tenant_fullName = $_err_tenant_num = $_err_tenant_emergencyNum = $_err_tenant_email = $_err_tenant_username = $_err_tenant_pass = $_err_tenant_room = $_err_tenant_photo = "";

// Flags 
$isTaken_contactNum = false;
$isTaken_email = false;
$isTaken_username = false;

/**
 * Fetch all values from the Create Tenant Account form
 * name="tenant-full-name" 
 * name="tenant-num"
 * name="tenant-emergency-num"
 * name="tenant-email"
 * name="tenant-username"
 * name="tenant-password"
 * name="tenant-assigned-room"
 * name="tenant-face-photo"
 */
//  Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    /** Input validatation */
    // Validate name
    $input_tenant_Fname = trim($_POST["tenant-full-name"]); 
    if (empty($input_tenant_Fname)) {
        $_err_tenant_fullName = "Please, enter a full name of your tenant!";
    }

    else if (!preg_match("/^[a-zA-Z\s\-.]+$/", $input_tenant_Fname)) {
        // Ensure that the full name only contains spaces, letters, periods, and hyphens
        $_err_tenant_fullName = "Special characters such as [-!$%^&*()_+|~=`{}\[\]: are not allowed";
    }
    
    else {
        $tenant_fullName = $input_tenant_Fname; 
    }



    // Validate number
    $input_tenant_num = trim($_POST["tenant-num"]);
    if (empty($input_tenant_num)) {
        $_err_tenant_num = "Please, enter a mobile number";
    }
    
    else if (!filter_var($input_tenant_num, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z0-9\s+]+$/"))) || preg_match("/[-!$%^&*()_|~=`{}\[\]:\";'<>?,.\/]/", $input_tenant_num)) {
        $_err_tenant_num = "Special characters such as periods, commas, hyphens are not allowed. Examples: [-!$%^&*()_+|~=`{}\[\]:";
    }

    else {
        // Check phone number availability 
        if (isset($input_tenant_num)) {
            // Create a query to check if the contact number is taken!
            $query = "SELECT * FROM TENANT"; 
            $results = mysqli_query($conn, $query); 
            
            // Fetch the results as rows
            while ($rows = mysqli_fetch_array($results)) {
                // A cursor points to each row 
                $cursor = $rows;         
                // fetch all existing contact_num
                $temp_contactNo = $cursor['mobile_num'];   
                if (strcmp($temp_contactNo, $input_tenant_num) == 0) {
                    $_err_tenant_num = "This contact number is already taken!";
                    $isTaken_contactNum = true;
                }

                else {
                    $isTaken_contactNum = false;
                }
            }

            if ($isTaken_contactNum == false) {
                $tenant_num = $input_tenant_num; 
            }
        }
    }



    // Validate emergency number
    $input_tenant_emergencyNum = trim($_POST["tenant-emergency-num"]);
    if (empty($input_tenant_emergencyNum)) {
        $_err_tenant_emergencyNum = "Please, enter a mobile number";
    }
    
    else if ((!filter_var($input_tenant_emergencyNum, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z0-9\s+]+$/"))) || preg_match("/[-!$%^&*()_|~=`{}\[\]:\";'<>?,.\/]/", $input_tenant_emergencyNum))) {
        $_err_tenant_emergencyNum = "Special characters such as periods, commas, hyphens are not allowed. Examples: [-!$%^&*()_+|~=`{}\[\]:";
    }

    else {
        $tenant_emergencyNum = $input_tenant_emergencyNum; 
    }



    // Validate email
    $input_tenant_email = trim($_POST["tenant-email"]);
    if (empty($input_tenant_email)) {
        $_err_tenant_email = "Please, provide an email!";
    }

    else if (!filter_var($input_tenant_email, FILTER_VALIDATE_EMAIL)) {
        $_err_tenant_email = "Please, enter a valid email!";
    }
    
    else {
        // Check to see if email is already taken and assigned
        if (isset($input_tenant_email)) {
            // Create a query to check if the contact number is taken!
            $query = "SELECT * FROM TENANT"; 
            $results = mysqli_query($conn, $query); 
            
            // Fetch the results as rows
            while ($rows = mysqli_fetch_array($results)) {
                // A cursor points to each row 
                $cursor = $rows;         
                // fetch all existing contact_num
                $temp_email = $cursor['email'];   
                if (strcmp($temp_email, $input_tenant_email) == 0) {
                    $_err_tenant_email = "This email is already taken!";
                    $isTaken_email = true;
                }

                else {
                    $isTaken_email = false;
                }
            }

            if ($isTaken_email == false) {
                $tenant_email = $input_tenant_email;
            }
        }
    }
    


    // Validate username
    $input_tenant_username = trim($_POST["tenant-username"]);
    if (empty($input_tenant_username)) {
        $_err_tenant_username = "Please, provide a username!";
    }

    else if (!preg_match("/^[a-zA-Z0-9_]+$/", $input_tenant_username)) {
        $_err_tenant_username = "Please, provide a valid username!";
    }

    else if (strlen($input_tenant_username) < 4 || strlen($input_tenant_username) > 16) {
        $_err_tenant_username = "Please, provide a username that has at least 4 up to more than 16 characters";
    }
    
    else {
        // Check to see if username is already taken
        if (isset($input_tenant_email)) {
            // Create a query to check if the contact number is taken!
            $query = "SELECT * FROM TENANT"; 
            $results = mysqli_query($conn, $query); 
            
            // Fetch the results as rows
            while ($rows = mysqli_fetch_array($results)) {
                // A cursor points to each row 
                $cursor = $rows;         
                // fetch all existing contact_num
                $temp_username = $cursor['username'];   
                if (strcmp($temp_username, $input_tenant_username) == 0) {
                    $_err_tenant_email = "This username is already taken!";
                    $isTaken_username = true;
                }

                else {
                    $isTaken_username = false;
                }
            }

            if ($isTaken_username == false) {
                $tenant_username =  $input_tenant_username;
            }
        }
    }


    // Validate password
    $input_tenant_password = trim($_POST["tenant-password"]);
    if (empty($input_tenant_password)) {
        $_err_tenant_pass = "Please, provide a password!";
    }

    else if (strlen($input_tenant_password) < 4 || strlen($input_tenant_password) > 16) {
        $_err_tenant_pass = "Please, provide a password that has at least 4 up to more than 16 characters";
    }

    else {
        $tenant_pass = $input_tenant_password;
    }


    
    // Validate assigned room
    $input_tenant_room = trim($_POST["tenant-assigned-room"]);
    // Since this is a required select field with options, just simply retrieve whatever is selected at POST
    if (empty($input_tenant_room)) {
        $tenant_room = $input_tenant_room; 
    }

    else {
        $tenant_room = $input_tenant_room; 
    }



    // Validate photo
    if (isset($_FILES["face_photo_upload"])) {
        if ($_FILES["face_photo_upload"]["size"] > 5242880) {
            $_err_tenant_photo = "Less than 5 MB only!";
        }
        $tenant_image_to_upload = addslashes(file_get_contents($_FILES["face_photo_upload"]["tmp_name"]));
    }


    // Check if no errors occured
    if (empty($_err_tenant_fullName) && empty($_err_tenant_num) && empty($_err_tenant_emergencyNum) && empty($_err_tenant_email) &&
        empty($_err_tenant_username) && empty($_err_tenant_pass) && empty($_err_tenant_room) && empty($_err_tenant_photo)) {
            
            // Set up a tenant img ref no
            $img_tenant_ref = rand(10, 10000);
            
            // Set the SESSION VARIABLES 
            $_SESSION["register-tenant"] = "SET_TENANT_ENTITY";
            $_SESSION["tenant-FullName"] = $tenant_fullName;
            $_SESSION["tenant-number"] = $tenant_num;
            $_SESSION["tenant-emergencyNumber"] = $tenant_emergencyNum;
            $_SESSION["tenant-email"] = $tenant_email;
            $_SESSION["tenant-username"] = $tenant_username;
            $_SESSION["tenant-password"] = $tenant_pass;
            $_SESSION["tenant-assignRoom"] = $tenant_room;
            $_SESSION["tenant-ref-img"] = $img_tenant_ref;
            $_SESSION["tenant-photo"] = $tenant_image_to_upload;
            
            // Send the form data to the local API
            header("location: ../../api/tenant/create.php");
    }
}

// Create a query to fetch all payment types 
$_sql_rental_payments = "SELECT * FROM PAYMENTS_RENTAL WHERE payment_status='Unpaid'";
$_sql_electricity_payments = "SELECT * FROM PAYMENTS_ELECTRICITY WHERE payment_status='Unpaid'";
$_sql_water_payments = "SELECT * FROM PAYMENTS_WATER WHERE payment_status='Unpaid'";

// Results 
$results_rental_payments = mysqli_query($conn, $_sql_rental_payments);
$results_electricity_payments = mysqli_query($conn, $_sql_electricity_payments);
$results_water_payments = mysqli_query($conn, $_sql_water_payments);

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
        .all-tenants-balances {
            margin-bottom: 50px;
        }
        .list-of-all-registered-tenants {
            margin-bottom: 50px;
        }        
        .card {
            margin-bottom: 50px;
        }
        .create-tenant-profile {
            margin-bottom: 50px;
        }
        table tr td {
            margin: 0px;
            width: 100px;
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
                <a class="nav-item nav-link active px-2" href="#"><i class="fa-solid fa-person-shelter"></i> Tenants</a>
                <a class="nav-item nav-link px-2" href="admin-securityLogs.php">Security Logs</a>
                <a class="nav-item nav-link px-2" href="admin-facenet.php">FaceNet</a>
                <a class="nav-item nav-link px-2" href="admin-messages.php">Messages</a>
                <a class="nav-item nav-link px-2" href="admin-archive-tenants.php">Tenant Archives</a>
                <a class="nav-item nav-link px-2" href="admin-archive-visitors.php">Visitor Archives</a>
                <a class="nav-item nav-link logout px-2" href="../../components/custom/logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Content goes here -->
    <div class="container">
        <!-- List of all tenants -->
        <div class="card shadow-border px-5 mx-2 mt-2">
            <h2 class="mt-2">List of All Tenants</h2>
            <p>This section displays all registered tenants and their personal information</p>
            
            <!-- Search Bar -->
            <div class="search-bar mb-2">
                <a href="#add-tenant" class="btn btn-primary mb-2"><i class="fas fa-plus ml-2"></i> Add Tenant</a>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" id="searchInput" placeholder="Search tenant..." class="form-control">
                </div>
                <div class="text-center mt-5">
                </div>
            </div>

            <div id="periodic-refresh10secs-ListAll-Tenants" class="list-of-all-registered-tenants">
                <!-- Dynamic content loads every 10 seconds -->
                <div id="loadingDiv"><img src="../../assets/images/Ellipsis-1s-200px.gif" alt="" width="50" height="50"></div>
            </div>
        </div>
    
        <!-- List of tenants balances -->
        <div class="card shadow-border px-5 mx-2 mt-2">
            <div class="all-tenants-balances">
                <h2 class="mt-2">Tenants Balances</h2>
                <p>This section presents all the unpaid balances from all tenants</p>
                <!-- Unpaid rentals -->
                <h5>Unpaid Rental Bills</h5>        
                    <!-- Per row is for each tenant balance -->
                        <?php 
                            // Rentals
                            if ($results_rental_payments->num_rows > 0) {
                                echo '<table class="table table-striped">';
                                echo    '<h5>Unpaid Rental Bills</h5>';
                                echo    '<thead class="thead-dark">';
                                echo        '<tr class="table-dark">';
                                echo            '<th scope="col">Name</th>';
                                echo            '<th scope="col">Rental Bills</th>';
                                echo            '<th scope="col">Due Date</th>';
                                echo        '</tr>';
                                echo    '</thead>';
                                echo '</table>'; 

                                echo '<tbody>';

                                while ($rentals_billings = mysqli_fetch_array($results_rental_payments)) {
                                    echo "<tr>";
                                    echo    "<td>".$rentals_billings["to_be_paid_by"]."</td>";
                                    echo    "<td>Php ".$rentals_billings["charges"]."</td>";
                                    echo    "<td>".$rentals_billings["due_date"]."</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo    '<div class="alert alert-info mt-2" role="alert">';
                                echo    '<i class="fa-solid fa-circle-info" style="padding-right: 5px;"></i>';
                                echo    '<b>No unpaid rental bills present</b>';
                                echo    '</div>'; 
                            }
                        ?>
                    </tbody>
                </table>
                <br><br>
                <!-- Unpaid electricity -->
                <h5>Unpaid Electricity Bills</h5>
                        <!-- Per row is for each tenant balance -->
                        <?php 
                            // Electricity
                            if ($results_electricity_payments->num_rows > 0) {
                                echo '<table class="table table-striped">';
                                echo    '<h5>Unpaid Rental Bills</h5>';
                                echo    '<thead class="thead-dark">';
                                echo        '<tr class="table-dark">';
                                echo            '<th scope="col">Name</th>';
                                echo            '<th scope="col">Rental Bills</th>';
                                echo            '<th scope="col">Due Date</th>';
                                echo        '</tr>';
                                echo    '</thead>';
                                echo '</table>'; 

                                echo '<tbody>';

                                while ($electricity_billings = mysqli_fetch_array($results_electricity_payments)) {
                                    echo "<tr>";
                                    echo    "<td>".$electricity_billings["to_be_paid_by"]."</td>";
                                    echo    "<td>Php ".$electricity_billings["charges"]."</td>";
                                    echo    "<td>".$electricity_billings["due_date"]."</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo    '<div class="alert alert-info mt-2" role="alert">';
                                echo    '<i class="fa-solid fa-circle-info" style="padding-right: 5px;"></i>';
                                echo    '<b>No unpaid electricity bills present</b>';
                                echo    '</div>'; 
                            }
                        ?>
                    </tbody>
                </table>
                <br><br>
                <!-- Unpaid water -->
                <h5>Unpaid Water Bills</h5>
                        <!-- Per row is for each tenant balance -->
                        <?php 
                            // Electricity
                            if ($results_water_payments->num_rows > 0) {
                                echo '<table class="table table-striped">';
                                echo    '<h5>Unpaid Rental Bills</h5>';
                                echo    '<thead class="thead-dark">';
                                echo        '<tr class="table-dark">';
                                echo            '<th scope="col">Name</th>';
                                echo            '<th scope="col">Rental Bills</th>';
                                echo            '<th scope="col">Due Date</th>';
                                echo        '</tr>';
                                echo    '</thead>';
                                echo '</table>'; 

                                echo '<tbody>';

                                while ($water_billings = mysqli_fetch_array($results_water_payments)) {
                                    echo "<tr>";
                                    echo    "<td>".$water_billings["to_be_paid_by"]."</td>";
                                    echo    "<td>Php ".$water_billings["charges"]."</td>";
                                    echo    "<td>".$water_billings["due_date"]."</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo    '<div class="alert alert-info mt-2" role="alert">';
                                echo    '<i class="fa-solid fa-circle-info" style="padding-right: 5px;"></i>';
                                echo    '<b>No unpaid water bills present</b>';
                                echo    '</div>'; 
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Creating Tenant Profile -->
        <div class="card shadow-border px-5 mx-2 mt-2" id="add-tenant">
            <div id= "tenant-acc-form" class="create-tenant-profile">
                <h2 class="mt-2">Create Tenant Profile</h2>
                <p>This section is where an admin can create an account for an inquiring tenant</p>
                <!-- Fill up form for a tenant account -->
                <form action="admin-tenants.php" method="POST" enctype="multipart/form-data">
                    <!-- Tenant Full Name -->
                    <div class="form-group">
                        <label for="Tenant's full name"><i class="fa-solid fa-id-card-clip"></i> Full name</label>
                        <input required type="text" id="fetchFullName" name="tenant-full-name" placeholder="Tenant Full Name" class="form-control <?php echo (!empty($_err_tenant_fullName)) ? 'is-invalid' : ''; ?>" value="<?php echo $tenant_fullName ; ?>">
                        <span class="invalid-feedback"><?php echo $_err_tenant_fullName ;?></span>
                    </div>
                    <br>
                    <!-- Tenant Mobile Number -->
                    <div class="form-group">
                        <label for="Tenant's mobile number"><i class="fa-solid fa-mobile-screen-button"></i> Mobile Number</label>
                        <small><b>Ensure to include the Philippine country code '+639'</b></small>
                        <input type="text" id="fetchNumber" name="tenant-num" placeholder="+639000000000" class="form-control <?php echo (!empty($_err_tenant_num)) ? 'is-invalid' : ''; ?>" value="<?php echo $tenant_num ; ?>">
                        <span class="invalid-feedback"><?php echo $_err_tenant_num ;?></span>
                    </div>
                    <br>
                    <!-- Tenant Emergency Contact No. -->
                    <div class="form-group">
                        <label for="Tenant's emergency contact number"><i class="fa-solid fa-phone-volume"></i> Emergency Contact Number</label>
                        <small><b>Ensure to include the Philippine country code '+639'</b></small>
                        <input type="text" id="fetchEmergencyNum" name="tenant-emergency-num" placeholder="+639000000000" class="form-control <?php echo (!empty($_err_tenant_emergencyNum)) ? 'is-invalid' : ''; ?>" value="<?php echo $tenant_emergencyNum ; ?>">
                        <span class="invalid-feedback"><?php echo $_err_tenant_emergencyNum ;?></span>
                    </div>
                    <br>
                    <!-- Tenant Email -->
                    <div class="form-group">
                        <label for="Tenant's email"><i class="fa-solid fa-envelope-open-text"></i> Email</label>
                        <input required type="email" id="fetchEmail" name="tenant-email" placeholder="username@domain.com" class="form-control <?php echo (!empty($_err_tenant_email)) ? 'is-invalid' : ''; ?>" value="<?php echo $tenant_email ; ?>">
                        <span class="invalid-feedback"><?php echo $_err_tenant_email ;?></span>
                    </div>
                    <br>
                    <!-- Tenant Username -->
                    <div class="form-group">
                        <label for="Tenant's username"><i class="fa-solid fa-users-rectangle"></i>  Username</label>
                        <p><i style="color: blue;">This will be used by the tenant as their login credentials</i></p>
                        <input required type="text" id="fetchUserName" name="tenant-username" placeholder="tenant_username" class="form-control <?php echo (!empty($_err_tenant_username)) ? 'is-invalid' : ''; ?>" value="<?php echo $tenant_username ; ?>">
                        <span class="invalid-feedback"><?php echo $_err_tenant_username ;?></span>
                    </div>
                    <br>
                    <!-- Tenant Password -->
                    <div class="form-group">
                        <label for="Tenant's password"><i class="fa-solid fa-lock"></i> Password</label>
                        <p><i style="color: blue;">This will be used by the tenant as their login credentials</i></p>
                        <input required type="password" id="fetchPassword" name="tenant-password" placeholder="********" class="form-control <?php echo (!empty($_err_tenant_pass)) ? 'is-invalid' : ''; ?>" value="<?php echo $tenant_pass ; ?>">
                        <span class="invalid-feedback"><?php echo $_err_tenant_pass ;?></span>
                    </div>
                    <br>
                    <!-- Tenant assigned room -->
                    <div class="form-group">
                        <label for="Tenant's room"><i class="fa-solid fa-people-roof"></i>  Assign a room</label>
                        <!-- <input required type="password" id="fetchRoom" name="tenant-assigned-room" placeholder="000" class="form-control <?php echo (!empty($_err_tenant_room)) ? 'is-invalid' : ''; ?>" value="<?php echo $tenant_room ; ?>"> -->
                        <span class="invalid-feedback"><?php echo $_err_tenant_room ;?></span>
                        <!-- Create a query to retrieve all options from the AVAILABLE_ROOMS where occupancy_status is "Available" -->
                        <select required id="fetchRoom" name="tenant-assigned-room" id="dyanmic-select-ListAll-availableRooms-asOptions" class="form-control">
                            <?php
                                //  Select statement to fetch all available rooms
                                $sql = "SELECT * FROM AVAILABLE_ROOMS where occupancy_status = 'Available'";
                                $results = mysqli_query($conn, $sql);
    
                                // Check if any results are returned
                                if ($results->num_rows > 0) {
                                    // Now, loop through, and list as options inside the <select>
                                    while($rows = mysqli_fetch_array($results)) {
                                        // <option value="$rows["room_number"]">$rows["room_number"]</option>
                                        // echo    '<option value=">'.$rows["room_number"].'"'.$rows["room_number"].'</option>';
                                        echo    '<option value="'.$rows["room_number"].'">'.$rows["room_number"].'</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <br>
                    <!-- Tenant facial photo -->
                    <div class="form-group">
                        <label for="Tenant's photo"><i class="fa-solid fa-image-portrait"></i> Upload a tenant's face photo</label>
                        <input type="file" id="tenantPhotoPreview" name="face_photo_upload" class="form-control <?php echo (!empty($_err_tenant_photo)) ? 'is-invalid' : ''; ?>" value="<?php echo "" ; ?>" required>
                        <div class="card px-5 mt-2 mb-2">
                            <h5>Preview</h5>
                                <img id="previewImage" class="card-img-top mb-2" width="600" height="auto">
                            <script>
                                const fileInput = document.getElementById("tenantPhotoPreview");
                                const previewImage = document.getElementById("previewImage");  
                                fileInput.addEventListener("change", function() {
                                    const file = fileInput.files[0];
                                    const reader = new FileReader();
                                    reader.addEventListener("load", function() {
                                        previewImage.src = reader.result;
                                    });
    
                                    if (file) {
                                        reader.readAsDataURL(file);
                                    }
                                });
                            </script>
                        </div>
                        <span class="invalid-feedback"></span>
                    </div>
                    <br>
                    <!-- Submit form, and preview the tenant details in a modal -->
                    <div class="form-group">
                        <input type="button" onclick="fetchData()" class="btn btn-primary form-control" name="" value="Finish Creating Tenant Profile" data-toggle="modal" data-target="#previewRegisteredTenant">
                    </div>
    
                    
                    <!-- Preview registered tenant in the modal -->
                    <!-- @note Try to retrieve the POST values if invoked method is POST -->
                    <!-- Modal --> 
    
                    <div class="modal fade" id="previewRegisteredTenant" tabindex="-1" role="dialog" aria-labelledby="previewRegisteredTenant" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Review Tenant Details</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="card">
                                    <img class="card-img-top" alt="" align="center" id="previewImgTenantModal" width="50%" height="50%">
                                    <script>
                                        const fetchFileInput = document.getElementById("tenantPhotoPreview");
                                        const renderModalImg = document.getElementById("previewImgTenantModal");  
                                        fetchFileInput.addEventListener("change", function() {
                                            const file = fetchFileInput.files[0];
                                            const reader = new FileReader();
                                            reader.addEventListener("load", function() {
                                                renderModalImg.src = reader.result;
                                            });
    
                                            if (file) {
                                                reader.readAsDataURL(file);
                                            }
                                        });
                                    </script>
                                </div>
                                <h3 id="modalPreview_tenant-fullname" style="padding-top: 10px;"></h3>
                                <h6><b id="modalPreview_tenant-room" ></b></h6>
                                <!-- Tenant POST details -->
                                <ul class="list-group list-group-flush">
                                    <li id="modalPreview_tenant-contactNum" class="list-group-item"></li>
                                    <li id="modalPreview_tenant-emergencyNum" class="list-group-item"></li>
                                    <li id="modalPreview_tenant-email" class="list-group-item"></li>
                                </ul>
                                <div class="card-body">
                                    <div class="modal-body">
                                        <h5>Login Credentials</h5>
                                        <ul class="list-group list-group-flush">
                                            <li id="modalPreview_tenant-username" class="list-group-item"></li>
                                            <li id="modalPreview_tenant-password" class="list-group-item"></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="submit" name="submit-tenant" class="btn btn-outline-success form-control" value="Register Tenant">
                            </div>
                            </div>
    
                            <script>
                                var tenant_fullname, tenant_room, tenant_contactNum, tenant_emergencyNum, tenant_email, tenant_username, tenant_password;
    
                                function fetchData() {
                                    tenant_fullname = document.getElementById("fetchFullName").value; 
                                    tenant_room = document.getElementById("fetchRoom").value; 
                                    tenant_contactNum = document.getElementById("fetchNumber").value; 
                                    tenant_emergencyNum = document.getElementById("fetchEmergencyNum").value; 
                                    tenant_email = document.getElementById("fetchEmail").value; 
                                    tenant_username = document.getElementById("fetchUserName").value; 
                                    tenant_password = document.getElementById("fetchPassword").value; 
    
                                    // Render the fetched values for modal preview
                                    renderFetchedData_toModalPreview();
                                }
    
                                function renderFetchedData_toModalPreview() {
                                    document.getElementById("modalPreview_tenant-fullname").innerHTML = tenant_fullname;
                                    document.getElementById("modalPreview_tenant-room").innerHTML = "@Room: " + tenant_room;
                                    document.getElementById("modalPreview_tenant-contactNum").innerHTML = "Contact No.: <b>" + tenant_contactNum + "</b>";
                                    document.getElementById("modalPreview_tenant-emergencyNum").innerHTML = "Emergency Contact No.: <b>" + tenant_emergencyNum + "</b>";
                                    document.getElementById("modalPreview_tenant-email").innerHTML = "Email: <b>" + tenant_email + "</b>";
                                    document.getElementById("modalPreview_tenant-username").innerHTML = "Username: " + tenant_username;
                                    document.getElementById("modalPreview_tenant-password").innerHTML = "Password: " + tenant_password;
                                }
                            </script>
                        </div>
                    </div>  
                </form>       
            </div>
        </div>
    </div>
    <!-- Script src to dynamically load list of tenants -->
    <script type="text/javascript" src="../../js/dynamic-load-ListAllTenants.js"></script>

    <!-- Search bar -->
    <script>
        $(document).ready(function() {
            // Function to filter tenant cards based on search input
            function filterTenants(searchTerm) {
                $('.card').each(function() {
                    var fullName = $(this).find('.card-header').text().toLowerCase();
                    if (fullName.includes(searchTerm.toLowerCase())) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            }

            // Listen for changes in the search input
            $('#searchInput').on('input', function() {
                var searchTerm = $(this).val();
                filterTenants(searchTerm);
            });
        });
    </script>
</body>
</html>