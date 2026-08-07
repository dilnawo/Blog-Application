<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include "includes/config.php";

if (isset($_POST['login'])) {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows == 1) {

        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            header("Location: dashboard.php");
            exit();

        } else {
            $error = "Incorrect password!";
        }

    } else {
        $error = "User not found!";
    }
}

include "includes/header.php";
?>

<h2>Login</h2>

<?php
if(isset($error)){
    echo "<p style='color:red;'>$error</p>";
}
?>

<form method="POST">

    <label>Email</label><br>
    <input type="email" name="email" required><br><br>

    <label>Password</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit" name="login">Login</button>

</form>

<p>
Don't have an account?
<a href="register.php">Register</a>
</p>

<?php
include "includes/footer.php";
?>