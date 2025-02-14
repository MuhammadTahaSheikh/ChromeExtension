<?php
$client_id = $_POST['client_id'];

// Fetch the value from the database based on the client_id
// ...your database code here...

if ($client_id) {
  echo 1;
} else {
  echo 02;
}
?>