<?php
session_start();
$allCommentFieldsAreOk = false;
require_once "databaseConnection.php";
if (isset($_POST['nick'])) {
  $allCommentFieldsAreOk = true;
  $nickname = $_POST['nick'];
  $email = $_POST['email'];
  $comment = $_POST['comment'];
  if(empty($nickname)) {
    $_SESSION['error-nickname'] = "Podaj swój nick";
    $allCommentFieldsAreOk = false;
  }
  if(empty($email)) {
    $_SESSION['error-email'] = "Podaj swój email";
    $allCommentFieldsAreOk = false;
  }
  if(empty($comment)) {
    $_SESSION['error-comment'] = "Wprowadź komentarz";
    $allCommentFieldsAreOk = false;
  }

  $secret_recaptcha = "6Lf60CAdAAAAAFu5pjDAcyIwo3vUtuOgg5AUBz-X";
  $check_recaptcha = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='
    .$secret_recaptcha.'&response='.$_POST['g-recaptcha-response']);
  $resp = json_decode($check_recaptcha);
  if($resp->success == false) {
    $_SESSION['error-recaptcha'] = "Zaakceptuj recpatche";
    $allCommentFieldsAreOk = false;
  }
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

  <meta name="theme-color" content="#fafafa">
  <script>
    var numberOfErrors = 0;
    function validateForm() {
      if(document.comment_form.nick.value === "")
        numberOfErrors++;
      if (document.comment_form.email.value === "")
        numberOfErrors++;
      if (document.comment_form.comment.value === "")
        numberOfErrors++;


      if(numberOfErrors > 1) {
        document.getElementById("single_error_nick").innerText = '';
        document.getElementById("single_error_email").innerText = '';
        document.getElementById("single_error_comment").innerText = '';
        document.getElementById('multiple_errors').innerText = 'Uzupełnij wszystkie pola';
        numberOfErrors = 0;
        return false;
      }  else if (numberOfErrors === 1) {
        document.getElementById('multiple_errors').innerText = '';
        if (document.comment_form.nick.value === "") {
          document.getElementById("single_error_nick").innerText = 'Wprowadź nick';
          document.getElementById("single_error_email").innerText = '';
          document.getElementById("single_error_comment").innerText = '';
        }
        else if (document.comment_form.email.value === "") {
          document.getElementById("single_error_nick").innerText = '';
          document.getElementById("single_error_email").innerText = 'Wprowadź email';
          document.getElementById("single_error_comment").innerText = '';
        }
        else if (document.comment_form.comment.value === "") {
          document.getElementById("single_error_nick").innerText = '';
          document.getElementById("single_error_email").innerText = '';
          document.getElementById("single_error_comment").innerText = 'Wprowadź komentarz';
        }
        numberOfErrors = 0;
        return false;
      } else {
        return true;
      }
    }
  </script>
</head>

<body>

<!-- Add your site or application content here -->
<?php
require("headerElement.php");
?>

<section style="float:left;" class="comment-form">
  <form method="post" action="commentsForm.php" name="comment_form" onsubmit="return(validateForm());">
    <input type="text" name="nick" placeholder="Nick" class="form-input"/>
    <?php
      if(isset($_SESSION['error-nickname'])) {
        echo '<div class="error-message">'.$_SESSION['error-nickname'].'</div>';
        unset($_SESSION['error-nickname']);
      }
    ?>
    <div id="single_error_nick" class="error-message"></div>
    <input type="text" name="email" placeholder="E-mail" class="form-input"/>
    <?php
    if(isset($_SESSION['error-email'])) {
      echo '<div class="error-message">'.$_SESSION['error-email'].'</div>';
      unset($_SESSION['error-email']);
    }
    ?>
    <div id="single_error_email" class="error-message"></div>
    <textarea name="comment" cols="170" rows="10" placeholder="Komentarz" class="form-input textarea-comment"></textarea>
    <?php
    if(isset($_SESSION['error-comment'])) {
      echo '<div class="error-message">'.$_SESSION['error-comment'].'</div>';
      unset($_SESSION['error-comment']);
    }
    ?>
    <div id="single_error_comment" class="error-message"></div>
    <div class="g-recaptcha" data-sitekey="6Lf60CAdAAAAAMasuehWgdphjirtMojPItjng9jK" data-theme="dark"></div>
    <?php
    if(isset($_SESSION['error-recaptcha'])) {
      echo '<div class="error-message">'.$_SESSION['error-recaptcha'].'</div>';
      unset($_SESSION['error-recaptcha']);
    }
    ?>
    <div class="error-message" id="multiple_errors"></div>
    <p><input type="submit" value="Dodaj komentarz" class="form-input"></p>
  </form>
  <?php
  try {
    $conn = new mysqli($servername, $username, $passwordDb, $database);
    if($conn->connect_errno != 0) {
      throw new Exception(mysqli_connect_errno());
    } else {
      if($allCommentFieldsAreOk == true) {
        $add_comment_query = "INSERT INTO comment (CommentID, Nickname, Comment_content, Email, PostID) VALUES (NULL,
        '$nickname', '$comment', '$email', '{$_SESSION['postIDForComment']}')";
        if($conn->query($add_comment_query) === TRUE) {
          echo "<p style='color: #38ef7d'>Komentarz został dodany. Dziękujemy!</p>";
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
