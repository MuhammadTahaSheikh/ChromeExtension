<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

// establish database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "updated_podio_extension";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the sent value from the $_POST superglobal
    $client_id = $_POST['client_id'];
    $client_url = $_POST['page_url'];
    
    
   







// $sql ="SELECT c.id AS company_id FROM companies c JOIN client_companies cc ON c.id = cc.company_id JOIN clients cl ON cc.client_id = cl.id WHERE c.id = $client_id AND c.`url` ='$client_url'";
$sql = "SELECT c.id AS company_id
FROM clients cl
JOIN client_companies cc ON cl.id = cc.client_id
JOIN companies c ON cc.company_id = c.id
WHERE cl.id = '$client_id' AND c.`url` ='$client_url'";

// ==============================================================================================================================================================================================================
  //  $sql = "SELECT * FROM cleint WHERE clients_id = $client_id";

    $result = mysqli_query($conn, $sql);
  
    if (mysqli_num_rows($result) > 0) {

        echo 1;
       
    } else {
        echo 0;
    }
} else {
    http_response_code(405);
    echo 'Invalid request method';
}

// Close database connection
mysqli_close($conn);
