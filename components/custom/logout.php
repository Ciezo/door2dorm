<?php
session_destroy();
header("location: ../../views/index.php");
setcookie("admin_cookie_username", "", time() - 3600);
setcookie("admin_cookie_password", "", time() - 3600);
setcookie("resident_cookie_username", "", time() - 3600);
setcookie("resident_cookie_password", "", time() - 3600);

// unset cookies
if (isset($_SERVER['HTTP_COOKIE'])) {
    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
    foreach($cookies as $cookie) {
        $parts = explode('=', $cookie);
        $name = trim($parts[0]);
        setcookie($name, '', time()-1000);
        setcookie($name, '', time()-1000, '/');
    }
}
?>
  