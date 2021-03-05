
<?php

include_once "../includes/header.php";

?>
<!-- welcome page, login, and register link -->
<section class="home">
<h1>Hi Welcome to our site!</h1>

<?php if (!isset($_SESSION['id'])):?>
   <div class="home-log">
       <p>Have an account? Log in.</p>

        <li><a class="home-login" href="../auth/login.php">Log In</a></li>
        <p>Don't have an account? register.</p>

        <li><a class="home-register" href="../auth/register.php">Register</a></li>

<?php else: ?>
<li><a href="../profile/profile.php?ID=<?php echo $_SESSION['id']?>">Your Profile</a></li>
<li><a href="../profile/people.php">Look for People</a></li>
<?php endif ?>




</div>
</section>
<!-- include footer page -->
<div id="home-footer">
<?php
include "../includes/footer.php"
?>
</div>
