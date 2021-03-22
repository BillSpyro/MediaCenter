<?php
// establish DB connection
include_once 'dbc_inc.php';
include_once "create_notification_inc.php";

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

//Display everyone for the friend check
$query = "SELECT * FROM users, profile WHERE users.id = profile.user_ID and users.id != ?";
if ($stmt = $conn->prepare($query)) {

  $stmt->bind_param("i", $yourID);

  $stmt->execute();

  $checker = $stmt->get_result();

  // if no row exists
  if (!$result) {
    $error = "You are not logged in.";
    header("Location: ../auth/login.php?error=$error");
    exit();
  }
}

$requestCheck = array();
$friendCheck = array();
$up = 0;

//Do a loop with queries in the loop checking for friend status
while ($checked = $checker->fetch_array()){
  $checkID = $checked['id'];

  $query = "SELECT * FROM friends WHERE friend_ID = ? and user_ID = ?";
  if ($stmt = $conn->prepare($query)) {

    $stmt->bind_param("ii", $yourID, $checkID);

    $stmt->execute();

    $stmt->store_result();

    $result2=$stmt->num_rows;

    if ($result2 > 0) {
      $query = "SELECT * FROM friends WHERE friend_ID = ? and user_ID = ? and friends = 1";
      if ($stmt = $conn->prepare($query)) {

        $stmt->bind_param("ii", $yourID, $checkID);

        $stmt->execute();

        $stmt->store_result();

        $result4=$stmt->num_rows;

    if ($result4 > 0) {
          array_push($friendCheck, 1);
        } else {
          array_push($friendCheck, -1);
        }
      }

      array_push($requestCheck, $checkID);

    } else {
      array_push($requestCheck, -1);
      array_push($friendCheck, -1);
    }
  }
}

//Previous Queries
// $query = "SELECT DISTINCT friends.user_ID, friends.friends FROM users LEFT JOIN friends ON friends.user_ID = users.id WHERE users.id != ? ORDER BY users.id";
// SELECT * FROM users LEFT JOIN friends ON friends.friend_ID = users.id WHERE (friends.user_ID != 3 OR friends.user_ID is NULL) and (friends.friend_ID = 3 OR friends.friend_ID is NULL) ORDER BY users.ID
// $query = "SELECT DISTINCT users.username, friends.friend_ID, friends.friends FROM users LEFT JOIN friends ON friends.friend_ID = users.id WHERE users.id != ? ORDER BY users.id";
// SELECT * FROM friends RIGHT JOIN users ON friends.user_ID = users.ID WHERE (friends.friend_ID = 3 OR friend_ID is NULL) and users.ID != 3 ORDER BY users.ID
// SELECT * FROM friends RIGHT JOIN users ON friends.user_ID = users.ID WHERE (friends.friend_ID = 3 OR friend_ID is NULL) and users.ID != 3 OR friends.user_ID = 3 ORDER BY users.ID
// SELECT * FROM friends RIGHT JOIN users ON friends.user_ID = users.ID WHERE (friends.friend_ID = 1 OR friend_ID is NULL) and users.ID != 1 AND (friends.user_ID != 1 OR friends.friends = 1) ORDER BY users.ID

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

        createNotification('Friend Request', $yourID, $friend_ID);

        header("Location: ../profile/people.php");
        exit();
    }

  }
}

?>
