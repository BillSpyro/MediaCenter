<?php

require_once 'dbc_inc.php';
include_once "create_notification_inc.php";

session_start();
if (isset($_POST["submit"])) {
    $profile_picture = '../images/' . $_FILES['image']['name'];
    $firstname = $_POST["first"];
    $middle = $_POST["middle"];
    $lastname = $_POST["last"];
    $phone = $_POST["phone"];
    $date = $_POST["date"];
    $gender = $_POST["gender"];
    $description = $_POST["description"];
    $location = $_POST["location"];
    $job = $_POST["job"];
    $education = $_POST["education"];
    $relation = $_POST["relation"];


// update profile

$user_ID = $_SESSION['id'];

if(copy($_FILES['image']['tmp_name'], $profile_picture)) {
$sql = "UPDATE profile SET  profile_picture = ?, first_name = ?, middle_name = ?, last_name = ?, phone = ?, date_of_birth = ?, gender = ?, description = ?, location = ?, job = ?, education = ?, relationship_status = ? WHERE user_ID = ?";

    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../profile/profile_edit.php?error=stmtfaild");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sssssssssssss", $profile_picture, $firstname, $middle, $lastname, $phone, $date, $gender, $description, $location,  $job, $education, $relation, $user_ID);

    mysqli_stmt_execute($stmt);

    //Getting ID of the profile that was updated
    $query = "SELECT * FROM profile WHERE user_ID = ?";
    if ($stmt = $conn->prepare($query)) {

      $stmt->bind_param("i", $user_ID);

      $stmt->execute();

      $result = $stmt->get_result();

      while ($row = $result->fetch_array()) {
        $profile_ID = $row['id'];
      }
    }

    mysqli_stmt_close($stmt);

    createNotification('Update Profile', $user_ID, $profile_ID);
    header("location: ../profile/profile.php?ID=$user_ID");
        exit();


}
}

else  {
    echo "didn't submit yet";
}
