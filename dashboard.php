<?php
session_start();

if (!isset($_SESSION['das_userid'])) {
    header("Location: login.php");
    exit();
}

// Fetch user role from the session
$role = isset($_SESSION['das_user_role']) ? $_SESSION['das_user_role'] : null;

// Check if $role is not null before displaying the welcome message
if ($role === 'CEO') {
    $welcomeMessage = "Welcome CEO!";
} elseif ($role === 'Co-CEO') {
    $welcomeMessage = "Welcome Co-CEO!";
} elseif ($role === 'StarMember') {
    $welcomeMessage = "Welcome Star Member!";
} else {
    $welcomeMessage = "Welcome User!";
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