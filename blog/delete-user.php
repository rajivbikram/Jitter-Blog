<?php
session_start();
require 'connection.php';
$userid = $_GET['id'];
$selectQuery = "SELECT user_id FROM users WHERE user_id='$userid'";
$result = mysqli_query($conn, $selectQuery);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    if ($row['user_id'] == $_SESSION['userId']) {
        header("Location: user-list.php");
        exit();
    }
    $deleteQuery = "DELETE FROM users WHERE user_id = '$userid'";
    if (mysqli_query($conn, $deleteQuery) === TRUE) {
        echo "User Deleted Successfully.";
        header("Location: user-list.php");
    }
} else {
    echo "User not found.";
}

// Close DB connection
$conn->close();
