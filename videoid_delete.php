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
$videos = $database->fetchAllVideos();

// Create a new instance of Database2
$database = new Database2("localhost", "root", "", "star_db1");

// Now you can call the deleteVideoByID method
$videoID = $_GET['id']; // Assuming you get the video ID from the URL
$result = $database->deleteVideoByID($videoID);
if ($result) {
    echo "Video deleted successfully.";
} else {
    echo "Failed to delete video.";
}
// Now you can use the $database object
$videoID = $_GET['id']; // Assuming you get the video ID from the URL
$result = $database->deleteVideoByID($videoID);
if ($result) {
    echo "Video deleted successfully.";
} else {
    echo "Failed to delete video.";
}
