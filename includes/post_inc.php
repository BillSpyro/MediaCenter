<?php
session_start();
include_once "dbc_inc.php";
include_once "create_notification_inc.php";

// if the page is posted to
if (isset($_POST['postName']) && isset($_POST['postContent'])) {
  $userId = $_SESSION['id'];
  $postName = $_POST['postName'];
  $postContent = $_POST['postContent'];
  $video_link = $_POST["link"];
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

    createNotification('New Post', $userId, $videoId);

    if ($_FILES['fileToUpload']['name'] != "") {
      include_once "../includes/upload_image.php";

      $query = "UPDATE posts SET video_link = ? WHERE id = ?;";
      if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("si", $target_file, $postId);
        $stmt->execute();
        $stmt->close();
      }
    }

    mysqli_close($conn);
  }
}
var_dump($_FILES);
?>
