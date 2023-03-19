<?php
require("../../config.php");
session_start(); 
// Check if tenant is logged in.
if (!isset($_SESSION["tenant-username"]) || !isset($_SESSION["admin-username"])) {
    // If not logged in, then redirect to log-in page.
    header("location: ../../views/error/error2.php");
}

require("../../views/sessions/tenant_session_vars.php");
$tenant_id = fetch_TenantSessionVars("tenant-id");
$tenant_name = fetch_TenantSessionVars("tenant-Fname");

// Values to retrieve 
$msg_subj = $msg_body = ""; 

/** Check if form is submitted validation */
if (isset($_POST["send-msg"]) && $_SERVER["REQUEST_METHOD"] == "POST") {

    $msg_subj = trim($_POST["msg-subj"]);
    $msg_body = trim($_POST["msg-body"], "\n\t\r");
    
    // Create a query to insert the message to database
    $sql = "INSERT INTO MESSAGES(msg_type, msg_body, sent_by, tenant_id) 
            VALUES
            (
                '$msg_subj',
                '$msg_body',
                '$tenant_name',
                '$tenant_id'
            )";

    // Execute the query 
    if (mysqli_query($conn, $sql)) {
        // Redirect to tenant messages page
        header("location: ../../views/tenant/tenant-messages.php");
    }
}
?>