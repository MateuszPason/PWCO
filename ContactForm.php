<?php
session_start();
$allContactFieldsAreOk = false;
require_once "databaseConnection.php";
if (isset($_POST['nick'])) {
  $allContactFieldsAreOk = true;
  $nickname = $_POST['nick'];
  $email = $_POST['email'];
  $message = $_POST['message'];
  $phone_number = $_POST['phone_number'];
  if(empty($phone_number)) {
    $_SESSION['error_phone_number'] = "Podaj swój numer telefonu";
    $allContactFieldsAreOk = false;
  }
  if(empty($nickname)) {
    $_SESSION['error-nickname'] = "Podaj swój nick";
    $allContactFieldsAreOk = false;
  }
  if(empty($email)) {
    $_SESSION['error-email'] = "Podaj swój email";
    $allContactFieldsAreOk = false;
  }
  if(empty($message)) {
    $_SESSION['error-message'] = "Wprowadź swoją wiadomość";
    $allContactFieldsAreOk = false;
  }
}
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

<section style="float:left;" class="comment-form">
  <div class="contact_form_header"">Formularz kontaktowy</div>
  <form method="post" action="ContactForm.php" name="contact_form">
    <input type="text" name="nick" placeholder="Nick" class="form-input"/>
    <?php
    if(isset($_SESSION['error-nickname'])) {
      echo '<div class="error-message">'.$_SESSION['error-nickname'].'</div>';
      unset($_SESSION['error-nickname']);
    }
    ?>
    <input type="text" name="email" placeholder="E-mail" class="form-input"/>
    <?php
    if(isset($_SESSION['error-email'])) {
      echo '<div class="error-message">'.$_SESSION['error-email'].'</div>';
      unset($_SESSION['error-email']);
    }
    ?>

    <input type="tel" name="phone_number" placeholder="Numer telefonu - 9 cyfr" class="form-input" pattern="[0-9]{9}">
    <?php
    if(isset($_SESSION['error_phone_number'])) {
      echo '<div class="error-message">'.$_SESSION['error_phone_number'].'</div>';
      unset($_SESSION['error_phone_number']);
    }
    ?>

    <textarea name="message" cols="170" rows="10" placeholder="Wiadomość" class="form-input textarea-comment"></textarea>
    <?php
    if(isset($_SESSION['error-message'])) {
      echo '<div class="error-message">'.$_SESSION['error-message'].'</div>';
      unset($_SESSION['error-message']);
    }
    ?>
    <p><input type="submit" value="Wyślij widomość" class="form-input"></p>
  </form>
  <?php
  try {
    $conn = new mysqli($servername, $username, $passwordDb, $database);
    if($conn->connect_errno != 0) {
      throw new Exception(mysqli_connect_errno());
    } else {
      if($allContactFieldsAreOk == true) {
        $add_message_query = "INSERT INTO contact_message (MessageID, Nick, Email, PhoneNumber, Message) VALUES (NULL,
        '$nickname', '$email', '$phone_number', '$message')";
        if($conn->query($add_message_query) === TRUE) {
          echo "<p style='color: #38ef7d'>Twoja wiadomość została zapisana, wkrótce otrzymasz odpowiedź</p>";
        }
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
