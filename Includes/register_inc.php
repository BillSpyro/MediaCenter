<?php

if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $pwd = $_POST["password"];
    $email = $_POST["email"];
    $role = 'user';
    
    require_once 'dbc_inc.php';
    
    require_once 'functions_inc.php';

    creatUser($conn, $username, $pwd, $email, $role);

}

else  {
    echo "didn't submit yet";
}

