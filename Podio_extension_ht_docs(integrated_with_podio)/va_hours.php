<?php

require_once 'db_connection.php';

//                 ####################### When User Timed Out in Podio Start #######################

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $report_id = $_POST['report_id'];
    $va_name = $_POST['va_name'];
    $created_at = $_POST['created_at'];
    $time_in = $_POST['time_in'];
    $time_out = $_POST['time_out'];
    $duration = $_POST['duration'];
    $cid = $_POST['clients_id'];

    // check for empty values and set defaults if necessary
    if (empty($report_id)) {
        $report_id = 0;
    }
    if (empty($va_name)) {
        $va_name = "";
    }
    if (empty($created_at)) {
        $created_at = "";
    }
    if (empty($time_in)) {
        $time_in = "";
    }
    if (empty($time_out)) {
        $time_out = "";
    }
    if (empty($duration)) {
        $duration = "";
    }
    if (empty($cid)) {
        $cid = 0;
    }

    $status = 'active';
    // Check if client exists in the database
    $sql = "SELECT * FROM `cleint` WHERE `clients_id` = ? AND `status` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("is", $cid, $status);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {

        //               ####################### VA Hours Section Start #######################
        // Check if the VA Hours already exists in the database
        $stmt = $mysqli->prepare("SELECT `id` FROM `va_hours` WHERE `report_id` = ?");
        $stmt->bind_param("s", $report_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // If the VA Hours exists, update the record
        if ($result->num_rows > 0) {
            $sql = "UPDATE `va_hours` SET `name`= ?, `time-in`= ?, `time-out`= ?, `working_hours`= ? WHERE `report_id` = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("sssii", $va_name, $time_in, $time_out, $duration, $report_id);
            if ($stmt->execute()) {
                echo "VA Hours Updated!"."\n";
            } else {
                echo "VA Hours Not Updated!"."\n";
                echo 'Error: ('. $stmt->errno .')' . $stmt->error."\n";
            }
        } else {
            // Insert VA Hours into DB
            $sql = "INSERT INTO `va_hours`(`report_id`, `name`, `created_at`, `time-in`, `time-out`, `working_hours`, `clients_id`) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $mysqli->prepare($sql);
            if (!$stmt) {
                echo "Error: (" . $mysqli->errno . ") " . $mysqli->error."\n";
            } 
            else {
                // bind the values to the placeholders
                $stmt->bind_param("issssii", $report_id, $va_name, $created_at, $time_in, $time_out, $duration, $cid);
                // execute the prepared statement
                if ($stmt->execute()) {
                    echo "VA Hours Inserted!"."\n";
                } else {
                    echo "VA Hours Not Inserted!"."\n";
                    echo 'Error: ('. $stmt->errno .')' . $stmt->error."\n";
                }

                // close the statement
                $stmt->close();
            }
        }
    //                 ####################### VA Hours Section End #######################
    } 
    else{
        echo "No active client found!"."\n";
        echo 'Error: ('. $stmt->errno .')' . $stmt->error."\n";
    }
}

//                 ####################### When User Timed Out in Podio End #######################