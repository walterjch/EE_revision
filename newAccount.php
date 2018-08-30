<?php

require_once("connect.php");



 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <form class="" action="newAccount.php" method="post">
      <fieldset>
        <legend>Inscription</legend>
        <label>Prénom : <br><input type="text" name="surname"/></label><br>
        <label>Nom : <br><input type="text" name="name"/></label><br>
        <label>Identifiant : <br><input type="text" name="id"/></label><br>
        <label>Mot de passe : <br><input type="password" name="pwd"/></label><br>
        <label>Validation du mot de passe : <br><input type="password" name="pwd2"/></label><br>
        <input type="submit" name="btnOK"/><br>
      </fieldset>
    </form>
    <a href="index.php">Back to connction page.</a>
  </body>
</html>
