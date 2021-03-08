
<?php

include_once "../includes/header.php";
include_once '../includes/people_inc.php';

//Searching for people
if (isset($_POST['search'])) {

    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];

    $sql_base = "SELECT * FROM users u, profile p WHERE u.id = p.user_ID";

    if (empty($first_name)){
        $sql_firstName = " and p.first_name LIKE '$first_name%'";
      }else {
        $sql_firstName = " and p.first_name = '$first_name'";
      }
      if (empty($middle_name)){
          $sql_middleName = " and p.middle_name LIKE '$middle_name%'";
        }else {
          $sql_middleName = " and p.middle_name = '$middle_name'";
        }
        if (empty($last_name)){
            $sql_lastName = " and p.last_name LIKE '$last_name%'";
          }else {
            $sql_lastName = " and p.last_name = '$last_name'";
          }

    $sql = $sql_base . $sql_firstName . $sql_middleName . $sql_lastName;

    $query = $sql;
    if ($stmt = $conn->prepare($query)) {

      $stmt->execute();

      $result = $stmt->get_result();
    }

    //Displays all people
}elseif(isset($_POST['showall'])) {
header("Location: ../profile/people.php");
}
?>

<section>
    <div>
    <h1>People</h1>

    <?php
    if (isset($_GET['error'])):
      $error = $_GET['error'];
    ?>
    <span><?php echo $error; ?></span>
    <?php endif ?>

    <form action="../profile/people.php" method="post">

      <label for="first_name">first name:</label>
      <input type="text" name="first_name">

      <label for="middle_name">middle name:</label>
      <input type="text" name="middle_name">

      <label for="last_name">last name:</label>
      <input type="text" name="last_name">

      <input class="save" name="search" type="submit" value="search">
      <input class="save" name="showall" type="submit" value="Show all">

    </form>

    <h2>Results</h2>

    <ul>
    <?php while ($row = $result->fetch_array()):  ?>
    <li><img src="<?php echo ['profile_picture'] ?>" alt="" width="100" height="100">
    <a href="../profile/profile.php?ID=<?php echo $row['id'] ?>"><?php echo $row['first_name'] . " " . $row['middle_name'] . " " . $row['last_name'] ?></a>
    <a href="../profile/people.php?friend_ID=<?php echo $row['id'] ?>">Send Friend Request</a>
    </li>
    <?php endwhile ?>
    </ul>

  </div>
</section>

<!-- include footer page -->
<div id="home-footer">
<?php
include "../includes/footer.php"
?>
</div>
