<?php
session_start();

include_once("classes/connect.php");
include_once("classes/login.php");
include_once("classes/database.php");
include_once("classes/signup.php");

// Function to get CO-CEO data
function getCoCEOData() {
    // Replace this with your actual implementation to retrieve CO-CEO data from the database
    // Example: You might have a Database method to fetch CO-CEO data, modify accordingly
    $co_ceo_data = array(
        'first_name' => 'John',
        'last_name' => 'Doe',
        'title' => 'Co-CEO',
        'email' => 'john.doe@example.com',
        // Add other CO-CEO data fields as needed
    );

    return $co_ceo_data;
}

// Function to get Star Member data
function getStarMemberData() {
    // Replace this with your actual implementation to retrieve Star Member data from the database
    // Example: You might have a Database method to fetch Star Member data, modify accordingly
    $star_member_data = array(
        'first_name' => 'Hridoy',
        'last_name' => 'Jomadder',
        'title' => 'Star Member',
        'email' => 'john.doe@example.com',
        // Add other Star Member data fields as needed
    );

    return $star_member_data;
}



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

// Add these lines at the beginning of your code
$co_ceo_data = getCoCEOData(); // Replace this with your actual method to get CO-CEO data
$star_member_data = getStarMemberData(); // Replace this with your actual method to get Star Member data
?>

 <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>DASHMIN - Bootstrap Admin Template</title>
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
</head>

<body>
    <div class="container-fluid position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-light navbar-light">
                <a href="index.php" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><i class="fa fa-star me-2"></i>DASHMIN</h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                    <h1><?php echo $welcomeMessage; ?></h1>
                      <?php echo $dashboardContent; ?>
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                    <div class="ms-3">
                        <!-- profile name -->
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    <a href="index.php" class="nav-item nav-link "><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-laptop me-2"></i>Star Dev</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="ceo.php" class="dropdown-item active">CEO</a>
                            <a href="co-ceo.php" class="dropdown-item">Co-CEO</a>
                            <a href="star_member.php" class="dropdown-item">Star Member</a>
                        </div>
                    </div>
                    <a href="message.php" class="nav-item nav-link"><i class="fa fa-envelope me-2"></i>Message</a>
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
                <a href="index.php" class="navbar-brand d-flex d-lg-none me-4">
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
                        <!-- profile name -->
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="ceo.php" class="dropdown-item">My Profile</a>
                            <a href="settings.php" class="dropdown-item">Settings</a>
                            <a href="logout.php" class="dropdown-item">Log Out</a>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->

         <!-- Display CEO's profile information -->
         <div class="container-fluid pt-4 px-4">
                <div class="row vh-100 bg-light rounded align-items-center justify-content-center mx-0">
                    <div class="col-md-6 text-center">
                        <div class="col-sm-12 col-xl-12">
                            <div class="bg-light rounded h-50 p-4">
                                <!-- Set the profile image -->
                                <!-- <?php echo '<img src="' . $profile_image . '" width="300" height="300" class="rounded-circle">';
                                  ?> -->
                                <br><br>
                                <h5 class="mb-0">Name: <?php echo $first_name . ' ' . $last_name; ?><br></h5>
                                <h6 class="mb-2">Title: <?php echo $role; ?><br></h6>

                                <!-- Additional CEO-specific content -->
                                <p><strong>Email:</strong> <?php echo $user['email'] ?></p>
                                
                                <!-- Check if "join_date" key exists in the user array -->
                                <?php if (isset($user['join_date'])): ?>
                                    <p><strong>Joined:</strong> <?php echo $user['join_date'] ?></p>
                                <?php endif; ?>

                                <!-- Display CO-CEO's profile information if the user is a CO-CEO -->
                                <?php if ($user['role'] === 'co_ceo' && $co_ceo_data): ?>
                                    <!-- CO-CEO profile section -->
                                <?php endif; ?>

                                <!-- Display Star Member's profile information if the user is a Star Member -->
                                <?php if ($user['role'] === 'star_member' && $star_member_data): ?>
                                    <!-- Star Member profile section -->
                                <?php endif; ?>
                                <!-- CO-CEO and Star Member Profile Sections End -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Additional CEO-specific content -->

            <!-- CO-CEO Profile Section -->
            <?php if(isset($co_ceo_data) && is_array($co_ceo_data)): ?>
                <div class="container-fluid pt-4 px-4">
                    <div class="row vh-100 bg-light rounded align-items-center justify-content-center mx-0">
                        <div class="col-md-6 text-center">
                            <div class="col-sm-12 col-xl-6">
                                <div class="bg-light rounded h-100 p-4">
                                    <!-- Display CO-CEO's profile information -->
                                    <!-- <?php
                                    echo '<img src="' . $co_ceo_data['profile_image'] . '" width="300" height="300" class="rounded-circle">';
                                    ?> -->
                                    <br><br>
                                    <h5 class="mb-0"><?php echo $co_ceo_data['first_name'] . " " . $co_ceo_data['last_name'] ?></h5>
                                    <h6 class="mb-2"><?php echo $co_ceo_data['title'] ?></h6>

                                    <!-- Additional CO-CEO-specific content -->
                                    <p><strong>Email:</strong> <?php echo $co_ceo_data['email'] ?></p>

                                    <!-- Add any other CO-CEO-specific content here -->
                                    <!-- <p>This is a sample CO-CEO profile. You can add more details and customize as needed.</p> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <p>No CO-CEO data available.</p>
            <?php endif; ?>
            <!-- CO-CEO Profile Section End -->


            <!-- <p><strong>Email:</strong> <?php echo $user['email'] ?></p>
            <!-- Replace this line in the CEO profile section -->
            <!-- <p><strong>Joined:</strong> <?php echo isset($user['join_date']) ? $user['join_date'] : 'N/A'; ?></p> --> -->

                <!-- CO-CEO Profile Section -->
            <?php if(isset($co_ceo_data) && is_array($co_ceo_data)): ?>
                <div class="container-fluid pt-4 px-4">
                    <!-- ... (your existing CO-CEO code) ... -->
                </div>
            <?php else: ?>
                <p>No CO-CEO data available.</p>
            <?php endif; ?>
            <!-- CO-CEO Profile Section End -->

            <!-- Star Member Profile Section -->
            <?php if(isset($star_member_data) && is_array($star_member_data)): ?>
                <div class="container-fluid pt-4 px-4">
                    <!-- ... (your existing Star Member code) ... -->
                </div>
            <?php else: ?>
                <p>No Star Member data available.</p>
            <?php endif; ?>
            <!-- Star Member Profile Section End -->




            <!-- Star Member Profile Section -->
            <div class="container-fluid pt-4 px-4">
                <div class="row vh-100 bg-light rounded align-items-center justify-content-center mx-0">
                    <div class="col-md-6 text-center">
                        <div class="col-sm-12 col-xl-6">
                            <div class="bg-light rounded h-100 p-4">
                                <!-- Display Star Member's profile information -->
                                <!-- <?php
                                echo '<img src="' . $star_member_data['profile_image'] . '" width="300" height="300" class="rounded-circle">';
                                ?> -->
                                <br><br>
                                <h5 class="mb-0"><?php echo $star_member_data['first_name'] . " " . $star_member_data['last_name'] ?></h5>
                                <h6 class="mb-2"><?php echo $star_member_data['title'] ?></h6>

                                <!-- Additional Star Member-specific content -->
                                <p><strong>Email:</strong> <?php echo $star_member_data['email'] ?></p>
                                <p><strong>Membership Type:</strong> Star Member</p>
                                <p><strong>Joined:</strong> <?php echo $star_member_data['join_date'] ?></p>

                                <!-- Add any other Star Member-specific content here -->
                                <p>This is a sample Star Member profile. You can add more details and customize as needed.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Star Member Profile Section End -->

             <!-- Footer Start -->
             <div class="container-fluid pt-4 px-4">
                <div class="bg-light rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="">Star</a>, All Right Reserved. 
                        </div>
                        <div class="col-12 col-sm-6 text-center text-sm-end">
                            Designed By <a href="">Star</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End -->
        </div>
        <!-- Content End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>