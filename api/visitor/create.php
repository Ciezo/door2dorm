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

    // Load up the Visitor Model template
    require("../../model/Visitor.php");

    $visitor = new Visitor($visitor_full_name, $visit_purpose, $visitor_contact, $visit_date, $visit_time, $visitor_ID_photo);

    // Prepare object params
    $param_visitor_Fname = $visitor->getFullName();
    $param_visitor_purpose = $visitor->getVisitPurpose();
    $param_visitor_contactNum = $visitor->getContactNum();
    $param_visitor_visitDate = $visitor->getVisitingDate();
    $param_visitor_visitTime = $visitor->getVisitingTime();
    $param_visitor_ID = $visitor->getVisitorValidID();

    // Create an SQL insert statement
    $sql = "INSERT INTO VISITOR(full_name, contact_no, visit_purpose, time_visit, date_visit, id_visitor_photo) 
            VALUES
                (
                    '$param_visitor_Fname',
                    '$param_visitor_contactNum',
                    '$param_visitor_purpose',
                    '$param_visitor_visitTime',
                    '$param_visitor_visitDate',
                    '$param_visitor_ID'
                )";

    // Once query executes, 
    if (mysqli_query($conn, $sql)) {
        // Redirect to home page
        header("location: ../../views/landing_page.php");
    }
    $conn->close();
}
?>
