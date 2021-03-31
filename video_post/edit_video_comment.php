
<?php

include_once '../includes/header.php';
$video_id = $_GET['videoID'];
echo $video_id;
// get data from videos tabe first to update 
$query_comments = "SELECT comments.* FROM comments WHERE video_ID='$video_id';";
$result2 = $conn->query($query_comments);
while ($row = $result2->fetch_array()) {
    $id = $row["id"];
    $v_id = $row["video_ID"];
    $comm = $row["content"];
}

?>
<!-- update vidoe form -->
<div class="update_video">
    <form class="post-form " action="edit_video_comment.php" method="post" >
        <p>edit video comment</p>
        <hr>
        <input type="text" name="comment_id" value="<?php echo $id?>" hidden>
        <input type="text" name="video_id" value="<?php echo $v_id?>" hidden>
        <input class="body" type="text" name="comment" value="<?php echo $comm?>" >
        <input class="submit" type="submit" name="submit" >
    </form>
</div>

<!-- Update video -->
<?php

if (isset($_POST["submit"])) {
    $user_ID = $_SESSION["id"];
    $video_id = $_POST["video_id"];
    $comment_id = $_POST["comment_id"];
    $comment = $_POST["comment"];
    $edited_comment = $comment . " (edited)";
    $sql = "UPDATE comments SET  content = ? WHERE id = ? and video_ID=?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: edit_video_comment.php?error=stmtfaild");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "sss", $edited_comment, $comment_id, $video_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: videos.php?error=none");
        exit();
    }


?>


<?php
include_once '../includes/footer.php';
?>


