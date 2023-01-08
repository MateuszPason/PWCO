<!doctype html>
<html class="no-js" lang="">

<head>
  <meta charset="utf-8">
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Blog - wszystko co musisz wiedzieć o biżuterii</title>
  <meta name=„keywords” content="Biżuteria, Pierścionki, Zegarki, Naszyjniki" />
  <meta name=„robots” content="index, follow"/>

  <meta property="og:title" content="">
  <meta property="og:type" content="">
  <meta property="og:url" content="">
  <meta property="og:image" content="">

  <link rel="manifest" href="site.webmanifest">
  <link rel="apple-touch-icon" href="icon.png">
  <!-- Place favicon.ico in the root directory -->

  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/main.css?v=<?php echo time(); ?>">

  <meta name="theme-color" content="#fafafa">
</head>

<body>

<?php
require("headerElement.php");
session_start();
require_once "databaseConnection.php";
require_once "php/functions.php";
$conn = new mysqli($servername, $username, $passwordDb, $database);
$tag = $_GET['tag'];
$show_posts_with_tag_query = "SELECT * FROM post WHERE Category = '$tag'";
$show_posts_with_tag =  $conn->query($show_posts_with_tag_query);
if ($show_posts_with_tag->num_rows > 0) {
  while ($row = mysqli_fetch_array($show_posts_with_tag)) {
    echo '<section class="blog-post">';
    echo '<header class="post-title"><h2>';
    echo $row['Title'];
    echo '</h2></header>';
    echo '<article><p>';
    echo bbCodesReplace($row['Post_content']);
    echo '</p></article>';
    echo '<footer>';
    echo '<span class="post-tags">';
    echo '<b>'.$row['Category'].'</b>';
    echo '</span>';
    ?>
    <?php
    echo '</footer>';
    echo '</section>';
  }
}


require("footerElement.php");
?>

<script src="js/vendor/modernizr-3.11.2.min.js"></script>
<script src="js/plugins.js"></script>
<script src="js/main.js"></script>

<!-- Google Analytics: change UA-XXXXX-Y to be your site's ID. -->
<script>
  window.ga = function () {
    ga.q.push(arguments)
  };
  ga.q = [];
  ga.l = +new Date;
  ga('create', 'UA-XXXXX-Y', 'auto');
  ga('set', 'anonymizeIp', true);
  ga('set', 'transport', 'beacon');
  ga('send', 'pageview')
</script>
<script src="https://www.google-analytics.com/analytics.js" async></script>
</body>

</html>
