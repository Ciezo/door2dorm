<?php
require("../../config.php");
session_start(); 

$email = $username = "";
$_err_email = $_err_username = "";

// Check if form is submitted
if (isset($_POST["recover-account"])) {
    /** Form validation */ 
    // Values to retrieve
    /**
     * name="recover-email"
     * name="recover-username"
     */
    // Validate email
    $input_email = trim($_POST["recover-email"]);
    if (empty($input_email)) {
        $_err_email = "Please, provide an email!";
    }

    else if (!filter_var($input_email, FILTER_VALIDATE_EMAIL)) {
        $_err_email = "Please, enter a valid email!";
    }
    
    else {
        $email = $input_email;
    }
    

    
    // Validate usernmae
    $input_username = trim($_POST["recover-username"]);
    if (empty($input_username)) {
        $_err_username = "Please, provide a username!";
    }

    else {
        $username = $input_username;
    }



    // Check if errors occured
    if (empty($_err_email) && empty($_err_username)) {
        // Assign them to SESSION VARIABLES
        $_SESSION["email-recovery"] =  $email;
        $_SESSION["username-recovery"] =  $username;

        // Redirect to the email service page
        header("location: ../../services/email/forgotPassword.php");
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
        .wrapper {
            padding-top: 50px;
            margin: 0 auto;
            width: 500px;
        }
        .navbar .navbar-brand {
            padding-left: 35px;
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
                <a class="nav-item nav-link" href="../landing_page.php">Home <span class="sr-only"></span></a>
                <a class="nav-item nav-link active" href="#">Tenant</a>
                <a class="nav-item nav-link" href="../admin/admin-login.php">Admin</a>
            </div>
        </div>
    </nav>

    <!-- Content goes here -->
    <div class="wrapper">
       <div class="card px-5">
            <h2>Recover my account</h2>
            <form action="tenant-forgot-pw.php" method="POST">
                <!-- Email -->
                <div class="form-group">
                    <label for="Email">Enter Email</label>
                    <input name="recover-email" type="email" class="form-control <?php echo (!empty($_err_email)) ? 'is-invalid' : ''; ?>" value="<?php echo $email ; ?>" placeholder="username@domain.com">
                    <span class="invalid-feedback"><?php echo $_err_email ;?></span>
                </div>
                <br>
                <!-- Username -->
                <div class="form-group">
                    <label for="Username">Username</label>
                    <input name="recover-username" type="text" class="form-control <?php echo (!empty($_err_username)) ? 'is-invalid' : ''; ?>" value="<?php echo $username ; ?>" placeholder="my_username">
                    <span class="invalid-feedback"><?php echo $_err_username ;?></span>
                </div>
                <br>
                <!-- Send -->
                <div class="form-group">
                    <input type="submit" name="recover-account" class="form-control btn btn-outline-primary">
                </div>
                <br>
            </form>
       </div>
    </div>
</body>
</html>