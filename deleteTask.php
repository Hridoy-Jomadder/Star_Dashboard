<?php
if (isset($_GET['taskName'])) {
    // Get the task name from the query parameter
    $taskName = $_GET['taskName'];

    // Establish a connection to the database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "das_db";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM tasks WHERE task_name = ?");
    $stmt->bind_param("s", $taskName);

    // Execute the statement
    if ($stmt->execute()) {
        // Check if any rows were affected
        if ($stmt->affected_rows > 0) {
            echo "Task deleted successfully";
        } else {
            echo "Task not found";
        }
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();

    // Close the connection
    $conn->close();
} else {
    // Handle the case where "taskName" is not set in the $_GET array
    echo "Error: 'taskName' not set in the query parameters.";
}
?>
