<?php

class Database2 {
    private $conn;

    public function __construct($host, $username, $password, $database) {
        // Create connection
        $this->conn = new mysqli($host, $username, $password, $database);

        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getDashboardData() {
        // SQL query to retrieve data
        $sql = "SELECT id, userid, first_name, last_name, profile_image, gender, date, email, ip_address, country, browser_name FROM users";

        // Execute the query
        $result = $this->conn->query($sql);

        // Check if the query execution was successful
        if ($result === false) {
            // If there was an error, print error message and return null
            echo "Error executing query: " . $this->conn->error;
            return null;
        }

        // Check if there are results
        if ($result->num_rows > 0) {
            // Fetch data and return as an associative array
            $data = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            $data = array(); // Return an empty array if no data found
        }

        return $data;
    }

  // Method to construct the URL for profile images
  private function constructProfileImageUrl($imageName) {
    // Assuming "Upload Files" folder is in the root directory accessible from the web
    $baseUrl = $_SERVER['HTTP_HOST']; // Use HTTP_HOST for domain name
    $uploadsFolder = "/Star/";
    return "http://" . $baseUrl . $uploadsFolder . $imageName;
}

// Method to fetch all users from the database
 public function fetchAllUsers() {
     // Define your SQL query to fetch all users
     $query = "SELECT * FROM users";

     // Execute the query
     $result = $this->conn->query($query);

     // Check if the query executed successfully and if there are any results
     if ($result !== false && $result->num_rows > 0) {
         // Fetch all users and return them as an associative array
         $users = $result->fetch_all(MYSQLI_ASSOC);

                     // Append the profile image URL to each user
                     foreach ($users as &$user) {
                        $user['profile_image_url'] = $this->constructProfileImageUrl($user['profile_image']);
                    }
        
         return $users;
     } else {
         // Return false if no users are found or an error occurred
         return false;
     }
 }


    public function __destruct() {
        // Close the connection
        $this->conn->close();
    }
}

// Example usage:
$database = new Database2("localhost", "root", "", "star_db1");
$dashboardData = $database->getDashboardData();

// Display data (you can customize this part based on your requirements)
// if ($dashboardData !== null) {
//     echo "<pre>";
//     print_r($dashboardData);
//     echo "</pre>";
// } else {
//     // Handle the case where dashboard data is null
//     echo "Failed to retrieve dashboard data.";
// }
 

  // Create a new instance of Database2
$database = new Database2("localhost", "root", "", "star_db1");

// Fetch users from the database
$users = $database->fetchAllUsers();

// Display users data (you can customize this part based on your requirements)
// if ($users !== false) {
//     echo "<pre>";
//     print_r($users);
//     echo "</pre>";
// } else {
//     // Handle the case where no users are found or an error occurred
//     echo "Failed to fetch users.";
// }
