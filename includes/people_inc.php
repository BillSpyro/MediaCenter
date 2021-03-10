<?php
// establish DB connection
include_once 'dbc_inc.php';

$yourID = $_SESSION['id'];

//Search everyone except yourself
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

//Check if already sent
$query = "SELECT * FROM friends WHERE friend_ID = ? ORDER BY user_ID";
if ($stmt = $conn->prepare($query)) {

  $stmt->bind_param("i", $yourID);

  $stmt->execute();

  $result2 = $stmt->get_result();
}

$requestCheck = array();
$friendCheck = array();
$up = 0;

while ($row2 = $result2->fetch_array()){
  echo $row2['user_ID'];
  array_push($requestCheck, $row2['user_ID']);
  array_push($friendCheck, $row2['friends']);
}

//Send Friend Request
if (isset($_GET['friend_ID'])){
  $friend_ID = $_GET['friend_ID'];

  $query = "SELECT * FROM friends WHERE user_ID = ? and friend_ID = ?";
  if ($stmt = $conn->prepare($query)) {

    $stmt->bind_param("ss", $friend_ID, $yourID);

    $stmt->execute();

    $stmt->store_result();

    $result3=$stmt->num_rows;
}
    // if a row exists dont insert
    if ($result3 > 0) {
      $error = "You are already friends with them or have already sent a request.";
      header("Location: ../profile/people.php?error=$error");
      exit();
    } else {

      $query = "INSERT INTO friends (user_ID, friend_ID) VALUES (?,?)";
      if ($stmt = $conn->prepare($query)) {

        $stmt->bind_param("ss", $friend_ID, $yourID);

        $stmt->execute();

        header("Location: ../profile/people.php");
        exit();
    }

  }
}

?>
