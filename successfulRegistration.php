<?php
session_start();
if((!isset($_SESSION['successfulRegistration']))) {
  header('Location: index.php');
} else {
  unset($_SESSION['successfulRegistration']);
}

if(isset($_SESSION['remember_email'])) unset($_SESSION['remember_email']);
if(isset($_SESSION['remember_password'])) unset($_SESSION['remember_password']);
if(isset($_SESSION['remember_password_repeat'])) unset($_SESSION['remember_password_repeat']);
if(isset($_SESSION['remember_phone_number'])) unset($_SESSION['remember_phone_number']);
if(isset($_SESSION['remember_first_name'])) unset($_SESSION['remember_first_name']);

if(isset($_SESSION['error_email_mess'])) unset($_SESSION['error_email_mess']);
if(isset($_SESSION['error_password_mess'])) unset($_SESSION['error_password_mess']);
if(isset($_SESSION['error_phone_number_mess'])) unset($_SESSION['error_phone_number_mess']);
if(isset($_SESSION['error_first_name_mess'])) unset($_SESSION['error_first_name_mess']);

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
<section style="text-align: center">
  <p style="text-align: center">Rejestracja przebiegła pomyślnie, możesz wrócić do strony głownej i zalogować się</p>
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

