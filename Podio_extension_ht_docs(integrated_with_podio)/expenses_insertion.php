<?php

require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $camp_id = $_POST['camp_id'];
    $cid = $_POST['clients_id'];
    $name = $_POST['month_name'];
    $year = $_POST['year'];
    $amount = $_POST['amount'];

    // check for empty values and set defaults if necessary
    if (empty($camp_id)) {
        $camp_id = 0;
    }
    if (empty($cid)) {
        $cid = 0;
    }
    if (empty($name)) {
        $name = "";
    }
    if (empty($year)) {
        $year = 0;
    }
    if (empty($amount)) {
        $amount = 0;
    }

    $name = explode(",", $name);
    $year = explode(",", $year);
    $amount = explode(",", $amount);

//                 ####################### Marketing Expense Section Start #######################
    for($index = 0; $index < count($name); $index++){
        // Check if the Marketing Expense already exists in the database
        $stmt = $mysqli->prepare("SELECT `id` FROM `marketing_expense` WHERE `monthname` = ? AND `year` = ? AND `campaign_id` = ?");
        $stmt->bind_param("sii", $name[$index], $year[$index], $camp_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // If the Marketing Expense exists, update the record
        if ($result->num_rows > 0) {
            $sql = "UPDATE `marketing_expense` SET `amount`= ? WHERE `monthname` = ? AND `year` = ? AND `campaign_id` = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("isii", $amount[$index], $name[$index], $year[$index], $camp_id);
            if ($stmt->execute()) {
                echo "Expense Updated!"."\n";
            } else {
                echo "Expense Not Updated!"."\n";
                echo 'Error: ('. $stmt->errno .')' . $stmt->error."\n";
            }
        } else {
        // Insert expense into DB
        $sql = "INSERT INTO `marketing_expense`(`campaign_id`, `monthname`, `year`, `amount`, `clients_id`) VALUES (?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($sql);
        if (!$stmt) {
            echo "Error: (" . $mysqli->errno . ") " . $mysqli->error."\n";
        } else {
            // bind the values to the placeholders
            $stmt->bind_param("isiii", $camp_id, $name[$index], $year[$index], $amount[$index], $cid);
            // execute the prepared statement
            if ($stmt->execute()) {
                echo "Expense Inserted!"."\n";
            } else {
                echo "Expense Not Inserted!"."\n";
                echo 'Error: ('. $stmt->errno .')' . $stmt->error."\n";
            }

            // close the statement
            $stmt->close();
        }
    }
}
//                 ####################### Marketing Expense Section End #######################
}
?>