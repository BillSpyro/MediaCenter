
<?php

include_once "../includes/header.php";
include_once '../includes/notification_inc.php';
$yourID = $_SESSION['id'];

//Handle marking or deleting notificiations
if (isset($_GET['Action'])){
  //Mark notification as viewed
  if ($_GET['Action'] == "Mark"){
    $query = "UPDATE notifications SET viewed = 1 WHERE id = ?";
    if ($stmt = $conn->prepare($query)) {
      $stmt->bind_param('i', $_GET['notificationID']);
      $stmt->execute();
      $stmt->close();
    }
    header("Location: ../notifications/notifications.php?ID=$yourID");
    //Delete notification
  } else if ($_GET['Action'] == "Delete"){
    $query = "DELETE FROM notifications WHERE id = ?";
    if ($stmt = $conn->prepare($query)) {
      $stmt->bind_param('i', $_GET['notificationID']);
      $stmt->execute();
      $stmt->close();
    }
    header("Location: ../notifications/notifications.php?ID=$yourID");
  } else {

  }
}



?>
<section>
    <div>
    <h1>Notifications</h1>

    <h2>Your Notifications</h2>

    <ul>
      <?php while ($row = $result->fetch_array()):  ?>
        <p>
          <!-- Check if notification is viewed -->
        <?php if ($row['viewed'] == '0'): ?>
          <span>NEW -> </span>
        <?php endif ?>

        <!-- Like post notification -->

        <?php if ($row['type'] == 'Like'): ?>
        <div class="notification">
        <?php
        $query = "SELECT * FROM profile, posts, likes WHERE likes.user_ID = ? and profile.user_ID = likes.user_ID and posts.id = ? and likes.post_ID = posts.id";
        if ($stmt = $conn->prepare($query)) {

          $stmt->bind_param("ii", $row['like_ID'], $row['post_ID']);

          $stmt->execute();

          $result2 = $stmt->get_result();

          while ($row2 = $result2->fetch_array()) {
            $name = $row2['first_name'] . " " . $row2['middle_name'] . " " . $row2['last_name'];
            $postName = $row2['name'];
            $postID = $row2['post_ID'];
          }
        }
        ?>
        <!-- Checks if the post was deleted -->
        <?php if(isset($name)): ?>
          <a href="../homepage/index.php#<?php echo $postID ?>"><?php echo $name; ?> liked your post, "<?php echo $postName; ?>" on <?php echo $row['notification_time']; ?></a>
        <?php else: ?>
          <a href="../homepage/index.php#<?php echo $postID ?>">This like is gone because the post was deleted <?php echo $row['notification_time']; ?></a>
   

      <?php endif ?>
      </div>
          <!-- Comment notification -->
        <?php elseif ($row['type'] == 'Comment'): ?>
          <div class="notification">
          <?php
          $query = "SELECT * FROM profile, posts, comments WHERE comments.id = ? and profile.user_ID = comments.user_ID and comments.post_ID = posts.id";
          if ($stmt = $conn->prepare($query)) {

            $stmt->bind_param("i", $row['comment_ID']);

            $stmt->execute();

            $result2 = $stmt->get_result();

            while ($row2 = $result2->fetch_array()) {
              $name = $row2['first_name'] . " " . $row2['middle_name'] . " " . $row2['last_name'];
              $postName = $row2['name'];
              $comment = $row2['content'];
              $postID = $row2['post_ID'];
            }
          }
          ?>
          <!-- Checks if the comment was deleted -->
          <?php if(isset($comment)): ?>
            <a href="../homepage/index.php#<?php echo $postID ?>"><?php echo $name; ?> commented with, "<?php echo $comment ?>" on your post, "<?php echo $postName; ?>" on <?php echo $row['notification_time']; ?></a>
          <?php else: ?>
            <a href="../homepage/index.php#<?php echo $postID ?>">This comment was deleted <?php echo $row['notification_time']; ?></a>
            
        <?php endif ?>
        </div>
            <!-- New Post notification -->
          <?php elseif ($row['type'] == 'New Post'): ?>
            <div class="notification">
            <?php
            $query = "SELECT * FROM profile, posts WHERE posts.id = ? and profile.user_ID = posts.user_ID";
            if ($stmt = $conn->prepare($query)) {

              $stmt->bind_param("i", $row['post_ID']);

              $stmt->execute();

              $result2 = $stmt->get_result();

              while ($row2 = $result2->fetch_array()) {
                $name = $row2['first_name'] . " " . $row2['middle_name'] . " " . $row2['last_name'];
                $postName = $row2['name'];
                $postID = $row['post_ID'];
              }
            }
            ?>
            <!-- Checks if the post was deleted -->
            <?php if(isset($name)): ?>
              <a href="../homepage/index.php#<?php echo $postID ?>"><?php echo $name; ?> created a new post, "<?php echo $postName; ?>" on <?php echo $row['notification_time']; ?></a>
            <?php else: ?>
              <a href="../homepage/index.php#<?php echo $postID ?>">This post was deleted <?php echo $row['notification_time']; ?></a>
              </div>
          <?php endif ?>
              <!-- New Video notification -->
            <?php elseif ($row['type'] == 'New Video'): ?>
              <div class="notification">
              <?php
              $query = "SELECT * FROM profile, videos WHERE videos.id = ? and profile.user_ID = videos.user_ID";
              if ($stmt = $conn->prepare($query)) {

                $stmt->bind_param("i", $row['video_ID']);

                $stmt->execute();

                $result2 = $stmt->get_result();

                while ($row2 = $result2->fetch_array()) {
                  $name = $row2['first_name'] . " " . $row2['middle_name'] . " " . $row2['last_name'];
                  $videoID = $row['video_ID'];
                }
              }
              ?>
              <!-- Checks if the video was deleted -->
              <?php if(isset($videoID)): ?>
                <a href="../video_post/videos.php#<?php echo $videoID ?>"><?php echo $name; ?> created a new video on <?php echo $row['notification_time']; ?></a>
              <?php else: ?>
                <a href="../homepage/index.php#<?php echo $videoID ?>">This video was deleted <?php echo $row['notification_time']; ?></a>
                </div>
            <?php endif ?>
              <!-- Update Profile notification -->
            <?php elseif ($row['type'] == 'Update Profile'): ?>
              <div class="notification">
              <?php
              $query = "SELECT * FROM profile, users WHERE profile.id = ? and users.id = profile.user_ID";
              if ($stmt = $conn->prepare($query)) {

                $stmt->bind_param("i", $row['profile_ID']);

                $stmt->execute();

                $result2 = $stmt->get_result();

                while ($row2 = $result2->fetch_array()) {
                  $name = $row2['first_name'] . " " . $row2['middle_name'] . " " . $row2['last_name'];
                }
              }
              ?>
                <a href="../profile/profile.php?ID=<?php echo $row['profile_ID'] ?>"><?php echo $name; ?> updated their profile on <?php echo $row['notification_time']; ?></a>
                </div>
              <!-- Friend Request notification -->
          <?php elseif ($row['type'] == 'Friend Request'): ?>
            <div class="notification">
            <?php
            $query = "SELECT * FROM profile WHERE user_ID = ?";
            if ($stmt = $conn->prepare($query)) {

              $stmt->bind_param("i", $row['friend_ID']);

              $stmt->execute();

              $result2 = $stmt->get_result();

              while ($row2 = $result2->fetch_array()) {
                $name = $row2['first_name'] . " " . $row2['middle_name'] . " " . $row2['last_name'];
              }
            }
            ?>
              <a href="../profile/profile.php?ID=<?php echo $row['friend_ID'] ?>"><?php echo $name; ?> send you a friend request on <?php echo $row['notification_time']; ?></a>
              </div>
              <!-- Friend Accept notification -->
            <?php elseif ($row['type'] == 'Friend Accept'): ?>
              <div class="notification">
              <?php
              $query = "SELECT * FROM profile WHERE user_ID = ?";
              if ($stmt = $conn->prepare($query)) {

                $stmt->bind_param("i", $row['friend_ID']);

                $stmt->execute();

                $result2 = $stmt->get_result();

                while ($row2 = $result2->fetch_array()) {
                  $name = $row2['first_name'] . " " . $row2['middle_name'] . " " . $row2['last_name'];
                }
              }
              ?>
                <a href="../profile/profile.php?ID=<?php echo $row['friend_ID'] ?>"><?php echo $name; ?> accepted your friend request on <?php echo $row['notification_time']; ?></a>
                </div>
                <!-- Friend Decline notification -->
              <?php elseif ($row['type'] == 'Friend Decline'): ?>
                <div class="notification">
                <?php
                $query = "SELECT * FROM profile WHERE user_ID = ?";
                if ($stmt = $conn->prepare($query)) {

                  $stmt->bind_param("i", $row['friend_ID']);

                  $stmt->execute();

                  $result2 = $stmt->get_result();

                  while ($row2 = $result2->fetch_array()) {
                    $name = $row2['first_name'] . " " . $row2['middle_name'] . " " . $row2['last_name'];
                  }
                }
                ?>
                  <a href="../profile/profile.php?ID=<?php echo $row['friend_ID'] ?>"><?php echo $name; ?> declined your friend request on <?php echo $row['notification_time']; ?></a>
                  </div>
                  <!-- Friend Remove notification -->
                <?php elseif ($row['type'] == 'Friend Remove'): ?>
                  <div class="notification">
                  <?php
                  $query = "SELECT * FROM profile WHERE user_ID = ?";
                  if ($stmt = $conn->prepare($query)) {

                    $stmt->bind_param("i", $row['friend_ID']);

                    $stmt->execute();

                    $result2 = $stmt->get_result();

                    while ($row2 = $result2->fetch_array()) {
                      $name = $row2['first_name'] . " " . $row2['middle_name'] . " " . $row2['last_name'];
                    }
                  }
                  ?>
                    <a href="../profile/profile.php?ID=<?php echo $row['friend_ID'] ?>"><?php echo $name; ?> removed you as a friend on <?php echo $row['notification_time']; ?></a>
                    </div>
                    
        <?php endif ?>
        <div class="notification">
        <a href="../notifications/notifications.php?Action=Mark&notificationID=<?php echo $row['id'] ?>">Mark</a> <a href="../notifications/notifications.php?Action=Delete&notificationID=<?php echo $row['id'] ?>">Delete</a></p>
        </div>
      <?php endwhile ?>
    </ul>

    </div>

  </div>


  </div>


</section>

<!-- include footer page -->
<div id="home-footer">
<?php
include "../includes/footer.php"
?>
</div>
