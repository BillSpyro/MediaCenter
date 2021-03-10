
<?php

include_once '../includes/header.php';
include_once '../includes/profile_inc.php';
?>
<section class="profile-page">
  <div class="profile">
    <div class="pic-name">
    <h1>Profile</h1>

    <img class="profile-picture" src="<?php echo $profile_picture ?>" alt="" width="100" height="100">
    <h2><?php echo $first_name . " " . $middle_name . " " . $last_name?></h2>
    <p><?php echo $description ?></p>
    <?php if ($_SESSION['id'] == $ID):?>
    <li><a class="edit-profile--link" href="../profile/profile_edit.php?ID=<?php echo $ID ?>">Edit Profile</a></li>
    <?php endif ?>
    </div>
  <div id="table-about">
    <h3>About</h3>
    <table class="table-about">

      <tr>
        <td>Phone Number:</td>
        <td><?php echo $phone ?></td>
      </tr>
      <tr>
        <td>Date of Birth:</td>
        <td><?php echo $date_of_birth ?></td>
      </tr>
      <tr>
        <td>Gender:</td>
        <td><?php echo $gender ?></td>
      </tr>
      <tr>
        <td>Location: </td>
        <td><?php echo $location ?></td>
      </tr>
      <tr>
        <td>Education: </td>
        <td><?php echo $education ?></td>
      </tr>
      <tr>
        <td>Job: </td>
        <td><?php echo $job ?></td>
      </tr>
      <tr>
        <td>Relationship Status: </td>
        <td><?php echo $relationship_status ?></td>
      </tr>
    </table>

    </div>
  </div>

<div class="freinds-info">

<div class="feed">

<h1>Feeds</h1>
<a href="posts.php">My Posts</a>
</div>

<div>

<h1>Friends</h1>
</div>

<?php if ($_SESSION['id'] == $ID):?>
<h2>Requests</h2>

<ul>
<?php while ($row2 = $result2->fetch_array()):  ?>
<li><img src="<?php echo $row2['profile_picture'] ?>" alt="" width="100" height="100">
<p><a href="../profile/profile.php?ID=<?php echo $row2['friend_ID'] ?>"><?php echo $row2['first_name'] . " " . $row2['middle_name'] . " " . $row2['last_name'] ?></a></p>
<a href="../profile/profile.php?friend=<?php echo 'accept' ?>&friend_ID=<?php echo $row2['friend_ID'] ?>">Accept</a>
<a href="../profile/profile.php?friend=<?php echo 'decline' ?>&friend_ID=<?php echo $row2['friend_ID'] ?>">Decline</a>
</li>
<?php endwhile ?>
</ul>

<?php endif ?>
<h2>Real Friends</h2>

<ul>
<?php while ($row3 = $result3->fetch_array()):  ?>
<li><img src="<?php echo $row3['profile_picture'] ?>" alt="" width="100" height="100">
<a href="../profile/profile.php?ID=<?php echo $row3['friend_ID'] ?>"><?php echo $row3['first_name'] . " " . $row3['middle_name'] . " " . $row3['last_name'] ?></a>
<?php if ($_SESSION['id'] == $ID):?>
<a href="../profile/profile.php?friend=<?php echo 'remove' ?>&friend_ID=<?php echo $row3['friend_ID'] ?>">Remove</a>
<?php endif ?>
</li>
<?php endwhile ?>
</ul>



</div>
</div>
</section>


<?php

include_once '../includes/footer.php';

?>
