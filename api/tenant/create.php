<?php
require("../../config.php");
session_start(); 

// Check if admin is logged in.
if (!isset($_SESSION["admin-username"])) {
    // If not logged in, then redirect to error page
    header("location: ../../views/error/error.php");
}

// Retrieve the CONSTANT key
if ($_SESSION["register-tenant"] = "SET_TENANT_ENTITY") {
    
    // Fetch all SESSION VARIABLES
    $tenant_fullName = $_SESSION["tenant-FullName"];
    $tenant_number = $_SESSION["tenant-number"];
    $tenant_emergencyNumber = $_SESSION["tenant-emergencyNumber"];
    $tenant_email = $_SESSION["tenant-email"];
    $tenant_username = $_SESSION["tenant-username"];
    $tenant_password = $_SESSION["tenant-password"];
    $tenant_assignRoom = $_SESSION["tenant-assignRoom"];
    $tenant_lease_start = $_SESSION["tenant-lease-start"];
    $tenant_lease_end = $_SESSION["tenant-lease-end"];
    $tenant_photo = $_SESSION["tenant-photo"];

    // Load up the Tenant Model 
    require("../../model/Tenant.php");

    $tenant = new Tenant($tenant_fullName, $tenant_number, $tenant_emergencyNumber, $tenant_email, $tenant_username, $tenant_password, $tenant_assignRoom, $tenant_lease_start, $tenant_lease_end);
    
    // Prepare the parameters
    $param_tenant_FName = $tenant->getFullName();
    $param_tenant_Num = $tenant->getContactNum();
    $param_tenant_EmergNum = $tenant->getEmergencyContactNum();
    $param_tenant_Email = $tenant->getEmail();
    $param_tenant_Username = $tenant->getUserName();
    $param_tenant_Password = $tenant->getPassword();
    $param_tenant_Room = $tenant->getAssignedRoom();
    $param_tenant_lease_start = $tenant->getLeaseStart();
    $param_tenant_lease_end = $tenant->getLeaseEnd();

    // Now, create an INSERT SQL query 
    $sql = "INSERT INTO TENANT(full_name, mobile_num, username, email, password, emergency_contact_num, room_assign, tenant_photo, lease_start, lease_end) 
            VALUES
            (
                '$param_tenant_FName',
                '$param_tenant_Num',
                '$param_tenant_Username',
                '$param_tenant_Email',
                '$param_tenant_Password',
                $param_tenant_EmergNum, 
                '$param_tenant_Room', 
                '$tenant_photo',
                '$param_tenant_lease_start',
                '$param_tenant_lease_end'
            )";

    if (mysqli_query($conn, $sql)) {
        // Redirect to Tenants page
        header("location: ../../views/admin/admin-tenants.php");
    }
    $conn->close();
}
?>
