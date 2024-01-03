class Login
{

    private $error = "";
 
    public function evaluate($data)
    {
        $email = addslashes($data['email']);
        $password = addslashes($data['password']);

        $query = "SELECT * FROM users WHERE email = '$email' LIMIT 1 ";

        $DB = new Database();
        $result = $DB->read($query);
  
        if ($result) {
            $row = $result[0];

            if ($password == $row['password']) {
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
        if (is_numeric($id)) {
            $query = "SELECT * FROM users WHERE userid = '$id' LIMIT 1 ";

            $DB = new Database();
            $result = $DB->read($query);

            if ($result) {
                $user_data = $result[0];
                return $user_data;
            } else {
                if ($redirect) {
                    header("Location: login.php");
                    die;
                } else {
                    $_SESSION['das_userid'] = 0;
                }
            }
        } else {
            if ($redirect) {
                header("Location: login.php");
                die;
            } else {
                $_SESSION['das_userid'] = 0;
            }
        }
    }
}
