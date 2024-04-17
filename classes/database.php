<?php
class Database
{

    private $conn;
    public $error;

    public function __construct()
    {
        $this->conn = new mysqli("localhost", "root", "", "das_db");

        if ($this->conn->connect_error) {
            $this->error = $this->conn->connect_error;
        }
    }

    public function escape_string($value)
    {
        return $this->conn->real_escape_string($value);
    }

    public function execute($query, $params = [])
    {
        $stmt = $this->conn->prepare($query);

        if ($stmt) {
            if (!empty($params)) {
                $types = str_repeat('s', count($params));
                $stmt->bind_param($types, ...$params);
            }

            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();

            return $result;
        } else {
            $this->error = $this->conn->error;
            return false;
        }
    }

    public function readWithParams($query, $params) {
        $stmt = $this->conn->prepare($query);
    
        if ($stmt) {
            // Bind parameters
            if (!empty($params)) {
                $types = str_repeat('s', count($params));
                $stmt->bind_param($types, ...$params);
            }
    
            // Execute the query
            $stmt->execute();
    
            // Get result set
            $result = $stmt->get_result();
    
            if ($result === false) {
                // Display error if the result is false
                echo "Database Error: " . $this->conn->error;
                return false;
            }
    
            // Fetch the results
            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
    
            // Close statement
            $stmt->close();
    
            return $data;
        } else {
            // Handle statement preparation failure
            echo "Statement Preparation Error: " . $this->conn->error;
            return false;
        }
    }
    

    public function fetchUserById($userId)
{
    $query = "SELECT * FROM users WHERE userid = ?";
    $params = [$userId];

    $result = $this->readWithParams($query, $params);

    if ($result !== false && !empty($result)) {
        return $result[0]; // Assuming you want to return the first row
    } else {
        // Handle the case where the query fails or no user is found
        return false;
    }
}

    public function fetchAdditionalUserData($userId)
{
    $query = "SELECT * FROM additional_user_data WHERE user_id = ?";
    $params = [$userId];

    $result = $this->readWithParams($query, $params);

    if ($result !== false && !empty($result)) {
        return $result[0]; // Assuming you want to return the first row
    } else {
        return false; // Handle the case where no additional user data is found
    }
}

public function fetchCoCEOData() {
    $query = "SELECT * FROM co_ceo_data_table";
    $result = $this->execute($query);

    if ($result !== false && $result->num_rows > 0) {
        $co_ceo_data = $result->fetch_all(MYSQLI_ASSOC);
        return $co_ceo_data;
    } else {
        return false;
    }
}

public function fetchStarMemberData() {
    $query = "SELECT * FROM star_member_data_table";
    $result = $this->execute($query);

    if ($result !== false && $result->num_rows > 0) {
        $star_member_data = $result->fetch_all(MYSQLI_ASSOC);
        return $star_member_data;
    } else {
        return false;
    }
}


public function fetchCoCEODetails($userId) {
    $query = "SELECT * FROM co_ceo_table WHERE user_id = ?";
    $params = [$userId];

    $result = $this->readWithParams($query, $params);

    if ($result !== false && !empty($result)) {
        return $result[0]; // Assuming you want to return the first row
    } else {
        // Handle the case where the query fails or no CO-CEO data is found
        return false;
    }
}

public function fetchStarMemberDetails($userId) {
    $query = "SELECT * FROM star_member_table WHERE user_id = ?";
    $params = [$userId];

    $result = $this->readWithParams($query, $params);

    if ($result !== false && !empty($result)) {
        return $result[0]; // Assuming you want to return the first row
    } else {
        // Handle the case where the query fails or no Star Member data is found
        return false;
    }
}

// Function to fetch CEO data
public function fetchCEOData() {
    try {
        $query = "SELECT profile_image, CONCAT(first_name, ' ', last_name) AS full_name, role AS user_role, email, join_date FROM users WHERE role = 'CEO' LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $ceo_data = $result->fetch_assoc();
            return $ceo_data;
        } else {
            return false; // No CEO data found
        }
    } catch (Exception $e) {
        echo "Error fetching CEO data: " . $e->getMessage();
        exit();
    }
}

// Function to fetch CO-CEO data
public function fetchCO_CEOData() {
    try {
        $query = "SELECT profile_image, CONCAT(first_name, ' ', last_name) AS full_name, role AS user_role, email, join_date FROM users WHERE role = 'CO-CEO' LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $co_ceo_data = $result->fetch_assoc();
            return $co_ceo_data;
        } else {
            return false; // No CO-CEO data found
        }
    } catch (Exception $e) {
        echo "Error fetching CO-CEO data: " . $e->getMessage();
        exit();
    }
}

public function fetchStar_MemberData() {
    try {
        $query = "SELECT profile_image, CONCAT(first_name, ' ', last_name) AS full_name, role AS user_role, email, join_date FROM starmember_user WHERE role = 'Star Member' LIMIT 1";
        $result = $this->execute($query); // Use the execute method

        if ($result !== false && $result->num_rows > 0) {
            $starmember_data = $result->fetch_assoc();
            return $starmember_data;
        } else {
            return false; // No Star Member data found
        }
    } catch (Exception $e) {
        echo "Error fetching Star Member data: " . $e->getMessage();
        // exit(); Remove this line to display potential errors
    }
}

public function fetchUserData($userIds, $userRoles) {
    // Initialize an empty array to store user data
    $userData = array();

    // Loop through each user ID and user role
    for ($i = 0; $i < count($userIds); $i++) {
        switch ($userRoles[$i]) {
            case 'ceo':
                $userData[$i] = $this->fetchCEOData($userIds[$i]);
                break;
            case 'co_ceo':
                $userData[$i] = $this->fetchCo_CEOData($userIds[$i]);
                break;
            case 'star_member':
                $userData[$i] = $this->fetchStar_MemberData($userIds[$i]);
                break;
            default:
                $userData[$i] = false;
        }
    }

    return $userData;
}

public function fetchUserDataByRole($roles) {
    // Ensure $roles is an array
    if (!is_array($roles)) {
        $roles = array($roles);
    }

    // Escape each role to prevent SQL injection
    $escapedRoles = array_map(array($this->conn, 'real_escape_string'), $roles);
    $implodedRoles = implode("','", $escapedRoles);

    // Construct the SQL query
    $query = "SELECT * FROM users WHERE role IN ('$implodedRoles')";

    // Execute the query
    $result = $this->conn->query($query);

    // Check if the query was successful
    if ($result !== false && $result->num_rows > 0) {
        // Fetch the data
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    } else {
        // Return an empty array if no data is found
        return array();
    }
}

public function searchUsers($searchTerm) {
    // Initialize an empty array to store the search results
    $results = array();

    // Sanitize the search term to prevent SQL injection
    $searchTerm = $this->sanitizeInput($searchTerm);

    // Prepare the SQL query to search for users by name
    $sql = "SELECT * FROM users WHERE first_name LIKE ? OR last_name LIKE ?";

    // For searching by name, we need to add '%' wildcards to search for partial matches
    $searchTermWithNameWildcard = "%$searchTerm%";

    // Bind the search term to the query
    $stmt = $this->conn->prepare($sql);

    // Check if the statement was prepared successfully
    if ($stmt) {
        // Bind parameters with proper data types
        $stmt->bind_param("ss", $searchTermWithNameWildcard, $searchTermWithNameWildcard);

        // Execute the query
        $stmt->execute();

        // Get the result set
        $result = $stmt->get_result();

        // Fetch the rows and store them in the results array
        while ($row = $result->fetch_assoc()) {
            $results[] = $row;
        }

        // Close the statement
        $stmt->close();
    } else {
        // Handle the case where statement preparation fails
        // You can log an error message or perform other actions as needed
        error_log("Failed to prepare statement: " . $this->conn->error);
    }

    // Return the search results
    return $results;
}


// Define the sanitizeInput method
public function sanitizeInput($input) {
    // Implement your input sanitization logic here
    // For example, you could use PHP's built-in functions like htmlspecialchars
    return htmlspecialchars($input);
}


//add to function

public function fetchMessages($senderRole, $receiverRole) {
    $query = "SELECT * FROM messages WHERE sender_role = ? AND receiver_role = ? ORDER BY sent_at ASC";
    $params = [$senderRole, $receiverRole];

    $result = $this->readWithParams($query, $params);

    if ($result !== false && !empty($result)) {
        return $result;
    } else {
        return []; // Return an empty array if no messages are found
    }
}


    /// Method to save a message to the database
    public function saveMessage($id, $sender_name, $sender_role, $sender_picture, $receiver_name, $receiver_role, $receiver_picture, $message, $sent_at, $is_read) {
        // Prepare the SQL query
        $query = "INSERT INTO messages (id, sender_name, sender_role, sender_picture, receiver_name, receiver_role, receiver_picture, message, sent_at, is_read) 
                VALUES ('$id', '$sender_name', '$sender_role', '$sender_picture', '$receiver_name', '$receiver_role', '$receiver_picture', '$message', '$sent_at', '$is_read')";
    
        // Execute the query
        $result = $this->conn->query($query);
    
        if ($result === true) {
            // Message saved successfully
            return true;
        } else {
            // Failed to save the message
            echo "Error: " . $this->conn->error;
            return false;
        }
    }
    
public function fetchMessagesByRoles($senderRole, $receiverRole) {
    $query = "SELECT * FROM messages WHERE sender_role = ? AND receiver_role = ?";
    $params = [$senderRole, $receiverRole];

    $result = $this->readWithParams($query, $params);

    if ($result !== false && !empty($result)) {
        return $result;
    } else {
        // Handle the case where the query fails or no messages are found
        echo "Failed to fetch messages.";
        return [];
    }
}
public function fetchMessagesByRolesWithPagination($senderRole, $receiverRole, $offset, $pageSize) {
    $query = "SELECT * FROM messages WHERE sender_role = ? AND receiver_role = ? LIMIT ?, ?";
    $params = [$senderRole, $receiverRole, $offset, $pageSize];

    $result = $this->readWithParams($query, $params);

    if ($result !== false && !empty($result)) {
        return $result;
    } else {
        // Handle the case where the query fails or no messages are found
        echo "Failed to fetch messages: " . $this->conn->error;
        return [];
    }
}

public function countMessagesByRoles($senderRole, $receiverRole) {
    $query = "SELECT COUNT(*) AS total FROM messages WHERE sender_role = ? AND receiver_role = ?";
    $params = [$senderRole, $receiverRole];

    $result = $this->readWithParams($query, $params);

    if ($result !== false && !empty($result)) {
        return $result[0]['total'];
    } else {
        // Handle the case where the query fails or no messages are found
        return 0;
    }
}

}


