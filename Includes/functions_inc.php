<!-- <?php
require_once 'dbc_inc.php';

// creatusers function

function usernameExists($conn, $username) {

    $sql = "SELECT * FROM users WHERE  username = ?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../auth/register.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($resultData)) {

        return $row;
        
    }else{
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}



function creatUser($conn, $firstname, $lastname, $username, $pwd, $email, $dob, $gender, $role) {

    $sql = "INSERT INTO users ( firstname, lastname, username, password, email, dob, gender, role) VALUES (?,?,?,?,?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../auth/register.php?error=stmtfaild");
        exit();
    }
    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, "ssssssss", $firstname, $lastname, $username, $hashedPwd, $email, $dob, $gender, $role);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../auth/login.php?error=none");
        exit();
} 


