<?php
include_once "../includes/header.php";
include_once "../includes/dbc_inc.php";
if(isset($_POST["submitcomment"])) {
    $user_id = $_SESSION["id"];
    $postId = $_POST['postId'];
    $post_comment_id = $_POST["post_comment_ID"];
    $comment = $_POST['comment'];
    $dateTime = date('Y-m-d H:i:s');
    $query = "INSERT INTO comments (user_ID, post_ID, comment_ID, posted_date, content) VALUES (?, ?, ?, ?, ?);";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param('sssss', $user_id, $postId, $post_comment_id, $dateTime, $comment);
        $stmt->execute();
        header("Location: ../homepage/index.php");
        $stmt->close();
        }else {
            echo "somethimg went wrong";
        }
        $conn->close();
    }


?>