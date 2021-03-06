
<?php

include_once '../includes/header.php';
// get data from videos tabe first to update 
$query = "SELECT * FROM profile, videos WHERE videos.user_ID = profile.user_ID ORDER BY post_time DESC";
$result = $conn->query($query);
while ($row = $result->fetch_array()) {
    $video_id = $row["id"];
    $desc = $row["description"];
    $video_name = $row["links"];
}

?>
<!-- update vidoe form -->
<div class="update_video">
    <form class="post-form "  action="update_video.php" method="post" enctype="multipart/form-data">
        <p>Update Video</p>
        <hr>
        <input id="update_video_id" type="text" name="video_id" value="<?php echo $video_id?>" hidden>
        <input class="body" type="text" name="description" value="<?php echo $desc?>" ><br>
        <input class="video" type="file" name="video"  value="<?php echo $video_name?>" ><br>
        <input class="submit" type="submit" name="submit" >
    </form>
</div>

<!-- Update video -->
<?php
if (isset($_POST["submit"])) {
    $video_id = $_POST["video_id"];
    $description = $_POST["description"];
    $video = '../images/' . $_FILES['video']['name'];
    $date = date('Y-m-d H:i:s');
    $user_ID = $_SESSION['id'];

if(copy($_FILES['video']['tmp_name'], $video)) {

    $sql = "UPDATE videos SET  description = ?, links = ?, post_time = ? WHERE id = ?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: update_video.php?error=stmtfaild");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ssss", $description, $video, $date, $video_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: videos.php?ID=$user_ID");
        exit();
    }
}

?>


<?php
include_once '../includes/footer.php';
?>


