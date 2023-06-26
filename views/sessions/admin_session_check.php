<?php
session_start();
// Verify if admin is logged in
// Now, validated if credentials are right
if (isset($_SESSION["admin-username"]) && isset($_SESSION["admin-password"])) {
        // Set cookies for admin
        setcookie("admin_cookie_username", $_SESSION["admin-username"], time() + (86400 * 30));
        setcookie("admin_cookie_password", $_SESSION["admin-password"], time() + (86400 * 30));
        header("location: ../admin/admin-home.php");
        exit();
    }

    else {
        header("location: ../error/error.php");
        exit();
    }
?>