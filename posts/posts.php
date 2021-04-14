<?php
include_once "../includes/dbc_inc.php";

// sql here for all posts in descending order
if ($_SESSION['id']) {
  $userId = $_GET['ID'];
  $postId;
  $NumberOfComments;

  // get all post names
  $query = "SELECT * FROM posts WHERE user_ID = ? ORDER BY post_time DESC;";
  if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_array()) {
      $postId = $row['id'];
      printf(<<<EOT
      <section class="post">
          <h1><a href="../homepage/index.php#%s">%s</a></h1>
          <p>Posted: %s</p>
          <p>You said..</p>
          <p>%s</p>
      EOT, $row['id'], $row['name'], $row['post_time'], $row['content']);

      if ($row['video_link'] != null) {
        printf("<img src='%s'></img>", $row['video_link']);
      }

      $query2 = "SELECT * FROM comments WHERE post_ID = ?;";
      if ($stmt2 = $conn->prepare($query2)) {
        $stmt2->bind_param("i", $postId);
        $stmt2->execute();
        $stmt2->store_result();
        $NumberOfComments = $stmt2->num_rows;
        printf(<<<EOT
          <p>%s comments</p>
        </section>
        EOT, $NumberOfComments);
      }
    }
  }
}
?>
