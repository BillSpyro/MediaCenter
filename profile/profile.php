
<?php

include_once '../includes/header.php';
include_once '../includes/profile_inc.php';
?>
<section class="profile-page">
  <div>
    <div class="pic-name">
    <h1>Profile</h1>



    <img class="profile-picture" src="<?php echo $profile_picture ?>" alt="" width="100" height="100">

    <h2><?php echo $first_name . " " . $middle_name . " " . $last_name?></h2>
    <p><?php echo $description ?></p>
    <?php if ($_SESSION['id'] == $ID):?>
    <li><a href="../profile/profile_edit.php?ID=<?php echo $ID ?>">Edit Profile</a></li>
    <?php endif ?>
</div>
<div clas="about">
    <h3>About</h3>
    <p>Phone Number: <?php echo $phone ?></p>
    <p>Date of Birth: <?php echo $date_of_birth ?></p>
    <p>Gender: <?php echo $gender ?></p>
    <p>Location: <?php echo $location ?></p>
    <p>Education: <?php echo $education ?></p>
    <p>Job: <?php echo $job ?></p>
    <p>Relationship Status: <?php echo $relationship_status ?></p>

    </div>
  </div>
</section>

<section>
<div>
<h1>Feed</h1>

</div>
</section>

<section>
<div>

<h1><a href="../posts/posts.php">My Posts</a></h1>

</div>
</section>

<section>
<div>

<h1>Friends</h1>

<h2>Requests</h2>

<ul>
<?php while ($row2 = $result2->fetch_array()):  ?>
<li><img src="<?php echo $row2['profile_picture'] ?>" alt="" width="100" height="100">
<a href="../profile/profile.php?ID=<?php echo $row2['friend_ID'] ?>"><?php echo $row2['first_name'] . " " . $row2['middle_name'] . " " . $row2['last_name'] ?></a>
<a href="../profile/profile.php?friend=<?php echo 'accept' ?>&friend_ID=<?php echo $row2['friend_ID'] ?>">Accept</a>
<a href="../profile/profile.php?friend=<?php echo 'decline' ?>&friend_ID=<?php echo $row2['friend_ID'] ?>">Decline</a>
</li>
<?php endwhile ?>
</ul>
<h2>Real Friends</h2>
<ul>
<?php while ($row3 = $result3->fetch_array()):  ?>
<li><img src="<?php echo $row3['profile_picture'] ?>" alt="" width="100" height="100">
<a href="../profile/profile.php?ID=<?php echo $row3['friend_ID'] ?>"><?php echo $row3['first_name'] . " " . $row3['middle_name'] . " " . $row3['last_name'] ?></a>
<a href="../profile/profile.php?friend=<?php echo 'remove' ?>&friend_ID=<?php echo $row3['friend_ID'] ?>">Remove</a>
</li>
<?php endwhile ?>
</ul>

</div>
</section>


<?php

include_once '../includes/footer.php';

?>
