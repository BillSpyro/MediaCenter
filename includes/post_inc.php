<?php
include_once "header.php";
// check if they are logged in, if not send them to the home page
if (!$_SESSION['id']) {
  exit();
  header("Location: homepage/index.php");
}
?>

<form action="post_handler.php" method="post">
  <label for="postName">Title:</label>
  <input type="text" name="postName" required>

  <label for="postContent">Content:</label>
  <input type="text" name="postContent" required>

  <input type="submit">
</form>

<?php
include_once "footer.php";
?>
