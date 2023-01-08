<?php
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
        $get_all_categories_query = "SELECT DISTINCT Category FROM post";
        $get_all_categories = $conn->query($get_all_categories_query);
        echo "<table style='margin-left: auto; margin-right: auto'><th colspan='1' style='font-size: 16px; text-transform: uppercase;'>Wybierze tag</th>";
        while ($row = mysqli_fetch_array($get_all_categories)) {
          ?>
          <tr>
            <td><a href="showPostWithTag.php?tag=<?php echo $row['Category']; ?>"><?php echo $row['Category']?></a></td>
          </tr>
          <?php
        }
        echo "</table>";
      }
    } catch (Exception $e) {
      echo "Connection error";
    }

    ?>
  </section>

<?php
require("footerElement.php");
?>
</body>
</html>
