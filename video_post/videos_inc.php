<?php
include_once '../includes/header.php';
include_once '../includes/dbc_inc.php';

if(isset($_POST["submit"])) {
    $userId = $_SESSION['id'];
    $Video_discription = $_POST["description"];
    $video = '../images/' . $_FILES['video']['name'];
    $date = date('Y-m-d H:i:s');
    if(copy($_FILES['video']['tmp_name'], $video)) {
        $query = "INSERT INTO videos (user_ID, description, links, post_time) VALUES (?, ?, ?, ?)";
        if($stmt = $conn->prepare($query)){
            $stmt->bind_param("ssss", $userId, $Video_discription, $video, $date);
            $stmt->execute();
            $stmt->close();
            echo "success";
            header("Location: videos.php?ID=$userId");
            mysqli_close($conn);
        }
}

}else {
    "not action";
}


?>