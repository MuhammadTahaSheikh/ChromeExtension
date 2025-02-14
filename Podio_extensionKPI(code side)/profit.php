<?php

require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $deal_id = $_POST['deal_id'];
    $cid = $_POST['clients_id'];
    $amount = $_POST['profit'];
    $created_at = $_POST['created_at'];

    // check for empty values and set defaults if necessary
    if (empty($deal_id)) {
        $deal_id = 0;
    }
    if (empty($cid)) {
        $cid = 0;
    }
    if (empty($amount)) {
        $amount = 0;
    }
    if (empty($created_at)) {
        $created_at = "";
    }

    $status = 'active';
    // Check if client exists in the database
    $sql = "SELECT * FROM `cleint` WHERE `clients_id` = ? AND `status` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("is", $cid, $status);
    $stmt->execute();
    $result = $stmt->get_result();
        if ($result->num_rows > 0) {

        //                 ####################### Profit Section Start #######################
        // Check if the Profit already exists in the database
        $stmt = $mysqli->prepare("SELECT `id` FROM `profit_chart` WHERE  `deal_id` = ?");
        $stmt->bind_param("i", $deal_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // If the Profit exists, update the record
        if ($result->num_rows > 0) {
            $sql = "UPDATE `profit_chart` SET `profit`= ? WHERE `deal_id` = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("ii", $amount, $deal_id);
            if ($stmt->execute()) {
                echo "Profit Updated!"."\n";
            } else {
                echo "Profit Not Updated!"."\n";
                echo 'Error: ('. $stmt->errno .')' . $stmt->error."\n";
            }
        } else {
        // Insert expense into DB
        $sql = "INSERT INTO `profit_chart`(`deal_id`, `profit`, `created_at`, `clients_id`) VALUES (?, ?, ?, ?)";
        $stmt = $mysqli->prepare($sql);
            if (!$stmt) {
                echo "Error: (" . $mysqli->errno . ") " . $mysqli->error."\n";
            } else {
                // bind the values to the placeholders
                $stmt->bind_param("iisi", $deal_id, $amount, $created_at, $cid);
                // execute the prepared statement
                if ($stmt->execute()) {
                    echo "Profit Inserted!"."\n";
                } else {
                    echo "Profit Not Inserted!"."\n";
                    echo 'Error: ('. $stmt->errno .')' . $stmt->error."\n";
                }

                // close the statement
                $stmt->close();
            }
        }
        //                 ####################### Marketing Expense Section End #######################
    } 
    else{
        echo "No active client found!"."\n";
        echo 'Error: ('. $stmt->errno .')' . $stmt->error."\n";
    }
}


?>