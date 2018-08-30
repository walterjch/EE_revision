<?php
require_once("connect.php");

if (filter_has_var(INPUT_POST, "btnOK")) {
    disconnect();
    header("Location: index.php");
}
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Confirmation</title>
  </head>
  <body>
    <p>Bonjour <?php echo $_SESSION["username"]; ?>, vous êtes connectés !</p>
    <form class="" action="#" method="post">
      <input type="submit" name="btnOK" value="Déconnexion">
    </form>
  </body>
</html>
