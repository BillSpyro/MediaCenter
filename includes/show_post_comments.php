<?php
include_once "../includes/dbc_inc.php";
// display all comments
$query = "SELECT comments.id, user_ID, username, posted_date, content FROM comments JOIN users ON users.id = comments.user_ID WHERE post_ID = ? ORDER BY posted_date DESC;";
if ($stmt = $conn->prepare($query)) {
  $stmt->bind_param("i", $postId);
  $stmt->execute();
  $stmt->bind_result($commentId, $userId, $username, $posted_date, $content);

  while ($stmt->fetch()) {
    if ($_SESSION['id'] == $userId) {
    printf(<<<EOT
    <section>
      <p>You commented on <span>%s:</span></p>
      <p>%s</p>
      <a href="../posts/edit_comment.php?commentId=%s&oldContent=%s&postId=%s">Edit Comment</a>
      <a href="../includes/delete_comment.php?commentId=%s&postId=%s">Delete Comment</a>
    <section>
    EOT, $posted_date, $content, $commentId, $content, $postId, $commentId, $postId);
  } else {
    printf(<<<EOT
    <section>
      <p>%s commented on <span>%s:</span></p>
      <p>%s</p>
    <section>
    EOT, $username, $posted_date, $content);
  }

  }
}
?>
