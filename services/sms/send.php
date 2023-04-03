<?php 
require("../../vendor/autoload.php");
require("../../config_twilio.php");


function create_SMS_and_send($toNumber, $messageBody) {
    /** This function can create an SMS message thru Twilio SMS REST API Client */

    // Twilio SMS Service parameters
    $twilio_acc_sid = getTwilio_AccountSID();
    $twilio_acc_token = getTwilio_AccountToken();
    $fromNumber = getTwilio_AccountPhoneNumber();

    try {
        $client = new Twilio\Rest\Client($twilio_acc_sid, $twilio_acc_token);
        $client->messages->create($toNumber, [
            'from' => $fromNumber,
            'body' => $messageBody
        ]);
        return "success";
    } catch (ErrorException) {return "fail";}
}
?>