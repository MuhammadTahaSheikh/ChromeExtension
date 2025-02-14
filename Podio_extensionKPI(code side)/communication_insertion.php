<?php

require_once 'db_connection.php';

//                 ####################### When New Item is Created in Podio Start #######################

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $comm_id = $_POST['id'];
    $type = $_POST['type'];
    $created_at = $_POST['created_at'];
    $cid = $_POST['clients_id'];

// check for empty values and set defaults if necessary
    if (empty($comm_id)) {
        $comm_id = "";
    }
    if (empty($type)) {
        $type = "";
    }
    if (empty($created_at)) {
        $created_at = "";
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

    //                 ####################### Telemarketing Insertion Start #######################
    // Check if telemarketing item already exists in the database
        $sql = "SELECT * FROM `telemarketing` WHERE `comm_id` = ?";
        $stmt = $mysqli->prepare($sql);
        if (!$stmt) {
            echo "Error: (" . $mysqli->errno . ") " . $mysqli->error."\n";
        } else {
            // bind the values to the placeholders
            $stmt->bind_param("s", $comm_id);
            // execute the prepared statement
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    echo "Telemarketing item already exists in the database!"."\n";
                    $stmt->close();
                    return;
                }
            } else {
                echo "Error: (" . $stmt->errno . ")" . $stmt->error."\n";
                $stmt->close();
                return;
            }
            // close the statement
            $stmt->close();
        }
        // Insert telemarketing item into DB
        $sql = "INSERT INTO `telemarketing`(`comm_id`, `created_at`, `communication_type`, `clients_id`) VALUES (?, ?, ?, ?)";
        $stmt = $mysqli->prepare($sql);
        if (!$stmt) {
            echo "Error: (" . $mysqli->errno . ") " . $mysqli->error."\n";
        } else {
            // bind the values to the placeholders
            $stmt->bind_param("sssi", $comm_id, $created_at, $type, $cid);
            // execute the prepared statement
            if ($stmt->execute()) {
                echo "Telemarketing item is inserted!"."\n";
            } else {
                echo "Telemarketing item is not inserted!"."\n";
                echo 'Error: ('. $stmt->errno .')' . $stmt->error."\n";
            }

            // close the statement
            $stmt->close();
        }
    //                 ####################### Telemarketing Insertion End #######################
    }   
    else{
        echo "No active client found!"."\n";
        echo 'Error: ('. $stmt->errno .')' . $stmt->error."\n";
    }
}
//                 ####################### When New Item is Created in Podio End #######################