<?php
session_start();

include_once("classes/connect.php");
include_once("classes/login.php");
include_once("classes/database.php");
include_once("classes/database2.php");
include_once("classes/signup.php");

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
if (isset($user['profile_image']) && !empty($user['profile_image'])) {
    $profile_image = $user['profile_image'];
} else {
    // Set a default image path or handle the case where profile_image is not set
    $profile_image = 'default_profile_image.jpg';
}

// Fetch CO-CEO data based on user ID if the user is a CO-CEO
if ($user['role'] === 'co_ceo') {
    // Use the fetched data directly in the CO-CEO profile section
    $co_ceo_data = $DB->fetchCoCEODetails($_SESSION['das_userid']);
}

// Fetch Star Member data based on user ID if the user is a Star Member
if ($user['role'] === 'star_member') {
    // Use the fetched data directly in the Star Member profile section
    $star_member_data = $DB->fetchStarMemberDetails($_SESSION['das_userid']);
}

// Fetch posts from the database
$posts = $database->fetchAllPosts();

// Check if video ID is provided in the URL
if(isset($_GET['id'])) {
    // Get the video ID from the URL
    $videoID = $_GET['id'];

    // Fetch video details by ID
    $video = $database->fetchVideoByID($videoID);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>DASHMIN - Star</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <meta content="Hridoy Jomadder" name="author">

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
                    <a href="dashboard.php" class="nav-item nav-link"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-laptop me-2"></i>Star Dev</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="ceo.php" class="dropdown-item">CEO</a>
                            <a href="co-ceo.php" class="dropdown-item">Co-CEO</a>
                            <a href="star_member.php" class="dropdown-item">Star Member</a>
                        </div>
                    </div>
                    <a href="message.php" class="nav-item nav-link"><i class="fa fa-envelope me-2"></i>Message</a>
                    <a href="group.php" class="nav-item nav-link"><i class="fa fa-th me-2"></i>Group</a>
                    <a href="power.php" class="nav-item nav-link"><i class="fa fa-keyboard me-2"></i>Power</a>
                    <a href="worldwide.php" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Worldwide</a>
                    <a href="charts.php" class="nav-item nav-link"><i class="fa fa-chart-bar me-2"></i>Charts</a>
                    <a href="reports.php" class="nav-item nav-link active"><i class="far fa-file-alt me-2"></i>All Reports</a>
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


 <!-- Star Account Start -->
<div class="container-fluid pt-4 px-4">
    <div class="bg-light text-center rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">Star Accounts</h6>
            <!-- <a href="reports.php">Show All</a> -->
        </div>
        <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0">
                <thead>
                    <tr class="text-dark">
                        <th scope="col">ID</th>
                        <th scope="col">User ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Profile Image</th>
                        <th scope="col">Gender</th>
                        <!-- <th scope="col">Date</th> -->
                        <th scope="col">E-mail</th>
                        <th scope="col">IP Address</th>
                        <th scope="col">Country</th>
                        <th scope="col">Browser Name</th>
                        <th scope="col" colspan="2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // Check if $users is defined and not null
                    if (isset($users) && $users !== false) {
                        foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo $user['id']; ?></td>
                                <td><?php echo $user['userid']; ?></td>
                                <td><?php echo $user['first_name'] . ' ' . $user['last_name']; ?></td>
                                <td><img src="<?php echo $user['profile_image_url']; ?>" alt="Profile Image" width="50" height="50"></td>

                                <td><?php echo $user['gender']; ?></td>
                                <!-- <td><?php echo $user['date']; ?></td> -->
                                <td><?php echo $user['email']; ?></td>
                                <td><?php echo $user['ip_address']; ?></td>
                                <td><?php echo $user['country']; ?></td>
                                <td><?php echo $user['browser_name']; ?></td>
                                <td><a class="btn btn-sm btn-info" href="detail.php?id=<?php echo $user['id']; ?>">Detail</a></td>
                                <td><a class="btn btn-sm btn-warning" href="delete.php?id=<?php echo $user['id']; ?>">Delete</a></td>

                            </tr>
                    <?php endforeach; 
                    } else {
                        // Handle the case where no users were fetched or $users is not defined
                        echo "<tr><td colspan='11'>No users found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Star Account End -->

<!-- Star post Start -->
<div class="container-fluid pt-4 px-4">
    <div class="bg-light text-center rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">Star posts</h6>
        </div>
        <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0">
                <thead>
                    <tr class="text-dark">
                        <th scope="col">ID</th>
                        <th scope="col">Post ID</th>
                        <th scope="col">Post</th>
                        <th scope="col">Image</th>
                        <th scope="col">Date</th>
                        <th scope="col">UserID</th>
                        <th scope="col">Stars</th>
                        <th scope="col">Comments</th>
                        <th scope="col" colspan="2">Action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php 
                    // Check if $posts is defined and not null
                    if (isset($posts) && !empty($posts)) {
                        foreach ($posts as $post): ?>
                            <tr>
                                <td><?php echo $post['id']; ?></td>
                                <td><?php echo $post['postid']; ?></td>
                                <td><?php echo $post['post']; ?></td>
                                <td><img src="<?php echo $post['image_url']; ?>" alt="Image" width="50" height="50"></td>
                                <td><?php echo $post['date']; ?></td>
                                <td><?php echo $post['userid']; ?></td>
                                <td><?php echo $post['stars']; ?></td>
                                <td><?php echo $post['comments']; ?></td>
                                <td><a class="btn btn-sm btn-info" href="postid_detail.php?id=<?php echo $post['postid']; ?>">Detail</a></td>
                                <td><a class="btn btn-sm btn-warning" href="postid_delete.php?id=<?php echo $post['postid']; ?>">Delete</a></td>
                            </tr>
                    <?php 
                        endforeach; 
                    } else {
                        // Handle the case where no posts were fetched or $posts is not defined
                        echo "<tr><td colspan='9'>No posts found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Star post End -->


<!-- Star Video Start -->
<div class="container-fluid pt-4 px-4">
    <div class="bg-light text-center rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">Star Videos</h6>
        </div>
        <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0">
                <thead>
                    <tr class="text-dark">
                        <th scope="col">ID</th>
                        <th scope="col">UserID</th>
                        <th scope="col">Video</th>
                        <th scope="col">Title</th>
                        <th scope="col">Description</th>
                        <th scope="col">Tag</th>
                        <th scope="col">URL</th>
                        <th scope="col">Upload Date</th>
                        <th scope="col" colspan="3">Google Action</th>
                    </tr>
                </thead>
                <tbody>
                    
                <?php 


// Check if $videos is not empty
if (!empty($videos)) {
    // Display videos in the HTML table
    foreach ($videos as $video) {
        echo "<tr>";
        echo "<td>{$video['id']}</td>";
        echo "<td>{$video['userid']}</td>";
        echo "<td>{$video['video']}</td>";
        echo "<td>{$video['title']}</td>";
        echo "<td>{$video['description']}</td>";
        echo "<td>{$video['tag']}</td>";
        echo "<td>{$video['url']}</td>";
        echo "<td>{$video['upload_date']}</td>";
        echo "<td><a class='btn btn-sm btn-info' href='videoid_detail.php?id={$video['id']}'>Video Detail</a></td>";
        echo "<td><button class='btn btn-sm btn-info' onclick='copyUrl(\"{$video['url']}\")'>URL Copy</button></td>";
                echo "<td><a class='btn btn-sm btn-warning' href='videoid_delete.php?id={$video['id']}'>Delete</a></td>";
        echo "</tr>";
    }
} else {
    // Display a message if no videos are found
    echo "<tr><td colspan='9'>No videos found.</td></tr>";
}
?>

                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Star Video End -->



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
    <script>
    //Todo list js
        function addTask() {
            const taskInput = document.getElementById("taskInput");
            const taskList = document.getElementById("taskList");
        
            if (taskInput.value.trim() !== "") {
                const li = document.createElement("li");
                li.innerHTML = `${taskInput.value} <button onclick="removeTask(this)">Delete</button>`;
                taskList.appendChild(li);
                taskInput.value = "";
            }
        }
        
        function removeTask(button) {
            const li = button.parentElement;
            const taskList = document.getElementById("taskList");
            taskList.removeChild(li);
        }</script>

// Template Javascript
<script src="js/main.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Sample data
        var countries = ['UK', 'US', 'Australia'];
        var data = [150, 200, 100];

        // Get the canvas element
        var ctxWorldwideCountry = document.getElementById('worldwide-country').getContext('2d');

        // Create the bar chart for Worldwide - Country
        var worldwideCountryChart = new Chart(ctxWorldwideCountry, {
            type: 'bar',
            data: {
                labels: countries,
                datasets: [{
                    label: 'Number of Users',
                    data: data,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Countries'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Users'
                        }
                    }
                }
            }
        });
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Sample data
        var categories = ['Category 1', 'Category 2', 'Category 3'];
        var activeData = [10, 15, 8];
        var offlineData = [5, 8, 12];

        // Get the canvas element
        var ctxActiveOffline = document.getElementById('active-offline').getContext('2d');

        // Create the line chart for Active & Offline
        var activeOfflineChart = new Chart(ctxActiveOffline, {
            type: 'line',
            data: {
                labels: categories,
                datasets: [{
                    label: 'Active',
                    data: activeData,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    fill: false
                }, {
                    label: 'Offline',
                    data: offlineData,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 2,
                    fill: false
                }]
            },
            options: {
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Categories'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Count'
                        }
                    }
                }
            }
        });
    });
</script>

<!-- Add this JavaScript code at the end of your HTML -->
<script>
function copyUrl(url) {
    // Create a temporary input element
    var input = document.createElement('input');
    input.setAttribute('value', url);
    document.body.appendChild(input);

    // Select the input text
    input.select();
    input.setSelectionRange(0, 99999); // For mobile devices

    // Copy the selected text to the clipboard
    document.execCommand('copy');

    // Remove the temporary input
    document.body.removeChild(input);

    // Provide a visual indication to the user
    alert("URL copied to clipboard: " + url);
}
</script>


</body>

</html>