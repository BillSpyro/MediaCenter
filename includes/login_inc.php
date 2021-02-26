<?php
// establish DB connection
include_once 'dbc_inc.php';

// go only if username and password were sent
if (isset($_POST['username']) && isset($_POST['password'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  // prepare a query to check username and password
  $query = "SELECT id, username, password FROM users WHERE username = ?;";
  if ($stmt = $conn->prepare($query)) {

    $stmt->bind_param("s", $username);

    $stmt->execute();

    $result = $stmt->get_result();

    // if no row exists
    if (!$result) {
      $error = "Some of your information was not correct.";
      header("Location: ../auth/login.php?error=$error");
      exit();
    }

    while ($row = $result->fetch_row()) {

      if ($username == $row[1] && password_verify($password, $row[2])) {
        session_start();
        $_SESSION['id'] = $row[0];
        // header to profile here
        header("Location: ../index.php");
      }
    }
  }
}
?>
