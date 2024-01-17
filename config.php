<?php
require 'vendor/autoload.php';

try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    // handle exception if the .env file is not found or readable
    // echo 'Could not find or read the .env file: ' . $e->getMessage();
} catch (Dotenv\Exception\ValidationException $e) {
    // handle exception if validation fails for any of the environment variables
    // echo 'Validation failed for one or more environment variables: ' . $e->getMessage();
}

$host = $_ENV["DB_HOST"];
$user = $_ENV["DB_USER"];
$password = $_ENV["DB_PASS"];
// Auto-generated credentials by ClearDB MySQL database at Heroku
$database = $_ENV["DB_SCHEMA"];

// database link connection
$conn = new mysqli($host, $user, $password, $database);


// /** Establish connection with error checking */
if ($conn->connect_error) {
    die("Error connecting".$conn->connect_error);
}

else {

}

$host_bk = $_ENV["DB_HOST_BK"];
$user_bk = $_ENV["DB_USER_BK"];
$pass_bk = $_ENV["DB_PASS_BK"];
$schema_bk = $_ENV["DB_SCHEMA_BK"];
        
// Init connection_bk 
$conn_bk = new mysqli($host_bk, $user_bk, $pass_bk, $schema_bk);
    if ($conn_bk->connect_error) {
        die("Error connecting".$conn_bk->connect_error);
    }

    else {

    }
?>