
<?php

include_once '../includes/header.php';


?>
<section>
    <div>
    <h1>Sign Up</h1>
    <p>It’s quick and easy.</p>
        <form action="../includes/register_inc.php" method="POST">
            <input type="text" name="first" placeholder="First Name">
            <input type="text" name="last" placeholder="Last Name">
            <input type="text" name="email" placeholder="email">
            <input type="password" name="password" placeholder="password">
            <label for="date">Birthday</label>
            <input type="date" name="date" placeholder="Birthday">
            <label for="gender">Gender</label>
            <select name="gender" id="gender">
                <option value="male">Male</option>
                <option value="female">Femal</option>
            </select>
            <input class="submit" type="submit" name="submit" value="submit" />
        </form>
    </div>
</section>


<?php

include_once '../includes/footer.php';

?>