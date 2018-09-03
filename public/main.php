<?php
require_once("functions.php");

//Is there any user connected ?
if (empty($_SESSION["username"])) {
  header("Location: index.php");
  exit;
}

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

$allPosts = getPosts();
$userArray = getUserByLogin($_SESSION['username']); //Connected user

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
    <h2>Bonjour <?php echo $userArray['surname'] . " " . $userArray['name']; ?>, voici votre fil d'actualités !</h2>
    <form class="" action="#" method="post">
      <fieldset>
        <legend>Nouveau post</legend>
        <label>Titre : <br><input type="text" name="title" value="<?php echo $title ?>"></label><br>
        <label>Description : <br><textarea rows="15" cols="100" name="description" ><?php echo $description ?></textarea></label><br>
        <input type="submit" name="btnOK" value="Insérer">
      </fieldset> <br>
      <input type="submit" name="btnDisconnect" value="Déconnexion">
    </form>
    <?php
      foreach ($allPosts as $singlePost) {
        $postAutor = getUserById($singlePost["idUser"]);
    ?>
    <div class="post">
      <p>Auteur: <?php echo $postAutor["name"] . " " . $postAutor["surname"]; ?></p>
      <p>Posté le <?php echo $singlePost["creationDate"]; ?>. Dernière modification le <?php echo $singlePost["lastEditDate"]; ?>.</p>
      <h1><?php echo $singlePost["title"] ?></h1>
      <p><?php echo $singlePost["description"]; ?></p>
      <?php if ($singlePost["idUser"] == $userArray["idUser"]) { ?>
      <a href="updateNews.php?idNews=<?php echo $singlePost["idNews"]; ?>">Modifier</a>
      <a href="deleteNews.php?idNews=<?php echo $singlePost["idNews"]; ?>">Suprrimer</a>
      <?php } ?>
    </div>
    <?php } ?>
  </body>
</html>
