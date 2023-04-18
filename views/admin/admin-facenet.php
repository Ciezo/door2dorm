<?php
require("../../config.php");
session_start(); 
// Check if admin is logged in.
if (!isset($_SESSION["admin-username"])) {
    // If not logged in, then redirect to log-in page.
    header("location: admin-login.php");
}

$tenant_name = $tenant_face_photo = "";
$_err_tenant_name = $_err_tenant_face_photo = "";

// Check if the form is submitted
if (isset($_POST["register_face"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    // Form values to retreieve
    /**
     * name="tenant-name-face-photo"
     * name="tenant-photo-file" 
     */

    // Validate tenant name 
    $input_tenant_name = trim($_POST["tenant-name-face-photo"]);
    if (empty($input_tenant_name)) {
        $_err_tenant_name = "Please, provide a full name of a tenant!";
    }

    else if (!preg_match("/^[a-zA-Z\s\-.]+$/", $input_tenant_name)) {
        // Ensure that the full name only contains spaces, letters, periods, and hyphens
        $_err_tenant_name = "Special characters such as [-!$%^&*()_+|~=`{}\[\]: are not allowed";
    }
    
    else {
        $tenant_name = $input_tenant_name; 
    }



    // Validate file uploaded
    if (isset($_FILES["tenant-photo-file"])) {
        if ($_FILES["tenant-photo-file"]["size"] > 5242880) {
            $_err_tenant_face_photo = "Less than 5 MB only!";
        }
        $tenant_face_photo = addslashes(file_get_contents($_FILES["tenant-photo-file"]["tmp_name"]));
    }

    else {
        $_err_tenant_face_photo = "Please, attach an image";
    }


    // Check if all error validations are passed 
    if (empty($_err_tenant_name) && empty($_err_tenant_face_photo)) {
        // Get the tenant ID first 
        $_sql_tenant_profile = "SELECT * FROM TENANT WHERE full_name='$tenant_name'";
        $results_tenant_profile = mysqli_query($conn, $_sql_tenant_profile);
        $results_tenant_profile = mysqli_fetch_assoc($results_tenant_profile);
        $tenant_id = $results_tenant_profile["tenant_id"];

        // Create a query to register the facial capture into the database
        $sql = "INSERT INTO FACE_IMG (tenant_id, tenant_name, face_status, face_capture)
                    VALUES 
                        (
                            '$tenant_id',
                            '$tenant_name',
                            'Authorized',
                            '$tenant_face_photo'
                        )";

        if (mysqli_query($conn, $sql)) {

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
    <title>FaceNet: Facial Recognition</title>

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
        .face-net {
            padding-bottom: 50px;
        }
        .view-all-face-img {
            padding-bottom: 50px;
        }
        .toast {
            position: fixed;
            margin-top: 65px;
            top: 0;
            right: 0;
        }
    </style>
    <script>
        $(document).ready(function(){
            $('.toast').toast(true);
        });
    </script>
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
                <a class="nav-item nav-link px-2" href="admin-tenants.php">Tenants</a>
                <a class="nav-item nav-link px-2" href="admin-securityLogs.php">Security Logs</a>
                <a class="nav-item nav-link active px-2" href="#"><i class="fa-solid fa-user-shield"></i> FaceNet</a>
                <a class="nav-item nav-link px-2" href="admin-messages.php">Messages</a>
                <a class="nav-item nav-link logout px-2" href="../../components/custom/logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Content goes here -->
    <div class="container px-5">
        <!-- FaceNet -->
        <div class="face-net">
            <h2>Register face capture of a tenant</h2>
            <p>Here you can register the facial capture of a tenant so they can be recognized by facial recognition</p>
            <div class="card px-5 mx-2">
                <form action="admin-facenet.php" id="_facenet_form" method="POST" enctype="multipart/form-data" class="pt-2">
                    <div class="form-group">
                        <label>Full Name</label> <br>
                        <small><i> Select a tenant to register them in FaceNet</i></small>
                        <!-- Dynamic options listing based on registered tenants -->
                        <select name="tenant-name-face-photo" id="tenant-selector" class="form-control">
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
                        <span class="invalid-feedback"><?php echo $_err_tenant_name ;?></span>
                    </div>
                    <br>
                    <div class="form-group">
                        <label>Choose photo</label>
                        <input type="file" id="file_tenant_photo" name="tenant-photo-file" class="form-control" required>
                        <span class="invalid-feedback"><?php echo $_err_tenant_face_photo ;?></span>
                        <div class="card px-5 mt-2 mb-2">
                            <h5>Preview</h5>
                            <div class="card px-5 mt-2 mb-2">
                                <img id="previewTenantFacePhoto" class="card-img-top mb-2" width="600" height="auto">
                                <script>
                                    const fetchFileInput = document.getElementById("file_tenant_photo");
                                    const renderImgModal = document.getElementById("previewTenantFacePhoto");
                                        fetchFileInput.addEventListener("change", function() {
                                            const file = fetchFileInput.files[0];
                                            const reader = new FileReader();
                                            reader.addEventListener("load", function() {
                                                renderImgModal.src = reader.result;
                                                });

                                                if (file) {
                                                    reader.readAsDataURL(file);
                                                }
                                        });
                                </script> 
                            </div>
                        </div>
                    </div>

                    <!-- Submit -->
                    <input type="submit" name="register_face" value="Register face" class="btn btn-outline-primary"><br><br>
                    <small style="color:red;">**By registering the tenant's facial capture. They will be recognized by the facial recognition software</small><br>
                </form>
            </div>
        </div>

        <!-- View all images from the database -->
        <div class="view-all-face-img">
            <h2>View all tenant images from the database</h2>
            <p>You can preview all tenant facial captures</p>
            <a href="admin-view_all-tenant-imgs.php" class="btn btn-primary">View all captures</a>
        </div>
    </div>

    <!-- Toast, Popup notication -->
    <div class="toast card mx-3" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="mr-auto"><i class="fa-solid fa-id-card-clip"></i> FaceNet Notification</strong>
        </div>
        <div class="toast-body">
            Facial capture registration, successful!
        </div>
    </div>

    <script>
        $(document).ready(function() {
        $("#_facenet_form").submit(function(e) {
                $('.toast').show();
                $('.toast').toast(3000);
            });
        });
  </script> 
</body>
</html>