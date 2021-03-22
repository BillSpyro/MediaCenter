<?php
session_start();
include_once "dbc_inc.php";

if (isset($_POST['postId']) && isset($_POST['postName']) && isset($_POST['postContent'])) {
  $postId = $_POST['postId'];
  $query = "UPDATE posts SET name = ?, content = ? WHERE id = ?;";
  if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("ssi", $_POST['postName'], $_POST['postContent'], $_POST['postId']);
    $stmt->execute();
    $stmt->close();
  }
}
mysqli_close($conn);
header("Location: ../posts/view_post.php?id=$postId");
?>
