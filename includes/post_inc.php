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
  $was_uploaded;
  $uploaded_img;
  
  // if there was a file uploaded
  if ($_FILES['fileToUpload']['name'] != "") {
    include "../includes/upload_image.php";
    // if the upload failed, upload ok will be 0
    if ($uploadOk == 0) {
      $error = 1;
      Header("Location: ../homepage/index.php?error=$error");
      exit();
    } else {
      $was_uploaded = 1;
      // target_file is the file path that was uploaded
      $uploaded_img = $target_file;
    }
  }
  // if a file wasn't uploaded, was_uploaded would be 0
  if ($was_uploaded == 0) {
    $query = "INSERT INTO posts (user_ID, name, content, post_time, likes, dislikes, reposts) VALUES (?,?,?,?,0,0,0);";
  } else {
    $query = "INSERT INTO posts (user_ID, name, content, post_time, video_link, likes, dislikes, reposts) VALUES (?,?,?,?,?,0,0,0);";
  }
  // change bind params if an image was uploaded
  if ($stmt = $conn->prepare($query)) {
    if ($was_uploaded == 0) {
      $stmt->bind_param("isss", $userId, $postName, $postContent, $dateTime);
    } else {
      $stmt->bind_param("issss", $userId, $postName, $postContent, $dateTime, $uploaded_img);
    }
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

      createNotification('New Post', $userId, $postId);

      mysqli_close($conn);
      header("Location: ../homepage/index.php");
    }
  }
?>
