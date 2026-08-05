<?php
session_start();
include "includes/config.php";
?>
<?php
session_start();
if (isset($_POST['register'])) {

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Check if email already exists
    $check = $conn->prepare("SELECT id FROM user WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        echo "<p style='color:red;'>Email already exists!</p>";
    } else {

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare(
            "INSERT INTO user (username, email, password)
             VALUES (?, ?, ?)"
        );

        $stmt->bind_param(
            "sss",
            $username,
            $email,
            $hashedPassword
        );

        if ($stmt->execute()) {
            echo "<p style='color:green;'>Registration Successful!</p>";
        } else {
            echo "<p style='color:red;'>Something went wrong.</p>";
        }
    }
}
include "includes/config.php";
include "includes/header.php";
?>

<h2>Register</h2>

<form method="POST" action="">
    <label>Username</label><br>
    <input type="text" name="username" required><br><br>

    <label>Email</label><br>
    <input type="email" name="email" required><br><br>

    <label>Password</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit" name="register">Register</button>
</form>

<p>Already have an account?
    <a href="login.php">Login</a>
</p>

<?php
include "includes/footer.php";
?>