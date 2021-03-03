<?php
// establish DB connection
include_once 'dbc_inc.php';

$yourID = $_SESSION['id'];

// prepare a query to check username and password
$query = "SELECT * FROM users, profile WHERE users.id = profile.user_ID and users.id != ?";
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

$query = "SELECT * FROM friends WHERE user_ID = ? or friend_ID = ?";
if ($stmt = $conn->prepare($query)) {

  $stmt->bind_param("ss", $yourID, $yourID);

  $stmt->execute();

  $result2 = $stmt->get_result();
}

//Send Friend Request
if (isset($_GET['friend_ID'])){
  $friend_ID = $_GET['friend_ID'];

  $query = "SELECT * FROM friends WHERE user_ID = ? and friend_ID = ?";
  if ($stmt = $conn->prepare($query)) {

    $stmt->bind_param("ii", $yourID, $friend_ID);

    $stmt->execute();

    $result3 = $stmt->get_result();
}
    // if a row exists
    if ($result3) {
      $error = "You are already friends with them or have already sent a request.";
      header("Location: ../profile/people.php?error=$error");
      exit();
    } else {
      $query = "INSERT INTO friends (user_ID, friend_ID) VALUES (?,?)";
      if ($stmt = $conn->prepare($query)) {

        $stmt->bind_param("ss", $yourID, $friend_ID);

        $stmt->execute();

        header("Location: ../profile/people.php");
    }
  }
}
?>
