<?php
session_start();

if((!isset($_POST['email'])) || (!isset($_POST['password']))) {
  header('Location: index.php');
  exit();
}
require_once "databaseConnection.php";

$conn = @new mysqli($servername, $username, $passwordDb, $database);

if($conn->connect_errno != 0) {
  echo "Error: ".$conn->connect_errno. " Description: ".$conn->connect_error;
} else {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $getUserQuery = "SELECT * FROM blog_user WHERE email = '$email'";
  if($getUser = @$conn->query($getUserQuery)) {
    $numberOfUsers = $getUser->num_rows;
    if($numberOfUsers == 1) {
      $userData = $getUser->fetch_assoc();
      if(password_verify($password, $userData['Password'])) {
        $_SESSION['loggedInUser'] = true;
        $_SESSION['user_id'] = $userData['UserID'];
        $_SESSION['user_email'] = $userData['Email'];


        unset($_SESSION['wrong_credentials']);
        $getUser->free_result();
        header('Location: PostManagement.php');
      } else {
        $_SESSION['wrong_credentials'] = '<div style="color:red; margin-bottom: 10px;">Podano niepoprawne dane logowania</div>';
        header('Location: Login.php');
      }
    } else {
      $_SESSION['wrong_credentials'] = '<div style="color:red; margin-bottom: 10px;">Podano niepoprawne dane logowania</div>';
      header('Location: Login.php');
    }
  }

  $conn->close();
}
?>
