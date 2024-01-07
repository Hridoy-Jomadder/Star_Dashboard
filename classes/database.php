<?php
class Database
{

    private $conn;
    public $error;

    public function __construct()
    {
        $this->conn = new mysqli("localhost", "root", "", "das_db");

        if ($this->conn->connect_error) {
            $this->error = $this->conn->connect_error;
        }
    }

    public function escape_string($value)
    {
        return $this->conn->real_escape_string($value);
    }

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
    

    public function fetchUserById($userId)
{
    $query = "SELECT * FROM users WHERE userid = ?";
    $params = [$userId];

    $result = $this->readWithParams($query, $params);

    if ($result !== false && !empty($result)) {
        return $result[0]; // Assuming you want to return the first row
    } else {
        // Handle the case where the query fails or no user is found
        return false;
    }
}

    public function fetchAdditionalUserData($userId)
{
    $query = "SELECT * FROM additional_user_data WHERE user_id = ?";
    $params = [$userId];

    $result = $this->readWithParams($query, $params);

    if ($result !== false && !empty($result)) {
        return $result[0]; // Assuming you want to return the first row
    } else {
        return false; // Handle the case where no additional user data is found
    }
}

public function fetchCoCEOData() {
    $query = "SELECT * FROM co_ceo_data_table";
    $result = $this->execute($query);

    if ($result !== false && $result->num_rows > 0) {
        $co_ceo_data = $result->fetch_all(MYSQLI_ASSOC);
        return $co_ceo_data;
    } else {
        return false;
    }
}

public function fetchStarMemberData() {
    $query = "SELECT * FROM star_member_data_table";
    $result = $this->execute($query);

    if ($result !== false && $result->num_rows > 0) {
        $star_member_data = $result->fetch_all(MYSQLI_ASSOC);
        return $star_member_data;
    } else {
        return false;
    }
}

}
