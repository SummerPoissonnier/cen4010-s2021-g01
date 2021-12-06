<?php

// Initialize the session

session_start();

// Check if the user is logged in, otherwise redirect to login page

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.html");
    exit;
}
// Include config file

require_once "config.php";

// Define variables and initialize with empty values

$new_username = $new_age = $new_bio = $new_password = $confirm_password = "";

$new_username_err = $new_age_err = $new_bio_err = $new_password_err = $confirm_password_err = "";

// Processing form data when form is submitted

if($_SERVER["REQUEST_METHOD"] == "POST"){
// Validate username
    if(empty(trim($_POST["new_username"]))){
        $new_username_err = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["new_username"]))){
        $new_username_err = "Username can only contain letters, numbers, and underscores.";
    } else{
        // Prepare a select statement
        $sql = "SELECT user_id FROM users WHERE username = ?";

        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            // Set parameters
            $param_username = trim($_POST["new_username"]);
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $new_username_err = "This username is already taken.";
                } else{
                    $new_username = trim($_POST["new_username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    // Validate age
    if(empty(trim($_POST["new_age"]))){
        $new_age_err = "Please enter your age.";
    } elseif(!preg_match('/^[0-9]+$/', trim($_POST["new_age"]))){
        $new_age_err = "Age can only contain numbers.";
    } else{
        // Prepare a select statement
        $sql = "SELECT user_id FROM users WHERE age = ?";

        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_age);
            // Set parameters
            $param_age = trim($_POST["new_age"]);
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                $new_age = trim($_POST["new_age"]);
            }
            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
     // Validate bio
    if(empty(trim($_POST["new_bio"]))){
        $new_bio_err = "Please enter a bio.";
    } elseif(!preg_match('/^[a-zA-Z0-9_ ]+$/', trim($_POST["new_bio"]))){
        $new_bio_err = "Bio can contain letters, numbers, and sybmols.";
    } else{
        // Prepare a select statement
        $sql = "SELECT user_id FROM users WHERE bio = ?";

        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_bio);
            // Set parameters
            $param_bio = trim($_POST["new_bio"]);
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                $new_bio = trim($_POST["new_bio"]);
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    // Validate new password
    if(empty(trim($_POST["new_password"]))){

        $new_password_err = "Please enter the new password.";     

    } elseif(strlen(trim($_POST["new_password"])) < 6){

        $new_password_err = "Password must have atleast 6 characters.";

    } else{

        $new_password = trim($_POST["new_password"]);
    }

    // Validate confirm password

    if(empty(trim($_POST["confirm_password"]))){

        $confirm_password_err = "Please confirm the password.";

    } else{

        $confirm_password = trim($_POST["confirm_password"]);

        if(empty($new_password_err) && ($new_password != $confirm_password)){

            $confirm_password_err = "Password did not match.";
        }
    }

    // Check input errors before updating the database

    if(empty($new_username_err) && empty($new_age_err) && empty($new_bio_err) && empty($new_password_err) && empty($confirm_password_err)){

        // Prepare an update statement

        $sql = "UPDATE users SET username=?, age = ?, bio = ?, password = ? WHERE user_id = ?";

        if($stmt = mysqli_prepare($conn, $sql)){

            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sissi", $param_username, $param_age, $param_bio, $param_password, $param_id);

            // Set parameters
            $param_username = $new_username;
            $param_age = $new_age;
            $param_bio = $new_bio;
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);

            $param_id = $_SESSION["user_id"];
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Password updated successfully. Destroy the session, and redirect to login page
                session_destroy();
                header("location: index.html");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    // Close connection
    mysqli_close($conn);
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
    <div class="wrapper">

        <h2 class="section-heading mb-4">
                                    <span class="section-heading-lower">Settings</span>
                                </h2>
        <p style="text-align:center; font-size: 20px; color: grey" >Please fill out this form to update your settings.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
            <div class="form-group">
                <label>Username</label>

                <input type="username" name="new_username" class="form-control <?php echo (!empty($new_username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $new_username; ?>">
                <span class="invalid-feedback"><?php echo $new_username_err; ?></span>
            </div>
            <div class="form-group">
                <label>Age</label>
                <input type="age" name="new_age" class="form-control <?php echo (!empty($new_age_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $new_age; ?>">
                <span class="invalid-feedback"><?php echo $new_age_err; ?></span>
            </div>
            <div class="form-group">
                <label>Bio</label>
                <input type="bio" name="new_bio" class="form-control <?php echo (!empty($new_bio_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $new_bio; ?>">
                <span class="invalid-feedback"><?php echo $new_bio_err; ?></span>
            </div>
            <div class="form-group">
                <label>New Password</label>
                <input type="password" name="new_password" class="form-control <?php echo (!empty($new_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $new_password; ?>">
                <span class="invalid-feedback"><?php echo $new_password_err; ?></span>

            </div>
            <div class="form-group">

                <label>Confirm Password</label>

                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>">

                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="submit" value="Submit">
            </div>
        </form>
    </div>
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
