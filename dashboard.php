<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include "includes/header.php";
?>

<div class="dashboard">

    <h1>Welcome, <?php echo $_SESSION['username']; ?> 👋</h1>

    <p>Manage your blog posts from here.</p>

    <div class="dashboard-buttons">

        <a href="create_blog.php" class="btn">➕ Create Blog</a>

        <a href="index.php" class="btn">📖 View Blogs</a>

        <a href="logout.php" class="btn logout">🚪 Logout</a>

    </div>

</div>

<?php include "includes/footer.php"; ?>