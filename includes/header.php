

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <meta name="description"
          content="My Blog - Share ideas, stories and knowledge">

    <title>My Blog</title>

    <!-- Premium CSS -->
    <link rel="stylesheet"
      href="/assets/css/style.css?v=5">
</head>

<body class="page-container">

<!-- =========================
     NAVBAR
========================= -->

<nav class="navbar">

    <div class="navbar-brand">
        <h2>My Blog</h2>
    </div>

    <div class="menu">

        <a href="/index.php">Home</a>

        <?php if (isset($_SESSION['user_id'])) { ?>

            <a href="/dashboard.php">Dashboard</a>

            <a href="/create_blog.php">Create Blog</a>

            <a href="/logout.php">Logout</a>

        <?php } else { ?>

            <a href="/login.php">Login</a>

            <a href="/register.php">Register</a>

        <?php } ?>

    </div>

</nav>


<!-- =========================
     MAIN CONTENT
========================= -->

<main class="content">