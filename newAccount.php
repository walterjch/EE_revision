<?php

require_once("connect.php");

$error = false;
$errormsg = "";

if (filter_has_var(INPUT_POST, "btnOK")) {
  $surname = filter_input(INPUT_POST, "surname", FILTER_SANITIZE_STRING);
  $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
  $login = filter_input(INPUT_POST, "login", FILTER_SANITIZE_STRING);
  $pwd = sha1(filter_input(INPUT_POST, "pwd", FILTER_SANITIZE_STRING));
  $pwd2 = sha1(filter_input(INPUT_POST, "pwd2", FILTER_SANITIZE_STRING));
  if ($pwd == $pwd2 && $surname != NULL && $name != NULL && $login != NULL && $pwd != NULL) {
    addUser($surname, $name, $login, $pwd);
    $error = false;
    $errormsg = "";
  }else {
    $error = true;
    $errormsg = "Whoopsi Dumbi !! Le formulaire n'as pas été correctement rempli !";
  }
}

 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Inscription</title>
  </head>
  <body>
    <form class="" action="newAccount.php" method="post">
      <fieldset>
        <legend>Inscription</legend>
        <?php if ($error == true) { ?>
          <span style="color: red;"><?php echo $errormsg ?></span><br>
        <?php } ?>
        <label>Prénom : <br><input type="text" name="surname"/></label><br>
        <label>Nom : <br><input type="text" name="name"/></label><br>
        <label>Identifiant : <br><input type="text" name="login"/></label><br>
        <label>Mot de passe : <br><input type="password" name="pwd"/></label><br>
        <label>Validation du mot de passe : <br><input type="password" name="pwd2"/></label><br>
        <input type="submit" name="btnOK"/><br>
      </fieldset>
    </form>
    <a href="index.php">Back to connction page.</a>
  </body>
</html>
