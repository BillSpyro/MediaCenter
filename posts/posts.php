<?php
include_once "../includes/header.php";
include_once "../includes/dbc_inc.php";

// sql here for all posts in descending order
if ($_SESSION['id']) {
  // get all post names
  $query = "SELECT id, name, post_time FROM posts WHERE user_ID = ? ORDER BY post_time DESC;";
  if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("i", $_SESSION['id']);
    $stmt->execute();
    $stmt->bind_result($id, $name, $postTime);
    while ($stmt->fetch()) {
      printf(<<<EOT
      <section>
        <h1><a href="../posts/view_post.php?id=%s">%s</a></h1>
        <p>Posted: %s</p>
      </section>
      EOT, $id, $name, $postTime);
    }
  }
}

include_once "../includes/footer.php";
?>
