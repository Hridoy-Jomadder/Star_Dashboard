<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['das_userid'])) {
    header("Location: login.php");
    exit();
}

// Fetch user role from the database based on the username
$role = get_user_role($_SESSION['username']);

// Set session variables after successful login
$_SESSION['das_userid'] = $row['userid'];
$_SESSION['das_user_role'] = $row['role'];

// Check user role and redirect accordingly
if ($role === 'CEO') {
    // CEO dashboard content
} elseif ($role === 'Co-CEO') {
    // Co-CEO dashboard content
} elseif ($role === 'StarMember') {
    // Star Member dashboard content
} else {
    // Default or unauthorized user content
}

function get_user_role($username) {
    // Implement the logic to fetch user role from the database based on the username
    // Make sure to return the user role from this function
}
