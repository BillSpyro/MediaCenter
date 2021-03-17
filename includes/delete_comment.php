<?php
include_once "../includes/dbc_inc.php";
if (isset($_GET['commentId'])) {
  $commentId = $_GET['commentId'];

  $query = "DELETE FROM comments WHERE id = ?;";
  if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param('i', $commentId);
    $stmt->execute();
    $stmt->close();

    header("Location: ../posts/posts.php");
    exit();
  }
}
?>
