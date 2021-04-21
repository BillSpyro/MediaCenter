<?php
include_once "../includes/header.php";
include_once "../includes/dbc_inc.php";

if ($_SESSION['id']) {
  // set some empty variables, populating them later with older data
  $postName;
  $postContent;
  $query = "SELECT name, content FROM posts WHERE user_ID = ? AND id = ?;";

  if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("ii", $_SESSION['id'], $_GET['postid']);

    $stmt->execute();

    $stmt->bind_result($name, $content);
    
    while ($stmt->fetch()) {
      $postName = $name;
      $postContent = $content;
    }
  }
}
// Show this old data in the editting boxes
?>

<section>
  <h1>Updating "<?php echo $postName; ?>"</h1>

  <form action="../includes/edit_post_inc.php" method="post">
    <input type="text" name="postId" value="<?php echo $_GET['postid']; ?>" hidden>

    <label for="postName">Post Name:</label>
    <input type="text" name="postName" value="<?php echo $postName; ?>" required>

    <label for="postContent">Post Content:</label>
    <input type="text" name="postContent" value="<?php echo $postContent; ?>" required>

    <input type="submit">
  </form>

</section>

<?php
include_once "../includes/footer.php";
?>
