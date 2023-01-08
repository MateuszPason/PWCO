<?php
session_start();
require_once "databaseConnection.php";
$conn = new mysqli($servername, $username, $passwordDb, $database);
$postID = $_GET['id'];
$queryToDeleteSpecifiedPost = "DELETE FROM post WHERE PostID = '$postID'";
$deleteSpecifiedPost = $conn->query($queryToDeleteSpecifiedPost);
if($deleteSpecifiedPost) {
  $conn->close();
  $_SESSION['deletedPostConfirmation'] = "Post został usunięty";
  header("Location: PostManagement.php");
  exit();
} else {
  echo "Błąd podczas usuwania";
}
