<?php
include_once "../includes/header.php";
include_once "../includes/dbc_inc.php";

// sql here for all posts in descending order
if ($_SESSION['id']) {
// SELECT name, content, post_time, likes, dislikes, reposts FROM posts WHERE user_ID = ? ORDER BY post_time DESC
  $query = "SELECT name, content, post_time, likes, dislikes, reposts FROM posts WHERE user_ID = ? ORDER BY post_time DESC;";
  if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("i", $_SESSION['id']);
    $stmt->execute();
    $stmt->bind_result($name, $content, $postTime, $likes, $dislikes, $reposts);
    while ($stmt->fetch()) {
      printf(<<<EOT
      <section>
        <h1>%s</h1>
        <p>%s</p>
        <p>%s</p>
        <p>Likes: %s Dislikes: %s Reposts: %s</p>
        <a href="edit_post.php">Edit</a>
      </section>
      EOT, $name, $postTime, $content, $likes, $dislikes, $reposts);
    }
  }
}

include_once "../includes/footer.php";
?>
