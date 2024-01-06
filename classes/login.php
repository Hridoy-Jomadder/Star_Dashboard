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
        $DB = new Database();

        $email = $DB->escape_string($data['email']);
        $password = $DB->escape_string($data['password']);

        // Fetch user information from the database based on the email
        $user = $this->fetchUserByEmail($email);

        // Check if the user exists
        if ($user && password_verify($password, $user['password'])) {
            // Login successful
            $_SESSION['das_userid'] = $user['userid'];
            $_SESSION['das_user_role'] = $user['role'];

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

    private function fetchUserByEmail($email)
    {
        // Query to fetch user information by email
        $query = "SELECT userid, role, password FROM users WHERE email = ?";
        $params = [$email];

        $result = $this->DB->readWithParams($query, $params);

        // Check if a user was found
        if (!empty($result)) {
            return $result[0];
        } else {
            return null; // User not found
        }
    }
}
?>
