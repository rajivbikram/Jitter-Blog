<?php
session_start();
require 'connection.php';
$commentId = $_GET['id'];
$userId = $_SESSION['userId'];
$selectQuery = "SELECT id,user_id FROM comments WHERE id='$commentId'";
$result = mysqli_query($conn, $selectQuery);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    if ($row['user_id'] != $userId) {
        header("Location: blog.php");
        exit();
    }
    $deleteQuery = "DELETE FROM comments WHERE id = '$commentId'";
    if (mysqli_query($conn, $deleteQuery) === TRUE) {
        echo "Comment Deleted Successfully.";
        header("Location: blog.php");
    }
} else {
    echo "Comment not found.";
}

// Close DB connection
$conn->close();
