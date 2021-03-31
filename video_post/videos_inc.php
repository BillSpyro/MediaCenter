<?php
include_once '../includes/header.php';
include_once '../includes/dbc_inc.php';
include_once "../includes/create_notification_inc.php";

if(isset($_POST["submit"])) {
    $userId = $_SESSION['id'];
    $Video_description = $_POST["description"];
    $video = '../images/' . $_FILES['video']['name'];
    $date = date('Y-m-d H:i:s');
    if(copy($_FILES['video']['tmp_name'], $video)) {
        $query = "INSERT INTO videos (user_ID, description, links, post_time) VALUES (?, ?, ?, ?)";
        if($stmt = $conn->prepare($query)){
            $stmt->bind_param("ssss", $userId, $Video_description, $video, $date);
            $stmt->execute();
            $stmt->close();

            //Getting ID of the video that was made
            $query = "SELECT * FROM videos WHERE user_ID = ? and description = ? and links = ? and post_time = ?";
            if ($stmt = $conn->prepare($query)) {

              $stmt->bind_param("isss", $userId, $Video_description, $video, $date);

              $stmt->execute();

              $result = $stmt->get_result();

              while ($row = $result->fetch_array()) {
                $videoId = $row['id'];
              }
            }

            $stmt->close();
            mysqli_close($conn);

            createNotification('New Video', $userId, $videoId);

            header("Location: videos.php?ID=$userId");
            mysqli_close($conn);
        }
}

}else {
    "not action";
}


?>
