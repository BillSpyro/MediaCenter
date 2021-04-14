<?php
include_once "../includes/header.php";
include_once "../includes/dbc_inc.php";
if (isset($_GET['commentId'])) {
  $commentId = $_GET['commentId'];
  $oldContent;
  $postId;
  
  $query = "SELECT * FROM comments WHERE id = ?;";
  if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param('i', $commentId);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_array()) {
      $oldContent = $row['content'];
      $postId = $row['post_ID'];
    }
    $stmt->close();
  }
}
?>

<section>
  <form action="../includes/edit_comment_inc.php" method="post">
    <label for="newContent">Content</label>
    <input type="text" name="newContent" value="<?php echo $oldContent; ?>">
    <input type="text" name="commentId" value="<?php echo $commentId; ?>" hidden>
    <input type="text" name="postId" value="<?php echo $postId; ?>" hidden>

    <input type="submit">
  </form>
</section>

<?php
include_once "../includes/footer.php";
?>
