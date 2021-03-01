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
// insert values in to users table
    $sql = "INSERT INTO users (username, password, email, role) VALUES (?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../auth/register.php?error=stmtfaild");
        exit();
    }
    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, "ssss", $username, $pwd, $email, $role);
    mysqli_stmt_execute($stmt);
    

    $userId;
    // selcet id form users inorder to use it for profile table
    $sql_id = "SELECT id from users WHERE username=? AND email=?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql_id)) {
        header("location: ../auth/register.php?error=stmtfaild");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $user_ID);
        mysqli_stmt_fetch($stmt);
        $userId = $user_ID;
    
// insert users info in to first and last name 
    $sql1 = "INSERT INTO profile (user_ID, first_name, last_name, date_of_birth, gender) VALUES (?,?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql1)) {
        header("location: ../auth/register.php?error=stmtfaild");
        exit();
    }
    
    mysqli_stmt_bind_param($stmt, "sssss", $userId, $firstname, $lastname, $dob, $gender);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../auth/login.php");
        exit();
} 




