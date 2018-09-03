<?php
require_once("functions.php");

$postArrayAModifier = getPostById($_GET["idNews"]);

$title = $postArrayAModifier["title"];
$description = $postArrayAModifier["description"];
$error = false;
$errormsg = "";
$successmsg = "";
$success = false;

if (filter_has_var(INPUT_POST, "btnOK")) {
  $deleteChoice = $_POST['delete'];
  if ($deleteChoice == "true") {
      deletePost($_GET["idNews"]);
      $successmsg = "Le post a bien été supprimé.";
      $success = true;
      $error = false;
  }
  else {
    $error = true;
    $success = false;
    $errormsg = "Le post n'a pas été supprimé.";
  }
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <link rel="stylesheet" href="../resources/style.css">
    <meta charset="utf-8">
    <title>Confirmation</title>
  </head>
  <body>
    <?php if($error){ ?>
    <h3 class="warning"><?php echo $errormsg; ?></h3>
  <?php }else{ ?>
    <h3 class="info"><?php echo $successmsg; ?></h3>
  <?php } ?>
    <h2>Suppression d'une nouvelle</h2>
    <?php if (!$error && !$success) { ?>
      <form class="" action="#" method="post">
        <p>Êtes-vous sûr-e de voulour supprimer le post intitulé: "<?php echo $postArrayAModifier["title"]; ?>"</p>
        <input type="radio" name="delete" value="true"> Oui
        <input type="radio" name="delete" value="false" checked="checked"> Non
        <input type="submit" name="btnOK" value="Valider"><br>
      </form>
    <?php } ?>
    <a href="main.php">Retour</a>
  </body>
</html>
