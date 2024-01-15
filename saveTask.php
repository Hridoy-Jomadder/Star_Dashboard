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

    // Use prepared statements to prevent SQL injection
    $sql = "INSERT INTO tasks (task_name) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $taskName);

    if ($stmt->execute()) {
        echo "Task saved successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the connection
    $stmt->close();
    $conn->close();
} else {
    // Handle the case where "taskName" is not set in the $_GET array
    echo "Error: 'taskName' not set in the query parameters.";
}
?>
