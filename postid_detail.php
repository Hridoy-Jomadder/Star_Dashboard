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

    // SQL query to retrieve post details based on post ID
    $sql = "SELECT * FROM posts WHERE postid = '$post_id'";

    // Execute the query
    $result = mysqli_query($conn, $sql);

    // Check if query executed successfully
    if ($result === false) {
        // Log the error for debugging purposes
        error_log("Error executing query: " . mysqli_error($conn));
        
        // Provide a user-friendly error message
        echo "An error occurred while retrieving the post details. Please try again later.";
    } else {
        // Check if post details are found
        if(mysqli_num_rows($result) > 0) {
            // Fetch post details
            $post = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Detail</title>
</head>
<body>
    <h1>Post Detail</h1>
    <div>
        <h2><?php echo htmlspecialchars($post['post_title']); ?></h2>
        <p><?php echo htmlspecialchars($post['post_content']); ?></p>
        <p>Date: <?php echo htmlspecialchars($post['post_date']); ?></p>
        <?php if(!empty($post['image_url'])): ?>
            <img src="<?php echo htmlspecialchars($post['image_url']); ?>" alt="Post Image" style="max-width: 300px;">
        <?php endif; ?>
    </div>
</body>
</html>
<?php
            // Free result set
            mysqli_free_result($result);
        } else {
            // Provide a generic error message for post not found
            echo "Post not found.";
        }
    }

    // Close the connection
    mysqli_close($conn);
} else {
    // Post ID not provided
    echo "Post ID not provided.";
}
?>
