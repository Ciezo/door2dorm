<!-- 
    Filename: config.php
    Description: The remote database configuration at ClearDB MySQL Heroku. 
 -->

<?php
require 'vendor/autoload.php';

try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
    echo '<script>';
    echo    'console.log("ENVIRONMENT VARIABLES LOADED!")';
    echo '</script>';
} catch (Dotenv\Exception\InvalidPathException $e) {
    // handle exception if the .env file is not found or readable
    // echo 'Could not find or read the .env file: ' . $e->getMessage();
    echo '<script>';
    echo    'console.log("Could not find or read the .env file: ")'.$e->getMessage();
    echo '</script>';
} catch (Dotenv\Exception\ValidationException $e) {
    // handle exception if validation fails for any of the environment variables
    // echo 'Validation failed for one or more environment variables: ' . $e->getMessage();
    echo '<script>';
    echo    'console.log("Validation failed for one or more environment variables: ")'.$e->getMessage();
    echo '</script>';
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
    echo '
    <script>
        console.log("Could not establish connection to Heroku or EXCEEDED MAXIMUM CONNECTIONS!");
    </script>'; 
    die("Error connecting".$conn->connect_error);
}

else {
    echo '
    <script>
        console.log("Connection SUCCESSFUL!");
    </script>'; 
}
?>