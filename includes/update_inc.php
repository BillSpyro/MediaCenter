<?php
session_start();
if (isset($_POST["submit"])) {
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
    require_once 'dbc_inc.php';
    
    
// update profile

$user_ID = $_SESSION['id'];
$sql = "UPDATE profile SET  first_name = ?, middle_name = ?, last_name = ?, phone = ?, date_of_birth = ?, gender = ?, description = ?, location = ?, job = ?, education = ?, relationship_status = ? WHERE user_ID = ?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../profile/profile_edit.php?error=stmtfaild");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ssssssssssss", $firstname, $middle, $lastname, $phone, $date, $gender, $description, $location,  $job, $education, $relation, $user_ID);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../profile/profile.php?ID=$user_ID");
        exit();
}

else  {
    echo "didn't submit yet";
}
