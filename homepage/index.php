<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../script/style.css" rel="stylesheet" type="text/css" />

    <title>Home Page</title>
</head>
<body class="home">
<!-- include header page -->
<?php

include "../includes/header.php";

?>
<!-- welcome page, login, and register link -->
<section class="home">
<h1>Hi Welcome to our site!</h1>

<?php if (!isset($_SESSION['id'])):?>
   <div class="home-log">
       <p>Have an account? Log in.</p>

        <li><a href="../auth/login.php">Log In</a></li>
        <p>Don't have an account? register.</p>
        <li><a href="../auth/register.php">Register</a></li>
<?php else: ?>
<li><a href="../profile/profile.php?ID=<?php echo $_SESSION['id']?>">Your Profile</a></li>

<?php endif ?>



</div>
</section>
<!-- include footer page -->
<div id="home-footer">
<?php
include "../includes/footer.php"
?>
</div>
