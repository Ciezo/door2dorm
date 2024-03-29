<?php
require("../config.php");
session_start(); 

/**
 * @note Create a token based interaction to send a request to the local PHP api
 */
// Initialize a session token upon loading
$_SESSION["user-request-token"] = "";
date_default_timezone_set('Asia/Manila');
$request_date_taken = date("d/m/Y");
$request_token = "req-user-".rand(10,100).$request_date_taken;
// Assign the request token to the specified declared SESSION variable
$_SESSION["user-request-token"] = $request_token;

/** @todo Set form validation for visitor */
// Values to retrieve
$visitor_fullName = $visit_purpose = $visitor_contact = $visit_date = $visit_time = $visitor_ID = "";
$_err_visitor_fullName = $_err_visitor_contact = $_err_visit_purpose = $_err_visit_date = $_err_visit_time = $_err_visitor_ID = "";

// Check if form is submitted 
if (isset($_POST["confirm-booking"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    /**
     * Input validation
     * @note values to retrieve: 
     *  name="visitor-full-name"
     *  name="visitor-purpose"
     *  name="visitor-contact"
     *  name="visitor-date"
     *  name="visitor-time"
     *  name="visitor"
     */

    // Validate name
    $input_full_name = trim($_POST["visitor-full-name"]);
    if (empty($input_full_name)) {
        $_err_visitor_fullName = "Please, enter your full name!";
    }

    else if (!filter_var($input_full_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/"))) || preg_match("/[-!$%^&*()_+|~=`{}\[\]:\";'<>?,.\/]/", $input_full_name)) {
        $_err_visitor_fullName = "Special characters such as periods, commas, hyphens are not allowed. Examples: [-!$%^&*()_+|~=`{}\[\]:";
    }

    else if (!filter_var($input_full_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))) {
        $_err_visitor_fullName = "Please, enter a valid name full name!";
    }

    else {
        $visitor_fullName = $input_full_name; 
    }



    // Validate visit purpose
    $input_visit_purpose = trim($_POST["visitor-purpose"]);
    if (empty($input_visit_purpose)) {
        $_err_visit_purpose = "Please, write your visiting purpose";
    }

    else if (!filter_var($input_visit_purpose, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z0-9\s]+$/"))) || preg_match("/[-!$%^&*()_+|~=`{}\[\]:\";'<>?,.\/]/", $input_visit_purpose)) {
        $_err_visit_purpose = "Special characters such as periods, commas, hyphens are not allowed. Examples: [-!$%^&*()_+|~=`{}\[\]:";
    }

    else if (!filter_var($input_visit_purpose, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z0-9\s]+$/")))) {
        $_err_visit_purpose = "Special characters such as periods, commas, hyphens are not allowed. Examples: [-!$%^&*()_+|~=`{}\[\]:";
    }

    else {
        $visit_purpose = $input_visit_purpose; 
    }



    // Validate contact number
    $input_contact_num = trim($_POST["visitor-contact"]);
    if (empty($input_contact_num)) {
        $_err_visitor_contact = "Please, provide your mobile number!";
    }

    else if (!filter_var($input_contact_num, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z0-9\s+]+$/"))) || preg_match("/[-!$%^&*()_|~=`{}\[\]:\";'<>?,.\/]/", $input_contact_num)) {
        $_err_visitor_contact = "Special characters such as periods, commas, hyphens are not allowed. Examples: [-!$%^&*()_+|~=`{}\[\]:";
    }
    
    else {
        $visitor_contact = $input_contact_num; 
    }

    

    // Validate date
    $input_visit_date = trim($_POST["visitor-date"]); 
    $temp_date = date("Y-m-d");
    if (empty($input_visit_date)) {
        $_err_visit_date = "Please, pick a scheduled date!";
    } 
    
    else if ($input_visit_date < $temp_date) {
        $_err_visit_date = "Invalid date!";
    }

    else {
        $visit_date = $input_visit_date; 
    }



    // Validate time
    $input_visit_time = trim($_POST["visitor-time"]); 
    if (empty($input_visit_time)) {
        $_err_visit_time = "Please, pick a scheduled time!";
    } 
    else {
        $visit_time = $input_visit_time; 
    }



    // Validate uploaded ID photo
    // If there is an uploaded file, check if it exceeds 5 MB
    if (isset($_FILES["visitor-ID"])) {
        if ($_FILES["visitor-ID"]["size"] > 5242880) {
            $_err_visitor_ID = "Less than 5 MB only!";
        }
        // Now, assign the temporary path to the expected variable
        $temp_path = addslashes(file_get_contents($_FILES["visitor-ID"]["tmp_name"]));
        $visitor_ID = $temp_path; 
    }

    // If all values are correct. And error variables are empty 
    // @todo set SESSION variables and request to API/visitor/create 
    if (empty($_err_visitor_fullName) && empty($_err_visit_purpose) && (empty($_err_visitor_contact)) &&
            empty($_err_visit_date) && empty($_err_visit_time) && empty($_err_visitor_ID)) {
                
                // Set SESSION VARIABLES
                $_SESSION["public-request"] = "SET_VISITOR_ENTITY";
                $_SESSION["visitor-FullName"] = $visitor_fullName; 
                $_SESSION["visitor-purpose"] = $visit_purpose; 
                $_SESSION["visitor-contact"] = $visitor_contact;
                $_SESSION["visitor-picked-date"] = $visit_date; 
                $_SESSION["visitor-picked-time"] = $visit_time; 
                $_SESSION["visitor-uploaded-ID"] = $temp_path; 

                // Send form data to request the local API
                header("location: ../api/visitor/create.php");
    }
}


?>

<!DOCTYPE html>
<html data-theme="light" lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Door2Dorm Home</title>

     <!-- Bootstrap from https://getbootstrap.com/ -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/c36559a51c.js" crossorigin="anonymous"></script>

    <!-- CSS Global theming and styles -->
    <link href="../css/globals.css" rel="stylesheet">

    <!-- Loading screen animation -->
    <link href="../css/loading.css" rel="stylesheet">   
    
    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.1.1/dist/full.css" rel="stylesheet" type="text/css" />
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
        .navbar .navbar-brand {
            padding-left: 35px;
        }
        .rooms-avail-table {
            padding-bottom: 50px;
        }
        .rooms-avail-table table {
            margin-top: 22px;
        }
        table tr td {
            width: auto;
        }
        .card {
            margin-bottom: 100px;
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
            <div class="navbar-nav px-2">
                <a class="nav-item nav-link active px-2" href="#">Home <span class="sr-only">(current)</span></a>
                <a class="nav-item nav-link px-2" href="tenant/tenant-login.php">Tenant</a>
                <a class="nav-item nav-link px-2" href="admin/admin-login.php">Admin</a>
                <b><a class="nav-item nav-link px-2" href="#sched-book-visit" style="color:yellow;"><i class="fa-solid fa-book-bookmark"></i> Book Now!</a></b>
            </div>
        </div>
    </nav>

    <!-- Content Wrapper -->
    <div class="container">
        <div id="loadingDiv"><img src="../assets/images/Rolling-1s-200px.gif" alt="Loading screen"></div>
        <!-- <h1>List Of Available Rooms</h1> -->
        <header class="bg-gray-800 text-white pb-4 mb-2 rounded-lg">
            <div class="container mx-auto px-4 flex justify-center">
                <h1 class="text-3xl font-bold">List of available rooms:</h1>
            </div>
        </header>

        <!-- @todo List of available rooms displayed in a grid -->
        <div class="card">
            <div class="rooms-avail-table mt-2">
                <div class="container">
                    <div class="w-full flex flex-wrap justify-center" id="periodic-refresh-5secs">
                        <!-- Rooms content are displayed as cards -->  
                    </div>
                </div>
            </div>
        </div>
 
        <div id="sched-book-visit" class="request-visit max-w-lg mx-auto p-6 bg-white rounded shadow-md mb-4">
            <h1 class="text-2xl font-bold mb-6">Schedule Visits</h1>
            <!-- Fill up form for a visitor -->
            <form action="landing_page.php" method="POST" enctype="multipart/form-data">
                <!-- Visitor full name -->
                <div class="form-group">
                    <label for="Full name of visitor">Full Name</label>
                    <input type="text" name="visitor-full-name" id="fetch_fullName" placeholder="My full name" class="form-control <?php echo (!empty($_err_visitor_fullName)) ? 'is-invalid' : ''; ?>" value="<?php echo $visitor_fullName ; ?>">
                    <span class="invalid-feedback"><?php echo $_err_visitor_fullName ;?></span>
                </div>
                <br>
                <!-- Visitor purpose -->
                <div class="form-group">
                    <label for="Full name of visitor">Purpose of visit</label>
                    <input type="text" name="visitor-purpose" id="fetch_visitPurpose" placeholder="Write here your visiting reasons" class="form-control <?php echo (!empty($_err_visit_purpose)) ? 'is-invalid' : ''; ?>" value="<?php echo $visit_purpose ; ?>">
                    <span class="invalid-feedback"><?php echo $_err_visit_purpose ;?></span>
                </div>
                <br>
                <!-- Visitor contact number -->
                <div class="form-group">
                    <label for="Contact Number of Visitor">Contact Number</label>
                    <input type="text" name="visitor-contact" id="fetch_visitContact" placeholder="+639000000000" class="form-control <?php echo (!empty($_err_visitor_contact)) ? 'is-invalid' : ''; ?>" value="<?php echo $visitor_contact ; ?>">
                    <span class="invalid-feedback"><?php echo $_err_visitor_contact ;?></span>
                </div>
                <br>
                <!-- Visitor pick date -->
                <div class="form-group">
                    <label for="Full name of visitor">Pick a date</label>
                    <input type="date" name="visitor-date" id="fetch_visitDate" class="form-control <?php echo (!empty($_err_visit_date)) ? 'is-invalid' : ''; ?>" value="<?php echo $visit_date ; ?>">
                    <span class="invalid-feedback"><?php echo $_err_visit_date ;?></span>
                </div>
                <br>
                <!-- Visitor pick time -->
                <div class="form-group">
                    <label for="Full name of visitor">Pick a time</label>
                    <input type="time" name="visitor-time" id="fetch_visitTime" placeholder="" class="form-control">
                    <span class="invalid-feedback"><?php echo $_err_visit_time ;?></span>
                </div>
                <br>
                <!-- Visitor ID upload -->
                <div class="form-group">
                    <label for="Upload a photo">Upload a photo of your valid ID</label>
                    <input type="file" id="fetch_photo" name="visitor-ID" class="form-control" required>
                    <div class="card px-5 mt-2 mb-2">
                        <h5>Preview</h5>
                        <img id="previewImage" class="card-img-top mb-2" width="600" height="auto">
                        <script>
                            const fetchFileInput = document.getElementById("fetch_photo");
                            const renderImgModal = document.getElementById("previewImage");
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

                    <span class="invalid-feedback"></span>
                    <span class="invalid-feedback"><?php echo $_err_visitor_ID ;?></span>
                </div>
                <br>
                <!-- Submit form, and trigger modal -->
                <div class="form-group">
                    <!-- <input type="button" name="schedule-visit-submit-form" data-toggle="modal" data-target="#previewBookingDetails" onclick="submitForm()" class="btn btn-warning w-full" value="Book now!"> -->
                    <input type="button" class="btn w-full mb-2" onclick="previewBookingDetails.showModal(); renderVisitForm()" value="Preview"></input>
                    <input type="submit" name="confirm-booking" class="btn btn-warning w-full mb-2" value="Confirm Booking">
                </div>
            </form>
        </div>
    </div>

    <!-- Tailwind Modal -->
    <!-- @note
        I have no idea how to properly trigger this that can submit the form using the confirm-booking button.
        The modal can be triggered.
        The IDs can be edited as well
        The problem is that I cannot submit and parse the form.
    -->
    <dialog id="previewBookingDetails" class="modal">
        <form method="dialog" class="modal-box">
            <div class="card" style="width: 100%;">
                <img class="card-img-top" alt="" align="center" id="modal_preview_VisitorID" width="50%" height="50%">
                <script>
                    const fileFetchInput = document.getElementById("fetch_photo");
                    const renderPreviewImgOnSubmit = document.getElementById("modal_preview_VisitorID");
                    fileFetchInput.addEventListener("change", function() {
                        const file = fileFetchInput.files[0];
                        const reader = new FileReader();
                        reader.addEventListener("load", function() {
                            renderPreviewImgOnSubmit.src = reader.result;
                        });
                        if (file) {
                            reader.readAsDataURL(file);
                        }
                    });
                </script>
                <div class="card-header" id="modal_preview_VisitorFullName"></div>
                <div class="card-body">
                    <p id="modal_preview_visitPurpose"></p>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item" id="modal_preview_VisitDate"></li>
                        <li class="list-group-item" id="modal_preview_VisitTime"></li>
                        <li class="list-group-item" id="modal_preview_VisitContact"></li>
                    </ul>
                </div>
            </div>

            <div class="modal-action">
                <!-- <input type="submit" name="confirm-booking" class="btn" value="Confirm Booking"> -->
                <button class="btn">Close</button>
            </div>
        </form>
    </dialog>
    <!-- Script file to dynamic load and refresh list of available rooms -->
    <script type="text/javascript" src="../js/dynamic-load-AvailableRooms.js"></script>

    <script>
    function renderVisitForm() {
        var full_name = document.getElementById("fetch_fullName").value;
        var visit_purpose = document.getElementById("fetch_visitPurpose").value;
        var visit_contact = document.getElementById("fetch_visitContact").value;
        var visit_time = document.getElementById("fetch_visitTime").value;
        var visit_date = document.getElementById("fetch_visitDate").value;

        document.getElementById("modal_preview_VisitorFullName").innerHTML = full_name;
        document.getElementById("modal_preview_visitPurpose").innerHTML = "<b>My Visiting Purpose:</b><br>" + visit_purpose;
        document.getElementById("modal_preview_VisitDate").innerHTML = "<b>Scheduled at: </b>" + visit_date;
        document.getElementById("modal_preview_VisitTime").innerHTML = "<b>On: </b>" + visit_time;
        document.getElementById("modal_preview_VisitContact").innerHTML = "<b>Contact No.: </b>" + visit_contact;
    }
    </script>
</body>
</html>