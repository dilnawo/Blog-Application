<?php

session_start();

include "includes/config.php";
include "includes/header.php";

?>

<!-- =========================
     HERO SECTION
========================= -->

<section class="hero">

    <div class="hero-content">

        <span class="hero-badge">
            ✦ WELCOME TO MY BLOG ✦
        </span>

        <h1>
            Share Your Ideas.<br>
            Inspire Others.
        </h1>

        <p>
            Discover interesting stories, ideas and knowledge
            from our growing blogging community.
        </p>

        <?php if (isset($_SESSION['user_id'])) { ?>

            <a href="create_blog.php" class="hero-btn">
                ✦ Create Your Story
            </a>

        <?php } else { ?>

            <a href="register.php" class="hero-btn">
                ✦ Join the Community
            </a>

        <?php } ?>

    </div>

</section>


<!-- =========================
     BLOG SECTION
========================= -->

<section class="blog-section">

    <div class="section-heading">

        <span class="section-label">
            EXPLORE
        </span>

        <h2>
            Latest Stories
        </h2>

        <p>
            Read the latest articles from our community.
        </p>

    </div>


    <!-- =========================
         SEARCH FORM
    ========================= -->

    <form method="GET" class="search-form">

        <div class="search-input-wrapper">

            <span class="search-icon">
                ⌕
            </span>

            <input
                type="text"
                name="search"
                placeholder="Search articles..."
                value="<?php
                    echo isset($_GET['search'])
                        ? htmlspecialchars($_GET['search'])
                        : '';
                ?>"
            >

        </div>

        <button type="submit">
            Search
        </button>

    </form>


<?php

/* =========================
   SEARCH / GET BLOG POSTS
========================= */

$search = isset($_GET['search'])
    ? trim($_GET['search'])
    : '';


if ($search != '') {

    $sql = "SELECT blogPost.*, user.username
            FROM blogPost
            JOIN user
            ON blogPost.user_id = user.id
            WHERE blogPost.title LIKE ?
            OR blogPost.content LIKE ?
            OR user.username LIKE ?
            ORDER BY blogPost.created_at DESC";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {

        die("Database query error.");

    }

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
            JOIN user
            ON blogPost.user_id = user.id
            ORDER BY blogPost.created_at DESC";

    $result = $conn->query($sql);

}

?>


<!-- =========================
     SEARCH RESULT MESSAGE
========================= -->

<?php if ($search != '') { ?>

    <div class="search-result-message">

        <span>🔎</span>

        Results for:

        <strong>
            "<?php echo htmlspecialchars($search); ?>"
        </strong>

    </div>

<?php } ?>


<!-- =========================
     BLOG GRID
========================= -->

<div class="blog-grid">

<?php

if ($result && $result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {

        $content = htmlspecialchars($row['content']);

?>

        <!-- =========================
             BLOG CARD
        ========================= -->

        <article class="premium-blog-card">


            <!-- CARD TOP -->

            <div class="card-top">

                <span class="post-label">
                    ✦ ARTICLE
                </span>

                <span class="post-date">

                    <?php

                    echo date(
                        "M d, Y",
                        strtotime($row['created_at'])
                    );

                    ?>

                </span>

            </div>


            <!-- TITLE -->

            <h3>

                <?php

                echo htmlspecialchars(
                    $row['title']
                );

                ?>

            </h3>


            <!-- AUTHOR / DATE -->

            <div class="post-meta">

                <span>

                    👤

                    <?php

                    echo htmlspecialchars(
                        $row['username']
                    );

                    ?>

                </span>


                <span class="meta-dot">
                    •
                </span>


                <span>

                    📅

                    <?php

                    echo date(
                        "F d, Y",
                        strtotime($row['created_at'])
                    );

                    ?>

                </span>

            </div>


            <!-- DIVIDER -->

            <div class="card-line"></div>


            <!-- CONTENT PREVIEW -->

            <p class="post-preview">

                <?php

                if (strlen($content) > 180) {

                    echo substr(
                        $content,
                        0,
                        180
                    ) . "...";

                } else {

                    echo $content;

                }

                ?>

            </p>


            <!-- CARD FOOTER -->

            <div class="card-footer">


                <!-- READ ARTICLE -->

                <a
                    class="read-more-premium"
                    href="blog.php?id=<?php
                        echo $row['id'];
                    ?>"
                >

                    Read Article

                    <span>
                        →
                    </span>

                </a>


                <!-- EDIT / DELETE -->

                <?php

                if (
                    isset($_SESSION['user_id']) &&
                    $_SESSION['user_id'] == $row['user_id']
                ) {

                ?>

                    <div class="post-actions">


                        <a
                            class="edit-link"
                            href="edit_blog.php?id=<?php
                                echo $row['id'];
                            ?>"
                        >
                            Edit
                        </a>


                        <span>
                            |
                        </span>


                        <a
                            class="delete-link"
                            href="delete_blog.php?id=<?php
                                echo $row['id'];
                            ?>"
                            onclick="return confirmDelete();"
                        >
                            Delete
                        </a>


                    </div>

                <?php } ?>


            </div>


        </article>


<?php

    }

} else {

?>


    <!-- =========================
         NO POSTS
    ========================= -->

    <div class="empty-state">

        <div class="empty-icon">
            ✦
        </div>


        <h3>
            No Articles Found
        </h3>


        <p>

            <?php

            if ($search != '') {

                echo "We couldn't find any articles matching your search.";

            } else {

                echo "There are no blog posts available yet.";

            }

            ?>

        </p>


        <?php if (isset($_SESSION['user_id'])) { ?>

            <a
                href="create_blog.php"
                class="btn"
            >
                Create First Article
            </a>

        <?php } ?>


    </div>


<?php

}

?>

</div>

</section>


<?php

include "includes/footer.php";

?>