<?php
// Start the session
session_start();

// Include necessary files
include_once("classes/connect.php");
include_once("classes/database.php");

// Check if the user is logged in, redirect to the login page if not
if (!isset($_SESSION['das_userid'])) {
    header("Location: login.php");
    exit();
}

// Create a Database instance
$DB = new Database();

// Fetch user information based on the user ID stored in the session
$user = $DB->fetchUserById($_SESSION['das_userid']);

// Check if the user is found
if (!$user) {
    // Handle the case where the user is not found
    echo "User not found.";
    exit();
}

// Now you can use $user to display user information in your dashboard
$first_name = $user['first_name'];
$last_name = $user['last_name'];
$role = $user['role'];

// Set a default profile image or use the user's profile image if available
$profile_image = isset($user['profile_image']) && !empty($user['profile_image']) ? $user['profile_image'] : 'default_profile_image.jpg';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize message content
    $message_content = htmlspecialchars($_POST["message_content"]);

    // Assuming the receiver role is the opposite of the sender role
    $receiverRole = ($user['role'] === 'CEO') ? 'Co-CEO' : 'CEO';

    // Insert the message into the database
    $result = $DB->saveMessage($id, $first_name . ' ' . $last_name, $user['role'], $profile_image, 'ReceiverNameHere', $receiverRole, 'ReceiverProfileImageHere', $message_content, date("Y-m-d H:i:s"), 0);

    // Check if the message is successfully saved
    if ($result) {
        // Message saved successfully, you can redirect or display a success message here
        // For now, let's redirect to the same page to avoid form resubmission
        header("Location: message.php");
        exit();
    } else {
        // Failed to save the message, you can handle this accordingly
        echo "<h3>Failed to send message. Please try again.</h3>";
    }
}

// Fetch messages from the 'messages' table based on sender and receiver roles
$senderRole = 'CEO'; // Replace with the actual sender role
$receiverRole = 'Co-CEO'; // Replace with the actual receiver role
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Get the current page number
$pageSize = 5; // Number of messages per page

$perPage = 10; // Change the value as per your pagination needs

// Calculate the offset based on the page number and page size
$offset = ($page - 1) * $pageSize;

// Fetch messages with pagination
$messages = $DB->fetchMessagesByRolesWithPagination($senderRole, $receiverRole, $offset, $pageSize);

// Check if messages are retrieved successfully before looping through them

?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>DASHMIN - Star</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <style>

.message {
    margin-bottom: 20px;
    padding: 15px;
    border-radius: 8px;
}

.sender {
    background-color: #cce5ff;
    float: right;
}

.receiver {
    background-color: floralwhite;
    float: left;
}

.pagination {
    margin-top: 20px;
}

.pagination .page-item .page-link {
    color: #007bff;
    background-color: transparent;
    border: 1px solid #007bff;
}

.pagination .page-item .page-link:hover {
    background-color: #007bff;
    color: #fff;
}

.pagination .page-item.active .page-link {
    background-color: #007bff;
    border-color: #007bff;
}

.pagination .page-item.disabled .page-link {
    color: #6c757d;
    pointer-events: none;
    cursor: not-allowed;
    background-color: transparent;
    border: 1px solid #dee2e6;
}


        </style>

</head>

<body>
    <div class="container-fluid position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <!-- <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div> -->
        <!-- Spinner End -->


        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-light navbar-light">
                <a href="dashboard.php" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><i class="fa fa-star me-2"></i>DASHMIN</h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                    <?php echo '<img src="uploads/' . $profile_image . '" width="50px" height="50px" class="rounded-circle">'; ?>
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                    <div class="ms-3">
                    <h6 class="mb-0"><?php echo $first_name . ' ' . $last_name; ?></h6>
                        <small><?php echo $role; ?></small>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    <a href="dashboard.php" class="nav-item nav-link "><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-laptop me-2"></i>Star Dev</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="ceo.php" class="dropdown-item">CEO</a>
                            <a href="co-ceo.php" class="dropdown-item">Co-CEO</a>
                            <a href="star_member.php" class="dropdown-item">Star Member</a>
                        </div>
                    </div>
                    <a href="message.php" class="nav-item nav-link active"><i class="fa fa-envelope me-2"></i>Message</a>
                    <a href="group.php" class="nav-item nav-link"><i class="fa fa-th me-2"></i>Group</a>
                    <a href="power.php" class="nav-item nav-link"><i class="fa fa-keyboard me-2"></i>Power</a>
                    <a href="worldwide.php" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Worldwide</a>
                    <a href="charts.php" class="nav-item nav-link"><i class="fa fa-chart-bar me-2"></i>Charts</a>
                    <a href="reports.php" class="nav-item nav-link"><i class="far fa-file-alt me-2"></i>All Reports</a>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
                <a href="dashboard.php" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-star"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <form class="d-none d-md-flex ms-4">
                    <input class="form-control border-0" type="search" placeholder="Search">
                </form>
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-envelope me-lg-2"></i>
                            <span class="d-none d-lg-inline-flex">Message</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">
                                <div class="d-flex align-items-center">
                        
                                    <div class="ms-2">
                                        <h6 class="fw-normal mb-0">Jhon send you a message</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                </div>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                                    <div class="ms-2">
                                        <h6 class="fw-normal mb-0">Jhon send you a message</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                </div>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                                    <div class="ms-2">
                                        <h6 class="fw-normal mb-0">Jhon send you a message</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                </div>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item text-center">See all message</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-bell me-lg-2"></i>
                            <span class="d-none d-lg-inline-flex">Notificatin</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">
                                <h6 class="fw-normal mb-0">Profile updated</h6>
                                <small>15 minutes ago</small>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <h6 class="fw-normal mb-0">New user added</h6>
                                <small>15 minutes ago</small>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <h6 class="fw-normal mb-0">Password changed</h6>
                                <small>15 minutes ago</small>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item text-center">See all notifications</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        <?php echo '<img src="uploads/' . $profile_image . '" width="40px" height="40px" class="rounded-circle">'; ?>
                            <span class="d-none d-lg-inline-flex"><?php echo $first_name . ' ' . $last_name; ?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="ceo.php" class="dropdown-item">My Profile</a>
                            <a href="settings.php" class="dropdown-item">Settings</a>
                            <a href="logout.php" class="dropdown-item">Log Out</a>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->

 <!-- Messages Start -->
 <div class="container-fluid pt-4 px-4">
                <div class="row g-12">
                    <div class="col-sm-12 col-md-6 col-xl-12">
                        <div class="h-100 bg-light rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="mb-0">Messages</h6>
                            </div>
<!-- Display messages here -->
<?php foreach ($messages as $message) : ?>
    <div class="message <?php echo $message['sender_role'] === $role ? 'sender' : 'receiver'; ?>">
        <?php if ($message['sender_role'] === $role) : ?>
            <!-- Display sender's information -->
            <p><?php echo $first_name . ' ' . $last_name; ?></p>
        <?php else : ?>
            <!-- Display receiver's information -->
            <p><?php echo $message['receiver_name']; ?></p>
        <?php endif; ?>
        <!-- Display message content -->
        <p><?php echo $message['message']; ?></p>
    </div>
<?php endforeach; ?>


                            <!-- Pagination links -->
                            <div class="container-fluid pt-4 px-4">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination justify-content-center">
                                        <?php
                                        // Previous page link
                                        if ($page > 1) {
                                            echo "<li class='page-item'><a class='page-link' href='send_message.php?page=" . ($page - 1) . "'>Previous</a></li>";
                                        }

                                        // Next page link
                                        if (count($messages) == $pageSize) {
                                            echo "<li class='page-item'><a class='page-link' href='send_message.php?page=" . ($page + 1) . "'>Next</a></li>";
                                        }
                                        ?>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Messages End -->

            <!-- Form for sending messages -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-12">
                    <div class="col-sm-12 col-md-6 col-xl-12">
                        <div class="h-100 bg-light rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="mb-0">Send a Message</h6>
                            </div>
                            <!-- Form for sending messages -->
                            <form method="post" action="send_message.php">
                                <div class="mb-3">
                                    <!-- CEO's Picture -->
                                    <img src="uploads/<?php echo $profile_image; ?>" width="40px" height="40px" class="rounded-circle">
                                    <?php echo $first_name . ' ' . $last_name; ?>
                                    <?php echo $role; ?>
                                </div>
                                <div class="mb-3">
                                    <label for="message_content" class="form-label">Message</label>
                                    <textarea class="form-control" id="message_content" name="message_content" rows="3"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Send Message</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>



            <!-- Footer Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light rounded p-4">
                    <div class="d-md-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <img src="img/logo.png" alt="logo" width="40">
                            <span class="ms-2">Star, Inc.</span>
                        </div>
                        <div class="d-md-flex align-items-center mt-3 mt-md-0">
                            <ul class="list-unstyled mb-0">
                                <li class="d-inline-block me-3"><a href="#" class="text-light"><i class="fab fa-facebook-f"></i></a></li>
                                <li class="d-inline-block me-3"><a href="#" class="text-light"><i class="fab fa-twitter"></i></a></li>
                                <li class="d-inline-block me-3"><a href="#" class="text-light"><i class="fab fa-instagram"></i></a></li>
                                <li class="d-inline-block me-3"><a href="#" class="text-light"><i class="fab fa-linkedin"></i></a></li>
                                <li class="d-inline-block me-3"><a href="#" class="text-light"><i class="fab fa-youtube"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End -->
        </div>
        <!-- Content End -->
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/js/bootstrap.bundle.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>
