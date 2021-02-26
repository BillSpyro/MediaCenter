
<?php

include_once '../includes/header.php';

?>
<section>
    <div>
    <h1>Sign Up</h1>
    <p>It’s quick and easy.</p>
        <form action="../includes/register_inc.php" method="POST">
            <input type="text" name="username" placeholder="username" required>
            <input type="password" name="password" placeholder="password" required>
            <input type="text" name="email" placeholder="email" required>
            <input class="submit" type="submit" name="submit"  />
        </form>
    </div>
</section>


<?php

include_once '../includes/footer.php';

?>