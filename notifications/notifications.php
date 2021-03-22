
<?php

include_once "../includes/header.php";
include_once '../includes/notification_inc.php';

?>
<section>
    <div>
    <h1>Notifications</h1>

    <h2>Your Notifications</h2>

    <ul>
      <?php while ($row = $result->fetch_array()):  ?>
        <?php if ($row['type'] == 'Like'): ?>
        <?php
        //Trying query:
        //SELECT * FROM profile, posts, likes WHERE likes.user_ID = 2 and profile.user_ID = likes.user_ID and likes.post_ID = posts.id
        $query = "SELECT * FROM profile, posts, likes WHERE likes.user_ID = ? and profile.user_ID = likes.user_ID and likes.post_ID = posts.id";
        if ($stmt = $conn->prepare($query)) {

          $stmt->bind_param("i", $row['like_ID']);

          $stmt->execute();

          $result = $stmt->get_result();

          while ($row2 = $result->fetch_array()) {
            $name = $row2['first_name'] . " " . $row2['middle_name'] . " " . $row2['last_name'];
            $postName = $row2['name'];
          }
        }
        ?>
          <p><?php echo $name; ?> liked your post, "<?php echo $postName; ?>" on <?php echo $row['notification_time']; ?></p>
        <?php endif ?>
        <p><?php echo $row['type'] . " happened on " . $row['notification_time']?></p>
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
