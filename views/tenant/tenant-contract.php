<?php
require("../../config.php");
session_start(); 
// Check if tenant is logged in.
if (!isset($_SESSION["tenant-username"])) {
    // If not logged in, then redirect to log-in page.
    header("location: tenant-login.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-contract</title>

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
            padding-bottom: 50px;
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
                <a class="nav-item nav-link px-2 active" href="#"><i class="fa-solid fa-circle-user"></i> My Account </span></a>
                <a class="nav-item nav-link px-2" href="tenant-payment.php">Payment </span></a>
                <a class="nav-item nav-link px-2" href="tenant-securityLogs.php">Security Logs </span></a>
                <a class="nav-item nav-link px-2" href="tenant-messages.php">Message </span></a>
                <a class="nav-item nav-link px-2" href="../../components/custom/logout.php">Logout </span></a>
            </div>
        </div>
    </nav>

    <!-- Content goes here -->
    <div class="container">
        <div class="e-contract">
            <h2>RENTAL AGREEMENT</h2>
            <label><?php echo $_SESSION["tenant-Fname"] ?> and Landlord</label>
            <br>
            <hr>
            <div class="card px-3">
                <h4><b>PARTIES</b></h4>
                <p>
                    - This Rental Agreement (hereinafter referred to as the <b>"Agreement"</b>) is entered into on ___________ (the <b>"Effective Date"</b>), by and between ___________, with an address of
                    ___________, with an address of (hereinafter referred to as the <b>"Renter"</b>) and (hereinafter referred to as the <b>"Landlord"</b>) (collectively referred to as the <b>"Parties"</b>).
                </p>
                <br>
                <h4><b>CONSIDERATION</b></h4>
                <p>
                    - The Renter hereby agrees to pay the Landlord the amount of money mentioned in this Agreement to lease the property owned by the Landlord.
                </p>
                <br>
                <h4><b>TERM</b></h4>
                <p>
                    - (Option 1) This Agreement shall be effective on the date of signing this Agreement (hereinafter referred to as the "Effective Date") and will end on ___________ <br>
                    - (Option 2) Upon the end of the term of the Agreement, this Agreement will not be automatically renewed for a new term. <br>
                </p>
                <br>
                <h4><b>PREMISES, USE AND OCCUPANCY</b></h4>
                <p>
                    - The premises that are to be rented by the Landlord are located at (address) <br>
                    - The premises are to be used only for residential purposes and may be occupied only by the registered occupants. <br>
                </p>
                <br>
                <h4><b>COSTS AND PAYMENT</b></h4>
                <p>
                    - The monthly rent to be paid by the Renter to the Landlord is ___________________. It is to be
                    paid by the Renter before the first day of every month, such that the first rent payment is due
                    on __________________. <br>
                    
                    - The method of payment preferred by both parties is ______________________. <br>
                    - In the event of late payments made by the Renter, the Landlord is entitled to impose a ______________ fine as late fee. <br>
                    - Prior to taking occupancy of the premises, the Renter will pay the Landlord an amount of ____________ as a security deposit to cover the cost of any damages suffered by the premises and cleaning. 
                    Such security deposit will be returned to the Renter upon the end of this Agreement, provided the premises are left in the same condition as prior to the occupancy. <br>
                </p>
            </div>
        </div>
    </div>
</body>
</html>