<?php
// establish DB connection
include_once 'dbc_inc.php';

$yourID = $_GET['ID'];

// prepare a query to check username and password
$query = "SELECT * FROM notifications WHERE user_ID = ?";
if ($stmt = $conn->prepare($query)) {

  $stmt->bind_param("i", $yourID);

  $stmt->execute();

  $result = $stmt->get_result();

  // if no row exists
  if (!$result) {
    $error = "You are not logged in.";
    header("Location: ../auth/login.php?error=$error");
    exit();
  }
}


?>
