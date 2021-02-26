<?php
// establish DB connection
$mysqli = new mysqli("localhost", "root", "", "mediaCenter");

// check connection, exit if fail
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
// Before you push, remove the above and uncomment the include
// include_once 'dbc_inc.php';

// go only if username and password were sent
if (isset($_POST['username']) && isset($_POST['password'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  // prepare a query to check username and password
  $query = "SELECT id, username, password FROM users WHERE username = ? AND password = ?";
  if ($stmt = $mysqli->prepare($query)) {

    $stmt->bind_param("ss", $username, $password);

    $stmt->execute();

    if (!$result) {
      $error = "Some of your information was not correct.";
      header("Location: ../auth/login.php?error=$error");
      exit();
    }
    while ($row = $result->fetch_row()) {

      if ($username == $row[1] && $password == $row[2]) {
        session_start();
        $_SESSION['id'] = $row[0];
      }
    }

    // header to profile here
  }
}
// unhashing alg goes here
?>
