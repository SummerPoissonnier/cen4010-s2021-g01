<?php
//connect to server and select database
$conn = mysqli_connect("lamp.cse.fau.edu", "cen4010_su21_g01", "JNc72QcBEM", "cen4010_su21_g01")
 or die(mysqli_error());

//gather the topics
 $get_topics = "select topic_id, topic_title,
 date_format(topic_create_time, '%b %e %Y at %r') as fmt_topic_create_time,
  topic_owner from Forum_topics order by topic_create_time desc";
  $get_topics_res = mysqli_query($conn, $get_topics) or die(mysqli_error($conn));
 if (mysqli_num_rows($get_topics_res) < 1) {
    //there are no topics, so say so
     $display_block = "<P><em>No topics exist.</em></p>";
  } else {
     //create the display string
    $display_block = "
     <table cellpadding=3 cellspacing=1 border=1>
     <tr>
    <th>TOPIC TITLE</th>
   <th># of POSTS</th>
</tr>";
     
      while ($topic_info = mysqli_fetch_array($get_topics_res)) {
        $topic_id = $topic_info['topic_id'];
        $topic_title = stripslashes($topic_info['topic_title']);
          $topic_create_time = $topic_info['fmt_topic_create_time'];
          $topic_owner = stripslashes($topic_info['topic_owner']);
 
        //get number of posts
       $get_num_posts = "select count(post_id) from Forum_posts
             where topic_id = $topic_id";
        $get_num_posts_res = mysqli_query($conn, $get_num_posts)
             or die(mysqli_error($conn));
        $num_posts = mysqli_fetch_assoc($get_num_posts_res)['count(post_id)'];
        //add to display
        $display_block .= "
        <tr>
        <td><a href=\"showtopic.php?topic_id=$topic_id\">
        <strong>$topic_title</strong></a><br>
         Created on $topic_create_time by $topic_owner</td>
        <td align=center>$num_posts</td>
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
            
    <h1>Topics in My Forum</h1>
    <?php print $display_block; ?>
         <p>Would you like to <a href="home.html">go to the Homepage</a>?</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div></section>
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
                  