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
    
    else if (!ctype_digit($input_tenant_num)) {
        $_err_tenant_num = "Please, enter a valid number";
    }

    else if (!filter_var($input_tenant_num, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z0-9\s]+$/"))) || preg_match("/[-!$%^&*()_+|~=`{}\[\]:\";'<>?,.\/]/", $input_tenant_num)) {
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
    
    else if (!ctype_digit($input_tenant_emergencyNum)) {
        $_err_tenant_emergencyNum = "Please, enter a valid number";
    }

    else if (!filter_var($input_tenant_emergencyNum, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z0-9\s]+$/"))) || preg_match("/[-!$%^&*()_+|~=`{}\[\]:\";'<>?,.\/]/", $input_tenant_emergencyNum)) {
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



    // Validate photo
    if (isset($_FILES["face_photo_upload"])) {
        if ($_FILES["face_photo_upload"]["size"] > 500000) {
            $_err_tenant_photo = "Less than 5 MB only!";
        }
        $tenant_image_to_upload = file_get_contents($_FILES["face_photo_upload"]["tmp_name"]);
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
            

            // Begin inserting the tenant image to the
            $sql = "INSERT INTO IMG_TENANT_ASSOC(tenant_name, img_ref, tenant_img)
                                VALUES
                                (
                                    '$tenant_fullName',
                                    '$img_tenant_ref',
                                    '$tenant_image_to_upload'
                                )";  
            mysqli_query($conn, $sql);
            $conn->close();
            
            sleep(2);
            // Send the form data to the local API
            header("location: ../../api/tenant/create.php");
    }
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
        .list-of-all-registered-tenants {
            margin-bottom: 50px;
        }        
        .card {
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
            <!-- Dynamic content loads every 10 seconds -->
            <div id="loadingDiv"><img src="../../assets/images/Ellipsis-1s-200px.gif" alt="" width="50" height="50"></div>
        </div>
        
        <br><br>

        <!-- Creating Tenant Profile -->
        <div id= "tenant-acc-form" class="create-tenant-profile">
            <h2>Create Tenant Profile</h2>
            <p>This section is where an admin can create an account for an inquiring tenant</p>
            <!-- Fill up form for a tenant account -->
            <form action="admin-tenants.php" method="POST">
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
                    <input type="text" id="fetchNumber" name="tenant-num" placeholder="09XXXXXXXXX" class="form-control <?php echo (!empty($_err_tenant_num)) ? 'is-invalid' : ''; ?>" value="<?php echo $tenant_num ; ?>">
                    <span class="invalid-feedback"><?php echo $_err_tenant_num ;?></span>
                </div>
                <br>
                <!-- Tenant Emergency Contact No. -->
                <div class="form-group">
                    <label for="Tenant's emergency contact number">Emergency Contact Number.</label>
                    <input type="text" id="fetchEmergencyNum" name="tenant-emergency-num" placeholder="09XXXXXXXXX" class="form-control <?php echo (!empty($_err_tenant_emergencyNum)) ? 'is-invalid' : ''; ?>" value="<?php echo $tenant_emergencyNum ; ?>">
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
                    <input type="file" class="form-control" name="face_photo_upload">
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
                                <img class="card-img-top" src="" alt="Tenant facial capture" align="center" id="" width="50%" height="50%">
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
    <!-- Script src to dynamically load list of tenants -->
    <script type="text/javascript" src="../../js/dynamic-load-ListAllTenants.js"></script>
</body>
</html>