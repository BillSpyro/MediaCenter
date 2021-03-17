<?php
include_once "../includes/dbc_inc.php";
if (isset($_GET['commentId'])) {
  $commentId = $_GET['commentId'];
  $postId = $_GET['postId'];

  $query = "DELETE FROM comments WHERE id = ?;";
  if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param('i', $commentId);
    $stmt->execute();
    $stmt->close();

    header("Location: ../posts/view_post.php?id=$postId");
    exit();
  }
}
?>
