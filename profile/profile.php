
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
<h1>Friends</h1>

</div>
</section>


<?php

include_once '../includes/footer.php';

?>
