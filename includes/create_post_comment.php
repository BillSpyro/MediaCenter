<?php
session_start();
include_once "../includes/dbc_inc.php";

// if they're logged in and have posted a comment
if ($_SESSION['id'] && isset($_POST['comment'])) {
  $userId = $_SESSION['id'];
  $postId = $_POST['postId'];
  $comment = $_POST['comment'];
  $dateTime = date('Y-m-d H:i:s');

  $query = "INSERT INTO comments (user_ID, post_ID, posted_date, content) VALUES (?, ?, ?, ?);";
  if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param('iiss', $userId, $postId, $dateTime, $comment);
    $stmt->execute();
    $stmt->close();
    header("Location: ../posts/posts.php");
    exit();
  }
}
?>
