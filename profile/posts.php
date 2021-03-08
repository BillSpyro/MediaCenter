<?php
include_once "../includes/header.php";
include_once "../includes/dbc_inc.php";

// sql here for all posts in descending order
if ($_SESSION['id']) {
  $postId;
// SELECT name, content, post_time, likes, dislikes, reposts FROM posts WHERE user_ID = ? ORDER BY post_time DESC
  $query = "SELECT id, name, content, post_time, likes, dislikes, reposts FROM posts WHERE user_ID = ? ORDER BY post_time DESC;";
  if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("i", $_SESSION['id']);
    $stmt->execute();
    $stmt->bind_result($id, $name, $content, $postTime, $likes, $dislikes, $reposts);
    while ($stmt->fetch()) {
      printf(<<<EOT
      <section>
        <h1>%s</h1>
        <p>Posted: %s</p>
        <p>%s</p>
        <p>Likes: %s Dislikes: %s Reposts: %s</p>
        <a href="edit_post.php?postid=%s">Edit</a>
        <p>Comments</p>
      </section>
      EOT, $name, $postTime, $content, $likes, $dislikes, $reposts, $id);

      // create comments
      printf(<<<EOT
      <section>
        <form action="../includes/create_post_comment.php" method="POST">
          <input type="text" name="postId" value="%s" hidden>
          <label for='comment'>New Comment</label>
          <input type='text' name='comment'>
          <input type='submit'>
        </form>
      </section>
      EOT, $id);

      // used for query for finding comments
      $postId = $id;
  }

    // query for comments
    $query = "SELECT username, posted_date, content FROM comments JOIN users ON users.id = comments.user_ID WHERE post_ID = ? ORDER BY posted_date DESC;";
    if ($stmt = $conn->prepare($query)) {
      $stmt->bind_param("i", $postId);
      $stmt->execute();
      $stmt->bind_result($username, $posted_date, $content);
      // display the comments
      while ($stmt->fetch()) {
        printf(<<<EOT
        <section>
          <p>%s commented on <span>%s:</span></p>
          <p>%s</p>
        <section>
        EOT, $username, $posted_date, $content);
      }
    }
  }
}

include_once "../includes/footer.php";
?>
