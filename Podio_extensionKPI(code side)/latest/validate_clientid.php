<?php


// establish database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "360synergydb";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
if (!empty($_POST)) {
    echo $_POST['Client_id'];
    $id = $_POST['Client_id'];

// build the SQL query with the $id variable
//  $id = $_POST['Client_id'];
// $sql = "SELECT * FROM leads WHERE Cleints_id =  1";
 $sql = "SELECT * FROM leads WHERE Cleints_id = " . $id;

// execute the query
$result = mysqli_query($conn, $sql);

// check if any rows were returned
if (mysqli_num_rows($result) > 0) {
    // loop through the result set and display each row
    // return 1;
    echo " results found.";
} else {
    // return 0;
    echo "No results found.";
}
}
// close database connection
mysqli_close($conn);
