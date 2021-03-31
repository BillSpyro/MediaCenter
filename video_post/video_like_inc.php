<?php
include_once "../includes/header.php";
include_once "../includes/dbc_inc.php";
$user_id = $_SESSION["id"];
if(isset($_POST["Like"])) {
    
    $video_id = $_POST["videoId"];
    $user_id = $_SESSION["id"];
   
    $sql_rate = "SELECT likes.likes FROM users, likes, videos WHERE likes.video_ID = videos.id and likes.user_ID  = users.id and users.id = '$user_id' and videos.id = '$video_id';";
    $result = $conn->query($sql_rate);
    if (!empty($result) && $result->num_rows > 0) {
        $query_delete_like = "DELETE FROM likes WHERE  video_ID = ? and user_ID = ?;";
        if ($stmt = $conn->prepare($query_delete_like)) {
            $stmt->bind_param('ii',  $video_id, $user_id);
            $stmt->execute();
            header("Location: videos.php");
            $stmt->close();
            exit();
        }else {
            echo "somthing went wrong";
        }
    }else {
        $rate_value = 1;
        $query = "INSERT INTO likes (user_ID, video_ID, profile_ID, likes) VALUES (?, ?, ?, ?);";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("iiii", $user_id, $video_id, $user_id, $rate_value);
            $stmt->execute();
            header("Location: videos.php");
            $stmt->close();
            }
            
            close($conn);
        }
        
}else{
    "didn't clcik";
}



?>