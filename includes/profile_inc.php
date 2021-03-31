<?php
// establish DB connection
include_once 'dbc_inc.php';
include_once "create_notification_inc.php";

$profileID = $_GET['ID'];

// prepare a query to check username and password
$query = "SELECT * FROM users, profile WHERE users.ID = profile.user_ID and users.ID = ?";
if ($stmt = $conn->prepare($query)) {

  $stmt->bind_param("i", $profileID);

  $stmt->execute();

  $result = $stmt->get_result();

  // if no row exists
  if (!$result) {
    $error = "You are not logged in.";
    header("Location: ../auth/login.php?error=$error");
    exit();
  }

  while ($row = $result->fetch_array()) {
    $ID = $row['id'];
    $profile_picture = $row['profile_picture'];
    $first_name = $row['first_name'];
    $middle_name = $row['middle_name'];
    $last_name = $row['last_name'];
    $phone = $row['phone'];
    $date_of_birth = $row['date_of_birth'];
    $gender = $row['gender'];
    $description = $row['description'];
    $location = $row['location'];
    $job = $row['job'];
    $education = $row['education'];
    $relationship_status= $row['relationship_status'];

  }


}

//Requests
$query = "SELECT * FROM users, profile, friends WHERE friends.friend_ID = profile.user_id and users.ID = friends.user_ID and users.ID = ? and friends.friends = 0";
if ($stmt = $conn->prepare($query)) {

  $stmt->bind_param("i", $profileID);

  $stmt->execute();

  $result2 = $stmt->get_result();
}

//Real Friends
$query = "SELECT * FROM users, profile, friends WHERE friends.friend_ID = profile.user_id and users.ID = friends.user_ID and users.ID = ? and friends.friends = 1";
if ($stmt = $conn->prepare($query)) {

  $stmt->bind_param("i", $profileID);

  $stmt->execute();

  $result3 = $stmt->get_result();
}

//Handles accepting or decline friend requests and removing friends
if (isset($_GET['friend'])){
  $request = $_GET['friend'];
  $yourID = $_SESSION['id'];
  $friendID = $_GET['friend_ID'];

  //Accepting a friend request
  if($request == 'accept'){
  $query = "UPDATE friends SET friends = 1 WHERE user_ID = ? and friend_ID = ?";
  if ($stmt = $conn->prepare($query)) {

    $stmt->bind_param("ii", $yourID, $friendID);

    $stmt->execute();

    }

    $query = "INSERT INTO friends (user_ID, friend_ID, friends) VALUES (?,?,1)";
    if ($stmt = $conn->prepare($query)) {

      $stmt->bind_param("ii", $friendID, $yourID);

      $stmt->execute();

  }

  createNotification('Friend Accept', $yourID, $friendID);

  header("Location: ../profile/profile.php?ID=$yourID");
  exit();

//Declining a friend request
} elseif ($request == 'decline') {
  $query = "DELETE FROM friends WHERE user_ID = ? and friend_ID = ?";
  if ($stmt = $conn->prepare($query)) {

    $stmt->bind_param("ii", $yourID, $friendID);

    $stmt->execute();

    $result = $stmt->get_result();
  }

  createNotification('Friend Decline', $yourID, $friendID);

  header("Location: ../profile/profile.php?ID=$yourID");
  exit();

//Removing a friend
} elseif ($request == 'remove'){

  $query = "DELETE FROM friends WHERE user_ID = ? and friend_ID = ? and friends = 1";
  if ($stmt = $conn->prepare($query)) {

    $stmt->bind_param("ii", $yourID, $friendID);

    $stmt->execute();

    $result = $stmt->get_result();
  }

    $query = "DELETE FROM friends WHERE user_ID = ? and friend_ID = ? and friends = 1";
    if ($stmt = $conn->prepare($query)) {

      $stmt->bind_param("ii", $friendID, $yourID);

      $stmt->execute();

      $result = $stmt->get_result();

}

createNotification('Friend Remove', $yourID, $friendID);

header("Location: ../profile/profile.php?ID=$yourID");
exit();

//Error if none above happens
} else {
  $error = "An error occured.";
  header("Location: ../auth/login.php?error=$error");
  exit();
}



}



?>
