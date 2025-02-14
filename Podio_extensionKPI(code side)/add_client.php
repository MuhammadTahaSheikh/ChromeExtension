<?php

$user = 'root';
$password = 'root';
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

//                 ####################### When New Item is Created in Podio Start #######################

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cid = $_POST['clients_id'];
    $f_name = $_POST['first_name'];
    $l_name = $_POST['last_name'];
    $phone = $_POST['phone_num'];
    $email = $_POST['email'];
    $status = $_POST['status'];

// check for empty values and set defaults if necessary
    if (empty($cid)) {
        $cid = 0;
    }
    if (empty($f_name)) {
        $f_name = "";
    }
    if (empty($l_name)) {
        $l_name = "";
    }
    if (empty($phone)) {
        $phone = "";
    }
    if (empty($email)) {
        $email = "";
    }
    if (empty($status)) {
        $status = "";
    }
    if (!clientExist($mysqli, $cid, $email)) {
        saveClient($mysqli, $cid, $f_name, $l_name, $phone, $email, $status);
    }
}

//                 ####################### Client Section Start #######################

    function clientExist($con, $cid, $email): bool
    {
// Check if client already exists in the database
        try {
            $sql = "SELECT * FROM `cleint` WHERE `clients_id` = ? OR `email` = ?";
            $stmt = $con->prepare($sql);
            if (!$stmt) {
                echo "Error: (" . $con->errno . ") " . $con->error . "\n";
                return false;
            } else {
                // bind the values to the placeholders
                $stmt->bind_param("is", $cid, $email);
                // execute the prepared statement
                if ($stmt->execute()) {
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        echo "Client already exists in the database!" . "\n";
                        return true;
                    }
                } else {
                    echo "Error: (" . $stmt->errno . ")" . $stmt->error . "\n";
                    return false;
                }

            }
        } catch (Exception $e) {
            throw $e;
        } finally {
            // close the statement
            $stmt->close();
        }
        return false;
    }

    function saveClient($con, $cid, $f_name, $l_name, $phone, $email, $status): bool
    {
        try {
            // Insert client into DB
            $sql = "INSERT INTO `cleint`(`clients_id`, `first_name`, `last_name`, `phone_num`, `email`, `status`) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $con->prepare($sql);
            if (!$stmt) {
                echo "Error: (" . $con->errno . ") " . $con->error . "\n";
                return false;
            } else {
                // bind the values to the placeholders
                $stmt->bind_param("isssss", $cid, $f_name, $l_name, $phone, $email, $status);
                // execute the prepared statement
                if ($stmt->execute()) {
                    echo "Client Inserted!" . "\n";
                    return true;
                } else {
                    echo "Client Not Inserted!" . "\n";
                    echo 'Error: (' . $stmt->errno . ')' . $stmt->error . "\n";
                    return false;
                }
            }
        } catch (Exception $e) {
            throw $e;
        } finally {
            // close the statement
            $stmt->close();
        }
    }
//                 ####################### Client Section End #######################


//                 ####################### When New Item is Created in Podio End #######################