<?php
session_start();

if(!isset($_SESSION["user_id"])){
	header("Location: login.php");
	exit();
}
//connect to server and select database
$conn = mysqli_connect("lamp.cse.fau.edu", "cen4010_su21_g01", "JNc72QcBEM", "cen4010_su21_g01")
 or die(mysqli_error());

//gather the user info 
 $get_user = "select user_id, username, bio, fullname, age
  from users where user_id = '$_SESSION[user_id]'";
  $get_user_res = mysqli_query($conn, $get_user) or die(mysqli_error($conn));
     
      while ($user_info = mysqli_fetch_array($get_user_res)) {
        $user_id = $user_info['user_id'];
        $user_name = stripslashes($user_info['username']);
        $fullname = stripslashes($user_info['fullname']);
        $user_age = stripslashes($user_info['age']);
        $user_bio = stripslashes($user_info['bio']);
      }       
 ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Gopher</title>
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v5.15.3/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body>
        <header>
            <h1 class="site-heading text-center text-faded d-none d-lg-block">
                <span class="site-heading-upper text-primary mb-3"></span>
                <span class="site-heading-lower">Gopher</span>
            </h1>
        </header>
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark py-lg-4" id="mainNav">
            <div class="container">
                <a class="navbar-brand text-uppercase fw-bold d-lg-none" href="index.html">Gopher</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item px-lg-4"><a class="nav-link text-uppercase" href="home.html">Home</a></li>
                        <li class="nav-item px-lg-4"><a class="nav-link text-uppercase" href="about_us.html">About Us</a></li>
                        <li class="nav-item px-lg-4"><a class="nav-link text-uppercase" href="account.php">Account</a></li>
                        <li class="nav-item px-lg-4"><a class="nav-link text-uppercase" href="chat.html">Chat</a></li>
                        <li class="nav-item px-lg-4"><a class="nav-link text-uppercase" href="settings.php">Settings</a></li>
                        <li class="nav-item px-lg-4"><a class="nav-link text-uppercase" href="logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <section class="page-section about-heading">
            <div class="container">
                <div class="about-heading-content">
                    <div class="row">
                        <div class="col-xl-9 col-lg-10 mx-auto">
                            <div class="bg-faded rounded p-5">
                                <h2 class="section-heading mb-4">
                                    <span class="section-heading-lower">My Profile</span>
                                </h2>
                                <p style="text-align:center; font-size: 20px; color: grey" >This is where you can see your account information.</p>
                                <h4>Name:</h4> <?php echo $fullname ?>
                                &nbsp;
                                <h4>Username:</h4> <?php echo $user_name?>
                                &nbsp;
                                <h4>Age:</h4> <?php echo $user_age?>
                                &nbsp;
                                <h4>Bio:</h4> <?php echo $user_bio?>
                                &nbsp;
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <footer class="footer text-faded text-center py-5">
            <div class="container"><p class="m-0 small">Copyright &copy; CEN Summer 2021</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
