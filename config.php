<!-- 
    Filename: config.php
    Description: The remote database configuration at ClearDB MySQL Heroku. 
 -->

<?php
// Auto-generated credentials by ClearDB MySQL database at Heroku
$host = "us-cdbr-east-06.cleardb.net"; 
$user = "bd22e71ea9fc1e";
$password = "34602037";
$database = "heroku_5388512170af7bf";

// database link connection
$conn = new mysqli($host, $user, $password, $database);


/** Establish connection with error checking */
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