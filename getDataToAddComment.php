<?php
session_start();
$_SESSION['postIDForComment'] = $_GET['id'];
header('Location: commentsForm.php');
