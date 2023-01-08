<?php
session_start();

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

  <meta name="theme-color" content="#fafafa">

</head>

<body>

<!-- Add your site or application content here -->
<?php
require("headerElement.php");
?>

<section class="register-form">
  <form method="get" action="checkContent.php" name="addPost">
    <input type="text" name="title" placeholder="Tytuł" class="form-input-register" value="<?php
      if(isset($_SESSION['title'])) {
        echo $_SESSION['title'];
      }
    ?>"/>

    <textarea name="content" cols="170" rows="10" placeholder="Treść" class="form-input-register textarea-comment"><?php
      if(isset($_SESSION['content'])) {
        echo $_SESSION['content'];
      }
      ?></textarea>

    <input type="text" name="category" placeholder="Kategoria" class="form-input-register" value="<?php
      if(isset($_SESSION['category'])) {
        echo $_SESSION['category'];
      }?>"/>
    <?php
    if (isset($_SESSION['missingPostFields'])) {
      echo '<div class="error-message">'.$_SESSION['missingPostFields'].'</div>';
      unset($_SESSION['missingPostFields']);
    }
    ?>
    <input type="submit" value="Dodaj post" class="form-input" />
  </form>
  <a href="index.php">Powrót</a>
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
