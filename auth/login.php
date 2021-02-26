<?php

include_once '../includes/header.php';

?>

<article>

  <h1>Login</h1>

  <?php
  if (isset($_GET['error'])):
    $error = $_GET['error'];
  ?>
  <span><?php echo $error; ?></span>
  <?php endif ?>

  <form action="../includes/login_inc.php" method="post">

    <label for="username">Username:</label>
    <input type="text" name="username" required>

    <label for="password">Password:</label>
    <input type="text" name="password" required>

    <input type="submit">

  </form>

  <p>Not a member? Register <a href="register.php">here</a>.</p>

</article>

<?php

include_once '../includes/footer.php';

?>
