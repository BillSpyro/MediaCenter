<?php
include_once "../includes/header.php";
include_once "../includes/dbc_inc.php";

if (isset($_GET['id']) && isset($_SESSION['id'])) {
  $postId = $_GET['id'];
  $userId = $_SESSION['id'];

  $query = "SELECT user_ID, name, content, post_time, likes, dislikes, reposts FROM posts WHERE id = ?;";
  if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("i", $postId);
    $stmt->execute();
    $stmt->bind_result($postCreator, $postName, $postContent, $postTime, $likes, $dislikes, $reposts);

    while ($stmt->fetch()) {
      echo "<section>";
      if ($userId == $postCreator) {
        printf('<a href="../posts/edit_post.php?postid=%s">Edit Post</a>', $postId);
      }
      printf(<<<EOT
        <h1>%s</h1>
        <p>Posted: %s</p>
        <p>%s</p>
        <p>Likes: %s Reposts: %s</p>
      </section>
      EOT, $postName, $postTime, $postContent, $likes, $reposts);
    }
    $stmt->close();

    // create a new comment
    printf(<<<EOT
      <section>
        <form action="../includes/create_post_comment.php" method="POST">
          <input type="text" name="postId" value="%s" hidden>
          <label for='comment'>New Comment</label>
          <input type='text' name='comment'>
          <input type='submit'>
        </form>
      </section>
      EOT, $postId);

    include_once "../includes/show_post_comments.php";
  }
}
?>
