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
?>
      <div>
    <div>
      <form action="posts.php" method="post">
        <input type="text" name="postId" value="<?php echo $id?>" hidden>
        <input type="submit" name="Like" value="Like">
      </form>
      <p>0 people liked your post</p>
  </div>
</div>

<?php
    }
  }

}
?>

<?php

$user_id = $_SESSION['id'];

echo $user_id;
if(isset($_POST["Like"])) {
  $post_id = $_POST["postId"]; 
  echo $post_id;
  $sql_rate = "SELECT likes.likes FROM users, likes, posts WHERE likes.post_ID = posts.id and likes.user_ID  = users.id and users.id = '$user_id' and posts.id = '$post_id';";
  
  $result = $conn->query($sql_rate);

  if (!empty($result) && $result->num_rows > 0) {
    echo "you are already liked the video";
    exit();
  } else {
    
    $rate_value = 1;
    
    
    $query = "INSERT INTO likes (user_ID, post_ID, profile_ID, likes) VALUES (?, ?, ?, ?);";
    if ($stmt = $conn->prepare($query)) {

      $stmt->bind_param("iiii", $user_id, $post_id, $user_id, $rate_value);

      $stmt->execute();
      echo "success";
      $stmt->close();
      
      }
    }
  
    $conn->close();
}


?>

<?php


include_once "../includes/footer.php";
?>
