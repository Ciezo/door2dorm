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

// Load up ENV Vars for Twilio 
function getTwilio_AccountSID() { 
    /** @note return the account SID */
    try {
        $account_sid = $_ENV["ACC_SID_TWILIO"] ;
        return $account_sid;
        echo '
        <script>
            console.log("Returned SID");
        </script>';
    } catch (ErrorException) {}
}

function getTwilio_AccountToken() {
    /** @note return the token */ 
    try {
        $acc_token = $_ENV["AUTH_TOKEN_TWILIO"] ;
        return $acc_token; 
        echo '
        <script>
            console.log("Returned Token");
        </script>';
    } catch (ErrorException) {}
}

function getTwilio_AccountPhoneNumber() {
    /** @note return the virtual phone number */
    try {
        $acc_phoneNumber = "+".$_ENV["PHONE_NUM_TWILIO"] ;
        return $acc_phoneNumber;
        echo '
        <script>
            console.log("Returned Phone Number");
        </script>';
    } catch (ErrorException) {}
}
?>