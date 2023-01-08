<?php
session_start();
require_once 'databaseConnection.php';

?>
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

<!-- Add your site or application content here -->
<?php
require("headerElement.php");
?>

<section style="text-align: center">
  <?php
  $postID = $_GET['id'];
  try {
    $conn = new mysqli($servername, $username, $passwordDb, $database);
    if($conn->connect_errno != 0) {
      throw New Exception(mysqli_connect_errno());
    } else {
      $get_all_specified_post_comments_query = "SELECT Comment_content, Nickname FROM comment WHERE PostID = '$postID'";
      $get_all_specified_post_comments = $conn->query($get_all_specified_post_comments_query);
      if($get_all_specified_post_comments->num_rows > 0) {
        while ($row = mysqli_fetch_array($get_all_specified_post_comments)) {
          echo "<p>".$row['Comment_content']." - Autor: ".$row['Nickname']."</p>";
        }
      } else {
        echo "<p>Brak komentarzy</p>";
      }
    }
  } catch (Exception $e) {
    echo "Connection error";
  }
  ?>
</section>

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

