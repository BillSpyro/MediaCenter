<?php
session_start();
include_once "dbc_inc.php";

// if the page is posted to
if (isset($_POST['postName']) && isset($_POST['postContent'])) {
  $userId = $_SESSION['id'];
  $postName = $_POST['postName'];
  $postContent = $_POST['postContent'];
  $dateTime = date('Y-m-d H:i:s');

  $query = "INSERT INTO posts (user_ID, name, content, post_time, likes, dislikes, reposts) VALUES (?,?,?,?,0,0,0);";
  if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("isss", $userId, $postName, $postContent, $dateTime);
    $stmt->execute();
    $stmt->close();
    mysqli_close($conn);
  }
}
?>
