<!-- basic header page -->
<header>
    <nav>
        <ul>
          <?php session_start();
          if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true): ?>
            <li><a href="../Accounts/logout.php">Log Out</a></li>
            <li><a href="../Accounts/accountPage.php">Home</a></li>
          <?php else: ?>
            <li><a href="../Accounts/index.php">Home</a></li>
            <li><a href="../Accounts/registerPage.php">Register</a></li>
            <li><a href="../Accounts/loginPage.php">Log In</a></li>
          <?php endif ?>
        </ul>
    </nav>
</header>
