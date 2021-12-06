<?php

//check for required fields from the form
if ((!$_POST['topic_owner']) || (!$_POST['topic_title'])
    || (!$_POST['post_text'])) {
    header("Location: home.html");
    exit;
}

//connect to server and select database
$conn = mysqli_connect("lamp.cse.fau.edu", "cen4010_su21_g01", "JNc72QcBEM", "cen4010_su21_g01")
 or die(mysqli_error());

//create and issue the first query
 $add_topic = "insert into Forum_topics values ('', '$_POST[topic_title]',
    now(), '$_POST[topic_owner]')";
    mysqli_query($conn, $add_topic) or die(mysqli_error($conn));

//get the id of the last query 
$topic_id = mysqli_insert_id($conn);

//create and issue the second query
$add_post = "insert into Forum_posts values ('', '$topic_id',
'$_POST[post_text]', now(), '$_POST[topic_owner]')";
mysqli_query($conn, $add_post) or die(mysqli_error($conn));
header("location: topiclisting.php");
//create nice message for user
$msg = "<P>The topic has been created.</p>";


?>

 <html>

 <head>

 <title>New Topic Added</title>

</head>

 <body>

<h1>New Topic Added</h1>

<?php print $msg; ?>
<p>Would you like to <a href="home.html">add another topic</a>?</p>
<p>Would you like to <a href="topiclisting.php">go to the forum</a>?</p>
</body>
</html>