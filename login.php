<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

include "includes/config.php";

$error = "";

if (isset($_POST['login'])) {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {

        $error = "Please enter your email and password.";

    } else {

        $stmt = $conn->prepare(
            "SELECT * FROM user WHERE email = ?"
        );

        if ($stmt) {

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

                    $error = "Incorrect password.";

                }

            } else {

                $error = "No account found with this email.";

            }

            $stmt->close();

        } else {

            $error = "Something went wrong. Please try again.";

        }
    }
}

include "includes/header.php";
?>

<!-- =========================
     LOGIN SECTION
========================= -->

<div class="auth-container">

    <div class="auth-box">

        <div class="auth-header">

            <div class="auth-icon">
                🔐
            </div>

            <h1>Welcome Back</h1>

            <p>
                Login to your My Blog account
            </p>

        </div>


        <?php if (!empty($error)) { ?>

            <div class="auth-error">
                <?php echo htmlspecialchars($error); ?>
            </div>

        <?php } ?>


        <form method="POST" class="auth-form">

            <div class="form-group">

                <label for="email">
                    Email Address
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="Enter your email"
                    value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
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
                    placeholder="Enter your password"
                    required
                >

            </div>


            <button
                type="submit"
                name="login"
                class="login-btn"
            >
                Login
            </button>

        </form>


        <!-- =========================
             REGISTER LINK
        ========================= -->

        <div class="auth-register">

            <span>
                Don't have an account?
            </span>

            <a href="register.php">
                Register
            </a>

        </div>

    </div>

</div>


<?php
include "includes/footer.php";
?>