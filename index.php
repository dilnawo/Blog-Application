
<?php
session_start();
include "includes/config.php";
include "includes/header.php";

$sql = "SELECT blogPost.*, user.username
        FROM blogPost
        JOIN user ON blogPost.user_id = user.id
        ORDER BY created_at DESC";

$result = $conn->query($sql);
?>
<div class="hero">
    <h1>Welcome to My Blog</h1>
    <p>Read, write, and share your ideas with everyone.</p>
</div>
<form method="GET">
    <input
        type="text"
        name="search"
        placeholder="Search blogs...">
</form>


<h2>All Blog Posts</h2>

<?php
if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {
?>

<div class="blog-card">

    <h3><?php echo htmlspecialchars($row['title']); ?></h3>

    <p>
        <strong>Author:</strong>
        <?php echo htmlspecialchars($row['username']); ?>
    </p>

    <p>
        <strong>Date:</strong>
        <?php echo $row['created_at']; ?>
    </p>

    <p>
        <?php
        echo nl2br(substr(htmlspecialchars($row['content']), 0, 150));

        if(strlen($row['content']) > 150){
            echo "...";
        }
        ?>
    </p>

    <a href="blog.php?id=<?php echo $row['id']; ?>">Read More</a>

<?php
if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $row['user_id']) {
?>
    <br><br>

    <a href="edit_blog.php?id=<?php echo $row['id']; ?>">Edit</a> |

    <a href="delete_blog.php?id=<?php echo $row['id']; ?>"
       onclick="return confirm('Are you sure you want to delete this blog?');">
        Delete
    </a>

<?php
}
?>

</div>

<hr>

<?php
    }

} else {

    echo "<p>No blog posts available.</p>";

}

include "includes/footer.php";
?>