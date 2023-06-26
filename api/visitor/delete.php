<?php
require("../../config.php");
session_start(); 
// Check if admin is logged in.
if (!isset($_SESSION["admin-username"])) {
    // If not logged in, then redirect to error page
    header("location: ../../views/error/error.php");
}

// Begin fetching the id of a record 
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];

    /**
     * Get the values for archiving
     */
    $name = $_POST["name"];
    $mobile_num = $_POST["mobile_num"];
    $purpose = $_POST["purpose"];
    $date = $_POST["date"];
    $time = $_POST["time"];

    $archive_visitor = "INSERT INTO VISITOR(full_name, contact_no, visit_purpose, time_visit, date_visit) 
            VALUES
            (
                '$name',
                '$mobile_num',
                '$purpose',
                '$time',
                '$date'
            )";
    // Archive the guest profile before redirect
    mysqli_query($conn_bk, $archive_visitor);

    // Create an sQL Delete statement
    $sql = "DELETE FROM VISITOR WHERE visitor_id = $id";

    // Begin executing the query 
    if (mysqli_query($conn, $sql)) {
        // Once, the record is deleted redirect to news feed
        header("location: ../../views/admin/admin-home.php");
        exit();
    }

    // Close connection
    $conn->close();
}

// If the id is not fetched or non-existent. Extract it from the URL
else {
    // Try fetching id, and...
    if(empty(trim($_GET["id"]))){
        // And if the ID is empty 
        // Get URL parameter for extraction
        $id =  trim($_GET["id"]);
        $name = $_GET["name"];
        $mobile_num = $_GET["mobile_num"];
        $purpose = $_GET["purpose"];
        $date = $_GET["date"];
        $time = $_GET["time"];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Visitor</title>

    <!-- Bootstrap from https://getbootstrap.com/ -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/c36559a51c.js" crossorigin="anonymous"></script>

    <!-- CSS Global theming and styles -->
    <link href="../../css/globals.css" rel="stylesheet">

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
                <a class="nav-item nav-link active px-2" href="../../views/admin/admin-home.php">Home <span class="sr-only"></span></a>
                <a class="nav-item nav-link px-2" href="../../views/admin/admin-payment.php">Payment</a>
                <a class="nav-item nav-link px-2" href="../../views/admin/admin-tenants.php">Tenants</a>
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
        <h2>Delete this visitor?</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="alert alert-danger">
                <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>"/>
                <input type="hidden" name="name" value="<?php echo trim($_GET["name"]); ?>"/>
                <input type="hidden" name="mobile_num" value="<?php echo trim($_GET["mobile_num"]); ?>"/>
                <input type="hidden" name="purpose" value="<?php echo trim($_GET["purpose"]); ?>"/>
                <input type="hidden" name="date" value="<?php echo trim($_GET["date"]); ?>"/>
                <input type="hidden" name="time" value="<?php echo trim($_GET["time"]); ?>"/>
                <p>Upon deletion. This record cannot be retrieved. Please, proceed with caution</p>
                <p><b>This guest profile will be archived for security purposes.</b></p>
                <p>
                    <input type="submit" value="Confirm" class="btn btn-danger">
                    <a class="btn btn-secondary ml-2" href="../../views/admin/admin-home.php">Cancel</a>
                </p>
            </div>
        </form>
    </div>
</body>
</html>