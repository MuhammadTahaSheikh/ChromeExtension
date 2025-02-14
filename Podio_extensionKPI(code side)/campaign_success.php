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
    $cid = $_POST['clients_id'];
    $name = $_POST['campaign_name'];
    $leads = $_POST['leads'];
    $camp_id = $_POST['campaign_id'];

    // check for empty values and set defaults if necessary
    if (empty($cid)) {
        $cid = 0;
    }
    if (empty($name)) {
        $name = "";
    }
    if (empty($leads)) {
        $leads = 0;
    }
    if (empty($camp_id)) {
        $camp_id = 0;
    }

    $status = 'active';
    // Check if client exists in the database
    $sql = "SELECT * FROM `cleint` WHERE `clients_id` = ? AND `status` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("is", $cid, $status);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {

    //               ####################### Campaign Success Leads Section Start #######################
        // Check if the Campaign Success Leads already exists in the database
        $stmt = $mysqli->prepare("SELECT `id` FROM `campaign_success` WHERE `csu_id` = ?");
        $stmt->bind_param("s", $camp_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // If the Campaign Success Leads exists, update the record
        if ($result->num_rows > 0) {
            $sql = "UPDATE `campaign_success` SET `campaign_name`= ?, `campaign_leads`= `campaign_leads` + ? WHERE `csu_id` = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("sii", $name, $leads, $camp_id);
            if ($stmt->execute()) {
                echo "Campaign Success Leads Updated!"."\n";
            } else {
                echo "Campaign Success Leads Not Updated!"."\n";
                echo 'Error: ('. $stmt->errno .')' . $stmt->error."\n";
            }
        } else {
        // Insert campaign success leads into DB
        $sql = "INSERT INTO `campaign_success`(`csu_id`, `campaign_name`, `campaign_leads`, `clients_id`) VALUES (?, ?, ?, ?)";
        $stmt = $mysqli->prepare($sql);
        if (!$stmt) {
            echo "Error: (" . $mysqli->errno . ") " . $mysqli->error."\n";
        } else {
            // bind the values to the placeholders
            $stmt->bind_param("isii", $camp_id, $name, $leads, $cid);
            // execute the prepared statement
            if ($stmt->execute()) {
                echo "Campaign Success Leads Inserted!"."\n";
            } else {
                echo "Campaign Success Leads Not Inserted!"."\n";
                echo 'Error: ('. $stmt->errno .')' . $stmt->error."\n";
            }

            // close the statement
            $stmt->close();
        }
    }
    //                 ####################### Campaign Success Leads Section End #######################
    }    
    else{
        echo "No active client found!"."\n";
        echo 'Error: ('. $stmt->errno .')' . $stmt->error."\n";
    }
}

?>