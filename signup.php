<?php
session_start();

include_once("classes/connect.php");
include_once("classes/signup.php");

$username = "";
$password = "";
$email = "";
$error_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $signup = new Signup();
    $error_message = $signup->evaluate($_POST);

    if ($error_message === true) {
        // Redirect to a dashboard or home page after successful registration
        header("Location: dashboard.php");
        exit();
    } else {
        echo "<div style='text-align:center;font-size:12px;color:white;background:red;'>";
        echo $error_message;
        echo "</div>";
    }

    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
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


  <!-- Sign Up Start -->
  <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h3 class="text-primary" style="font-family: times new roman;"><i class="fa fa-star me-2"></i>STAR_DASHMIN</h3>
                        </div>                 

                        <form method="post" action="signup.php">
                            <!-- ... other form fields ... -->
                            <input name="username" class="form-control" value="<?php echo htmlspecialchars($username); ?>" type="text" id="text" placeholder="Username" style="font-family: times new roman;">
                            <input name="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>" type="text" id="text" placeholder="E-mail Address" style="font-family: times new roman;">
                            <input name="password" class="form-control" value="<?php echo htmlspecialchars($password); ?>" type="password" id="password" placeholder="password" style="font-family: times new roman;">
                            <!-- ... other form fields ... -->

                            <input type="submit" class="btn btn-primary py-3 w-100 mb-4" id="button" value="Sign Up" style="font-family: times new roman;"><br><br>
                            <p class="text-center mb-0">Already have an account? <a href="login.php" style="font-family: times new roman;">Log In</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sign Up End -->
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