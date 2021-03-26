
<?php

include_once "../includes/header.php";
include_once '../includes/notification_inc.php';
$yourID = $_SESSION['id'];

if (isset($_GET['Action'])){
  if ($_GET['Action'] == "Mark"){
    $query = "UPDATE notifications SET viewed = 1 WHERE id = ?";
    if ($stmt = $conn->prepare($query)) {
      $stmt->bind_param('i', $_GET['notificationID']);
      $stmt->execute();
      $stmt->close();
    }
    header("Location: ../notifications/notifications.php?ID=$yourID");
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
        <?php if ($row['viewed'] == '0'): ?>
          <span>NEW -> </span>
        <?php endif ?>
        <?php if ($row['type'] == 'Like'): ?>
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
          <a href="../posts/view_post.php?id=<?php echo $postID ?>"><?php echo $name; ?> liked your post, "<?php echo $postName; ?>" on <?php echo $row['notification_time']; ?></a>
        <?php elseif ($row['type'] == 'Comment'): ?>
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
            <a href="../posts/view_post.php?id=<?php echo $postID ?>"><?php echo $name; ?> commented with, "<?php echo $comment ?>" on your post, "<?php echo $postName; ?>" on <?php echo $row['notification_time']; ?></a>
          <?php elseif ($row['type'] == 'New Post'): ?>
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
              <a href="../posts/view_post.php?id=<?php echo $postID ?>"><?php echo $name; ?> created a new post, "<?php echo $postName; ?>" on <?php echo $row['notification_time']; ?></a>
          <?php elseif ($row['type'] == 'Friend Request'): ?>
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
            <?php elseif ($row['type'] == 'Friend Accept'): ?>
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
              <?php elseif ($row['type'] == 'Friend Decline'): ?>
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
                <?php elseif ($row['type'] == 'Friend Remove'): ?>
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
        <?php endif ?>
        <a href="../notifications/notifications.php?Action=Mark&notificationID=<?php echo $row['id'] ?>">Mark</a> <a href="../notifications/notifications.php?Action=Delete&notificationID=<?php echo $row['id'] ?>">Delete</a></p>
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
