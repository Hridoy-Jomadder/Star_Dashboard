<?php
function getprofile_image($userId, $conn)
{
    $sql = "SELECT profile_image FROM users WHERE id = $userId";
    $result = $conn->query($sql);

    if (!$result) {
        // Add error handling
        echo "Error in SQL query: " . $conn->error;
        return "img/photo.png"; // Default image
    }

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $profileImage = $row["profile_image"];

        // Check if the file exists
        $imagePath = "uploads/" . $profileImage;
        if (file_exists($imagePath)) {
            return $profileImage;
        } else {
            // Add error handling
            echo "Image file not found: $imagePath";
            return "img/photo.png"; // Default image
        }
    } else {
        // Add error handling
        echo "No rows found for user ID: $userId";
        return "img/photo.png"; // Default image
    }
}
