<?php

function getMessages_byGeneral() {
    require("../../config.php");

    // Create a query to select all messages based on General type 
    $sql = "SELECT * FROM MESSAGES WHERE msg_type='General'";
    $messages = mysqli_query($conn, $sql);

    return $messages;
}

function getMessages_byRepairs() {
    require("../../config.php");

    // Create a query to select all messages based on Repairs type 
    $sql = "SELECT * FROM MESSAGES WHERE msg_type='Repairs'";
    $messages = mysqli_query($conn, $sql);

    return $messages;
}

function getMessages_byFeedback() {
    require("../../config.php");

    // Create a query to select all messages based on Feedback type 
    $sql = "SELECT * FROM MESSAGES WHERE msg_type='Feedback'";
    $messages = mysqli_query($conn, $sql);

    return $messages;
}

function getMessages_byReports() {
    require("../../config.php");

    // Create a query to select all messages based on Report type 
    $sql = "SELECT * FROM MESSAGES WHERE msg_type='Report'";
    $messages = mysqli_query($conn, $sql);

    return $messages;
}
?>