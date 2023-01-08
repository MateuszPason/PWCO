<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Title</title>
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/main.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="css/register.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="css/postAdd.css?v=<?php echo time(); ?>">
</head>
<body>
<?php
require("headerElement.php");
?>

  <p class="information-paragraph">Post został dodany/edytowany na blogu.</p>
  <p class="information-paragraph"><a href="AddPost.php">Wróć do formularza dodawania/edytowania postów</a></p>
  <?php
  require_once "databaseConnection.php";
  session_start();
  try {
    $conn = new mysqli($servername, $username, $passwordDb, $database);
    if($conn->connect_errno != 0) {
      throw new Exception(mysqli_connect_errno());
    } else {
      if ($_SESSION['allPostFieldsAreOk'] == false) {
        $_SESSION['missingPostFields'] = 'Wszystkie pola muszą zostać uzupełnione';
        header('Location: AddPost.php');
      } else {
        if (isset($_SESSION['editPostInsteadOfAddNew'])) {
          $edit_post_query = "UPDATE post SET Title = '{$_SESSION['title']}', Post_content = '{$_SESSION['content']}',
            Category = '{$_SESSION['category']}' WHERE PostID = '{$_SESSION['postID']}'";
          if($conn->query($edit_post_query) === TRUE) {
            $conn->commit();
          } else {
            $conn->rollback();
          }
          unset($_SESSION['editPostInsteadOfAddNew']);
        } else {
          $conn->query("INSERT INTO post VALUES (NULL, '{$_SESSION['title']}', '{$_SESSION['bbCodeChanged']}',
        '{$_SESSION['user_email']}', '{$_SESSION['category']}')");
          $conn->commit();
        }
        unset($_SESSION['title']);
        unset($_SESSION['content']);
        unset($_SESSION['category']);
        unset($_SESSION['postID']);
        $conn->close();
      }

    }
  } catch (Exception $e) {
    echo "Connection error";
  }
  ?>

<?php
require("footerElement.php");
?>
</body>
</html>
