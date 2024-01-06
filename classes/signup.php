<?php

class Signup
{
    private $error = "";

    public function __construct()
    {
        // Database connection is not instantiated here; it might be done elsewhere
        // include_once("classes/database.php");
    }

    public function evaluate($data)
    {
        $DB = new Database();

        // Sanitize input
        $username = $DB->escape_string($data['username']);
        $password = $DB->escape_string($data['password']);
        $email = $DB->escape_string($data['email']);  // Expects 'email' key

        // Use prepared statements
        $query = "INSERT INTO users (username, password, email, role) VALUES (?, ?, ?, 'StarMember')";
        $params = [$username, password_hash($password, PASSWORD_DEFAULT), $email];

        // Execute the query and handle errors
        $result = $DB->execute($query, $params);

        if ($result) {
            // Registration successful
            return true;
        } else {
            // Get the specific error message from the Database class
            $this->error = $DB->get_error();
            return $this->error;
        }
    }
}
