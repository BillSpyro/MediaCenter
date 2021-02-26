<!-- <?php
require_once 'dbc_inc.php';

// creatusers function
function creatUser($conn, $username, $pwd, $email, $role) {

    $sql = "INSERT INTO users ( username, password, email, role) VALUES (?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../auth/register.php?error=stmtfaild");
        exit();
    }
    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, "ssss", $username, $hashedPwd, $email, $role);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../auth/login.php");
        exit();
}
