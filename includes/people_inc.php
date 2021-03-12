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

//Previous Queries
// $query = "SELECT DISTINCT friends.user_ID, friends.friends FROM users LEFT JOIN friends ON friends.user_ID = users.id WHERE users.id != ? ORDER BY users.id";
// SELECT * FROM users LEFT JOIN friends ON friends.friend_ID = users.id WHERE (friends.user_ID != 3 OR friends.user_ID is NULL) and (friends.friend_ID = 3 OR friends.friend_ID is NULL) ORDER BY users.ID
// $query = "SELECT DISTINCT users.username, friends.friend_ID, friends.friends FROM users LEFT JOIN friends ON friends.friend_ID = users.id WHERE users.id != ? ORDER BY users.id";
// SELECT * FROM friends RIGHT JOIN users ON friends.user_ID = users.ID WHERE (friends.friend_ID = 3 OR friend_ID is NULL) and users.ID != 3 ORDER BY users.ID
// SELECT * FROM friends RIGHT JOIN users ON friends.user_ID = users.ID WHERE (friends.friend_ID = 3 OR friend_ID is NULL) and users.ID != 3 OR friends.user_ID = 3 ORDER BY users.ID
// SELECT * FROM friends RIGHT JOIN users ON friends.user_ID = users.ID WHERE (friends.friend_ID = 1 OR friend_ID is NULL) and users.ID != 1 AND (friends.user_ID != 1 OR friends.friends = 1) ORDER BY users.ID

//Check if already sent
$query = "SELECT * FROM friends RIGHT JOIN users ON friends.user_ID = users.ID WHERE (friends.friend_ID = ? OR friend_ID is NULL) and users.ID != ? AND (friends.user_ID != ? OR friends.friends = 1 OR friends.friends IS NULL) ORDER BY users.ID";
if ($stmt = $conn->prepare($query)) {

  $stmt->bind_param("iii", $yourID, $yourID, $yourID);

  $stmt->execute();

  $result2 = $stmt->get_result();
}

$requestCheck = array();
$friendCheck = array();
$up = 0;

while ($row2 = $result2->fetch_array()){
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
