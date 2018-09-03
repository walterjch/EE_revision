<?php

require_once("functions.php");

$postArrayAModifier = getPostById($_GET["idNews"]);
$userArray = getUserByLogin($_SESSION['username']); //Connected user

$title = $postArrayAModifier["title"];
$description = $postArrayAModifier["description"];
$error = false;
$errormsg = "";
$successmsg = "";



if (filter_has_var(INPUT_POST, "btnOK")) {
  $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_STRING);
  $description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_STRING);
  if ($title != "" && $description != "") {
      if(updatePost($_GET["idNews"], $title, $description)){
          updatePost($_GET["idNews"], $title, $description);
          $successmsg = "Votre post a bien été modifié !";
      }
  }
  else {
    $error = true;
    if ($title == "") {
      $errormsg .= "La saisie d'un titre est obligatoire ! <br>";
    }
    if ($description == "") {
      $errormsg .= "La saisie d'une description est obligatoire !";
    }
  }
}
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <link rel="stylesheet" href="./css/style.css">
    <meta charset="utf-8">
    <title>Confirmation</title>
  </head>
  <body>
    <?php if($error){ ?>
    <h3 class="warning"><?php echo $errormsg; ?></h3>
  <?php }else{ ?>
    <h3 class="info"><?php echo $successmsg; ?></h3>
  <?php } ?>
    <h2>Mise à jour d'une nouvelle</h2>
    <form class="" action="#" method="post">
      <fieldset>
        <legend>Données du post</legend>
        <label>Titre : <br><input type="text" name="title" value="<?php echo $title ?>"></label><br>
        <label>Description : <br><textarea rows="15" cols="100" name="description" ><?php echo $description ?></textarea></label><br>
        <input type="submit" name="btnOK" value="Insérer">
      </fieldset> <br>
      <a href="main.php">Retour</a>
    </form>
  </body>
</html>
