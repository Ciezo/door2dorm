<?php
    session_start();
    $cookie_admin_username = $_SESSION["admin-username"]; 
    $cookie_admin_pw = $_SESSION["admin-password"]; 

    // Set admin username cookies
    setcookie($cookie_admin_username, $cookie_admin_username, time() + (86400 * 30));
    setcookie($cookie_admin_pw, $cookie_admin_pw, time() + (86400 * 30));
?>