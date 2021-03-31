<?php
session_start();
include_once "dbc_inc.php";

// if the page is posted to
if (isset($_POST['postName']) && isset($_POST['postContent'])) {
  $userId = $_SESSION['id'];
  $postName = $_POST['postName'];
  $postContent = $_POST['postContent'];
  $video_link = $_POST["link"];
  $dateTime = date('Y-m-d H:i:s');

  $query = "INSERT INTO posts (user_ID, name, content, video_link, post_time, likes, dislikes, reposts) VALUES (?,?,?,?,?,0,0,0);";
  if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("issss", $userId, $postName, $postContent, $video_link, $dateTime);
    $stmt->execute();
    $stmt->close();
    mysqli_close($conn);
    header("Location: ../profile/profile.php?ID=$userId");
    // header("Location: link to user's feed goes here");
  }
}
?>
