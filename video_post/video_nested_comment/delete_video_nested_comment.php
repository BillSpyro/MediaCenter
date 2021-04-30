<?php

include_once '../../includes/header.php';
// delete video the comment should deleted along with post because comment without post is invalid

if(isset($_POST["delete_video_comment"])) {
    $video_id = $_POST["video_id"];
    $comment_id = $_POST["comment_id"];
    $nested_comment_id = $_POST["nested_comment_id"];

    $sql = "DELETE  FROM  comments WHERE id = ? and comment_ID=? and video_ID=?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: delete_video_nested_comment.php?error=stmtfaild");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "sss",  $nested_comment_id, $comment_id, $video_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../videos.php?error=none");
        exit();
    
    }


?>


