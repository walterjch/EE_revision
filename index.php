<!--
Titre       : EE_Revision
Description : Projet de révision de la
              deuxième année.
Auteur      : JAUCH Walter
Date        : 30.08.2018
-->
<?php

require_once("connect.php");

$username = filter_input(INPUT_POST, "id", FILTER_SANITIZE_STRING);
$pwd = sha1(filter_input(INPUT_POST, "pwd", FILTER_SANITIZE_STRING));

$error = false;
$errormsg = "";
$username = "";
$pwd = "";
$logged = false;
$userCo = "";

//On vérifie que l'utilisateur a clique sur le bouton
if (filter_has_var(INPUT_POST, "btnOK")) {
//Est-il déconnecté ? Si oui on lui propose de se déconnecter,
//Sinon, on lui propose de se connecter
  if (!isset($_SESSION['username'])) {
    $username = filter_input(INPUT_POST, "username");
    $pwd = filter_input(INPUT_POST, "password");
    checkUser($username, $pwd);
  }else {
    disconnect();
  }

}
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <form class="" action="index.php" method="post">
      <fieldset>
        <legend>Connection</legend>
        <label>Identifiant : </br><input type="text" name="id"/></label></br>
        <label>Mot de passe : </br><input type="password" name="pwd"/></label></br>
        <input type="submit" name="btnOK"/></br>
        <a href="newAccount.php">You don't have an account ?</a>
      </fieldset>
    </form>
  </body>
</html>
