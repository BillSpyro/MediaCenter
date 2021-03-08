<?php
include_once "../includes/header.php";
include_once "../includes/dbc_inc.php";

// sql here for all posts in descending order
if ($_SESSION['id']) {
  $userId;
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
      $userId = $id;
    }
    // query for comments
    $query = "SELECT username, posted_date, content FROM comments JOIN users ON users.id = comments.user_ID WHERE post_ID = ? ORDER BY posted_date DESC;";
    if ($stmt = $conn->prepare($query)) {
      $stmt->bind_param("i", $userId);
      $stmt->execute();
      $stmt->bind_result($username, $posted_date, $content);
      // display the comments
      while ($stmt->fetch()) {
        printf(<<<EOT
        <p>%s</p>
        <span>%s</span>
        <p>%s</p>
        EOT, $username, $posted_date, $content);
      }
    }
  }
}

include_once "../includes/footer.php";
?>
