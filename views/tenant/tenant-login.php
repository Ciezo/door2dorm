<?php
require("../../config.php");
session_start(); 

error_reporting(0);
$username = $password = "";
$_err_ = "";
if(isset($_POST['tenant-login']) && $_SERVER["REQUEST_METHOD"] == "POST") {    
    $username = ($_POST["tenant-username"]);
    $password = ($_POST["tenant-password"]);

    // Create a query to select a single entry from the USERS table
    $query = "SELECT * FROM TENANT WHERE username='$username' AND password='$password'"; 
    $results = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($results);

    // If all input credentials are matched from the database then
    if ($username == $row["username"] && $password == $row["password"]) {
        // Set up SESSION VARIABLES
        $_SESSION["tenant-username"] = $username; 
        $_SESSION["tenant-password"] = $password; 
        /** Redirect to admin session checking */
        header("location: ../sessions/tenant_session_check.php");
    }

    else {
        $_err_ = "Wrong username or password!";
    }
}
?>

<!DOCTYPE html>
<html data-theme="light" lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login, Tenant</title>

    <!-- Bootstrap from https://getbootstrap.com/ -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/c36559a51c.js" crossorigin="anonymous"></script>

    <!-- CSS Global theming and styles -->
    <link href="../../css/globals.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@2.51.6/dist/full.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
     
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
        }
        .container .tenant-login label {
            font-size: 20px;
            padding-bottom: 15px;
        }
        .container .tenant-login {
            width: 50%;
        }
        .container .tenant-login input:focus {
            box-shadow: 0px 0px 10px 0px #333;
        }
        .container .tenant-login .btn.btn-primary {
            margin-top: 50px;
            width: 100%;
        }
        .navbar .navbar-brand {
            padding-left: 35px;
        }
        .card {
            box-shadow: 0px 2px 0px 0px rgba(0,0,0,0.1);
        }
        .left-side {
            background-image: url("../../assets/images/landing_photo.jpg");
            background-size: cover;
            overflow: hidden;
            border-radius: 5px;
            transition: transform 0.3s
        } 
        .left-side:hover {
            transform: scale(1.01);
            transition: transform 0.3s
        }
        .left-side #header_welcome {
            font-weight: 700;
            color: white;
            text-shadow: black;
        } 
        @media screen and (max-width: 1080px) {
            #header_welcome {
                display: none;
            }
        }
        .right-side {
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <!-- Bootstrap navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light px-3">
        <a class="navbar-brand" href="#">      
            <i class="fa-solid fa-building-user"></i>
                Door2Dorm 
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="true" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav px-2">
                <a class="nav-item nav-link px-2" href="../landing_page.php">Home <span class="sr-only"></span></a>
                <a class="nav-item nav-link px-2 active" href="#">Tenant</a>
                <a class="nav-item nav-link px-2" href="../admin/admin-login.php">Admin</a>
            </div>
        </div>
    </nav>

    <!-- Content goes here -->
    <div class="hero min-h-screen " style="background-image: url(https://xx.bstatic.com/data/xphoto/1440x810/332/33284819.jpg?size=S);">
        <div class="hero-overlay bg-opacity-60">
    </div>
    
    <div class="hero-content flex flex-col lg:flex-row lg:space-x-8">
        <div class="text-center lg:text-left">
            <h1 class="text-5xl font-bold mb-6 text-white">👋 Welcome back, Tenant!</h1>
            <p class="text-white">Enter the account credentials given to you by the dormitory admin.</p>
        </div>
        
        <div class="card flex-shrink-0 w-full max-w-sm shadow-2xl bg-base-100">
            <div class="card-body">
                <form action="tenant-login.php" class="tenant-login" method="POST">
                    <div class="form-control mb-2">
                        <label class="label">
                            <span class="label-text"><i class="fa-solid fa-users-rectangle"></i> Username</span>
                        </label>
                        <input type="text" name="tenant-username" required placeholder="Username" class="input input-bordered <?php echo (!empty($_err_)) ? 'is-invalid' : ''; ?>" value="<?php echo $username ; ?>">
                        <span class="invalid-feedback"><b>😪 <?php echo $_err_ ;?></b></span>
                    </div>
                    
                    <div class="form-control mb-2">
                        <label class="label">
                            <span class="label-text"><i class="fa-solid fa-lock-open"></i> Password</span>
                        </label>
                        <input type="password" name="tenant-password" placeholder="Password" class="input input-bordered <?php echo (!empty($_err_)) ? 'is-invalid' : ''; ?>" value="<?php echo $password ; ?>">
                        <span class="invalid-feedback"><b>😪 <?php echo $_err_ ;?></b></span>
                        
                        <label class="label">
                            <a href="tenant-forgot-pw.php" class="label-text-alt link link-hover"><i class="fa-solid fa-circle-xmark" style="color: #e85b45;"></i> Forgot password?</a>
                        </label>
                    </div>
                    
                    <div class="form-control mt-6">
                        <button class="btn btn-warning" name="tenant-login" type="submit" >Login as Tenant</button>
                    </div>
                </form>
            </div>
        </div>
  </div>
</div>
</body>
</html>