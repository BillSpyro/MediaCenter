
<?php

include_once "../includes/header.php";
include_once '../includes/people_inc.php';

//Searching for people
if (isset($_POST['search'])) {

  $yourID = $_SESSION['id'];

    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];

    $sql_base = "SELECT * FROM users u, profile p WHERE u.id = p.user_ID and u.ID != $yourID";

    if (empty($first_name)){
        $sql_firstName = " and p.first_name LIKE '$first_name%'";
      }else {
        $sql_firstName = " and p.first_name = '$first_name'";
      }

      if (empty($middle_name)){
          $sql_middleName = " and (p.middle_name LIKE '$middle_name%' OR p.middle_name IS NULL)";
        }else {
          $sql_middleName = " and p.middle_name = '$middle_name'";
        }

        if (empty($last_name)){
            $sql_lastName = " and p.last_name LIKE '$last_name%'";
          }else {
            $sql_lastName = " and p.last_name = '$last_name'";
          }

    $sql = $sql_base . $sql_firstName  . $sql_middleName . $sql_lastName;

    $query = $sql;
    if ($stmt = $conn->prepare($query)) {

      $stmt->execute();

      $result = $stmt->get_result();


    }

    //Display everyone for the friend check
    $sql_base = "SELECT * FROM users u, profile p WHERE u.id = p.user_ID and u.ID != $yourID";

    if (empty($first_name)){
        $sql_firstName = " and p.first_name LIKE '$first_name%'";
      }else {
        $sql_firstName = " and p.first_name = '$first_name'";
      }

      if (empty($middle_name)){
          $sql_middleName = " and (p.middle_name LIKE '$middle_name%' OR p.middle_name IS NULL)";
        }else {
          $sql_middleName = " and p.middle_name = '$middle_name'";
        }

        if (empty($last_name)){
            $sql_lastName = " and p.last_name LIKE '$last_name%'";
          }else {
            $sql_lastName = " and p.last_name = '$last_name'";
          }

    $sql = $sql_base . $sql_firstName  . $sql_middleName . $sql_lastName;

    $query = $sql;
    if ($stmt = $conn->prepare($query)) {

      $stmt->execute();

      $checker = $stmt->get_result();

      // if no row exists
      if (!$result) {
        $error = "You are not logged in.";
        header("Location: ../auth/login.php?error=$error");
        exit();
      }
    }

    $requestCheck = array();
    $friendCheck = array();
    $up = 0;

    //Do a loop with queries in the loop checking for friend status
    while ($checked = $checker->fetch_array()){
      $checkID = $checked['id'];
      echo $yourID . '-' . $checkID . ' ';

      $query = "SELECT * FROM friends WHERE friend_ID = ? and user_ID = ?";
      if ($stmt = $conn->prepare($query)) {

        $stmt->bind_param("ii", $yourID, $checkID);

        $stmt->execute();

        $stmt->store_result();

        $result2=$stmt->num_rows;

        if ($result2 > 0) {
          $query = "SELECT * FROM friends WHERE friend_ID = ? and user_ID = ? and friends = 1";
          if ($stmt = $conn->prepare($query)) {

            $stmt->bind_param("ii", $yourID, $checkID);

            $stmt->execute();

            $stmt->store_result();

            $result4=$stmt->num_rows;

        if ($result4 > 0) {
              array_push($friendCheck, 1);
            } else {
              array_push($friendCheck, -1);
            }
          }

          array_push($requestCheck, $checkID);

        } else {
          array_push($requestCheck, -1);
          array_push($friendCheck, -1);
        }
      }
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

      <input class="save" name="search" type="submit" value="Search">
      <input class="save" name="showall" type="submit" value="Show All">

    </form>

    <h2>Results</h2>

    
    <div class="peoples">
    <?php while ($row = $result->fetch_array()):  ?>
      <div class="people">
    <div><li><img src="<?php echo ['profile_picture'] ?>" alt="" width="100" height="100"></div>
    <div><a class="name-people" href="../profile/profile.php?ID=<?php echo $row['id'] ?>"><?php echo $row['first_name'] . " " . $row['middle_name'] . " " . $row['last_name'] ?></a></div>
    <?php if (isset($friendCheck[$up]) && $friendCheck[$up] == 1): ?>
    <span>Friends</span>
  <?php elseif (isset($requestCheck[$up]) && $requestCheck[$up] == $row['id']): ?>
    <span>Request Sent</span>
    <?php else: ?>
    <a class="send-request" href="../profile/people.php?friend_ID=<?php echo $row['id'] ?>">Send Friend Request</a>
    <?php endif ?>
    </li>
    <?php $up += 1; ?>
    </div>
    <?php endwhile ?>
   
  </div>


  </div>


</section>

<!-- include footer page -->
<div id="home-footer">
<?php
include "../includes/footer.php"
?>
</div>
