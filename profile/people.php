
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
    <li><img src="<?php echo ['profile_picture'] ?>" alt="" width="100" height="100">
    <a href="../profile/profile.php?ID=<?php echo $row['id'] ?>"><?php echo $row['first_name'] . " " . $row['middle_name'] . " " . $row['last_name'] ?></a>
    <a href="../profile/people.php?friend_ID=<?php echo $row['id'] ?>">Send Friend Request</a>
    </li>
    <?php endwhile ?>
    </ul>

  </div>
</section>

<!-- include footer page -->
<div id="home-footer">
<?php
include "../includes/footer.php"
?>
</div>
