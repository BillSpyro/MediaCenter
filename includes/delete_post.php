<?php
include_once "../includes/dbc_inc.php";

if (isset($_GET['postId'])) {
  $postId = $_GET['postId'];

  $query = "DELETE FROM posts WHERE id = ?;";
  if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param('i', $postId);
    $stmt->execute();
    $stmt->close();

    $query = "DELETE FROM comments WHERE post_ID = ?;";
    if ($stmt = $conn->prepare($query)) {
      $stmt->bind_param("i", $postId);
      $stmt->execute();
      $stmt->close();

      header("Location: ../posts/posts.php");
      exit();
    }
  }
}
?>
