<!-- 
    Filename: config.php
    Description: The remote database configuration at ClearDB MySQL Heroku. 
 -->

<?php
require 'vendor/autoload.php';

try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    // handle exception if the .env file is not found or readable
    echo 'Could not find or read the .env file: ' . $e->getMessage();
} catch (Dotenv\Exception\ValidationException $e) {
    // handle exception if validation fails for any of the environment variables
    echo 'Validation failed for one or more environment variables: ' . $e->getMessage();
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