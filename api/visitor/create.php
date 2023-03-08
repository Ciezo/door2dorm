<?php
require("../../config.php");
session_start(); 
// Check if a user has proper session to make requests to the local API
if (!isset($_SESSION["user-request-token"])) {
    // If not logged in, then redirect to error page
    header("location: ../../views/error/error.php");
}

// Retrieve the particular CONSTANT STRING key
if ($_SESSION["public-request"] = "SET_VISITOR_ENTITY") {

    // Fetch all SESSION variables and assign
    $visitor_full_name = $_SESSION["visitor-FullName"];
    $visit_purpose = $_SESSION["visitor-purpose"];
    $visitor_contact = $_SESSION["visitor-contact"];
    $visit_date = $_SESSION["visitor-picked-date"];
    $visit_time = $_SESSION["visitor-picked-time"];
    $visitor_ID_photo = $_SESSION["visitor-uploaded-ID"];

    // Create an SQL insert statement
    $sql = "INSERT INTO VISITOR(full_name, contact_no, visit_purpose, time_visit, date_visit, id_visitor_photo) 
            VALUES
                (
                    '$visitor_full_name',
                    '$visitor_contact',
                    '$visit_purpose',
                    '$visit_time',
                    '$visit_date',
                    '$visitor_ID_photo'
                )";

    // Once query executes, 
    if (mysqli_query($conn, $sql)) {
        // Redirect to home page
        header("location: ../../views/landing_page.php");
    }
    $conn->close();
}
?>
