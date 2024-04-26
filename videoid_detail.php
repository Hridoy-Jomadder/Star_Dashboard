<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Details</title>
    <style>
        /* Style for video details */
        .video-details {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .video-details h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .video-details p {
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 10px;
        }

        .video-details p.description {
            font-style: italic;
        }

        .video-details p.tag {
            font-weight: bold;
            color: #007bff;
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            .video-details {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
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
        echo "<div class='video-details'>";
        echo "<h1>{$videoDetails['title']}</h1>";
        echo "<p class='description'>Description: {$videoDetails['description']}</p>";
        echo "<p>Uploaded on: {$videoDetails['upload_date']}</p>";
        echo "<p class='tag'>Tag: {$videoDetails['tag']}</p>";

        // Embed video player
        echo "<video width='640' height='360' controls>";
        echo "<source src='{$videoDetails['video']}' type='video/mp4'>";
        echo "Your browser does not support the video tag.";
        echo "</video>";
        echo "</div>";
        
        // Add any additional information or functionality here
        // For example, you might include a video player to play the video

    } else {
        // Handle the case where the video ID is not found
        echo "<p>Video not found.</p>";
    }
    ?>
</body>
</html>
