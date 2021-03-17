<?php
include_once "../includes/dbc_inc.php";

if ($_POST['newContent'] && $_POST['commentId']) {
  $newContent = $_POST['newContent'];
  $commentId = $_POST['commentId'];
  $postId = $_POST['postId'];

  $query = "UPDATE comments SET content = ? WHERE id = ?;";
  if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param('si', $newContent, $commentId);
    $stmt->execute();
    $stmt->close();

    header("Location: ../posts/view_post.php?id=$postId");
    exit();
  }
}
?>
