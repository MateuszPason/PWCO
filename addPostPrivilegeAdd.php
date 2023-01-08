<?php
session_start();
require_once "databaseConnection.php";
$conn = new mysqli($servername, $username, $passwordDb, $database);
$_SESSION['userID'] = $_GET['id'];

$promote_user_query = "UPDATE blog_user SET is_Admin = 2 WHERE userID = '{$_SESSION['userID']}'";
$promote_user = $conn->query($promote_user_query);
$_SESSION['successPromote'] = "Użytkownik może dodawać posty";
$conn->commit();
header('Location: AdminPanel.php');
