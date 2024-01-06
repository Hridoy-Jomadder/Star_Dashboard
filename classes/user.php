<?php 

class User
{

	public function get_user($id)
	{
		$query = "SELECT * FROM users WHERE userid = ? LIMIT 1";
		$DB = new Database();
		$result = $DB->readWithParams($query, [$id]);
	
		if ($result) {
			return $result[0];
		} else {
			return false;
		}
	}
	
    public function get_user($id)
	{

		$query = "select * from users where userid = '$id' limit 1";
		$DB = new Database();
		$result = $DB->read($query);

		if($result)
		{
			return $result[0];
		}else
		{

			return false;
		}
	}
}
