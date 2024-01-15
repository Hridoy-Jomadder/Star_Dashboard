<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "das_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>


	function read($query)
	{
		$conn = $this->connect();
		$result = mysqli_query($conn,$query);

		if(!$result)
		{
			return false;
		}
		else
		{
			$data = false;
			while($row = mysqli_fetch_assoc($result))
			{

				$data[] = $row;

			}

			return $data;
		}
	}

	function save($query)
	{
		$conn = $this->connect();
		$result = mysqli_query($conn,$query);

		if(!$result)
		{
			return false;
		}else
		{
			return true;
		}
	}

}

