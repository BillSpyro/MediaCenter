<?php
include_once "../includes/dbc_inc.php";

if (isset($_GET['commentId'])) {
  // get the comment's id and the post it's on
  $commentId = $_GET['commentId'];
  $postId = $_GET['postId'];

  $query = "DELETE FROM comments WHERE id = ?;";

  if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param('i', $commentId);

    $stmt->execute();

    $stmt->close();

    mysqli_close($conn);
    // send them back to index to that same post afterwards
    header("Location: ../homepage/index.php#$postId");
    exit();
  }
}
?>
