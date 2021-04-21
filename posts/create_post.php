<?php
// check if they are logged in, if not send them to the home page
if (!$_SESSION['id']) {
  exit();
  header("Location: homepage/index.php");
}
?>
<div class="post-form--div">
  <div>

  <?php if (isset($_GET['error'])) {
    if ($_GET['error'] == 1) {
      echo "<p>There was an issue with your image upload.</p>";
      echo "<p>Please make sure your image is under 5mb and is a .jpg, .png, or .jpeg file.</p>";
    } 
  } 
  ?>
  <form class="post-form" action="../includes/post_inc.php" method="post" enctype="multipart/form-data">
  <p>Create Post</p>
  <hr>
  <input type="file" name="fileToUpload">
  <input class="title" type="text" name="postName" placeholder="title" >
  <input class="body" type="text" name="postContent" placeholder="What's on your mind?" required>
  <input class="title" type="text" name="link" placeholder="video link" >
  <input class="submit" type="submit" value="POST">
</form>
  </div>

</div>
