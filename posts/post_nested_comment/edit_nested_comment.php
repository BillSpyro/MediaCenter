

<?php

include_once '../../includes/header.php';
$post_id = $_GET['postID'];
$comment_id = $_GET["commentID"];
$id = $_GET["ID"];

// get data from videos tabe first to update 
$query_comments = "SELECT comments.* FROM comments WHERE id='$id' and post_ID='$post_id' and comment_ID = '$comment_id';";
$result2 = $conn->query($query_comments);
while ($row = $result2->fetch_array()) {
    $nested_comment_id = $row["id"];
    $post_id = $row["post_ID"];
    $comment_id = $row["comment_ID"];
    $comm = $row["content"];
}

?>
<!-- update vidoe form -->
<div class="update_video">
    <form class="post-form " action="edit_nested_comment.php" method="post" >
        <p>edit post nested scomment</p>
        <hr>
        <input type="text" name="nested_comment_id" value="<?php echo $nested_comment_id?>" hidden>
        <input type="text" name="post_id" value="<?php echo $post_id?>" hidden>
        <input type="text" name="comment_id" value="<?php echo $comment_id?>" hidden>
        <input class="body" type="text" name="comment" value="<?php echo $comm?>" >
        <input class="submit" type="submit" name="submit" >
    </form>
</div>

<!-- Update video -->
<?php

if (isset($_POST["submit"])) {
    $user_ID = $_SESSION["id"];
    $post_id = $_POST["post_id"];
    $comment_id = $_POST["comment_id"];
    $nested_comment_id = $_POST["nested_comment_id"];
    $comment = $_POST["comment"];
    
    $sql = "UPDATE comments SET  content = ? WHERE id = ? and comment_ID=? and post_ID=?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
      
        header("location: edit_nested_comment.php?error=stmtfaild");
        exit();
    }
    echo "nice";
    mysqli_stmt_bind_param($stmt, "ssss", $comment, $nested_comment_id, $comment_id, $post_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../../homepage/index.php?error=none");
        exit();
    }


?>


