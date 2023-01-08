<?php
require_once "databaseConnection.php";
require_once 'php/functions.php';
session_start();
if(isset($_GET['title'])) {
  $_SESSION['allPostFieldsAreOk'] = true;
  $_SESSION['title'] = $_GET['title'];
  $_SESSION['content'] = $_GET['content'];
  $_SESSION['category'] = $_GET['category'];

  if(empty($_SESSION['title']) || empty($_SESSION['content']) || empty($_SESSION['category'])) {
    $_SESSION['error-information'] = "Wszystkie pola muszą zostać uzupełnione";
    $_SESSION['allPostFieldsAreOk'] = false;
  }

  $_SESSION['bbCodeChanged'] = bbCodesReplace($_SESSION['content']);
}
?>
<!doctype html>
<html class="no-js" lang="">

<head>
  <meta charset="utf-8">
  <title>Blog</title>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
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
  <link rel="stylesheet" href="css/register.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="css/postAdd.css?v=<?php echo time(); ?>">

  <meta name="theme-color" content="#fafafa">

</head>

<body>

<!-- Add your site or application content here -->
<?php
require("headerElement.php");
?>

<section class="blog-post">
  <header class="post-title"><h2>
    <?php
      echo $_SESSION['title'];
    ?>
    </h2></header>
  <?php
  echo $_SESSION['bbCodeChanged'];
  ?>
  <footer>
    <?php
    print '<br />';
    print '<span class="post-tags">';
    print $_SESSION['category'];
    print '</span>';
    ?>
  </footer>
</section>

<section class="register-form">
  <form method="get" action="AddPost.php">
    <input type="submit" value="Powrót" class="form-input-register">
  </form>

  <form method="post" action="dodanoEdytowano.php">
    <input type="submit" value="Dodaj/Edytuj" class="form-input-register">
  </form>
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

