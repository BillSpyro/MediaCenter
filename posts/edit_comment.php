<?php
include_once "../includes/header.php";
if (isset($_GET['commentId']) && isset($_GET['oldContent'])) {
  $commentId = $_GET['commentId'];
  $oldContent = $_GET['oldContent'];
  $postId = $_GET['postId'];
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
