<?php
include_once "../includes/dbc_inc.php";
include_once "create_notification_inc.php";
session_start();

// if they're logged in and have posted a comment
if (isset($_SESSION['id']) && isset($_POST['comment'])) {
  $userId = $_SESSION['id'];
  $postId = $_POST['postId'];
  $comment = $_POST['comment'];
  $dateTime = date('Y-m-d H:i:s');

  $query = "INSERT INTO comments (user_ID, post_ID, posted_date, content) VALUES (?, ?, ?, ?);";

  if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param('iiss', $userId, $postId, $dateTime, $comment);

    $stmt->execute();

    $stmt->close();

    //Getting ID of the post owner
    $query = "SELECT * FROM posts WHERE id = ?";
    if ($stmt = $conn->prepare($query)) {

      $stmt->bind_param("i", $postId);

      $stmt->execute();

      $result = $stmt->get_result();

      while ($row = $result->fetch_array()) {
        $ownerID = $row['user_ID'];
      }
    }

    //Getting ID of the comment that was made
    $query = "SELECT * FROM comments WHERE user_ID = ? and post_ID = ? and content = ? and posted_date = ?";
    if ($stmt = $conn->prepare($query)) {

      $stmt->bind_param("iiss", $userId, $postId, $comment, $dateTime);

      $stmt->execute();

      $result = $stmt->get_result();

      while ($row = $result->fetch_array()) {
        $commentID = $row['id'];
      }

      $stmt->close();

      mysqli_close($conn);
    }


    createNotification('Comment', $commentID, $ownerID, $postId);

    header("Location: ../homepage/index.php#$postId");
    exit();
  }
}
?>
