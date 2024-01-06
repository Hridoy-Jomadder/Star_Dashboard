<?php
session_start(); // Ensure that session_start() is called at the beginning

if (!isset($_SESSION['das_userid'])) {
    header("Location: login.php");
    exit();
}

// Fetch user role from the session
$role = $_SESSION['das_user_role'];

var_dump($row);

// Set session variables after successful login
$_SESSION['das_userid'] = $row['userid'];
$_SESSION['das_user_role'] = $row['role'];

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