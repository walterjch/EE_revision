<!--
Titre       : EE_Revision
Description : Projet de révision de la
              deuxième année.
Auteur      : JAUCH Walter
Date        : 30.08.2018
Comments    : The website content is in french and all the code in english
              If you are testing the website, you can use the login "professor"
              password : professor1234
              (Each user has as password its login with 1234 in the end)
-->
<?php

require_once("functions.php");

//Is there any user connected ?
if (!empty($_SESSION["username"])) {
  header("Location: main.php");
  exit;
}

$error = false;
$errormsg = "";
$username = "";
$pwd = "";
$logged = false;

$username = filter_input(INPUT_POST, "id", FILTER_SANITIZE_STRING);
$pwd = sha1(filter_input(INPUT_POST, "pwd", FILTER_SANITIZE_STRING));

//On vérifie que l'utilisateur a clique sur le bouton
if (filter_has_var(INPUT_POST, "btnOK")) {
//Est-il déconnecté ? Si oui on lui propose de se déconnecter,
//Sinon, on lui propose de se connecter
  if (!isset($_SESSION['username'])) {
    if (checkUser($username, $pwd) != NULL){
       $name = getUserByLogin($username, $pwd);
       $_SESSION['entireName'] = $name;
       $_SESSION['username'] = $username;
       $error = false;
       $errormsg = "";
       $logged = true;
       header("Location: main.php");
       exit;
    }
    else {
      $error = true;
      $errormsg = "Mauvais mot de passe ou identifiant !";
      $logged = false;
    }
  }else {
    disconnect();
  }

}
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../resources/style.css">
    <title>Connexion</title>
  </head>
  <body>
    <form class="" action="index.php" method="post">
      <fieldset>
        <legend>Connexion</legend>
        <?php if ($error == true) {?>
          <span style="color: red;"><?php echo $errormsg; ?></span><br>
        <?php } ?>
        <label>Identifiant : </br><input type="text" name="id"/></label></br>
        <label>Mot de passe : </br><input type="password" name="pwd"/></label></br>
        <input type="submit" name="btnOK"/></br>
      </fieldset>
    </form>
    <a href="newAccount.php">Vous n'avez pas de compte ?</a>
  </body>
</html>
