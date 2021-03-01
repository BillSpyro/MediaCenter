
<?php

include "../includes/header.php";

?>
<!-- welcome page, login, and register link -->
<section class="home">
<h1>Hi Welcome to our site!</h1>


   <div class="home-log">
       <p>Have an account? Log in.</p>

        <li><a href="../auth/login.php">Log In</a></li>
        <p>Don't have an account? register.</p>
        <li><a href="../auth/register.php">Register</a></li>
</div>
</section>
<!-- include footer page -->
<div id="home-footer">
<?php
include "../includes/footer.php"
?>
</div>
