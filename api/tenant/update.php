<?php
require("../../config.php");
session_start(); 

// Check if admin is logged in.
if (!isset($_SESSION["admin-username"])) {
    // If not logged in, then redirect to error page
    header("location: ../../views/error/error.php");
}

// Values to retrieve
$tenant_fullName = $tenant_num = $tenant_emergencyNum = $tenant_email = $tenant_username = $tenant_pass = $tenant_room = $lease_start = $lease_end = "";
$_err_tenant_fullName = $_err_tenant_num = $_err_tenant_emergencyNum = $_err_tenant_email = $_err_tenant_username = $_err_tenant_pass = $_err_tenant_room = $_err_lease_start = $_err_lease_end = $_err_tenant_photo = "";

// Retrieve the id from the URL parameter after POST
if(isset($_POST["id"]) && !empty($_POST["id"])) {
    // Get hidden input value
    $id = $_POST["id"];
}

else {
    $id =  trim($_GET["id"]);

    // Create a query to select the retrieved entry
    $sql = "SELECT * FROM TENANT WHERE tenant_id=$id";
    $results = mysqli_query($conn, $sql); 
    $results = mysqli_fetch_array($results);
    // Begin filling in data values
    if (is_array($results)) {
        $tenant_fullName = $results["full_name"];
        $tenant_num = $results["mobile_num"];
        $tenant_emergencyNum = $results["emergency_contact_num"];
        $tenant_email = $results["email"];
        $tenant_username = $results["username"];
        $tenant_pass = $results["password"];
        $tenant_room = $results["room_assign"];
        $lease_start = $results["lease_start"];
        $lease_end = $results["lease_end"];
        $tenant_photo = $results["tenant_photo"];
    }
}

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
        $tenant_num = $input_tenant_num; 
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
        $tenant_email = $input_tenant_email;
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
        $tenant_username =  $input_tenant_username;
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



    // Validate lease start
    $input_lease_start = trim($_POST["tenant-lease-start"]);
    if (empty($input_lease_start)) {
        $lease_start = $input_lease_start; 
    }
    
    else {
        $lease_start = $input_lease_start; 
    }

    // Validate lease end
    $input_lease_end = trim($_POST["tenant-lease-end"]);
    if (empty($input_lease_end)) {
        $lease_end = $input_lease_end; 
    }
    
    else {
        $lease_end = $input_lease_end; 
    }



    // Validate photo
    if (isset($_FILES["face_photo_upload"])) {
        if ($_FILES["face_photo_upload"]["size"] > 500000) {
            $_err_tenant_photo = "Less than 5 MB only!";
        }
        $tenant_image_to_upload = file_get_contents($_FILES["face_photo_upload"]["tmp_name"]);
    }


    // Check if no errors occured
    if (empty($_err_tenant_fullName) && empty($_err_tenant_num) && empty($_err_tenant_emergencyNum) && empty($_err_tenant_email) &&
        empty($_err_tenant_username) && empty($_err_tenant_pass) && empty($_err_tenant_room) && empty($_err_lease_start) && empty($_err_lease_end) && empty($_err_tenant_photo)) {
            
            // Create an UPDATE statement
            $sql = "UPDATE TENANT 
                    SET
                        full_name = '$tenant_fullName' ,
                        mobile_num = '$tenant_num' ,
                        username = '$tenant_username' ,
                        email = '$tenant_email' ,
                        password = '$tenant_pass' ,
                        emergency_contact_num = '$tenant_emergencyNum' ,
                        room_assign = '$tenant_room' ,
                        lease_start = '$lease_start' , 
                        lease_end = '$lease_end'  
                    WHERE tenant_id=$id";

            // Once query executes
            if (mysqli_query($conn, $sql)) {
                // Redirect to tenants page
                header("location: ../../views/admin/admin-tenants.php");
                exit();
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
    <title>Update Tenant Account</title>

    <!-- Bootstrap from https://getbootstrap.com/ -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/c36559a51c.js" crossorigin="anonymous"></script>

    <!-- CSS Global theming and styles -->
    <link href="../../css/globals.css" rel="stylesheet">

    <!-- jQuery -->
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
                <a class="nav-item nav-link px-2" href="../../views/admin/admin-home.php">Home <span class="sr-only"></span></a>
                <a class="nav-item nav-link px-2" href="../../views/admin/admin-payment.php">Payment</a>
                <a class="nav-item nav-link active px-2" href="#">Tenants</a>
                <a class="nav-item nav-link px-2" href="../../views/admin/admin-securityLogs.php">Security Logs</a>
                <a class="nav-item nav-link px-2" href="../../views/admin/admin-facenet.php">FaceNet</a>
                <a class="nav-item nav-link px-2" href="../../views/admin/admin-messages.php">Messages</a>
                <a class="nav-item nav-link px-2" href="./../views/admin/admin-archive-tenants.php">Tenant Archives</a>
                <a class="nav-item nav-link px-2" href="./../views/admin/admin-archive-visitors.php">Visitor Archives</a>
                <a class="nav-item nav-link logout px-2" href="../../components/custom/logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Content goes here -->
    <div class="container">
        <h2>Update Tenant Account</h2>
        <p><i>Modify and update tenant account information using this page</i></p>
        <hr>
        <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="POST" enctype="multipart/form-data">
            <!-- Tenant Full Name -->
            <div class="form-group">
                    <label for="Tenant's full name">Full name</label>
                    <input required type="text" id="fetchFullName" name="tenant-full-name" placeholder="Tenant Full Name" class="form-control <?php echo (!empty($_err_tenant_fullName)) ? 'is-invalid' : ''; ?>" value="<?php echo $tenant_fullName ; ?>">
                    <span class="invalid-feedback"><?php echo $_err_tenant_fullName ;?></span>
                </div>
                <br>
                <!-- Tenant Mobile Number -->
                <div class="form-group">
                    <label for="Tenant's mobile number">Mobile Number</label>
                    <small><b>Ensure to include the Philippine country code '+639'</b></small>
                    <input type="text" id="fetchNumber" name="tenant-num" placeholder="639XXXXXXXXX" class="form-control <?php echo (!empty($_err_tenant_num)) ? 'is-invalid' : ''; ?>" value="<?php echo $tenant_num ; ?>">
                    <span class="invalid-feedback"><?php echo $_err_tenant_num ;?></span>
                </div>
                <br>
                <!-- Tenant Emergency Contact No. -->
                <div class="form-group">
                    <label for="Tenant's emergency contact number">Emergency Contact Number.</label>
                    <small><b>Ensure to include the Philippine country code '+639'</b></small>
                    <input type="text" id="fetchEmergencyNum" name="tenant-emergency-num" placeholder="+639XXXXXXXXX" class="form-control <?php echo (!empty($_err_tenant_emergencyNum)) ? 'is-invalid' : ''; ?>" value="<?php echo $tenant_emergencyNum ; ?>">
                    <span class="invalid-feedback"><?php echo $_err_tenant_emergencyNum ;?></span>
                </div>
                <br>
                <!-- Tenant Email -->
                <div class="form-group">
                    <label for="Tenant's email">Email</label>
                    <input required type="email" id="fetchEmail" name="tenant-email" placeholder="username@domain.com" class="form-control <?php echo (!empty($_err_tenant_email)) ? 'is-invalid' : ''; ?>" value="<?php echo $tenant_email ; ?>">
                    <span class="invalid-feedback"><?php echo $_err_tenant_email ;?></span>
                </div>
                <br>
                <!-- Tenant Username -->
                <div class="form-group">
                    <label for="Tenant's username">Username</label>
                    <p><i style="color: blue;">This will be used by the tenant as their login credentials</i></p>
                    <input required type="text" id="fetchUserName" name="tenant-username" placeholder="tenant_username" class="form-control <?php echo (!empty($_err_tenant_username)) ? 'is-invalid' : ''; ?>" value="<?php echo $tenant_username ; ?>">
                    <span class="invalid-feedback"><?php echo $_err_tenant_username ;?></span>
                </div>
                <br>
                <!-- Tenant Password -->
                <div class="form-group">
                    <label for="Tenant's password">Password</label>
                    <p><i style="color: blue;">This will be used by the tenant as their login credentials</i></p>
                    <input required type="password" id="fetchPassword" name="tenant-password" placeholder="********" class="form-control <?php echo (!empty($_err_tenant_pass)) ? 'is-invalid' : ''; ?>" value="<?php echo $tenant_pass ; ?>">
                    <span class="invalid-feedback"><?php echo $_err_tenant_pass ;?></span>
                </div>
                <br>
                <!-- Tenant lease start -->
                <div class="form-group">
                        <label for="Lease start"><i class="fa-solid fa-calendar-day"></i> Start of lease</label>
                        <small><b>The starting date for the tenant's stay</b></small>
                        <input required type="date" id="fetchLeaseStart" name="tenant-lease-start" class="form-control <?php echo (!empty($_err_lease_start)) ? 'is-invalid' : ''; ?>" value="<?php echo $lease_start ; ?>">
                        <span class="invalid-feedback"><?php echo $_err_lease_start ;?></span>
                    </div>
                    <br>
                    <!-- Tenant lease end -->
                    <div class="form-group">
                        <label for="Lease end"><i class="fa-solid fa-calendar-check"></i> End of lease</label>
                        <small><b>The ending date for the tenant's stay</b></small>
                        <input required type="date" id="fetchLeaseEnd" name="tenant-lease-end" class="form-control <?php echo (!empty($_err_lease_end)) ? 'is-invalid' : ''; ?>" value="<?php echo $lease_end ; ?>">
                        <span class="invalid-feedback"><?php echo $_err_lease_end ;?></span>
                    </div>
                    <br>
                <!-- Tenant assigned room -->
                <div class="form-group">
                    <label for="Tenant's room">Assign a room</label>
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
                    <label for="Tenant's photo">Upload a tenant's face photo</label>
                    <input type="file" class="form-control" name="face_photo_upload" required>
                </div>
                <br>

            <!-- Submit form -->
            <input type="submit" name="post-account-form" class="btn btn-outline-success" value="Confirm updates">
            <!-- Back/Cancel button -->
            <a href="../../views/admin/admin-tenants.php" class="btn btn-outline-danger">Cancel</a>
        </form>
    </div>
</body>
</html>