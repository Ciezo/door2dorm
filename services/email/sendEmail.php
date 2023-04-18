<?php
require("../../config.php");
session_start(); 

// Prepare the PHPMailer Service
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load up Composer autoloader
require '../../vendor/autoload.php';

// Now, create an instance of the PHP Mailer

try {
    function notifyThruEmail($subjectName, $toEmail, $billType, $charges, $dueDate, $paymentStatus) {
        $mail = new PHPMailer(true); 
        //Server settings
        $mail->isSMTP();                                                        //Send using SMTP
        $mail->Host       = 'smtp.gmail.com.';                                  //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                               //Enable SMTP authentication
        $mail->Username   = 'noreplydoordorm.service@gmail.com';                //SMTP username
        $mail->Password   = 'ddmpcedxpgxouksn';                                 //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;                     //Enable implicit TLS encryption
        $mail->Port       = 587;                                                //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
        //Recipients
        /**
         * List of working domains
         * 1. @gmail.com
         * 2. @yahoo.com
         * 3. @mymail (outlook)
         */
        $mail->setFrom('noreplydoordorm.service@gmail.com');                    // my gmail (sender)
    
        $mail->addAddress($toEmail);                                  // receiver email             
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Door2Dorm - Billings for '.$subjectName;
        $mail->Body    = '<h2>Your have been posted! </h2>
                            <table border="1">
                                <thead>
                                    <tr>
                                        <th scope="col">Bill Type</th>
                                        <th scope="col">Charges</th>
                                        <th scope="col">Due Date</th>
                                        <th scope="col">Payment status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <td>'.$billType.'</td>
                                    <td>'.$charges.'</td>
                                    <td>'.$dueDate.'</td>
                                    <td>'.$paymentStatus.'</td>
                                </tbody>
                            </table>
                            <b>You are kindly reminded to pay on time!</b>
                        ';
    
        $mail->send();
    }     
} 

catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

?>