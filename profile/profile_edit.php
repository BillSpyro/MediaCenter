

<?php

include_once '../includes/header.php';
include_once '../includes/profile_inc.php';
?>
<section>
    <div>
    <h1>Edit</h1>
    <form class="edit-form" action="../includes/update_inc.php" method="POST">
        <label for="first">First Name</label>
            <input type="text" name="first" value="<?php echo $first_name;?>" required>
            <label for="middle">Middle Name</label>
            <input type="text" name="middle" value="<?php echo $middle_name;?>" required>
            <label for="last">Last Name</label>
            <input type="text" name="last" value=<?php echo $last_name;?> >
            <label for="phone">Phone</label>
            <input type="text" name="phone" value="<?php echo $phone;?>" required>
            <label for="date">Date of birth</label>
            <input type="date" name="date" value="<?php echo $date_of_birth;?>" required>
            <label for="gender">Gender</label>
            <div class="gender">
            <input type="radio" id="male" name="gender" value="male">
            <label for="male">Male</label><br>
            <input type="radio" id="female" name="gender" value="female">
            <label for="female">Female</label><br>
            <input type="radio" id="other" name="gender" value="other">
            <label for="other">Other</label>
            </div>
            
            <label for="description">Bio/description</label>
            <input type="text" name="description" value="<?php echo $description;?>" required>

            <label for="location">Locatione</label>
            <input type="text" name="location" value="<?php echo $location;?>" required>
            <label for="job">Job</label>
            <input type="text" name="job" value="<?php echo $job;?>" required>
            <label for="education">Education</label>
            <input type="text" name="education" value="<?php echo $education;?>" required>
            <div>
            <label for="relation">Relation:</label>
            <input type="radio" id="single" name="relation" value="Single">
            <label for="single">Single</label><br>
            <input type="radio" id="married" name="relation" value="Married">
            <label for="merried">Married</label>
            </div>
            <input class="submit" type="submit" name="submit"  />

        </form>

    </div>
</section>


<?php

include_once '../includes/footer.php';

?>


