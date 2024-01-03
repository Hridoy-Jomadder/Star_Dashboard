<?php

class Login
{

	private $error = "";
 
	public function evaluate($data)
	{

		$email = addslashes($data['email']);
		$password = addslashes($data['password']);

		$query = "select * from users where email = '$email' limit 1 ";

		$DB = new Database();
		$result = $DB->read($query);
  
		if($result)
		{

			$row = $result[0];

			if($password == $row['password'])
			{

				//create session data
				$_SESSION['das_userid'] = $row['userid'];

			}else
			{
				$this->error .= "wrong email or password<br>";
			}
		}else
		{

			$this->error .= "No Such email was found.<br>";
		}

		return $this->error;
		
	}
    
    public function check_login($id,$redirect = true)
    {
        if (is_numeric($id))
           {
                $query = "select * from users where userid = '$id' limit 1 ";

                $DB = new Database();
                $result = $DB->read($query);

                // Add this code in the check_login function after verifying credentials
                if ($result) {
                  $_SESSION['das_user_role'] = $user_data['role'];
                }
                else
                {
                 if($redirect){
                   header("Location: login.php");
                   die;
                 }else{
                     
                  $_SESSION['das_userid'] = 0;
                     
                 }
               }   
         }else
         {

         if($redirect){
                header("Location: login.php");
                die;
                 }else{
             
                 $_SESSION['das_userid'] = 0;
             
                 }
        }
   }
}
