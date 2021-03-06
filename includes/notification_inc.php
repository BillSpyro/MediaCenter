<?php
// establish DB connection
include_once 'dbc_inc.php';

$yourID = $_GET['ID'];

// Grab notifications for the user
$query = "SELECT * FROM notifications WHERE user_ID = ? ORDER BY notification_time DESC";
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
