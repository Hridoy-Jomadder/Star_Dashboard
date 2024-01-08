<?php
class Login
{
    private $error = "";
    private $DB;

    public function __construct(Database $DB)
    {
        $this->DB = $DB;
    }

    public function evaluate($data)
    {
        $email = $this->DB->escape_string($data['email']);
        $password = $this->DB->escape_string($data['password']);

        // Fetch user information from the database based on the email
        $user = $this->fetchUserByEmail($email);

        // Check if the user exists
        if ($user && password_verify($password, $user['password'])) {
            // Login successful
            $_SESSION['das_userid'] = $user['userid'];
            $_SESSION['das_user_role'] = $user['role'];

            // Fetch additional user data
            $additionalUserData = $this->fetchAdditionalUserData($user['userid']);
            $_SESSION['das_user_data'] = $additionalUserData;

            // Set $row for dashboard.php
            $row = $user;

            header("Location: dashboard.php");
            exit();
        } else {
            // Login failed
            $this->error = "Invalid email or password";
            return $this->error;
        }
    }

    private function fetchAdditionalUserData($userId)
    {
        // Query to fetch additional user data by user ID
        $query = "SELECT * FROM additional_user_data WHERE user_id = ?";
        $params = [$userId];

        $result = $this->DB->readWithParams($query, $params);

        // Check if additional user data was found
        if (!empty($result)) {
            return $result[0];
        } else {
            return null; // Additional user data not found
        }
    }

    private function fetchUserByEmail($email)
    {
        // Query to fetch user information by email
        $query = "SELECT userid, role, password FROM users WHERE email = ?";
        $params = [$email];
    
        // For debugging purposes, output the SQL query
        // echo "Debug: SQL Query: $query, Params: " . implode(', ', $params) . "<br>";
        
        $result = $this->DB->readWithParams($query, $params);
    
        // Check if a user was found
        if (!empty($result)) {
            return $result[0];
        } else {
            return null; // User not found
        }
    }
    
}
