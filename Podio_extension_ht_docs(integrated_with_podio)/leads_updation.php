<?php

require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lead_id = $_POST['id'];
    $type = $_POST['type'];
    $created_at = $_POST['created_at'];
    $temp = $_POST['temperature'];
    $cid = $_POST['clients_id'];
    $drip = $_POST['leads_under_drip'];
    // $appt_data = $_POST['appt_data'];

    // check for empty values and set defaults if necessary
    if (empty($lead_id)) {
        $lead_id = 0;
    }
    if (empty($type)) {
        $type = "";
    }
    if (empty($created_at)) {
        $created_at = "";
    }
    if (empty($temp)) {
        $temp = "";
    }
    if (empty($cid)) {
        $cid = 0;
    }
    if (empty($drip)) {
        $drip = 0;
    }

    $status = 'active';
    // Check if client exists in the database
    $sql = "SELECT * FROM `cleint` WHERE `clients_id` = ? AND `status` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("is", $cid, $status);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {

        // check if a record already exists for the given lead_id
        $sql = "SELECT * FROM `leads` WHERE `lu_id` = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('i', $lead_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // a record already exists, update it
            $sql = "UPDATE `leads` SET `type`= ?,`temperature`= ?,`leads_under_drip`= ? WHERE `lu_id` = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param('ssii', $type, $temp, $drip, $lead_id);
            $stmt->execute();
            echo "Lead is updated!"."\n";
        } else {
            // no record found, create a new one
            //                 ####################### Lead Insertion Start #######################

            // prepare the SQL query with placeholders for the values
            $sql = "INSERT INTO `leads`(`lu_id`, `type`, `created_at`, `temperature`, `clients_id`, `leads_under_drip`) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $mysqli->prepare($sql);

            // bind the values to the placeholders
            $stmt->bind_param("isssii", $lead_id, $type, $created_at, $temp, $cid, $drip);

            // execute the prepared statement
            if ($stmt->execute()) {
                echo "Lead Inserted!"."\n";
                // exit();
            } else {
                echo "Lead Not Inserted!"."\n";
                echo 'Error: ('. $stmt->errno .')' . $stmt->error."\n";
            }

            // close the statement
            $stmt->close();

        //                 ####################### Lead Insertion End #######################

        //                 ####################### Appointment Section Start #######################

            // if($appt_data != ""){
            //     $appt_data = json_decode($appt_data, true);
            //     foreach($appt_data as $val){
            //         $data = json_decode($val, true);
            //         $appt_id = $data['appt_id'];
            //         $appt_title = $data['appt_title'];
            //         $appt_status = $data['appt_status'];
            //         $appt_datetime = $data['appt_datetime'];

            //         // Check if the appointment already exists in the database
            //         $stmt = $mysqli->prepare("SELECT au_id FROM appointments WHERE au_id = ?");
            //         $stmt->bind_param("i", $appt_id);
            //         $stmt->execute();
            //         $result = $stmt->get_result();
                    
            //         // If the appointment exists, update the record; otherwise, create a new record
            //         if ($result->num_rows > 0) {
            //             $stmt = $mysqli->prepare("UPDATE appointments SET `title` = ?, `date` = ?, `status` = ? WHERE `au_id` = ?");
            //             $stmt->bind_param("sssi", $appt_title, $appt_datetime, $appt_status, $appt_id);
            //             echo "Appointment Updated!"."\n";
            //         } else {
            //             $stmt = $mysqli->prepare("INSERT INTO appointments (`au_id`, `title`, `date`, `status`, `clients_id`) VALUES (?, ?, ?, ?, ?)");
            //             $stmt->bind_param("isssi", $appt_id, $appt_title, $appt_datetime, $appt_status, $cid);
            //         }        
            //         if (!$stmt) {
            //             echo "Error: (" . $mysqli->errno . ") " . $mysqli->error."\n";
            //         } else {
            //             if ($stmt->execute()) {
            //                 echo "Appointment Saved!"."\n";
            //             } else {
            //                 echo "Appointment Not Saved!"."\n";
            //                 echo 'Error: ('. $stmt->errno .')' . $stmt->error."\n";
            //             }

            //             $stmt->close();
            //         }
            //     }
            // }
    //                 ####################### Appointment Section End #######################

        }
    }  
    else{
        echo "No active client found!"."\n";
        echo 'Error: ('. $stmt->errno .')' . $stmt->error."\n";
    }
}

?>