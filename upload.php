<?php
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if a file was selected
    if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
        // Define the upload directory
        $uploadDir = "uploads/";

        // Generate a unique filename for the uploaded file
        $newFileName = uniqid() . "_" . basename($_FILES["file"]["name"]);
        $uploadFilePath = $uploadDir . $newFileName;

        // Move the uploaded file to the upload directory
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $uploadFilePath)) {
            // Update the user's profile photo in the database
            $userId = 1; // Replace with the actual user ID
            updateProfilePhoto($userId, $newFileName);

            echo "Profile photo updated successfully!";
        } else {
            echo "Error uploading file.";
        }
    } else {
        echo "No file selected.";
    }
}

// Function to update the user's profile photo in the database
function updateProfilePhoto($userId, $newFileName) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "das_db";

    // Create a connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Update the user's profile photo in the database
    $sql = "UPDATE users SET profile_image = '$newFileName' WHERE id = $userId";

    if ($conn->query($sql) === TRUE) {
        // Profile photo updated successfully
    } else {
        echo "Error updating profile photo: " . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>
