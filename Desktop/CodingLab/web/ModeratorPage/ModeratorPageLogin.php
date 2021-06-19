<?php
// Initialize the session
include_once 'CheckTimeActivity.php';

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: ModeratorPage.php");
    exit;
}

include_once '../connectToTheDatabase.php';

$username = $password = "";
$username_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if(isset($_POST['submit'])){

    // Check if username is empty
    if(empty(trim($_POST["login"]))){
        $username_err = "Please enter username.";
    } else{
        $login = trim($_POST["login"]);
    }

    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT COUNT(1) FROM chefs WHERE login = '$login';";
        if ($sql) {
            $sql = "SELECT id, login, password FROM chefs WHERE login = '$login' LIMIT 1;";
            // Execute the statement
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            if (isset($row['password']) && $row['password'] == $password) {
                // Password is correct, so start a new session
                session_start();

                // Store data in session variables
                $_SESSION["loggedin"] = true;
                $_SESSION["id"] = $row['id'];
                $_SESSION["username"] = $login;

                // Redirect user to welcome page
                header("location: ModeratorPage.php");
            }
        }
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Moderator Page</title>
</head>
<body>
<form action="ModeratorPageLogin.php" method="post">
    <label for="login"> Enter your username
        <input type="text" id="login" name="login" placeholder="login">
    </label>
    <br/>
    <label for="password"> Enter your password
        <input type="text" id="password" name="password" placeholder="password">
    </label>
    <br/>
    <input type="submit" name="submit">
</form>
</body>
</html>