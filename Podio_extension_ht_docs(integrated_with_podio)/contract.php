<?php

require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cid = $_POST['client_id'];
    $lead_id = $_POST['id'];
    $lead_status = $_POST['status'];
    $created_at = $_POST['created_at'];

    // check for empty values and set defaults if necessary
    if (empty($cid)) {
        $cid = 0;
    }
    if (empty($lead_id)) {
        $lead_id = 0;
    }
    if (empty($lead_status)) {
        $lead_status = "";
    }
    if (empty($created_at)) {
        $created_at = "";
    }

    $client_status = 'active';
    // Check if client exists in the database
    $sql = "SELECT * FROM `cleint` WHERE `clients_id` = ? AND `status` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("is", $cid, $client_status);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {

    //                 ####################### Contract Section Start #######################
        // Check if the Contract already exists in the database
        $stmt = $mysqli->prepare("SELECT `id` FROM `contracts` WHERE `lead_id` = ?");
        $stmt->bind_param("i", $lead_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // If the Contract exists, update the record
        if ($result->num_rows > 0 && ($lead_status == "sent" || $lead_status == "signed")) {
            $sql = "UPDATE `contracts` SET `status`= ? WHERE `lead_id` = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("si", $lead_status, $lead_id);
            if ($stmt->execute()) {
                echo "Contract Updated!"."\n";
            } else {
                echo "Contract Not Updated!"."\n";
                echo 'Error: ('. $stmt->errno .')' . $stmt->error."\n";
            }
        }  
        elseif ($result->num_rows > 0 && $lead_status == "lead") {
            $sql = "DELETE FROM `contracts` WHERE `lead_id` = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("i", $lead_id);
            if ($stmt->execute()) {
                echo "Contract Deleted!"."\n";
            } else {
                echo "Contract Not Deleted!"."\n";
                echo 'Error: ('. $stmt->errno .')' . $stmt->error."\n";
            }
        }  
        elseif ($result->num_rows <= 0 && $lead_status != "lead") {
            // Insert Contract into DB
            $sql = "INSERT INTO `contracts`(`status`, `client_id`, `lead_id`, `created_at`) VALUES (?, ?, ?, ?)";
            $stmt = $mysqli->prepare($sql);
            if (!$stmt) {
                echo "Error: (" . $mysqli->errno . ") " . $mysqli->error."\n";
            } else {
                // bind the values to the placeholders
                $stmt->bind_param("siis", $lead_status, $cid, $lead_id, $created_at);
                // execute the prepared statement
                if ($stmt->execute()) {
                    echo "Contract Inserted!"."\n";
                } else {
                    echo "Contract Not Inserted!"."\n";
                    echo 'Error: ('. $stmt->errno .')' . $stmt->error."\n";
                }
    
                // close the statement
                $stmt->close();
            }
        }
    //                 ####################### Contract Section End #######################

    }
    else{
        echo "No active client found!"."\n";
        echo 'Error: ('. $stmt->errno .')' . $stmt->error."\n";
    }
}

?>