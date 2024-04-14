<?php 
function getDashboardData() {
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "star_db1";

    // Create connection
    $conn = new mysqli($host, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL query to retrieve data
    $sql = "SELECT userid, first_name, post, ip_address, country, browser_name FROM users";

    // Execute the query
    $result = $conn->query($sql);

    // Check if the query execution was successful
    if ($result === false) {
        // If there was an error, print error message and return null
        echo "Error executing query: " . $conn->error;
        return null;
    }

    // Check if there are results
    if ($result->num_rows > 0) {
        // Fetch data and return as an associative array
        $data = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $data = array(); // Return an empty array if no data found
    }

    // Close the connection
    $conn->close();

    return $data;
}

// Example usage:
$dashboardData = getDashboardData();

// Display data (you can customize this part based on your requirements)
if ($dashboardData !== null) {
    echo "<pre>";
    print_r($dashboardData);
    echo "</pre>";
} else {
    // Handle the case where dashboard data is null
    echo "Failed to retrieve dashboard data.";
}
