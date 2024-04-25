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
// Assuming the video ID is passed as a query parameter named 'id'
$videoID = $_GET['id']; // Retrieve the video ID from the URL parameter

// Assuming you have a method in your Database class to fetch video details by ID
// Replace 'fetchVideoByID' with the appropriate method name in your Database class
$videoDetails = $database->fetchVideoByID($videoID);

// Check if video details are found
if ($videoDetails !== false) {
    // Display video details
    echo "<h1>{$videoDetails['title']}</h1>";
    echo "<p>Description: {$videoDetails['description']}</p>";
    echo "<p>Uploaded on: {$videoDetails['upload_date']}</p>";
    echo "<p>Tag: {$videoDetails['tag']}</p>";

    // Add any additional information or functionality here
    // For example, you might include a video player to play the video

} else {
    // Handle the case where the video ID is not found
    echo "<p>Video not found.</p>";
}
