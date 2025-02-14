<?php

$user = 'root';
$password = '';
$database = 'podio_extension';
$servername = 'localhost';

$mysqli = new mysqli(
    $servername,
    $user,
    $password,
    $database
);

if ($mysqli->connect_error) {
    die('Connect Error (' .
        $mysqli->connect_errno . ') ' .
        $mysqli->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cid = $_POST['client_id'];
    $appt_id = $_POST['appt_id'];
    $appt_title = $_POST['appt_title'];
    $appt_status = $_POST['appt_status'];
    $appt_datetime = $_POST['appt_datetime'];
    $status = 'active';

    // check for empty values and set defaults if necessary
    if (empty($cid)) {
        $cid = 0;
    }
    if (empty($appt_id)) {
        $appt_id = 0;
    }
    if (empty($appt_title)) {
        $appt_title = "";
    }
    if (empty($appt_status)) {
        $appt_status = "";
    }
    if (empty($appt_datetime)) {
        $appt_datetime = "";
    }

    // Check if client exists in the database
    $sql = "SELECT * FROM `cleint` WHERE `clients_id` = ? AND `status` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("is", $cid, $status);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {

    //                 ####################### Appointment Section Start #######################
        // Check if the appointment already exists in the database
        $stmt = $mysqli->prepare("SELECT au_id FROM appointments WHERE au_id = ?");
        $stmt->bind_param("i", $appt_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // If the appointment exists, update the record
        if ($result->num_rows > 0) {
            $sql = "UPDATE `appointments` SET `title`= ?,`date`= ?,`status`= ? WHERE `au_id` = ?";
            //$stmt = $mysqli->prepare("UPDATE appointments SET title = ?, date = ?, status = ? WHERE au_id = ?");
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("sssi", $appt_title, $appt_datetime, $appt_status, $appt_id);
            if ($stmt->execute()) {
                echo "Appointment Updated!"."\n";
            } else {
                echo "Appointment Not Updated!"."\n";
                echo 'Error: ('. $stmt->errno .')' . $stmt->error."\n";
            }
        } else {
            echo 'Error: ('. $stmt->errno .')' . $stmt->error." No Appointment Found!"."\n";
        }
    //                 ####################### Appointment Section End #######################

    }
    else{
        echo "No active client found!"."\n";
        echo 'Error: ('. $stmt->errno .')' . $stmt->error."\n";
    }
}

?>