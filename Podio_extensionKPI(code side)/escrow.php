<?php

require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cid = $_POST['client_id'];
    $deal_id = $_POST['deal_id'];
    $money = $_POST['escrow'];
    $int_money = intval(str_replace(',', '', $money));
    $created_at = $_POST['created_at'];

    // check for empty values and set defaults if necessary
    if (empty($cid)) {
        $cid = 0;
    }
    if (empty($deal_id)) {
        $deal_id = 0;
    }
    if (empty($money)) {
        $money = 0;
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

    //                 ####################### Escrow Section Start #######################
        // Check if the Escrow already exists in the database
        $stmt = $mysqli->prepare("SELECT `id` FROM `escrow` WHERE `deal_id` = ?");
        $stmt->bind_param("i", $deal_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // If the Escrow exists, update the record
        if ($result->num_rows > 0) {
            $sql = "UPDATE `escrow` SET `escrow_money`= ? WHERE `deal_id` = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("ii", $int_money, $deal_id);
            if ($stmt->execute()) {
                echo "Escrow Updated!"."\n";
            } else {
                echo "Escrow Not Updated!"."\n";
                echo 'Error: ('. $stmt->errno .')' . $stmt->error."\n";
            }
        } else {
            // Insert Escrow into DB
            $sql = "INSERT INTO `escrow`(`escrow_money`, `deal_id`, `client_id`, `created_at`) VALUES (?, ?, ?, ?)";
            $stmt = $mysqli->prepare($sql);
            if (!$stmt) {
                echo "Error: (" . $mysqli->errno . ") " . $mysqli->error."\n";
            } else {
                // bind the values to the placeholders
                $stmt->bind_param("iiis", $int_money, $deal_id, $cid, $created_at);
                // execute the prepared statement
                if ($stmt->execute()) {
                    echo "Escrow Inserted!"."\n";
                } else {
                    echo "Escrow Not Inserted!"."\n";
                    echo 'Error: ('. $stmt->errno .')' . $stmt->error."\n";
                }
    
                // close the statement
                $stmt->close();
            }
        }
    //                 ####################### Escrow Section End #######################

    }
    else{
        echo "No active client found!"."\n";
        echo 'Error: ('. $stmt->errno .')' . $stmt->error."\n";
    }
}

?>