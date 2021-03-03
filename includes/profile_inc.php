<?php
// establish DB connection
include_once 'dbc_inc.php';

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





?>
