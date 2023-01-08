<?php
session_start();
require_once 'php/functions.php';
require_once "databaseConnection.php";

?>
<!doctype html>
<html class="no-js" lang="">

<head>
  <meta charset="utf-8">
  <title>Blog</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">

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

  <!-- Add your site or application content here -->
  <?php
    require("headerElement.php");
  ?>

  <nav>
    <ul>
      <?php
      include 'php/data.php';
        for ($i = 0; $i < count($navigation_elements); $i++) {
          if($navigation_elements[$i] == 'Zaloguj się' || $navigation_elements[$i] == "Zarejestruj się") {
            continue;
          }
          print '<li class="nav-element">';
          print '<a href="';
            print $navigation_links[$i];
          print '">';
            print $navigation_elements[$i];
          print '</a></li>';
        }
      ?>
    </ul>
  </nav>

  <?php
  try {
    $conn = new mysqli($servername, $username, $passwordDb, $database);
    if($conn->connect_errno != 0) {
      throw new Exception(mysqli_connect_errno());
    } else {
      $select_post_details_query = "SELECT PostID, Title, Post_content, Category FROM post";
      $select_post_details = $conn->query($select_post_details_query);
      if ($select_post_details->num_rows > 0) {
        while ($row = mysqli_fetch_array($select_post_details)) {
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
          <a class="comment_link" href="getDataToAddComment.php?id=<?php echo $row['PostID'];?>">Dodaj komentarz</a>
          <a class="comment_link" href="postComments.php?id=<?php echo $row['PostID'];?>">Wyświetl komentarze</a>
          <?php
          echo '</footer>';
          echo '</section>';
        }
      }
    }
  } catch (Exception $e) {
    echo "Connection error";
  }
  ?>

  <?php
  require("footerElement.php");
  ?>

  <script src="js/vendor/modernizr-3.11.2.min.js"></script>
  <script src="js/plugins.js"></script>
  <script src="js/main.js"></script>

  <!-- Google Analytics: change UA-XXXXX-Y to be your site's ID. -->
  <script>
    window.ga = function () { ga.q.push(arguments) }; ga.q = []; ga.l = +new Date;
    ga('create', 'UA-XXXXX-Y', 'auto'); ga('set', 'anonymizeIp', true); ga('set', 'transport', 'beacon'); ga('send', 'pageview')
  </script>
  <script src="https://www.google-analytics.com/analytics.js" async></script>
</body>

</html>
