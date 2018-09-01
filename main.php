<?php
require_once("connect.php");

if (filter_has_var(INPUT_POST, "btnDisconnect")) {
    disconnect();
    header("Location: index.php");
    exit;
}

$title = "";
$description = "";
$error = false;
$errormsg = "";
$successmsg = "";

$userArray = getUserByLogin($_SESSION['username']);

if (filter_has_var(INPUT_POST, "btnOK")) {
  $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_STRING);
  $description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_STRING);

  if ($title != "" && $description != "") {
    if (!postExists($title, $description, $userArray["idUser"])) {
      insertPost($title, $description, $userArray['idUser']);
      $successmsg = "Votre post a bien été publié et figure ci-dessous !";
    }else {
      $error = true;
      $errormsg = "Vous avez déjà créé ce post !";
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

$allPosts = getPosts($userArray['idUser']);


 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Confirmation</title>
  </head>
  <body>
    <?php if($error){ ?>
    <h3><?php echo $errormsg; ?></h3>
  <?php }else{ ?>
    <h3><?php echo $successmsg; ?></h3>
  <?php } ?>
    <h2>Bonjour <?php echo $userArray['surname'] . " " . $userArray['name']; ?>, voici votre fil d'actualités !</h2>
    <form class="" action="#" method="post">
      <fieldset>
        <legend>Nouveau post</legend>
        <label>Titre : <br><input type="text" name="title" value="<?php echo $title ?>"></label><br>
        <label>Description : <br><textarea rows="15" cols="100" name="description" value="<?php echo $description ?>"></textarea></label><br>
        <input type="submit" name="btnOK" value="Insérer">
      </fieldset> <br>
      <input type="submit" name="btnDisconnect" value="Déconnexion">
    </form>
    <?php
      foreach ($allPosts as $singlePost) {
    ?>
    <h1><?php echo $singlePost["title"] ?></h1>
    <p><?php echo $singlePost["description"]; ?></p>
    <?php } ?>
  </body>
</html>
