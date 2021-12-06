<?php
 //connect to server and select database
$conn = mysqli_connect("lamp.cse.fau.edu", "cen4010_su21_g01", "JNc72QcBEM", "cen4010_su21_g01")
 or die(mysqli_error());

//check to see if we're showing the form or adding the post
if ((isset($_POST['op'])) != "addpost") {
      // showing the form; check for required item in query string
    if (!$_GET['post_id']) {
        header("Location: topiclisting.php");
        exit;
    }
     
     //still have to verify topic and post
    $verify = "select ft.topic_id, ft.topic_title from
     Forum_posts as fp left join Forum_topics as ft on
     fp.topic_id = ft.topic_id where fp.post_id = $_GET[post_id]";

    $verify_res = mysqli_query($conn, $verify) or die(mysqli_error($conn));
     if (mysqli_num_rows($verify_res) < 1) {
        //this post or topic does not exist
        header("Location: topiclisting.php");
        exit;
    } else {
        //get the topic id and title
        $topic_id = mysqli_fetch_assoc($verify_res)['topic_id'];
        $topic_title = stripslashes(mysqli_fetch_assoc($verify_res)['topic_title']);
         
         $display_block = "
        <html>
        <head>
        <title>Gopher</title>
        </head>
        <body>
        <h1>Post Your Reply</h1>
        <form method=post action=\"$_SERVER[PHP_SELF]\">
 
        <p><strong>Your E-Mail Address:</strong><br>
        <input type=\"text\" name=\"post_owner\" size=40 maxlength=150>
 
        <P><strong>Post Text:</strong><br>
        <textarea name=\"post_text\" rows=8 cols=40 wrap=virtual></textarea>
 
        <input type=\"hidden\" name=\"op\" value=\"addpost\">
        <input type=\"hidden\" name=\"topic_id\" value=\"$topic_id\">
 
        <P><input type=\"submit\" name=\"submit\" value=\"Add Post\"></p>
 
        </form>
        </body>
        </html>";
    }
 } else if ($_POST['op'] == "addpost") {
    //check for required items from form
    if ((!$_POST['topic_id']) || (!$_POST['post_text']) ||
     (!$_POST['post_owner'])) {
        header("Location: topiclisting.php");
        exit;
    }
 
    //add the post
    $add_post = "insert into Forum_posts values ('', '$_POST[topic_id]',
     '$_POST[post_text]', now(), '$_POST[post_owner]')";
    mysqli_query($conn, $add_post) or die(mysqli_error($conn));
 
   //redirect user to topic
    header("Location: showtopic.php?topic_id=$topic_id");
    exit;
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
                                <?php print $display_block; ?>
                                <p>Would you like to <a href="home.html">go to the Homepage</a>?</p>
<p>Would you like to <a href="topiclisting.php">go to Forum</a>?</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

     <footer class="footer text-faded text-center py-5">
            <div class="container"><p class="m-0 small">Copyright &copy; CEN Summer 2021</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
                          
    </body>
</html>                           
                                