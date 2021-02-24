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

include "Includes/header.php";
?>
<!-- welcome page, login, and register link -->
<section class="home">
<h1>Hi Welcome to our site!</h1>


   <div class="home-log">
       <p>Have an account? Log in.</p>

        <li><a href="../Accounts/loginPage.php">Log In</a></li>
        <p>Don't have an account? register.</p>
        <li><a href="../Accounts/registerPage.php">Register</a></li>
</div>
</section>
<!-- include footer page -->
<div id="home-footer">
<?php
include "Includes/footer.php"
?>
</div>
