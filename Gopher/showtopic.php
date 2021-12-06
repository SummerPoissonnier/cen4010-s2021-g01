<?php
//check for required info from the query string
if (!$_GET['topic_id']) {
    header("Location: topiclisting.php");
    exit;
 }

 //connect to server and select database
$conn = mysqli_connect("lamp.cse.fau.edu", "cen4010_su21_g01", "JNc72QcBEM", "cen4010_su21_g01")
 or die(mysqli_error());

//verify the topic exists
$verify_topic = "select topic_title from Forum_topics where
     topic_id = $_GET[topic_id]";
 $verify_topic_res = mysqli_query($conn,$verify_topic)
     or die(mysqli_error($conn));

if (mysqli_num_rows($verify_topic_res) < 1) {
     //this topic does not exist
    $display_block = "<P><em>You have selected an invalid topic.
     Please <a href=\"topiclist.php\">try again</a>.</em></p>";
 } else {
     //get the topic title
    $topic_title = stripslashes(mysqli_fetch_assoc($verify_topic_res)['topic_title']);
    
    //gather the posts
    $get_posts = "select post_id, post_text, date_format(post_create_time,
         '%b %e %Y at %r') as fmt_post_create_time, post_owner from
         Forum_posts where topic_id = $_GET[topic_id]
         order by post_create_time asc";
 
   $get_posts_res = mysqli_query($conn,$get_posts) or die(mysqli_error($conn));
 
    //create the display string
    $display_block = "
    <P>Showing posts for the <strong>$topic_title</strong> topic:</p>
 
    <table width=100% cellpadding=3 cellspacing=1 border=1>
    <tr>
    <th>AUTHOR</th>
    <th>POST</th>
    </tr>";
    
     while ($posts_info = mysqli_fetch_array($get_posts_res)) {
         $post_id = $posts_info['post_id'];
        $post_text = nl2br(stripslashes($posts_info['post_text']));
        $post_create_time = $posts_info['fmt_post_create_time'];
        $post_owner = stripslashes($posts_info['post_owner']);
 
        //add to display
       $display_block .= "
        <tr>
        <td width=35% valign=top>$post_owner<br>[$post_create_time]</td>
        <td width=65% valign=top>$post_text<br><br>
         <a href=\"replytopost.php?post_id=$post_id\"><strong>REPLY TO
         POST</strong></a></td>
        </tr>";
    } 
    //close up the table
    $display_block .= "</table>";
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
 <h1>Posts in Topic</h1>
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
