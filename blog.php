<?php
session_start();
include "includes/config.php";
include "includes/header.php";

if (!isset($_GET['id'])) {
    echo "<p>Blog not found.</p>";
    include "includes/footer.php";
    exit();
}

$id = $_GET['id'];

$stmt = $conn->prepare("
    SELECT blogPost.*, user.username
    FROM blogPost
    JOIN user ON blogPost.user_id = user.id
    WHERE blogPost.id = ?
");

$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {

    $blog = $result->fetch_assoc();
?>

<h2><?php echo htmlspecialchars($blog['title']); ?></h2>

<p>
    <strong>Author:</strong>
    <?php echo htmlspecialchars($blog['username']); ?>
</p>

<p>
    <strong>Date:</strong>
    <?php echo $blog['created_at']; ?>
</p>

<hr>

<p>
    <?php echo nl2br(htmlspecialchars($blog['content'])); ?>
</p>

<?php
} else {
    echo "<p>Blog not found.</p>";
}
?>

<p><a href="index.php">← Back to Home</a></p>

<?php
include "includes/footer.php";
?>