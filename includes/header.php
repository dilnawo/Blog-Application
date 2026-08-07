<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Application</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="page-container">

<nav class="navbar">

    <h2>My Blog</h2>

    <div>

        <a href="index.php">Home</a>

        <?php if(isset($_SESSION['user_id'])){ ?>

            <a href="dashboard.php">Dashboard</a>

            <a href="create_blog.php">Create Blog</a>

            <a href="logout.php">Logout</a>

        <?php }else{ ?>

            <a href="login.php">Login</a>

            <a href="register.php">Register</a>

        <?php } ?>

    </div>

</nav>