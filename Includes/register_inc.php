<?php

if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $pwd = $_POST["password"];
    $email = $_POST["email"];
    $role = 'user';
    
    require_once 'dbc_inc.php';
    
    require_once 'functions_inc.php';

// check if the username is taken
    if (usernameExists($conn, $username) !== false) {
        header("location: ../auth/register.php?error=usernametaken");

        exit();
    } 
// create the account 
    creatUser($conn, $username, $pwd, $email, $role);

}

else  {
    echo "didn't submit yet";
}

