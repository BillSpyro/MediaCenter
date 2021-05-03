<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <script defer src="../css/script.js"></script>
</head>
<body>
<?php session_start(); ?>
<?php if (isset($_SESSION['id'])):?>
<?php
include_once 'dbc_inc.php';

$yourID = $_SESSION['id'];

// Grab notifications for the user
$query = "SELECT * FROM notifications WHERE user_ID = ? and viewed = 0 ORDER BY notification_time DESC";
if ($stmt = $conn->prepare($query)) {

  $stmt->bind_param("i", $yourID);

  $stmt->execute();

  $stmt->store_result();

  $result = $stmt->num_rows();

}
?>
<?php endif ?>

<header>
    <nav>
        <ul class="navs">
          <?php if (isset($_SESSION['id'])):?>
            <li><a href="../auth/logout.php">Logout</a></li>
            <li><a href="../profile/profile.php?ID=<?php echo $_SESSION['id']?>">Your Profile</a></li>
            <li><a href="../profile/people.php">People</a></li>
            <li><a href="../video_post/videos.php">Videos</a></li>
            <li><a href="../notifications/notifications.php?ID=<?php echo $_SESSION['id']?>">Notifications<?php if ($result > 0): ?><span>(<?php echo $result; ?>)</span><?php endif ?></a></li>
        <?php else: ?>
            <li><a href="../auth/register.php">Register</a></li>
            <li><a href="../auth/login.php">Log In</a></li>
        <?php endif ?>
            <li><a href="../homepage/index.php">Home</a></li>
        </ul>
    </nav>
</header>
