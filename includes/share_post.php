<?php
session_start();
include_once "../includes/dbc_inc.php";

if (isset($_GET['postId'])) {
  $postId = $_GET['postId'];
  // set up variables for the later insert
  $userId = $_SESSION['id'];
  $oldPostId = $postId;
  $oldName;
  $oldContent;
  $postTime = date('Y-m-d H:i:s');
  $likes;
  $dislikes;
  $oldReposts;
  $oldVideoLink;
  $oldShareRef;
  $oldPostUserId;

  $query = "SELECT * FROM posts WHERE id = ?";
  if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param('i', $postId);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
      $oldName = $row['name'];
      $oldContent = $row['content'];
      $likes = 0;
      $dislikes = 0;
      $oldReposts = $row['reposts'] + 1;
      if (is_null($row['video_link'])) {
        $oldVideoLink = null;
      } else {
        $oldVideoLink = $row['video_link'];
      }
      // check if old share ref exists
      if (is_null($row['share_ref'])) {
        $oldShareRef = $oldPostId;
      } else {
        $oldShareRef = $row['share_ref'];
      }

      if (is_null($row['share_user_ref'])) {
        $oldPostUserId = $row['user_ID'];
      } else {
        $oldPostUserId = $row['share_user_ref'];
      }
    }

    $query = "INSERT INTO `posts` (user_ID, name, content, post_time, likes, dislikes, reposts, video_link, share_ref, share_user_ref) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
    if ($stmt = $conn->prepare($query)) {
      $stmt->bind_param('ssssiiisii', $userId, $oldName, $oldContent, $postTime, $likes, $dislikes, $oldReposts, $oldVideoLink, $oldShareRef, $oldPostUserId);
      $stmt->execute();
      $stmt->close();

      if ($stmt = $conn->prepare("UPDATE posts SET reposts = ? WHERE id = ?;")) {
        $stmt->bind_param("ii", $oldReposts, $postId);
        $stmt->execute();
        Header("Location: ../homepage/index.php");
        exit();
      }
    }
  }
}
?>
