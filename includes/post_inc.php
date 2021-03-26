<?php
session_start();
include_once "dbc_inc.php";
include_once "create_notification_inc.php";

// if the page is posted to
if (isset($_POST['postName']) && isset($_POST['postContent'])) {
  $userId = $_SESSION['id'];
  $postName = $_POST['postName'];
  $postContent = $_POST['postContent'];
  $dateTime = date('Y-m-d H:i:s');

  $query = "INSERT INTO posts (user_ID, name, content, post_time, likes, dislikes, reposts) VALUES (?,?,?,?,0,0,0);";
  if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("isss", $userId, $postName, $postContent, $dateTime);
    $stmt->execute();

    //Getting ID of the post that was made
    $query = "SELECT * FROM posts WHERE user_ID = ? and name = ? and content = ? and post_time = ?";
    if ($stmt = $conn->prepare($query)) {

      $stmt->bind_param("isss", $userId, $postName, $postContent, $dateTime);

      $stmt->execute();

      $result = $stmt->get_result();

      while ($row = $result->fetch_array()) {
        $postId = $row['id'];
      }
    }

    $stmt->close();
    mysqli_close($conn);

    createNotification('New Post', $userId, $postId);

    header("Location: ../profile/profile.php?ID=$userId");
    // header("Location: link to user's feed goes here");
  }
}
?>
