<?php

require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $cid = $_POST['client_id'];
    $appt_id = $_POST['appt_id'];
    $appt_title = $_POST['appt_title'];
    $appt_status = $_POST['appt_status'];
    $appt_datetime = $_POST['appt_datetime'];
    $lead_id = $_POST['lead_id'];
    
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
    if (empty($lead_id)) {
        $lead_id = NULL;
    }

    if (clientExist($mysqli, $cid)) {
        if (apptExist($mysqli, $appt_id)) {   // If the appointment exists, update the record
            apptUpdate($mysqli, $appt_title, $appt_datetime, $appt_status, $appt_id, $lead_id);
        }
        elseif (!apptExist($mysqli, $appt_id)) {  // If the appointment does not exists, create a new the record
            apptSave($mysqli, $appt_id, $appt_title, $appt_datetime, $appt_status, $cid, $lead_id);
        }
    }
    else {
        echo "No active client found!"."\n";
    }
}

function clientExist($mysqli, $cid) : bool
{
    try{
        $sql = "SELECT * FROM `client` WHERE `clients_id` = ?";
            $stmt = $mysqli->prepare($sql);
            if (!$stmt) {
                echo "Error: (" . $mysqli->errno . ") " . $mysqli->error . "\n";
                return false;
            } else {
                // bind the values to the placeholders
                $stmt->bind_param("i", $cid);
                // execute the prepared statement
                if ($stmt->execute()) {
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        // echo "Client already exists in the database!" . "\n";
                        return true;
                    }
                } else {
                    echo "Error: (" . $stmt->errno . ")" . $stmt->error . "\n";
                    return false;
                }
            }
    }
    catch (Exception $e){
        throw $e;        
    }
    finally{
        // close the statement
        $stmt->close();
    }
    return false;
}

function apptExist($mysqli, $appt_id) : bool
{
    try {
        $stmt = $mysqli->prepare("SELECT au_id FROM appointments WHERE au_id = ?");
        $stmt->bind_param("i", $appt_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return true;
        } else {
            echo 'Error: ('. $stmt->errno .')' . $stmt->error." No Appointment Found!"."\n";
            return false;
        }
    }
    catch (Exception $e){
        throw $e;
    }
    finally {
        // close the statement
        $stmt->close();
    }
    return false;
}

function apptUpdate($mysqli, $appt_title, $appt_datetime, $appt_status, $appt_id, $lead_id) : bool
{
    try {
        // Update Appointment query
        $sql = "UPDATE `appointments` SET `title`= ?,`date`= ?,`status`= ?, `lead_id` = ? WHERE `au_id` = ?";
        $stmt = $mysqli->prepare($sql);
        if (!$stmt) {
            echo "Error: (" . $mysqli->errno . ") " . $mysqli->error . "\n";
            return false;
        } else {
            // bind the values to the placeholders
            $stmt->bind_param("sssii", $appt_title, $appt_datetime, $appt_status, $lead_id, $appt_id);
            // execute the prepared statement
            if ($stmt->execute()) {
                echo "Appointment Updated!"."\n";
                return true;
            } else {
                echo "Appointment Not Updated!"."\n";
                echo 'Error: ('. $stmt->errno .')' . $stmt->error."\n";
                return false;
            }
        }
    }
    catch (Exception $e) {
        throw $e;
    }
}

function apptSave($mysqli, $appt_id, $appt_title, $appt_datetime, $appt_status, $cid, $lead_id) : bool
{
    try {
        // Insert Appointment query
        $sql = "INSERT INTO appointments (`au_id`, `title`, `date`, `status`, `clients_id`, `lead_id`) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($sql);
        
        if (!$stmt) {
            echo "Error: (" . $mysqli->errno . ") " . $mysqli->error . "\n";
            return false;
        } else {
            // bind the values to the placeholders
            $stmt->bind_param("isssii", $appt_id, $appt_title, $appt_datetime, $appt_status, $cid, $lead_id);
            // execute the prepared statement
            if ($stmt->execute()) {
                echo "Appointment Inserted!"."\n";
                return true;
            } else {
                echo "Appointment Not Inserted!"."\n";
                echo 'Error: ('. $stmt->errno .')' . $stmt->error."\n";
                return false;
            }
        }
    }
    catch (Exception $e) {
        throw $e;
    }
}

?>