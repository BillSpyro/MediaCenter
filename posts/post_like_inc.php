
<?php
include_once "../includes/header.php";
include_once "../includes/dbc_inc.php";
include_once "../includes/create_notification_inc.php";

  if (isset($_SESSION['id'])) {
    $user_id = $_SESSION["id"];
  }
    if(isset($_POST["Like"])) {
        $post_id = $_POST["postId"];
        $sql_rate = "SELECT likes.likes FROM users, likes, posts WHERE likes.post_ID = posts.id and likes.user_ID  = users.id and users.id = '$user_id' and posts.id = '$post_id';";
        $result = $conn->query($sql_rate);
        if (!empty($result) && $result->num_rows > 0) {
            $query_delete_like = "DELETE FROM likes WHERE post_ID = ? and user_ID = ?;";
            if ($stmt = $conn->prepare($query_delete_like)) {
                $stmt->bind_param('ii', $post_id, $user_id);
                $stmt->execute();
                header("Location: ../homepage/index.php");
                $stmt->close();
                exit();
  }
        }else {
            $rate_value = 1;
            $query = "INSERT INTO likes (user_ID, post_ID, profile_ID, likes) VALUES (?, ?, ?, ?);";
            if ($stmt = $conn->prepare($query)) {
                $stmt->bind_param("iiii", $user_id, $post_id, $user_id, $rate_value);
                $stmt->execute();
                header("Location: ../homepage/index.php");
                $stmt->close();
                }
            }

            //Getting ID of the post owner
            $query = "SELECT * FROM posts WHERE id = ?";
            if ($stmt = $conn->prepare($query)) {

              $stmt->bind_param("i", $post_id);

              $stmt->execute();
              header("Location: ../homepage/index.php");

              $result = $stmt->get_result();

              while ($row = $result->fetch_array()) {
                $ownerID = $row['user_ID'];
              }
            }
            createNotification('Like', $user_id, $ownerID, $post_id);

            $conn->close();
    }
?>