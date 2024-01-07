<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['das_userid'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Display welcome message, name, and title
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Your head content here -->
</head>

<body>
    <div>
        <h2>Welcome to STAR_DASHMIN!</h2>
        <p>Name: <?php echo $_SESSION['das_first_name'] . ' ' . $_SESSION['das_last_name']; ?></p>
        <p>Title: <?php echo $_SESSION['das_user_role']; ?></p>
    </div>

    <!-- Rest of your HTML content here -->

</body>

</html>
