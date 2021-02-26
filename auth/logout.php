<?php
// logout
session_start();
session_unset();
session_destroy();
header("Location: ../homepage/index.php");
exit();
?>
