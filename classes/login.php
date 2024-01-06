<?php

class Login
{
    private $error = "";

    public function evaluate($data)
    {
        $DB = new Database();

        // Sanitize input
        $email = $DB->escape_string($data['email']);
        $password = $DB->escape_string($data['password']);

        $query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
        $result = $DB->read($query);

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

        return $this->error;
    }

    public function check_login($id, $redirect = true)
    {
        $DB = new Database();

        if (is_numeric($id)) {
            $query = "SELECT * FROM users WHERE userid = '$id' LIMIT 1";
            $result = $DB->read($query);

            if ($result) {
                $user_data = $result[0];
                return $user_data;
            } else {
                if ($redirect) {
                    header("Location: login.php");
                }
            }
        } else {
            if ($redirect) {
                header("Location: login.php");
            }
        }

        $_SESSION['das_userid'] = 0;
    }
}

?>
