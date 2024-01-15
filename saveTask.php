<?php
if (isset($_GET['taskName'])) {
    // Get the task name from the query parameter
    $taskName = $_GET['taskName'];

    // Check if taskName is not empty
    if (!empty($taskName)) {

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

        // Insert the task into the tasks table
        $sql = "INSERT INTO tasks (task_name) VALUES ('$taskName')";

        if ($conn->query($sql) === TRUE) {
            echo "Task saved successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close the connection
        $conn->close();
    } else {
        // Handle the case where taskName is empty
        echo "Error: 'taskName' is empty.";
    }
} else {
    // Debugging statement to print the entire $_GET array
    echo "Debugging: ";
    print_r($_GET);
    
    // Handle the case where "taskName" is not set in the $_GET array
    echo "Error: 'taskName' not set in the query parameters.";
}
?>
