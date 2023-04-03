<?php 
require("../../vendor/autoload.php");
require("../../config_twilio.php");

// Twilio SMS Service parameters
$twilio_acc_sid = getTwilio_AccountSID();
$twilio_acc_token = getTwilio_AccountToken();
$fromNumber = getTwilio_AccountPhoneNumber();



if (isset($_POST["send_sms"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    // Get all form values 
    $toNumber = trim($_POST["toNumber"]);
    $toNumber = "+".$toNumber;
    $sms_msg = trim($_POST["sms_msg"], "\n");
    
    try {
        $client = new Twilio\Rest\Client($twilio_acc_sid, $twilio_acc_token);
        $client->messages->create($toNumber, [
            'from' => $fromNumber,
            'body' => $sms_msg
        ]);
        
        echo "Message has been sent!"."\t\t\t\n\n";
    } catch (ErrorException) {}
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test SMS Service</title>
</head>
<body>
    <form action="testSMS.php" method="POST">
        <!-- Receiver of SMS -->
        <label for="To Number">Number</label>
        <input type="number" name="toNumber" placeholder="+639000000000">
        <br>
        <!-- Message Body -->
        <label for="Message Body">Message Body</label><br>
        <textarea name="sms_msg" id="" cols="30" rows="10" placeholder="Write your message here"></textarea><br><br>
        <input type="submit" value="Send SMS" name="send_sms">
    </form>
</body>
</html>