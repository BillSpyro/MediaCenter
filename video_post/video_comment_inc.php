<?php
include_once "../includes/header.php";
include_once "../includes/dbc_inc.php";
if(isset($_POST["submitcomment"])) { 
    $user_id = $_SESSION["id"];
    $videoId = $_POST['videoId'];
    $comment = $_POST['comment'];
    $dateTime = date('Y-m-d H:i:s');
    $query = "INSERT INTO comments (user_ID, video_ID, posted_date, content) VALUES (?, ?, ?, ?);";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param('iiss', $user_id, $videoId, $dateTime, $comment);
        $stmt->execute();
        header("Location: videos.php");
        $stmt->close();
        }else {
            echo "somethimg went wrong";
        }
        $conn->close();
    }


?>