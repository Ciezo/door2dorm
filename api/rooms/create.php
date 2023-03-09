<?php
require("../../config.php");
session_start(); 
// Check if admin is logged in.
if (!isset($_SESSION["admin-username"])) {
    // If not logged in, then redirect to error page
    header("location: ../../views/error/error.php");
}

// Define variables and initialize with empty values
$room_number = $room_type  = $room_category = $gender_assign = $room_details = $pricing = $num_Of_occupants = $occupy_status = "";
$_err_room_number = $_err_room_type = $_err_room_category = $_err_gender_assign = $_err_room_details = $_err_pricing = $_err_num_Of_occupants = $_err_occupy_status = "";

// Begin retrieving the form values submitted
/** Implement sanitization and input validation */
  /**
     * @note 
     * for the <select> fields 
     * always retrive the selected value after POST
     */

// Check if form is submitted 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate room number
    $input_room_number = trim($_POST["room-number"]);
    if (empty($input_room_number)) {
        $_err_room_number = "Please, enter a room/unit number!"; 
    } 

    else if (!ctype_digit($input_room_number)) {
        $_err_room_number = "Please, enter a valid room/unit number!";
    }
    
    else if ($input_room_number <= -100 || $input_room_number <= 0) {
        $_err_room_number = "Please, positive value to assign a room/unit number!!";
    }

    else {
        $room_number =  $input_room_number;
    }



    // Validate room type
    $input_room_type = trim($_POST["room-type"]);
    if (empty($input_room_type)) {
        $room_type = $input_room_type; 
    }
    else {
        $room_type = $input_room_type; 
    }



    // Validate room category
    $input_room_category = trim($_POST["room-category"]);
    if (empty($input_room_category)) {
        $room_category = $input_room_category; 
    }
    else { 
        $room_category = $input_room_category; 
    }



    // Validate Room gender
    $input_room_gender = trim($_POST["room-gender"]); 
    if (empty($input_room_gender)) {
        $gender_assign = $input_room_gender; 
    }
    else { 
        $gender_assign = $input_room_gender;  
    }



    // Validate room details
    $input_room_details = trim($_POST["room-details"]);
    if (empty($input_room_details)) {
        $_err_room_details = "Please, write a short description about the unit/room";
    }
    else {
        $room_details = $input_room_details; 
    }



    // Validate pricing
    $input_room_pricing = trim($_POST["room-pricing"]); 
    if (empty($input_room_pricing)) {
        $_err_pricing = "Please, enter a value for pricing!"; 
    } 
    
    else if (!ctype_digit($input_room_number)) {
        $_err_pricing = "Please, enter a valid number to set pricing!"; 
    }
    
    else if ($input_room_pricing <= -100 || $input_room_pricing <= 0) {
        $_err_room_number = "Please, positive value to assign a room/unit number!!";
    }

    else {
        $pricing = $input_room_pricing;     
    }



    // Validate number of occupants
    $input_num_occupants = trim($_POST["number-occupants"]);
    if (empty($input_num_occupants)) {
        $_err_num_Of_occupants = "Please, enter a value for the number of occupants!"; 
    } 
    
    else if (!ctype_digit($input_num_occupants)) {
        $_err_num_Of_occupants = "Please, enter a valid number for the number of occupants"; 
    }
    
    else if ($input_num_occupants <= -100 || $input_num_occupants <= 0) {
        $_err_num_Of_occupants = "Please, enter a valid number for the number of occupants";
    }

    else {
        $num_Of_occupants = $input_num_occupants; 
    }



    // Validate occupancy status
    $input_occupy_status = trim($_POST["occupy_status"]); 
    if (empty($input_occupy_status)) {
        $occupy_status = $input_occupy_status;
    }
    
    else {
        $occupy_status = $input_occupy_status;
    }



    // Validate uploaded photo 
    /** Submit the chosen photo -
     * @todo Begin file validation and ensure that it is no longer than 5 MB */
    if (isset($_FILES["file_photo_upload"])) {
        if ($_FILES["file_photo_upload"]["size"] > 500000) {
            $_err_file_size = "Less than 5 MB only!";
        }
        $image_to_upload = addslashes(file_get_contents($_FILES["file_photo_upload"]["tmp_name"]));
    }

    /**
     * @todo Begin MySQL Query using this api to interface to the database
     */
    // Check if all error variables are empty 
    // $_err_room_number = $_err_room_type = $_err_room_category = $_err_gender_assign = $_err_room_details = $_err_pricing = $_err_num_Of_occupants = $_err_occupy_status = "";
    if (empty($_err_room_number) && empty($_err_room_type) && empty($_err_room_category) && empty($_err_room_details) 
        && empty($_err_gender_assign) && empty($_err_pricing) && empty($_err_num_Of_occupants) && empty($_err_occupy_status)) {

            // Load up the model 
            include("../../model/Rooms.php");
            // __construct($room_num, $room_type, $room_category, $gender_assigned, $room_details, $pricing, $number_of_occupants, $occupancy_status)  
            $room = new Rooms($room_number, $room_type, $room_category, $gender_assign, 
                            $room_details, $pricing, $num_Of_occupants, $occupy_status);

            // Create parameters for the SQL statement
            $param_roomNum = $room->getRoomNum();
            $param_roomType = $room->getRoomType();
            $param_roomCateg = $room->getRoomCategory();
            $param_assignGender = $room->getGenderAssigned();
            $param_roomDetails = $room->getRoomDetails();
            $param_roomPrice = $room->getRoomPricing();
            $param_numOfOccupants = $room->getNumOfOccupants();
            $param_occupy_status = $room->getOccupancyStatus();

            // Create an INSERT statement
            $sql = "INSERT INTO AVAILABLE_ROOMS (room_number, room_type, room_category, gender_assign, details, pricing, num_of_occupants, occupancy_status, room_photo) 
                    VALUES('$param_roomNum', '$param_roomType', '$param_roomCateg', '$param_assignGender', '$param_roomDetails', '$param_roomPrice', '$param_numOfOccupants', '$param_occupy_status', '$image_to_upload')";

            // Once the query executes, redirect to admin home page
            if (mysqli_query($conn, $sql)) {
                header("location: ../../views/admin/admin-home.php");
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
    <title>Setting Room/Unit Availability </title>

    <!-- Bootstrap from https://getbootstrap.com/ -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/c36559a51c.js" crossorigin="anonymous"></script>

    <!-- CSS Global theming and styles -->
    <link href="../../css/globals.css" rel="stylesheet">

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
                <a class="nav-item nav-link active" href="../../views/admin/admin-home.php">Home <span class="sr-only"></span></a>
                <a class="nav-item nav-link" href="../../views/admin/admin-payment.php">Payment</a>
                <a class="nav-item nav-link" href="../../views/admin/admin-tenants.php">Tenants</a>
                <a class="nav-item nav-link" href="../../views/admin/admin-securityLogs.php">Security Logs</a>
                <a class="nav-item nav-link" href="../../views/admin/admin-facenet.php">FaceNet</a>
                <a class="nav-item nav-link" href="../../views/admin/admin-messages.php">Messages</a>
                <a class="nav-item nav-link logout" href="../../components/custom/logout.php">Logut</a>
            </div>
        </div>
    </nav>

    <!-- Content goes here -->
    <div class="wrapper">
        <h2>Setup an available unit or room</h2>
        <p><i>Using this page you can list available units or rooms for visitors and tenants to see</i></p>
        <hr><br>
        <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="POST" enctype="multipart/form-data">
            <!-- Room or Unit number || name="room-number"-->
            <div class="form-group">
                <label for="Room/Unit Number">Room or Unit Number</label>
                <input type="text" name="room-number" placeholder="000" class="form-control <?php echo (!empty($_err_room_number)) ? 'is-invalid' : ''; ?>" value="<?php echo $room_number ; ?>">
                <span class="invalid-feedback"><?php echo $_err_room_number ;?></span>
            </div>
            <br>
            <!-- Room Type || name="room-type"-->
            <div class="form-group">
                <label for="Selecting a Room type">Select a room type</label>
                <select class="form-control" name="room-type" id="" required="">
                    <option value="Single">Single</option>
                    <option value="Double">Double</option>
                    <option value="Triple">Triple</option>
                    <option value="Quad">Quad</option>
                    <option value="Studio">Studio</option>
                </select>
            </div>
            <br>
            <!-- Room Category || name="room-category" -->
            <div class="form-group">
                <label for="Selecting a Room Category">Select room category</label>
                <select class="form-control" name="room-category" id="" required="">
                    <option value="With Airconditiong Unit">With Airconditiong Unit</option>
                    <option value="Without Airconditiong Unit">Without Airconditiong Unit</option>
                    <option value="With Electric Fans">With Electric Fans</option>
                    <option value="Without Electric Fans">Without Electric Fans</option>
                </select>
            </div>
            <br>
            <!-- Gender to assign || name="room-gender"-->
            <div class="form-group">
                <label for="Assigning Genders">Assign genders to occupy the room</label>
                <select class="form-control" name="room-gender" id="" required="">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Mix">Mix</option>
                </select>
            </div>
            <br>
            <!-- Room Details || name="room-details"-->
            <div class="form-group">
                <label for="Writing unit description">Give a description for room details</label>
                <textarea name="room-details" placeholder="Write a short description about the unit" rows="5" class="form-control <?php echo (!empty($_err_room_details)) ? 'is-invalid' : ''; ?>"><?php echo $room_details; ?></textarea>
                <span class="invalid-feedback"><?php echo $_err_room_details ;?></span>
            </div>
            <br>
            <!-- Pricing || name="room-pricing"-->
            <div class="form-group">
                <label for="Setting Monthly Prices">Set Monthtly Pricing</label>
                <textarea name="room-pricing" placeholder="Php 0.00" rows="1" class="form-control <?php echo (!empty($_err_pricing)) ? 'is-invalid' : ''; ?>"><?php echo $pricing; ?></textarea>
                <span class="invalid-feedback"><?php echo $_err_pricing ;?></span>
            </div>
            <br>
            <!-- Number of occupants || name="number-occupants" -->
            <div class="form-group">
                <label>Set number of occupants</label>
                <textarea name="number-occupants" placeholder="0" rows="1" class="form-control <?php echo (!empty($_err_num_Of_occupants)) ? 'is-invalid' : ''; ?>"><?php echo $num_Of_occupants; ?></textarea>
                <span class="invalid-feedback"><?php echo $_err_num_Of_occupants ;?></span>
            </div>
            <br>
            <!-- Occupancy Status || name="occupy_status" -->
            <div class="form-group">
                <label for="Setting status of room (available or taken)">Set Occupancy Status</label>
                <select class="form-control" name="occupy_status" id="" required="">
                    <option value="Available">Available</option>
                    <option value="Taken">Taken</option>
                </select>
            </div>
            <br>
            <!-- Room Photo -->
            <div class="form-group">
                <label for="Upload a photo">Upload a photo of the unit</label>
                <input type="file" class="form-control" name="file_photo_upload">
                <span class="invalid-feedback"><?php echo $_err_file_size ;?></span>
            </div>
            <br><br>
            <!-- Submit form -->
            <input type="submit" name="post-room-form" class="btn btn-outline-success" value="Post">
            <!-- Back/Cancel button -->
            <a href="../../views/admin/admin-home.php" class="btn btn-outline-danger">Cancel</a>
        </form>
    </div>
</body>
</html>