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


