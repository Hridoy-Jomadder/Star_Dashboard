<?php class Database
{
    private $conn; // Add this line to declare the $conn property

    public function __construct()
    {
        $this->conn = new mysqli("your_host", "your_username", "your_password", "your_database");

        // Check the connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    // ... other methods and properties ...

    public function execute($query, $params)
    {
        $stmt = $this->conn->prepare($query);

        if ($stmt === false) {
            // Handle prepare error
            $this->error = $this->conn->error;
            return false;
        }

        // Bind parameters
        if (!empty($params)) {
            $types = str_repeat('s', count($params)); // Assuming all parameters are strings
            $stmt->bind_param($types, ...$params);
        }

        // Execute the statement
        $result = $stmt->execute();

        if ($result === false) {
            // Handle execute error
            $this->error = $stmt->error;
        }

        $stmt->close();

        return $result; // Return true or false based on success
    }

    // ... other methods ...
}
