<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

include "includes/config.php";

$error = "";
$success = "";

if (isset($_POST['register'])) {

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check password confirmation
    if ($password !== $confirm_password) {

        $error = "Passwords do not match!";

    } else {

        // Check if email already exists
        $stmt = $conn->prepare(
            "SELECT id FROM user WHERE email = ?"
        );

        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {

            $error = "An account with this email already exists.";

        } else {

            // Hash password
            $hashed_password = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            // Insert new user
            $stmt = $conn->prepare(
                "INSERT INTO user (username, email, password)
                 VALUES (?, ?, ?)"
            );

            $stmt->bind_param(
                "sss",
                $username,
                $email,
                $hashed_password
            );

            if ($stmt->execute()) {

                $success = "Registration successful! You can now login.";

            } else {

                $error = "Registration failed. Please try again.";
            }
        }
    }
}

include "includes/header.php";
?>

<!-- =========================
     REGISTER PAGE
========================= -->

<div class="auth-page">

    <div class="auth-card">

       <div class="auth-header">

    <div class="auth-icon">
        👤
    </div>

    <h1>Create Account</h1>

    <p>
        Join My Blog and start sharing your ideas.
    </p>

</div>

        <!-- ERROR MESSAGE -->

        <?php if (!empty($error)) { ?>

            <div class="auth-message error">
                <?php echo htmlspecialchars($error); ?>
            </div>

        <?php } ?>


        <!-- SUCCESS MESSAGE -->

        <?php if (!empty($success)) { ?>

            <div class="auth-message success">

                <?php echo htmlspecialchars($success); ?>

                <br>

                <a href="login.php">
                    Login now
                </a>

            </div>

        <?php } ?>


        <!-- REGISTER FORM -->

        <?php if (empty($success)) { ?>

            <form method="POST" class="auth-form">

                <div class="form-group">

                    <label for="username">
                        Username
                    </label>

                    <input
                        type="text"
                        id="username"
                        name="username"
                        placeholder="Enter your username"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="email">
                        Email
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="Enter your email"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="password">
                        Password
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Create a password"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="confirm_password">
                        Confirm Password
                    </label>

                    <input
                        type="password"
                        id="confirm_password"
                        name="confirm_password"
                        placeholder="Confirm your password"
                        required
                    >

                </div>


                <button
                    type="submit"
                    name="register"
                    class="auth-button"
                >
                    Create Account
                </button>

            </form>


            <!-- LOGIN LINK -->

            <div class="auth-footer">

                <p>
                    Already have an account?
                    <a href="login.php">
                        Login
                    </a>
                </p>

            </div>

        <?php } ?>

    </div>

</div>

<?php
include "includes/footer.php";
?>