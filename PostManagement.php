<?php
session_start();
if(!isset($_SESSION['loggedInUser'])) {
  header('Location: index.php');
}
require_once "databaseConnection.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin panel</title>
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/main.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="css/register.css?v=<?php echo time(); ?>">
</head>
<body>
<?php
require("headerElement.php");
?>

  <section style="text-align: center;">
    <?php
    try {
      $conn = new mysqli($servername, $username, $passwordDb, $database);
      if($conn->connect_errno != 0) {
        throw new Exception(mysqli_connect_errno());
      } else {
        $check_privileges_query = "SELECT is_Admin FROM blog_user WHERE Email = '{$_SESSION['user_email']}'";
        $check_privileges = $conn->query($check_privileges_query);
        $privileges_result = mysqli_fetch_array($check_privileges);
        if ($privileges_result[0] == "1") {
          $all_posts_query = "SELECT * FROM post";
          $all_posts = $conn->query($all_posts_query);
          if($all_posts->num_rows > 0) {
            echo "<table style='margin-left: auto; margin-right: auto'><th colspan='3' style='font-size: 16px; text-transform: uppercase;'>Zarządzaj postami</th>";
            while ($row = mysqli_fetch_array($all_posts)) {
              ?>
              <tr>
                <td><?php echo $row['Title']; ?></td>
                <td><a href="editPost.php?id=<?php echo $row['PostID'];?>">Edytuj</a></td>
                <td><a href="deletePost.php?id=<?php echo $row['PostID'];?>">Usuń</a></td>
              </tr>
              <?php
            }
            echo "</table>";
          }
        } else {
          $user_posts_query = "SELECT * FROM post WHERE author = '{$_SESSION['user_email']}'";
          $user_posts = $conn->query($user_posts_query);
          if ($user_posts->num_rows > 0) {
            echo "<table style='margin-left: auto; margin-right: auto'><th colspan='3' style='font-size: 16px; text-transform: uppercase;'>Zarządzaj postami</th>";
            while ($row = mysqli_fetch_array($user_posts)) {
              ?>
              <tr>
                <td><?php echo $row['Title']; ?></td>
                <td><a href="editPost.php?id=<?php echo $row['PostID'];?>">Edytuj</a></td>
                <td><a href="deletePost.php?id=<?php echo $row['PostID'];?>">Usuń</a></td>
              </tr>
              <?php
            }
            echo "</table>";
          } else {
            echo "<p>Brak postów do wyświetlenia</p>";
          }
        }
      }
    } catch (Exception $e) {
      echo "Connection error";
    }
    //Ostylować
      if(isset($_SESSION['deletedPostConfirmation'])) {
        echo "<p style='color: #38ef7d'>".$_SESSION['deletedPostConfirmation'].'</p>';
        unset($_SESSION['deletedPostConfirmation']);
      }
    ?>

    <br />
    <a href="logout.php">Wyloguj się</a>
  </section>

<?php
require("footerElement.php");
?>
</body>
</html>
