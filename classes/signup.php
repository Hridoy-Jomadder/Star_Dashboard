<?php

class Signup
{
    private $error = "";

    public function __construct()
    {
        include_once("classes/database.php");
    }

    public function registerUser($data)
    {
        $DB = new Database();

        // Sanitize input
        $email = $DB->escape_string($data['email']);
        $password = $DB->escape_string($data['password']);
        // You may want to add additional validations and checks

        // Check if the email already exists
        $existingUser = $DB->readWithParams("SELECT * FROM users WHERE email = ?", [$email]);

        if ($existingUser) {
            $this->error .= "Email already exists. Please choose a different one.<br>";
            return $this->error;
        }

        // Insert the new user into the database
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $insertQuery = "INSERT INTO users (email, password) VALUES (?, ?)";
        $result = $DB->write($insertQuery, [$email, $hashedPassword]);

        if (!$result) {
            $this->error .= "Registration failed. Please try again.<br>";
        }

        return $this->error;
    }
}

?>
