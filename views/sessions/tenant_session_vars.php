<?php
function set_TenantSessionVars($key, $value) {
    $_SESSION[$key] = $value;
} 

function fetch_TenantSessionVars($key) {
    return $_SESSION[$key];
}
?>