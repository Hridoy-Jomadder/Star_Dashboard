class Database
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

    public function readWithParams($query, $params)
    {
        $stmt = $this->conn->prepare($query);

        if ($stmt) {
            // Bind parameters
            if (!empty($params)) {
                $types = str_repeat('s', count($params)); // Assuming all parameters are strings, adjust as needed
                $stmt->bind_param($types, ...$params);
            }

            // Execute the query
            $stmt->execute();

            // Get result set
            $result = $stmt->get_result();

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
            return false;
        }
    }

    public function fetchUserById($userId)
    {
        $query = "SELECT * FROM users WHERE id = ?";
        $params = [$userId];

        $result = $this->readWithParams($query, $params);

        if ($result !== false && !empty($result)) {
            return $result[0]; // Assuming you want to return the first row
        } else {
            // Handle the case where the query fails or no user is found
            return false;
        }
    }
}
