<?php
require_once("connect.php");

if (filter_has_var(INPUT_POST, "btnDisconnect")) {
    disconnect();
    header("Location: index.php");
    exit;
}

$userArray = getUserByLogin($_SESSION['username']);
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Confirmation</title>
  </head>
  <body>
    <h2>Bonjour <?php echo $userArray['surname'] . " " . $userArray['name']; ?>, vous êtes connectés !</h2>
    <form class="" action="#" method="post">
      <fieldset>
        <legend>Nouveau post</legend>
        <label>Titre : <br><input type="text" name="" value=""></label><br>
        <label>Description : <br><textarea rows="15" cols="100"></textarea></label><br>
        <input type="submit" name="btnOK" value="Insérer">
      </fieldset> <br>
      <input type="submit" name="btnDisconnect" value="Déconnexion">
    </form>
  </body>
</html>
