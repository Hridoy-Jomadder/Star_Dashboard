<?php

class Database {
    private $conn;
    public $error;

    public function __construct($dbType)
    {
        $this->connectToDatabase($dbType);
    }

    private function connectToDatabase($dbType) {
        if ($dbType === 'das_db') {
            $this->conn = new mysqli("localhost", "root", "", "das_db");
        } elseif ($dbType === 'star_db1') {
            $this->conn = new mysqli("localhost", "root", "", "star_db1");
        } else {
            $this->error = "Invalid database type";
            return;
        }

        if ($this->conn->connect_error) {
            $this->error = $this->conn->connect_error;
        }
    }

    // Function to escape strings
    public function escape_string($value)
    {
        return $this->conn->real_escape_string($value);
    }

    // Function to execute prepared statements
    public function execute($query, $params = [])
    {
        $stmt = $this->conn->prepare($query);

        if ($stmt) {
            if (!empty($params)) {
                $types = str_repeat('s', count($params));
                $stmt->bind_param($types, ...$params);
            }

            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();

            return $result;
        } else {
            $this->error = $this->conn->error;
            return false;
        }
    }

    // Function to execute prepared statements with parameters and fetch data
    public function readWithParams($query, $params) {
        $stmt = $this->conn->prepare($query);

        if ($stmt) {
            // Bind parameters
            if (!empty($params)) {
                $types = str_repeat('s', count($params));
                $stmt->bind_param($types, ...$params);
            }

            // Execute the query
            $stmt->execute();

            // Get result set
            $result = $stmt->get_result();

            if ($result === false) {
                // Display error if the result is false
                echo "Database Error: " . $this->conn->error;
                return false;
            }

            // Fetch the results
            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }

            // Close statement
            $stmt->close();

            return $data;
        } else {
            // Handle statement preparation failure
            echo "Statement Preparation Error: " . $this->conn->error;
            return false;
        }
    }

    // Function to fetch user data by user ID
    public function fetchUserById($userId)
    {
        $query = "SELECT * FROM users WHERE userid = ?";
        $params = [$userId];

        return $this->readWithParams($query, $params);
    }

    // Function to fetch additional user data by user ID
    public function fetchAdditionalUserData($userId)
    {
        $query = "SELECT * FROM additional_user_data WHERE user_id = ?";
        $params = [$userId];

        return $this->readWithParams($query, $params);
    }

    // Function to fetch CO-CEO data
    public function fetchCoCEOData() {
        $query = "SELECT * FROM co_ceo_data_table";
        return $this->execute($query);
    }

    // Function to fetch star member data
    public function fetchStarMemberData() {
        $query = "SELECT * FROM star_member_data_table";
        return $this->execute($query);
    }

    // Function to fetch CO-CEO details by user ID
    public function fetchCoCEODetails($userId) {
        $query = "SELECT * FROM co_ceo_table WHERE user_id = ?";
        $params = [$userId];
        return $this->readWithParams($query, $params);
    }

    // Function to fetch star member details by user ID
    public function fetchStarMemberDetails($userId) {
        $query = "SELECT * FROM star_member_table WHERE user_id = ?";
        $params = [$userId];
        return $this->readWithParams($query, $params);
    }

    // Destructor to close connection
    public function __destruct() {
        $this->conn->close();
    }
}

// Assuming you want to connect to 'das_db'
$database1 = new Database('das_db');

// Assuming you want to connect to 'star_db1'
$database2 = new Database('star_db1');


