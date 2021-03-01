<?php

$_SERVER = "localhost";
$_dbUserName = "root";
$_dbPassword = "";
$_dbName = "mediaCenter";

$conn = mysqli_connect($_SERVER, $_dbUserName, $_dbPassword, $_dbName);

if(!$conn) {
    die("Connection failed: " .mysqli_connect_error());
}
