<?php
session_start();
require_once "databaseConnection.php";
$conn = new mysqli($servername, $username, $passwordDb, $database);
$userID = $_GET['id'];
$delete_specified_user_query = "DELETE FROM blog_user WHERE UserID = '$userID'";
$delete_specified_user = $conn->query($delete_specified_user_query);
if ($delete_specified_user) {
  $conn->close();
  $_SESSION['delete_user_confirmation'] = "Użytkownik został usunięty";
  header('Location: AdminPanel.php');
  exit();
} else {
  echo "Błąd podczas usuwania";
}
