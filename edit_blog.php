<?php
session_start();
include "includes/config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM blogPost WHERE id=? AND user_id=?");
$stmt->bind_param("ii", $id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Access Denied");
}

$blog = $result->fetch_assoc();

if (isset($_POST['update'])) {

    $title = $_POST['title'];
    $content = $_POST['content'];

    $update = $conn->prepare("UPDATE blogPost SET title=?, content=? WHERE id=?");
    $update->bind_param("ssi", $title, $content, $id);

    if ($update->execute()) {
        header("Location: index.php");
        exit();
    }
}

include "includes/header.php";
?>

<h2>Edit Blog</h2>

<form method="POST">

<label>Title</label>

<input
type="text"
name="title"
value="<?php echo htmlspecialchars($blog['title']); ?>"
required>

<label>Content</label>

<textarea
name="content"
rows="10"
required><?php echo htmlspecialchars($blog['content']); ?></textarea>

<button type="submit" name="update">
Update Blog
</button>

</form>

<?php include "includes/footer.php"; ?>