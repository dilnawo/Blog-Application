<?php
session_start();
include "includes/config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$message = "";

if (isset($_POST['publish'])) {

    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $user_id = $_SESSION['user_id'];

    if (!empty($title) && !empty($content)) {

        $stmt = $conn->prepare("INSERT INTO blogPost (user_id, title, content) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $title, $content);

        if ($stmt->execute()) {
            $message = "<p style='color:green;'>Blog published successfully!</p>";
        } else {
            $message = "<p style='color:red;'>Error: " . $conn->error . "</p>";
        }

    } else {
        $message = "<p style='color:red;'>Please fill all fields.</p>";
    }
}

include "includes/header.php";
?>

<h2>Create New Blog</h2>

<?= $message ?>

<form method="POST">

    <label>Title</label><br>
    <input type="text" name="title" required><br><br>

    <label>Content</label><br>
    <textarea name="content" rows="10" cols="60" required></textarea><br><br>

    <button type="submit" name="publish">Publish Blog</button>

</form>

<p><a href="dashboard.php">← Back to Dashboard</a></p>

<?php
include "includes/footer.php";
?>