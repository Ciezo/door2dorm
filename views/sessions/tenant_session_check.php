<?php
session_start();
// Verify if a tenant is logged in
// Now, validated if credentials are right
if (isset($_SESSION["tenant-username"])) {
    if (isset($_SESSION["tenant-password"])) {
        // Set cookies for tenant or resident
        setcookie("tenant_cookie_username", $_SESSION["tenant-username"], time() + (86400 * 30));
        setcookie("tenant_cookie_password", $_SESSION["tenant-password"], time() + (86400 * 30));
        header("location: ../tenant/tenant-home.php");
        exit();
    }
}

else {
    header("location: ../error/error.php");
    exit();
}

?>