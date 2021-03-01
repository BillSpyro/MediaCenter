
<?php

include_once '../includes/header.php';

?>
<section>
    <div>
    <h1>Sign Up</h1>
    <p>It’s quick and easy.</p>
        <form action="../includes/register_inc.php" method="POST">
            <input type="text" name="first" placeholder="first Name" required>
            <input type="text" name="last" placeholder="last Name" required>
            <input type="text" name="username" placeholder="username" required>
            <input type="password" name="password" placeholder="password" required>
            <input type="text" name="email" placeholder="email" required>
            <input type="date" name="dob" placeholder="Borthday" required>
            <p>Please select your gender:</p>
            <input type="radio" id="male" name="gender" value="male">
            <label for="male">Male</label><br>
            <input type="radio" id="female" name="gender" value="female">
            <label for="female">Female</label><br>
            <input type="radio" id="other" name="gender" value="other">
            <label for="other">Other</label>
            <input class="submit" type="submit" name="submit"  />
        </form>
    </div>
</section>


<?php

include_once '../includes/footer.php';

?>