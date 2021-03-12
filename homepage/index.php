
<?php

include_once "../includes/header.php";
include_once "../includes/dbc_inc.php";
?>
<!-- welcome page, login, and register link -->
<section class="home">
<h1>Hi Welcome to our site!</h1>

<?php if (!isset($_SESSION['id'])):?>
   <div class="home-log">
       <p>Have an account? Log in.</p>

        <li><a class="home-login" href="../auth/login.php">Log In</a></li>
        <p>Don't have an account? register.</p>

        <li><a class="home-register" href="../auth/register.php">Register</a></li>

<?php else: ?>
<li><a href="../profile/profile.php?ID=<?php echo $_SESSION['id']?>">Your Profile</a></li>
<li><a href="../profile/people.php">Look for People</a></li>
<?php include_once "../profile/create_post.php"; ?>
<?php


$query = "SELECT * FROM profile, posts WHERE posts.user_ID = profile.user_ID ORDER BY post_time DESC";
$result = $conn->query($query);
  ?>
<?php while ($row = $result->fetch_array()):  ?>
    <div class="posts">
        <div class="post">

        <div class="header-post">
        <div class="image">

            <img src="<?php echo $row['profile_picture'] ?>" alt="" width="100" height="100">
        </div>

        <div class="name-time">
        <p><?php echo $row["first_name"] . " " . $row["last_name"]?></p>
        <span> posted on <?php echo $row["post_time"]?></span>
        </div>
        </div>

        
        <div>
            <h2><?php echo $row["name"]?></h2>
            <p><?php echo $row["content"]?></p>
        </div>
    
    </div>
    </div>
    
   
   
    <?php endwhile ?>





<?php endif ?>




</div>
</section>
<!-- include footer page -->
<div id="home-footer">
<?php
include "../includes/footer.php"
?>
</div>
