<?php
session_start();
require 'connection.php';
$postSlug = $_GET['slug'];

// Fetch single blog posts
$sql = "SELECT p.id, p.title, p.slug, p.image, p.content, p.created_at, u.fullname AS author
        FROM posts p
        JOIN users u ON p.user_id = u.user_id
        WHERE p.status = 1 AND p.slug = '$postSlug'";

$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) == 0) {
    header("Location: blog.php");
    exit;
}
$post = mysqli_fetch_assoc($result);
$postId = $post['id'];
if (isset($_POST['save_comment'])) {
    $comment = $_POST['comment'];
    $userID = $_SESSION['userId'];
    $createdAt = date('Y-m-d H:i:s');

    if (empty($comment)) {
        $message = "Comment is required";
        $messageType = 'danger';
    } else {
        $sql = "INSERT INTO comments (comment, user_id, post_id, created_at) VALUES('$comment', '$userID', '$postId', '$createdAt')";
        if (mysqli_query($conn, $sql) === TRUE) {
            $message = "Comment Posted Successfully!";
            $messageType = 'success';
        }
    }
}

// feting the comments
$commentSql = "SELECT c.id, c.comment, c.user_id, c.post_id, c.created_at, u.fullname AS author
        FROM comments c
        JOIN users u ON c.user_id = u.user_id
        WHERE c.post_id = '$postId'";
$commentResult = mysqli_query($conn, $commentSql);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blog - Latest Posts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .card-text {
            font-size: 0.95rem;
        }

        .read-more {
            text-decoration: none;
        }

        .read-more:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <?php include 'include/navbar.php'; ?>

    <div class="container py-5">
        <h1 class="mb-4 h2">
            <?= $post['title'] ?>
        </h1>
        <div class="row g-4">
            <p>
                <span>
                    <?= $post['author'] ?>
                </span>
                <span>
                    <?= $post['created_at'] ?>
                </span>
            </p>
            <img src="uploads/post/<?= $post['image'] ?>" class="card-img-top" alt="<?= htmlspecialchars($post['title']) ?>">

            <p>
                <?= $post['content'] ?>
            </p>
            <hr>
            <div class="mt-4">
                <h5>Comments</h5>
                <?php
                if (mysqli_num_rows($commentResult) > 0) {
                    while ($comment = mysqli_fetch_assoc($commentResult)) {
                ?>
                        <div class="p-3 border mb-3">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <span>
                                        <?= $comment['author'] ?>
                                    </span>
                                    <span>
                                        <?= $comment['created_at'] ?>
                                    </span>
                                </div>
                                <?php if ($_SESSION['userId'] == $comment['user_id']) { ?>
                                    <a href="delete-comment.php?id=<?= $comment['id'] ?>" class="btn btn-danger btn-sm ">Delete</a>
                                <?php } ?>
                            </div>
                            <p> <?= $comment['comment'] ?> </p>
                        </div>
                    <?php }
                }
                if (!empty($message)) { ?>
                    <div class="alert alert-<?= $messageType ?>">
                        <?= $message ?>
                    </div>
                <?php } ?>
                <form action="#" method="post">
                    <textarea rows="5" placeholder="Your comment is here" name="comment" id="" class="form-control"></textarea>
                    <button name="save_comment" type="submit" class="btn btn-primary mt-3">Post Comment</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
// Close DB connection
$conn->close();
?>