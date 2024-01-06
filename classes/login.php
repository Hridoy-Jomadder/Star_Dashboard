<?php

class Login
{
    private $error = "";

    public function __construct()
    {
        include_once("classes/database.php");
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
        $DB = new Database();
        $email = $DB->escape_string($email);

        // Query to fetch user information by email
        $query = "SELECT id, userid, role, password FROM users WHERE email = ?";
        $params = [$email];

        $result = $DB->readWithParams($query, $params);

        // Check if a user was found
        if (!empty($result)) {
            return $result[0];
        } else {
            return null; // User not found
        }
    }
}
?>
