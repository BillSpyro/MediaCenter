<?php
include_once "../includes/header.php";
include_once "../includes/dbc_inc.php";

if (isset($_GET['id']) && isset($_SESSION['id'])) {
  $postId = $_GET['id'];
  $userId = $_SESSION['id'];

  $query = "SELECT first_name, last_name, posts.user_ID, name, content, post_time, likes, dislikes, reposts FROM posts JOIN profile ON posts.user_ID = profile.user_ID WHERE posts.id = ?;";
  if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("i", $postId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($row = $result->fetch_array()) {
      echo "<section>";
      // Checks if the current user is the owner, lets them edit or delete if so.
      if ($userId == $row['user_ID']) {
        printf('<a href="../posts/edit_post.php?postid=%s">Edit Post</a>', $postId);
        printf('<a href="../includes/delete_post.php?postId=%s">Delete Post</a>', $postId);
        printf("<p>You posted..</p>");
      } else {
        printf(<<<EOT
        <p>%s %s posted...</p>
        EOT, $row['first_name'], $row['last_name']);
      }
      printf(<<<EOT
        <h1>%s</h1>
        <p>Posted: %s</p>
        <p>%s</p>
        <p>Likes: %s Reposts: %s</p>
      </section>
      EOT, $row['name'], $row['post_time'], $row['content'], $row['likes'], $row['reposts']);
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
