<?php
// check if they are logged in, if not send them to the home page
if (!$_SESSION['id']) {
  exit();
  header("Location: homepage/index.php");
}
?>
<div class="post-form--div">
  <div>

  <form class="post-form" action="../includes/post_inc.php" method="post">
  <p>Create Post</p>
  <hr>
  <input class="title" type="text" name="postName" placeholder="title" >
  <input class="body" type="text" name="postContent" placeholder="What's on your mind?" required>
  <input class="submit" type="submit" value="POST">
</form>
  </div>

</div>