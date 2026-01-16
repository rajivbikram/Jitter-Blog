<?php

session_start();
if ($_SESSION['isLogin'] !== true) {
    header("Location: login.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include 'include/navbar.php'; ?>
    <div class="container my-5">
        <div class="row">
            <?php include 'include/sidebar.php'; ?>
            <div class="col-lg-9">
                <div class="alert alert-info">
                    <h4>
                        Hello! <?= $_SESSION['name'] ?>
                    </h4>
                    <p>Welcome to Dashboard</p>
                </div>
                <div class="d-flex gap-3">
                    <a href="post-list.php" class="btn btn-primary">Manage Post</a>
                    <a href="post-list.php" class="btn btn-success">Manage Category</a>
                    <a href="post-list.php" class="btn btn-warning">Manage Users</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>