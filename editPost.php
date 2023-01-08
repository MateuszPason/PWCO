<?php
session_start();
require_once "databaseConnection.php";
$conn = new mysqli($servername, $username, $passwordDb, $database);
$_SESSION['postID'] = $_GET['id'];

$all_post_data_query = "SELECT Title, Post_content, Category FROM post WHERE PostID = '{$_SESSION['postID']}'";
$all_post_data = $conn->query($all_post_data_query);
$row = mysqli_fetch_array($all_post_data);
$_SESSION['title'] = $row['Title'];
$_SESSION['content'] = $row['Post_content'];
$_SESSION['category'] = $row['Category'];
$_SESSION['editPostInsteadOfAddNew'] = 1;
header('Location: AddPost.php');

