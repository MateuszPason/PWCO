<?php
session_start();
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
      $get_user_privileges_query = "SELECT is_Admin FROM blog_user WHERE UserID = '{$_SESSION['user_id']}'";
      $get_user_privileges = $conn->query($get_user_privileges_query);
      $privileges_result = mysqli_fetch_array($get_user_privileges);
      if($privileges_result[0] == "1") {
        $get_all_non_admin_users_query = "SELECT UserID, Email FROM blog_user WHERE is_Admin = 0";
        $get_all_non_admin_users = $conn->query($get_all_non_admin_users_query);
        if($get_all_non_admin_users->num_rows > 0) {
          echo "<table style='margin-left: auto; margin-right: auto'><th colspan='3' style='font-size: 16px; text-transform: uppercase;'>Zarządzaj użytkownikami</th>";
          while ($row = mysqli_fetch_array($get_all_non_admin_users)) {
            ?>
            <tr>
              <td><?php echo $row['Email']; ?></td>
              <td><a href="promoteUser.php?id=<?php echo $row['UserID'];?>">Awansuj na admina</a></td>
              <td><a href="deleteUser.php?id=<?php echo $row['UserID'];?>">Usuń użytkownika</a></td>
            </tr>
            <?php
          }
          echo "</table>";
        } else {
          echo "<p>Brak użytkowników do zarządzania</p>";
        }
      } else {
        echo "<p>Nie wystarczające uprawnienia</p>";
      }
    }
  } catch (Exception $e) {
    echo "Connection error";
  }

  if(isset($_SESSION['successPromote'])) {
    echo "<p style='color: #38ef7d'>".$_SESSION['successPromote'].'</p>';
    unset($_SESSION['successPromote']);
  }

  if(isset($_SESSION['delete_user_confirmation'])) {
    echo "<p style='color: #38ef7d'>".$_SESSION['delete_user_confirmation'].'</p>';
    unset($_SESSION['delete_user_confirmation']);
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
