<?php

class Signup
{
    private $error = "";

    public function __construct()
    {
        include_once("classes/database.php");
    }

    public function evaluate($data)
    {
        // Validation (you may need to customize this)
        if (empty($data['username']) || empty($data['password']) || empty($data['email'])) {
            $this->error = "All fields are required.";
            return false;
        }

        $DB = new Database();

        // Sanitize input
        $username = $DB->escape_string($data['username']);
        $password = $DB->escape_string($data['password']);
        $email = $DB->escape_string($data['email']);  // Expects 'email' key

        // Check if 'role' key exists and assign a default value if not set
        $role = isset($data['role']) ? $DB->escape_string($data['role']) : 'default_role';


        // Use prepared statements
        $query = "INSERT INTO users (username, password, email, role) VALUES (?, ?, ?, ?)";
        $params = [$username, password_hash($password, PASSWORD_DEFAULT), $email, $data['role']];

        $result = $DB->execute($query, $params);

        if ($result) {
            // Registration successful
            return true;
        } else {
            // Error handling
            $this->error = $DB->error;
            return false;
        }
    }

    public function getError()
    {
        return $this->error;
    }
}

?>
