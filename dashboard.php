<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['das_userid'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Display welcome message, name, and title
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Your head content here -->
</head>

<body>
    <div>
        <h2>Welcome to STAR_DASHMIN!</h2>
        <p>Name: <?php echo $_SESSION['das_first_name'] . ' ' . $_SESSION['das_last_name']; ?></p>
        <p>Title: <?php echo $_SESSION['das_user_role']; ?></p>
    </div>

    <!-- Your code to fetch and display user data from the database -->
    <?php
    // Assuming you have a function to fetch user data by user ID from your database
    function fetchUserData($userID) {
        // Your database query logic here
        // ...

        // Example: Fetching user data from your database
        $userData = [
            'first_name' => 'Hridoy',
            'last_name' => 'Jomadder',
            'title' => 'CEO',
            // ... other user data fields
        ];

        return $userData;
    }

    // Fetch user data based on the user's session ID
    $loggedInUserData = fetchUserData($_SESSION['das_userid']);
    ?>

    <!-- Displaying additional user information from the database -->
    <p>Additional Information:</p>
    <p>Title: <?php echo $loggedInUserData['title']; ?></p>
    <!-- ... other user data fields you want to display -->

    <!-- Rest of your HTML content here -->

</body>

</html>
