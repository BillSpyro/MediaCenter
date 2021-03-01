<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    
<header>
    <nav>
        <ul class="navs">
          <?php session_start();
          if (isset($_SESSION['id'])):?>
            <li><a href="../auth/logout.php">Logout</a></li>
        <?php else: ?>
            <li><a href="../auth/register.php">Register</a></li>
            <li><a href="../auth/login.php">Log In</a></li>
        <?php endif ?>
            <li><a href="../homepage/index.php">Home</a></li>
        </ul>
    </nav>
</header>