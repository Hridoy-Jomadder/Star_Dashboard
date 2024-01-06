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
    
        // Check if 'email' key is set in $_POST
        if (isset($data['email'])) {
            // Sanitize input
            $email = $DB->escape_string($data['email']);
            $password = $DB->escape_string($data['password']);
        
            // Use prepared statements
            $query = "SELECT * FROM users WHERE email = ? LIMIT 1";
            $result = $DB->readWithParams($query, [$email]);
        
            if ($result) {
                $row = $result[0];
        
                if (password_verify($password, $row['password'])) {
                    // Create session data
                    $_SESSION['das_userid'] = $row['userid'];
                    $_SESSION['das_user_role'] = $row['role'];
                } else {
                    $this->error .= "Wrong email or password<br>";
                }
            } else {
                $this->error .= "No such email was found.<br>";
            }
        } else {
            $this->error .= "Email not provided.<br>";
        }
    
        return $this->error;
    }

    // ... rest of your class ...
}

?>
