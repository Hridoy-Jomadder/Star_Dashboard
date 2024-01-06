<?php
session_start();

if (!isset($_SESSION['das_userid'])) {
    header("Location: login.php");
    exit();
}

// Fetch user role from the session
$role = isset($_SESSION['das_user_role']) ? $_SESSION['das_user_role'] : null;

// Check if $row is not null before accessing its values
if (isset($row) && is_array($row)) {
    // Set session variables after successful login
    $_SESSION['das_userid'] = $row['userid'];
    $_SESSION['das_user_role'] = $row['role'];

    // Fetch user role from the session
    $role = $_SESSION['das_user_role'];

    // Check user role and redirect accordingly
    if ($role === 'CEO') {
        // CEO dashboard content
        echo "<h1>Welcome CEO!</h1>";
    } elseif ($role === 'Co-CEO') {
        // Co-CEO dashboard content
        echo "<h1>Welcome Co-CEO!</h1>";
    } elseif ($role === 'StarMember') {
        // Star Member dashboard content
        echo "<h1>Welcome Star Member!</h1>";
    } else {
        // Default or unauthorized user content
        echo "<h1>Welcome User!</h1>";
    }
} else {
    // Handle the case where user information is not available
    echo "<h1>Error: User information not available</h1>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- your head content here -->
</head>

<body>
    <!-- your body content here -->

    <?php
    // Check user role and display accordingly
    if ($role === 'CEO') {
        // CEO dashboard content
        echo "<h1>Welcome CEO!</h1>";
    } elseif ($role === 'Co-CEO') {
        // Co-CEO dashboard content
        echo "<h1>Welcome Co-CEO!</h1>";
    } elseif ($role === 'StarMember') {
        // Star Member dashboard content
        echo "<h1>Welcome Star Member!</h1>";
    } else {
        // Default or unauthorized user content
        echo "<h1>Welcome User!</h1>";
    }
    ?>

</body>

</html>