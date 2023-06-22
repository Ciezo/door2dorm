<?php
require("../../config.php");
session_start(); 

$username = $password1 = $password2 = "";
$_err_username = $_err_password1 = $_err_password2 = "";

if (isset($_POST["reset-password"]) && $_SERVER["REQUEST_METHOD"] == "POST") {

    /** Validate username */
    $input_username = trim($_POST["username"]);
    if (empty($input_username)) {
        $_err_username = "Please, provide a username!";
    }

    else {
        $username = $input_username;
    }

    /** Validate password 1 */
    $input_password1 = trim($_POST["reset-password-1"]); 
    if (empty($input_password1)) {
        $_err_password1 = "Please, provide a password!";
    }

    else {
        $password1 = $input_password1;
    }

    /** Validate password 2 */
    $input_password2 = trim($_POST["reset-password-2"]); 
    if (empty($input_password1)) {
        $_err_password2 = "Please, provide a password!";
    }

    else {
        $password2 = $input_password2;
    }

    /** Validate and confirm passwords are equal */
    if ($input_password1 != $input_password2) {
        $_err_password1 = "Password does not match";
        $_err_password2 = "Password does not match";
    } else {
        $password1 = $input_password1;
        $password2 = $input_password2;
    }

    
    // Check if no errors
    if (empty($_err_username) && empty($_err_password1) && empty($_err_password2)) {
        $sql = "UPDATE TENANT SET
                    password = '$password2'
                WHERE username = '$username'";

        if (mysqli_query($conn, $sql)) {
            header("location: tenant-login.php");
        } else {
            header("location: ../error/error.php");
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
    <title>Forgot password</title>

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
    </style>
</head>
<body>
    <!-- Bootstrap navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
        <a class="navbar-brand" href="#">      
            <i class="fa-solid fa-building-user"></i>
                Door2Dorm 
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="true" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-item nav-link px-2" href="../landing_page.php">Home <span class="sr-only"></span></a>
                <a class="nav-item nav-link active px-2" href="tenant-login.php">Tenant</a>
                <a class="nav-item nav-link px-2" href="../admin/admin-login.php">Admin</a>
            </div>
        </div>
    </nav>

    <!-- Content goes here -->
    <div class="container">
       <div class="card px-5 mx-2">
            <h2>Reset my password</h2>
            <form action="tenant-password-reset.php" method="POST">
                <div class="form-group">
                    <!-- Username -->
                    <label>Enter username</label>
                    <input type="text" name="username" placeholder="Username" class="form-control <?php echo (!empty($_err_password1)) ? 'is-invalid' : ''; ?>" value="<?php echo $username ; ?>">
                    <span class="invalid-feedback"><?php echo $_err_username ;?></span>
                </div>
                <br>
                <div class="form-group">
                    <!-- New password -->
                    <label>Enter new password</label>
                    <input type="password" name="reset-password-1" placeholder="Password" class="form-control <?php echo (!empty($_err_password1)) ? 'is-invalid' : ''; ?>" value="<?php echo $password1 ; ?>">
                    <span class="invalid-feedback"><?php echo $_err_password1 ;?></span>
                </div>
                <br>
                <div class="form-group">
                    <!-- Confirm New password -->
                    <label>Confirm new password</label>
                    <input type="password" name="reset-password-2" placeholder="Password" class="form-control <?php echo (!empty($_err_password2)) ? 'is-invalid' : ''; ?>" value="<?php echo $password2 ; ?>">
                    <span class="invalid-feedback"><?php echo $_err_password2 ;?></span>
                </div>
                <br>
                <!-- Send -->
                <div class="form-group">
                    <input type="submit" name="reset-password" class="form-control btn btn-success" value="Update my new password">
                </div>
            </form>
        </div>
        <br>
        <a href="tenant-login.php" class="btn btn-primary">Back</a>
    </div>
</body>
</html>