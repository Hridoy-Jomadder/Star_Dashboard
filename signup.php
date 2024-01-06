<?php

  include("classes/connect.php");
  include("classes/signup.php");

  $first_name = "";
  $last_name = "";
  $gender = ""; 
  $email = "";
  $password = ""; 
  $password = ""; 
  $title = "";

  if($_SERVER['REQUEST_METHOD'] == 'POST')
   {
    
     $signup = new Signup();
     $result = $signup->evaluate($_POST);

     $password2 = $_POST['password2'];
    
     if ($password !== $password2) {
         $result .= "Passwords do not match.<br>";
     

    if($result != "")
    {
            
        echo "<div style='text-align:center;font-size:12px;color:white;background:red;'>";
        echo "<br>The following errors occured:<br><br>";
        echo $result;
        echo "</div>";
            
    }
      else
    {
          
        header("Location: login.php");
        die;
    
    }

        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $title = $_POST['title'];
        $gender = $_POST['gender'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password = $_POST['password'];
            
   }
  
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
                        <div class="form-floating mb-3">  
                            <input value="<?php echo $first_name ?>" name="first_name" class="form-control" type="text" id="text" placeholder="First Name" style="font-family: times new roman;">
                            <label for="text">First Name</label>
                        </div>
                        <div class="form-floating mb-3"> 
                            <input value="<?php echo $last_name ?>" name="last_name" class="form-control" type="text" id="text" placeholder="Last Name" style="font-family: times new roman;">
                            <label for="text">Last Name</label>
                             </div>
                            <div class="form-floating mb-3"> 
                            <input value="<?php echo $title ?>" name="title" class="form-control" type="text" id="text" placeholder="Title" style="font-family: times new roman;">
                            <label for="text">Title</label>
                           </div>
                            
                            
                            <span>Gender<br></span>
                            <select id="text" name="gender" class="form-control" style="font-family: times new roman;">
                                <option <?php echo $gender ?>>Male</option>
                                <option>Female</option>
                                <option>Other</option>
                            </select>
                           <br>
                            <div class="form-floating mb-3"> 
                            <input value="<?php echo $email ?>" name="email" class="form-control" type="text" id="text" placeholder="Email Address or Phone Number" style="font-family: times new roman;">
                            <label for="text">Email Address or Phone Number</label>
                            </div>
                            <div class="form-floating mb-3"> 
                            <input value="<?php echo $password ?>" name="password" class="form-control" type="password" id="text" placeholder="Password" style="font-family: times new roman;">
                            <label for="text">Password</label>
                            </div>
                            
                            <div class="form-floating mb-3"> 
                            <input value="<?php echo $password ?>" name="password2" class="form-control" type="password" id="password2" placeholder="Retype Password" style="font-family: times new roman;">
                            <label for="password2">Retype Password</label>
                            </div>
                            <input type="submit" class="btn btn-primary py-3 w-100 mb-4" id="button" value="Sign Up" style="font-family: times new roman;">
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