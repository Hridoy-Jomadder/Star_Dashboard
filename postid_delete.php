<?php
session_start();

include_once("classes/connect.php");
include_once("classes/login.php");
include_once("classes/database.php");
include_once("classes/database2.php");
include_once("classes/signup.php");

// Check if the user is logged in, redirect to the login page if not
if (!isset($_SESSION['das_userid'])) {
    header("Location: login.php");
    exit();
}

// Check if post ID is provided in the URL
if(isset($_GET['id'])) {
    // Sanitize the post ID to prevent SQL injection
    $post_id = mysqli_real_escape_string($conn, $_GET['id']);

    // SQL query to delete post based on post ID
    $sql = "DELETE FROM posts WHERE postid = '$post_id'";

    // Execute the query
    if(mysqli_query($conn, $sql)) {
        // Post deleted successfully
        echo "Post deleted successfully.";

        // Redirect to dashboard or another page
        header("Location: dashboard.php");
        exit();
    } else {
        // Error deleting post
        echo "Error deleting post: " . mysqli_error($conn);
    }
} else {
    // Post ID not provided
    echo "Post ID not provided.";
}
?>
