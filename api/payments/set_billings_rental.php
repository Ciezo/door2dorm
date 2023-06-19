<?php
require("../../config.php");
require("../../vendor/autoload.php");
require("../../config_twilio.php");
require("../../services/email/sendEmail.php");

// Check if admin is logged in.
if (!isset($_SESSION["admin-username"])) {
    // If not logged in, then redirect to log-in page.
    header("../../views/error/error2.php");
}

// Check if the form is submitted through POST
if (isset($_POST["billings_rentals"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch all form values
    $tenant_id = $_POST["tenant_id"];
    $tenant_name = $_POST["tenant_fullName"];
    $tenant_phoneNum = $_POST["tenant_phoneNumber"];
    $tenant_email = $_POST["tenant_email"];
    $rental_charges = $_POST["rental_charges"];
    $rental_due_date = $_POST["rental_due_date"];
    $payment_status = $_POST["rental_payment_status"];
    $date_paid = date("d/M/Y");

    // We need to check first if there is an existing payment record
    $sql_payment_existing_record = "SELECT * FROM PAYMENTS_RENTAL WHERE tenant_id=$tenant_id";
    $check_existing_Results = mysqli_query($conn, $sql_payment_existing_record);

    if (mysqli_num_rows($check_existing_Results) <= 0) {
        // If returned null, then simply create a record
        $sql_create_payment_record = "INSERT INTO PAYMENTS_RENTAL (tenant_id, charges, payment_by, due_date, to_be_paid_by, date_paid, payment_status)
                                        VALUES 
                                            (
                                                '$tenant_id', 
                                                '$rental_charges',
                                                '$tenant_name',
                                                '$rental_due_date',
                                                '$tenant_name',
                                                '$date_paid',
                                                '$payment_status'
                                            )";

        if (mysqli_query($conn, $sql_create_payment_record)) {
            
            // Begin to notify the tenant through SMS
            try {
                // Twilio SMS Service parameters
                $twilio_acc_sid = getTwilio_AccountSID();
                $twilio_acc_token = getTwilio_AccountToken();
                $fromNumber = getTwilio_AccountPhoneNumber();
                $toNumber = $tenant_phoneNum; 

                $sms_msg = "Your monthly rental billings have been posted!\nCurrent Charges: ".$rental_charges."\n".
                            "Due Date: ".$rental_due_date."\n";

                $client = new Twilio\Rest\Client($twilio_acc_sid, $twilio_acc_token);
                $client->messages->create($toNumber, [
                    'from' => $fromNumber,
                    'body' => $sms_msg
                ]);
                
            } catch (ErrorException) {}

            // Begin to notify the tenant thru Email
            try {
                notifyThruEmail($tenant_name, $tenant_email, "Rental", $rental_charges, $rental_due_date, $payment_status);
            } catch (ErrorException) {}

            // Redirect to
            header("location: ../../views/admin/admin-payment.php");
        }

    }
    
    else {
        // Submit a query to set a payment record for rentals
        $sql = "UPDATE PAYMENTS_RENTAL SET 
                            tenant_id = '$tenant_id', 
                            charges = '$rental_charges',
                            payment_by = '$tenant_name', 
                            due_date = '$rental_due_date', 
                            to_be_paid_by = '$tenant_name', 
                            date_paid = '$date_paid', 
                            payment_status = '$payment_status' 
                            WHERE tenant_id = '$tenant_id'";
    
        if (mysqli_query($conn, $sql)) {

            // Begin to notify the tenant through SMS
            try {
                // Twilio SMS Service parameters
                $twilio_acc_sid = getTwilio_AccountSID();
                $twilio_acc_token = getTwilio_AccountToken();
                $fromNumber = getTwilio_AccountPhoneNumber();
                $toNumber = $tenant_phoneNum; 

                $sms_msg = "Your monthly rental billings have been updated!\nCurrent Charges: ".$rental_charges."\n".
                            "Due Date: ".$rental_due_date."\n";

                $client = new Twilio\Rest\Client($twilio_acc_sid, $twilio_acc_token);
                $client->messages->create($toNumber, [
                    'from' => $fromNumber,
                    'body' => $sms_msg
                ]);
                
            } catch (ErrorException) {}

            // Begin to notify the tenant thru Email
            try {
                notifyThruEmail($tenant_name." (Updates)", $tenant_email, "Rental", $rental_charges, $rental_due_date, $payment_status);
            } catch (ErrorException) {}

            // Redirect to
            header("location: ../../views/admin/admin-payment.php");
        }
    }
}


// Check if the payment is being marked as Paid
if (isset($_POST["mark-paid-rental"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $tenant_id = $_POST["tenant_id"];
    $tenant_name = $_POST["tenant_fullName"];
    $tenant_email = $_POST["tenant_email"];
    $electricity_charges = $_POST["electricity_charges"];
    $electricity_due_date = $_POST["electricity_due_date"];
    $tenant_phoneNum = $_POST["tenant_phoneNumber"];
    $get_current_date = date("d-m-Y"); 
    $_sql_update_payment_stat = "UPDATE PAYMENTS_RENTAL SET 
                                    payment_status = 'Paid',
                                    date_paid = '$get_current_date'
                                    WHERE tenant_id=$tenant_id";
                                    
    if (mysqli_query($conn, $_sql_update_payment_stat)) {

        // Begin to notify the tenant through SMS
        try {
            // Twilio SMS Service parameters
            $twilio_acc_sid = getTwilio_AccountSID();
            $twilio_acc_token = getTwilio_AccountToken();
            $fromNumber = getTwilio_AccountPhoneNumber();
            $toNumber = $tenant_phoneNum; 

            $sms_msg = "Your monthly rentals have been acknowledged!";

            $client = new Twilio\Rest\Client($twilio_acc_sid, $twilio_acc_token);
            $client->messages->create($toNumber, [
                'from' => $fromNumber,
                'body' => $sms_msg
            ]);
            
        } catch (ErrorException) {}

        // Begin to notify the tenant thru Email
        try {
            notifyThruEmail($tenant_name." (Paid Acknowledged)", $tenant_email, "Rental", $rental_charges, $rental_due_date, "Paid");
        } catch (ErrorException) {}

        // Redirect to
        header("location: ../../views/admin/admin-payment.php");
    }
}

?>