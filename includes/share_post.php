<?php
include_once "../includes/dbc_inc.php";

if (isset($_GET['postId'])) {
  $postId = $_GET['postId'];
  // set up variables for the later insert
  $oldPostId = $postId;
  $oldName;
  $oldContent;
  $oldPostTime;
  $oldReposts;
  $oldVideoLink;
  $oldShareRef;

  $query = "SELECT * FROM posts WHERE id = ?";
  if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param('i', $postId);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
      $oldName = $row['name'];
      $oldContent = $row['content'];
      $oldPostTime = $row['post_time'];
      $likes = 0;
      $dislikes = 0;
      $oldReposts = $row['reposts'] + 1;
      $oldVideoLink = $row['video_link'];
      // check if old share ref exists
    }
  }
}
?>
