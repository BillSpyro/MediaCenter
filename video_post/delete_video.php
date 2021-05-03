<?php

include_once '../includes/header.php';
// delete video the comment should deleted along with post because comment without post is invalid

if(isset($_POST["delete_video"])) {
    $video_id = $_POST["video_id"];
    $sql = "DELETE FROM  videos WHERE id = ?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: update_video.php?error=stmtfaild");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s",  $video_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $sql_del = "DELETE FROM  comments WHERE video_ID = ?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql_del)) {
        header("location: delete_video.php?error=stmtfaild");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s",  $video_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: videos.php?ID=$user_ID");
        exit();
    
    }


?>


<?php
include_once '../includes/footer.php';
?>


