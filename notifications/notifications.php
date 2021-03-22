
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
        <p><?php echo $row['notification_time'] . " " . $row['id'] ?></p>
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
