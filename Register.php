<?php
session_start();
require_once "databaseConnection.php";
if(isset($_POST['email'])) {
  $allFieldsAreOk = true;

  $email = $_POST['email'];
  $password = $_POST['password'];
  $password_repeat = $_POST['password_repeat'];
  $phone_number = $_POST['phone_number'];
  $first_name = $_POST['firstName'];

  $clearedEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
  if((filter_var($clearedEmail, FILTER_VALIDATE_EMAIL) == false) || ($clearedEmail != $email)) {
    $allFieldsAreOk = false;
    $_SESSION['error_email_mess'] = 'Podaj poprawny adres email';
  }

  if((strlen($password) < 8) || (strlen($password) > 20)) {
    $allFieldsAreOk = false;
    $_SESSION['error_password_mess'] = 'Hasło musi mieć długość od 8 do 20 znaków';
  }

  if($password != $password_repeat) {
    $allFieldsAreOk = false;
    $_SESSION['error_password_mess'] = 'Hasła nie są identyczne';
  }

  $password_hash = password_hash($password, PASSWORD_DEFAULT);

  if(strlen($phone_number) != 9) {
    $allFieldsAreOk = false;
    $_SESSION['error_phone_number_mess'] = 'Numer telefonu musi miec 9 cyfr';
  }

  if(strlen($first_name) < 4) {
    $allFieldsAreOk = false;
    $_SESSION['error_first_name_mess'] = 'Wprowadź swoję imię';
  }

  $_SESSION['remember_email'] = $email;
  $_SESSION['remember_password'] = $password;
  $_SESSION['remember_password_repeat'] = $password_repeat;
  $_SESSION['remember_phone_number'] = $phone_number;
  $_SESSION['remember_first_name'] = $first_name;


  mysqli_report(MYSQLI_REPORT_STRICT);
  try {
    $conn = new mysqli($servername, $username, $passwordDb, $database);
    if($conn->connect_errno != 0) {
      throw new Exception(mysqli_connect_errno());
    } else {
      $ifUserAlreadyExists = $conn->query("SELECT UserID FROM blog_user WHERE email='$email'");
      if(!$ifUserAlreadyExists) {
        throw new Exception($conn->error);
      }

      $numberOfTheSameEmail = $ifUserAlreadyExists->num_rows;
      if($numberOfTheSameEmail > 0) {
        $allFieldsAreOk = false;
        $_SESSION['error_email_mess'] = "Podany adres email jest już używany";
      }

      if ($allFieldsAreOk == true) {
        if($conn->query("INSERT INTO blog_user VALUES (NULL, '$email', '$password_hash', '$phone_number', '$first_name', 0)")) {
          $_SESSION['successfulRegistration'] = true;
          header('Location: successfulRegistration.php');
        } else {
          throw new Exception($conn->error);
        }
      }
      $conn->close();
    }
  } catch(Exception $e) {
    echo "Connection error";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name=„robots” content="index, follow"/>
  <title>Rejestracja</title>
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/main.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="css/register.css?v=<?php echo time(); ?>">
  <script>
    function validateRegisterForm(event) {
      let email = document.forms["register_form"]["email"].value;
      let password1 = document.forms["register_form"]["password"].value;
      let password2 = document.forms["register_form"]["password_repeat"].value;
      let phone_number = document.forms["register_form"]["phone_number"].value;
      let firstName = document.forms["register_form"]["firstName"].value;

      if (validateEmail(email)) {
        document.getElementById('error-email').innerText = '';
      } else {
        document.getElementById('error-email').innerText = 'Podaj poprawny adres email';
      }

      if (password1.length < 8 || password1.length > 20) {
        document.getElementById('error-password').innerText = 'Hasło musi mieć długość od 8 do 20 znaków';
      } else {
        document.getElementById('error-password').innerText = '';
      }

      if (password1 != password2) {
        document.getElementById('error-password-repeat').innerText = 'Hasła nie są identyczne';
      } else {
        document.getElementById('error-password-repeat').innerText = '';
      }

      if (phone_number.match("^\\d{9}$")) {
        document.getElementById('error-phone-number').innerText = '';
      } else {
        document.getElementById('error-phone-number').innerText = 'Numer telefonu musi miec 9 cyfr';
      }

      if (firstName.length < 4) {
        document.getElementById('error-first-name').innerText = 'Wprowadź swoję imię';
      } else {
        document.getElementById('error-first-name').innerText = '';
      }

      event.preventDefault();
    }

    function validateEmail(email) {
      const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      return re.test(String(email).toLowerCase());
    }

    function register() {
      document.register_form.addEventListener("invalid", validateRegisterForm, true);
    }
    window.addEventListener("load", register, false);
  </script>
</head>
<body>
<?php
require("headerElement.php");
?>

<section class="register-form">
  <form method="post" action="Register.php" name="register_form">
    <p><input type="text" name="email" placeholder="Email" class="form-input-register" required value="<?php
        if(isset($_SESSION['remember_email'])) {
          echo $_SESSION['remember_email'];
          unset($_SESSION['remember_email']);
        }
      ?>"></p>
    <div class="error-message" id="error-email"></div>
    <?php
      if(isset($_SESSION['error_email_mess'])) {
        echo '<div class="error-message">'.$_SESSION['error_email_mess'].'</div>';
        unset($_SESSION['error_email_mess']);
      }
    ?>
    <p><input type="password" name="password" placeholder="Hasło" class="form-input-register" minlength="8" maxlength="20" required value="<?php
      if(isset($_SESSION['remember_password'])) {
        echo $_SESSION['remember_password'];
        unset($_SESSION['remember_password']);
      }
      ?>"></p>
    <div class="error-message" id="error-password"></div>
    <?php
    if(isset($_SESSION['error_password_mess'])) {
      echo '<div class="error-message">'.$_SESSION['error_password_mess'].'</div>';
      unset($_SESSION['error_password_mess']);
    }
    ?>
    <p><input type="password" name="password_repeat" placeholder="Powtórz hasło" class="form-input-register" value="<?php
      if(isset($_SESSION['remember_password_repeat'])) {
        echo $_SESSION['remember_password_repeat'];
        unset($_SESSION['remember_password_repeat']);
      }
      ?>"></p>
    <div class="error-message" id="error-password-repeat"></div>
    <p><input type="tel" name="phone_number" placeholder="Numer telefonu - 9 cyfr" class="form-input-register" required pattern="[0-9]{9}" value="<?php
      if(isset($_SESSION['remember_phone_number'])) {
        echo $_SESSION['remember_phone_number'];
        unset($_SESSION['remember_phone_number']);
      }
      ?>"></p>
    <div class="error-message" id="error-phone-number"></div>
    <?php
    if(isset($_SESSION['error_phone_number_mess'])) {
      echo '<div class="error-message">'.$_SESSION['error_phone_number_mess'].'</div>';
      unset($_SESSION['error_phone_number_mess']);
    }
    ?>
    <p><input type="text" name="firstName" placeholder="Imię" class="form-input-register" value="<?php
      if(isset($_SESSION['remember_first_name'])) {
        echo $_SESSION['remember_first_name'];
        unset($_SESSION['remember_first_name']);
      }
      ?>"></p>
    <div class="error-message" id="error-first-name"></div>
    <?php
    if(isset($_SESSION['error_first_name_mess'])) {
      echo '<div class="error-message">'.$_SESSION['error_first_name_mess'].'</div>';
      unset($_SESSION['error_first_name_mess']);
    }
    ?>
    <p><input type="submit" value="Zarejestruj się" class="form-input"></p>
  </form>
  <a href="index.php">Powrót</a>
</section>

<?php
require("footerElement.php");
?>
</body>
</html>
