<?php

if (isset($_POST["submit"])) {
    $firstname = $_POST["first"];
    $lastname = $_POST["last"];
    $username = $_POST["username"];
    $pwd = $_POST["password"];
    $email = $_POST["email"];
    $dob = $_POST["dob"];
    $gender = $_POST["gender"];
    $role = 'user';
    
    require_once 'dbc_inc.php';
    
    require_once 'functions_inc.php';

// check if the username is taken
    if (usernameExists($conn, $username) !== false) {
        header("location: ../auth/register.php?error=usernametaken");

        exit();
    } 
// create the account 
    creatUser($conn, $firstname, $lastname, $username, $pwd, $email, $dob, $gender, $role);

}

else  {
    echo "didn't submit yet";
}

