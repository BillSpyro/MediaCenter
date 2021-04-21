<?php
include_once "../includes/dbc_inc.php";

// get the new content that was editted and put it into the database
if ($_POST['newContent'] && $_POST['commentId']) {
  $newContent = $_POST['newContent'];
  $commentId = $_POST['commentId'];
  $postId = $_POST['postId'];

  $query = "UPDATE comments SET content = ? WHERE id = ?;";

  if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param('si', $newContent, $commentId);

    $stmt->execute();

    $stmt->close();

    mysqli_close($conn);

    header("Location: ../homepage/index.php#$postId");
    exit();
  }
}
?>
