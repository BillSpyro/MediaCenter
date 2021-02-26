<?php

include_once '../includes/header.php';


?>
<section>
    <div>
    <h1>Login</h1>
    
        <form action="../includes/register_inc.php" method="POST">
            <input type="text" name="username" placeholder="username">
            <input type="password" name="password" placeholder="password">
            <input type="text" name="email" placeholder="email">
            
            <input class="submit" type="submit" name="submit" value="submit" />
        </form>
    </div>
</section>


<?php

include_once '../includes/footer.php';

?>