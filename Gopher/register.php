<?php

// Include config file

require_once "config.php";

// Define variables and initialize with empty values

$username = $fullname = $age = $gender = $bio = $password = $confirm_password = "";
$username_err = $fullname_err = $age_err = $gender_err = $bio_err = $password_err = $confirm_password_err = "";
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else{
        // Prepare a select statement
        $sql = "SELECT user_id FROM users WHERE username = ?";

        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            // Set parameters
            $param_username = trim($_POST["username"]);
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    // Validate name
    if(empty(trim($_POST["fullname"]))){
        $fullname_err = "Please enter your Fullname.";
    } elseif(!preg_match('/^[a-zA-Z0-9_ ]+$/', trim($_POST["fullname"]))){
        $fullname_err = "Fullname can only contain letters.";
    } else{
        // Prepare a select statement
        $sql = "SELECT user_id FROM users WHERE fullname = ?";

        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_fullname);
            // Set parameters
            $param_fullname = trim($_POST["fullname"]);
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                $fullname = trim($_POST["fullname"]);
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    // Validate age
    if(empty(trim($_POST["age"]))){
        $age_err = "Please enter your age.";
    } elseif(!preg_match('/^[0-9]+$/', trim($_POST["age"]))){
        $age_err = "Age can only contain numbers.";
    } else{
        // Prepare a select statement
        $sql = "SELECT user_id FROM users WHERE age = ?";

        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_age);
            // Set parameters
            $param_age = trim($_POST["age"]);
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                $age = trim($_POST["age"]);
            }
            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    // Validate gender
    if(empty(trim($_POST["gender"]))){
        $gender_err = "Please enter your Gender.";
    } elseif(!preg_match('/^[a-zA]+$/', trim($_POST["gender"]))){
        $gender_err = "Gender can only contain letters.";
    } else{
        // Prepare a select statement
        $sql = "SELECT user_id FROM users WHERE gender = ?";

        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_gender);
            // Set parameters
            $param_gender = trim($_POST["gender"]);
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                $gender = trim($_POST["gender"]);
            }
            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
     // Validate bio
    if(empty(trim($_POST["bio"]))){
        $bio_err = "Please enter a bio.";
    } elseif(!preg_match('/^[a-zA-Z0-9_ ]+$/', trim($_POST["bio"]))){
        $bio_err = "Bio can contain letters, numbers, and sybmols.";
    } else{
        // Prepare a select statement
        $sql = "SELECT user_id FROM users WHERE bio = ?";

        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_bio);
            // Set parameters
            $param_bio = trim($_POST["bio"]);
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                $bio = trim($_POST["bio"]);
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     

    } elseif(strlen(trim($_POST["password"])) < 6){

        $password_err = "Password must have atleast 6 characters.";

    } else{

        $password = trim($_POST["password"]);
    }
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    // Check input errors before inserting in database
    if(empty($fullname_err) && empty($age_err) && empty($bio_err) && empty($gender_err) && empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO users (fullname, age, gender, username, bio, password) VALUES (? , ?, ?, ?, ?, ?)";
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sissss", $param_fullname, $param_age, $param_gender, $param_username, $param_bio, $param_password);
            mysqli_stmt_bind_param($stmt, "sissss", $param_fullname, $param_age, $param_gender, $param_username, $param_bio, $param_password);
            // Set parameters
            $param_fullname = $fullname;
            $param_age = $age;
            $param_gender = $gender;
            $param_username = $username;
            $param_bio = $bio;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: index.html");
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
    <html lang="en">
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
    <!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">-->
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 1350px; padding: 20px; }
    </style>
    </html>
</head>
<body>  
    <div class="wrapper">
        <header>
            <h1 class="site-heading text-center text-faded d-none d-lg-block">
                <span class="site-heading-upper text-primary mb-3"></span>
                <span class="site-heading-lower">Gopher</span>
            </h1>
        </header>
        <!-- Navigation-->
        <section class="page-section about-heading">
            <div class="container">
            
                <div class="about-heading-content">
                    <div class="row">
                        <div class="col-xl-9 col-lg-10 mx-auto">
                            <div class="bg-faded rounded p-5">
        <h2>Sign Up</h2>

        <p>Please fill out this form to create an account.</p>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>First and Last Name</label>
                <input type="text" name="fullname" class="form-control <?php echo (!empty($fullname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $fullname; ?>">
                <span class="invalid-feedback"><?php echo $fullname_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Age</label>
                <input type="text" name="age" class="form-control <?php echo (!empty($age_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $age; ?>">
                <span class="invalid-feedback"><?php echo $age_err; ?></span>
            </div> 
            <div class="form-group">
                <label>Gender</label>
                <input type="text" name="gender" class="form-control <?php echo (!empty($gender_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $gender; ?>">
                <span class="invalid-feedback"><?php echo $gender_err; ?></span>
            </div> 
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div> 
            <div class="form-group">
                <label>Bio</label>
                <input type="text" name="bio" class="form-control <?php echo (!empty($bio_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $bio; ?>">
                <span class="invalid-feedback"><?php echo $bio_err; ?></span>
            </div> 
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="submit" value="Submit">
            </div>
            <style> a {color: grey}</style>
            <p>Already have an account? <a href="index.html">Login here</a>.</p>
        </form>
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
    </div>
</body>
</html>