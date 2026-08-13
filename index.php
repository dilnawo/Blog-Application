
<?php
session_start();
include "includes/config.php";
include "includes/header.php";
?>

<h2 class="page-title">All Blog Posts</h2>

<!-- Search Form -->
<form method="GET" class="search-form">

    <input
        type="text"
        name="search"
        placeholder="Search blogs..."
        value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
    >

    <button type="submit">Search</button>

</form>

<?php

$search = isset($_GET['search']) ? trim($_GET['search']) : '';

if ($search != '') {

    $sql = "SELECT blogPost.*, user.username
            FROM blogPost
            JOIN user ON blogPost.user_id = user.id
            WHERE blogPost.title LIKE ?
            OR blogPost.content LIKE ?
            OR user.username LIKE ?
            ORDER BY blogPost.created_at DESC";

    $stmt = $conn->prepare($sql);

    $searchTerm = "%" . $search . "%";

    $stmt->bind_param(
        "sss",
        $searchTerm,
        $searchTerm,
        $searchTerm
    );

    $stmt->execute();

    $result = $stmt->get_result();

} else {

    $sql = "SELECT blogPost.*, user.username
            FROM blogPost
            JOIN user ON blogPost.user_id = user.id
            ORDER BY blogPost.created_at DESC";

    $result = $conn->query($sql);
}

?>

<?php

if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {
?>

<div class="blog-card">

    <h3>
        <?php echo htmlspecialchars($row['title']); ?>
    </h3>

    <p>
        <strong>Author:</strong>
        <?php echo htmlspecialchars($row['username']); ?>
    </p>

    <p>
        <strong>Date:</strong>
        <?php echo htmlspecialchars($row['created_at']); ?>
    </p>

    <p>
        <?php
        $content = htmlspecialchars($row['content']);

        if (strlen($content) > 150) {
            echo substr($content, 0, 150) . "...";
        } else {
            echo $content;
        }
        ?>
    </p>

    <a href="blog.php?id=<?php echo $row['id']; ?>">
        Read More
    </a>

    <?php
    if (isset($_SESSION['user_id']) &&
        $_SESSION['user_id'] == $row['user_id']) {
    ?>

        <br><br>

        <a href="edit_blog.php?id=<?php echo $row['id']; ?>">
            Edit
        </a>

        |

        <a href="delete_blog.php?id=<?php echo $row['id']; ?>"
           onclick="return confirm('Are you sure you want to delete this blog?');">
            Delete
        </a>

    <?php
    }
    ?>

</div>

<?php
    }

} else {

    if ($search != '') {
        echo "<p class='no-results'>No blogs found for: <strong>"
             . htmlspecialchars($search)
             . "</strong></p>";
    } else {
        echo "<p class='no-results'>No blog posts available.</p>";
    }
}

include "includes/footer.php";
?>