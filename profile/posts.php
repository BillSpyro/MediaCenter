<?php
include_once "../includes/header.php";
include_once "../includes/dbc_inc.php";

// sql here for all posts in descending order
if ($_SESSION['id']) {
// SELECT name, content, post_time, likes, dislikes, reposts FROM posts WHERE user_ID = ? ORDER BY post_time DESC
  $query = "SELECT id, name, content, post_time, likes, dislikes, reposts FROM posts WHERE user_ID = ? ORDER BY post_time DESC;";
  if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("i", $_SESSION['id']);
    $stmt->execute();
    $stmt->bind_result($id, $name, $content, $postTime, $likes, $dislikes, $reposts);
    while ($stmt->fetch()) {
      printf(<<<EOT
      <section>
        <h1>%s</h1>
        <p>%s</p>
        <p>%s</p>
        <p>Likes: %s Dislikes: %s Reposts: %s</p>
        <a href="edit_post.php?postid=%s">Edit</a>
      </section>
      
      EOT, $name, $postTime, $content, $likes, $dislikes, $reposts, $id);
      ?>
   <div>
      <form action="posts.php" method="post">
        <input type="submit" name="Like" value="Like">
      </form>
      <p>0 people liked your post</p>
  </div>
      <?php
    }
  }
}

include_once "../includes/footer.php";
?>


<?php
$user_id = $_SESSION['id'];

if(isset($_POST["Like"])) {

  $sql_postId = "SELECT post_ID FROM users, profile, posts, likes WHERE likes.post_ID = posts.id and posts.user_ID = profile.user_ID and profile.user_ID = users_id and users.id = ?";
if ($stmt = $conn->prepare($sql_postId)) {

  $stmt->bind_param("i", $user_id);

  $stmt->execute();

  $post_id = $stmt->get_result();
}


  $query = "UPDATE likes SET likes = 1 WHERE user_ID = ? and post_ID = ?";
  if ($stmt = $conn->prepare($query)) {

    $stmt->bind_param("ii", $user_id, $post_id);

    $stmt->execute();
    echo "success";
    exit();
    }else{
      echo "something goes wrong";
    }
}


?>

