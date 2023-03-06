<?php
    session_start();
    $cookie_tenant_username = $_SESSION["tenant-username"]; 
    $cookie_tenant_pw = $_SESSION["tenant-password"]; 

    // Set admin username cookies
    setcookie($cookie_tenant_username, $cookie_tenant_username, time() + (86400 * 30));
    setcookie($cookie_tenant_pw, $cookie_tenant_pw, time() + (86400 * 30));
?>