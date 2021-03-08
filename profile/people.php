
<?php

include_once "../includes/header.php";
include_once '../includes/people_inc.php';
?>

<section>
    <div>
    <h1>People</h1>

    <?php
    if (isset($_GET['error'])):
      $error = $_GET['error'];
    ?>
    <span><?php echo $error; ?></span>
    <?php endif ?>

    <form action="../includes/people_inc.php" method="post">

      <label for="name">name:</label>
      <input type="text" name="name" required>

      <input type="submit">

    </form>

    <h2>Results</h2>

    <ul>
    <?php while ($row = $result->fetch_array()):  ?>
      <div class="people">
        <div class="peoples">
          <div><img src="<?php echo $row['profile_picture'] ?>" alt="" width="100" height="100"></div>
          <div><a class="name-people" href="../profile/profile.php?ID=<?php echo $row['id'] ?>"><?php echo $row['first_name'] . " " . $row['middle_name'] . " " . $row['last_name'] ?></a></div>
          <div><a class="send-request" href="../profile/people.php?friend_ID=<?php echo $row['id'] ?>">Send Friend Request</a></div>
      </div>
    <?php endwhile ?>
    </ul>
  </div>
  </div>
</section>

<!-- include footer page -->
<div id="home-footer">
<?php
include "../includes/footer.php"
?>
</div>
