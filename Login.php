<?php
    session_start();
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
  <link rel="stylesheet" href="css/register.css?v=<?php echo time(); ?>">

  <meta name="theme-color" content="#fafafa">
</head>

<body>

<!-- Add your site or application content here -->
<?php
require("headerElement.php");
?>

<section class="register-form">
  <form method="post" action="processLogin.php" name="addPost">
    <input type="text" name="email" placeholder="Email" class="form-input-register" value=""/>

    <input type="password" name="password" placeholder="Hasło" class="form-input-register" value=""/>
    <input type="submit" value="Zaloguj się" class="form-input" />
  </form>
  <?php
  if(isset($_SESSION['wrong_credentials']))
    echo $_SESSION['wrong_credentials'];
  ?>
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
