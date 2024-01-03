<?php 

 session_start();

 include("classes/connect.php");
 include("classes/login.php");
 include("classes/user.php");
 
 //check if user is logged in
 if(isset($_SESSION['das_userid']) && is_numeric($_SESSION['das_userid']))
 {
    $id = $_SESSION['das_userid'];
    $login = new Login();

    $result = $login->check_login($id);

    if($result)
    {
        //retrieve user data;
        $user = new User();
        $user_data = $user->get_data($id);

        if(!$user_data){
            header("Location: login.php");
            die;
        }

    }else{
        header("Location: login.php");
        die;
    }
 }else{
    header("Location: login.php");
    die;
 }


// Retrieve the user's profile photo from the database
$userId = 1; // Replace with the actual user ID
$profile_image = getprofile_image($userId);

function getprofile_image($userId) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "das_db";

    // Create a connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve the user's profile photo from the database
    $sql = "SELECT profile_image FROM users WHERE id = $userId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row["profile_image"];
    } else {
        return "img/photo.png"; // Replace with a default photo
    }
}
?>