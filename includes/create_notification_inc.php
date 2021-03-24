<?php

//Types of Notifications:
//Friend Request
//Likes
//Comments
//Sharing posts
//Accepting friend request
//Decling Friend Request
//Remove friend

function createNotification($type, $user_ID, $other = null, $optional = null) {

//DB Connection
  $_SERVER = "localhost";
  $_dbUserName = "root";
  $_dbPassword = "";
  $_dbName = "mediaCenter";

  $conn = mysqli_connect($_SERVER, $_dbUserName, $_dbPassword, $_dbName);

  if(!$conn) {
      die("Connection failed: " .mysqli_connect_error());
  }

//Grab variables
$dateTime = date('Y-m-d H:i:s');
$userID = $user_ID;
$notificationType = $type;
$otherID = $other;
$optionalID = $optional;


//Friend Request Notification
if($notificationType == 'Friend Request'){
  $query = "INSERT INTO notifications (user_ID, notification_time, friend_ID, type) VALUES (?, ?, ?, ?)";
  if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param('isis', $otherID, $dateTime, $userID, $notificationType);
    $stmt->execute();
    $stmt->close();
  }
//Like Notification
} else if ($notificationType == 'Like'){
  $query = "INSERT INTO notifications (user_ID, notification_time, like_ID, post_ID, type) VALUES (?, ?, ?, ?, ?)";
  if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param('isiis', $otherID, $dateTime, $userID, $optionalID, $notificationType);
    $stmt->execute();
    $stmt->close();
  }

//Comment Notification
} else if ($notificationType == 'Comment'){
  $query = "INSERT INTO notifications (user_ID, notification_time, comment_ID, post_ID, type) VALUES (?, ?, ?, ?, ?)";
  if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param('isiis', $otherID, $dateTime, $userID, $optionalID, $notificationType);
    $stmt->execute();
    $stmt->close();
  }

//Friend Accept Notification
} else if ($notificationType == 'Friend Accept'){
  $query = "INSERT INTO notifications (user_ID, notification_time, friend_ID, type) VALUES (?, ?, ?, ?)";
  if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param('isis', $otherID, $dateTime, $userID, $notificationType);
    $stmt->execute();
    $stmt->close();
  }

//Friend Decline Notification
} else if ($notificationType == 'Friend Decline'){
  $query = "INSERT INTO notifications (user_ID, notification_time, friend_ID, type) VALUES (?, ?, ?, ?)";
  if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param('isis', $otherID, $dateTime, $userID, $notificationType);
    $stmt->execute();
    $stmt->close();
  }

//Friend Remove Notification
} else if ($notificationType == 'Friend Remove'){
  $query = "INSERT INTO notifications (user_ID, notification_time, friend_ID, type) VALUES (?, ?, ?, ?)";
  if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param('isis', $otherID, $dateTime, $userID, $notificationType);
    $stmt->execute();
    $stmt->close();
  }
}


}

?>
