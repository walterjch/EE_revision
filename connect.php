<?php

session_start();

function checkUser($username, $pwd) {
    $db = connectDb();
    $sql = "SELECT login FROM users "
          . "WHERE login = :login AND pwd = :pwd";
    $request = $db->prepare($sql);
    if ($request->execute(array(
                'login' => $username,
                'pwd' => $pwd))) {
        $result = $request->fetch(PDO::FETCH_ASSOC);
        return $result;
    } else {
        return NULL;
    }
}


function connectDb()
{
    $server = '127.0.0.1';
    $pseudo = 'root';
    $pwd = 'root';
    $dbname = 'EE_revision_forum';

    static $db = null;
    if ($db === null)
    {
        $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
        $db = new PDO("mysql:host=$server;dbname=$dbname", $pseudo, $pwd, $pdo_options);
        $db->exec('SET CHARACTER SET utf8');
    }
    return $db;
}

//L'utilisateur se déconnecte
function disconnect() {
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
    }
    $_SESSION = array();
    session_destroy();
    header("Location: index.php");
    exit;
}

function addUser($surname, $name, $login, $pwd) {
  if (!userExists($login)) {
    $db = connectDb();
    $sql = "INSERT INTO users(surname, name, login, pwd) " .
            " VALUES (:surname, :name, :login, :pwd)";
    $request = $db->prepare($sql);
    if ($request->execute(array(
                'surname' => $surname,
                'name' => $name,
                'login' => $login,
                'pwd' => $pwd))) {
        return $db->lastInsertID();
    } else {
        return NULL;
    }
  }else {
    echo "Cet identifiant est déjà pris !";
  }

}


function userExists($login){
    $db = connectDb();
    $sql = "SELECT login FROM users "
            . "WHERE login = :login";
    $request = $db->prepare($sql);
    if ($request->execute(array(
                'login' => $login))) {
        $result = $request->fetch(PDO::FETCH_ASSOC);
        if (isset($result['login'])) {
          return true;
        }else {
          return false;
        }
    } else {
        return false;
    }
}


function getUserByLogin($login){
  $db = connectDb();
  $sql = "SELECT idUser, surname, name FROM users " .
          "WHERE login = :login";
  $request = $db->prepare($sql);
  if ($request->execute(array(
              'login' => $login))) {
      $result = $request->fetch();

      return $result;
  } else {
      return false;
  }
}

function insertPost($title, $description, $idUser){
  $db = connectDb();
  $sql = "INSERT INTO news(title, description, idUser) " .
          " VALUES (:title, :description, :idUser)";
  $request = $db->prepare($sql);
  if ($request->execute(array(
              'title' => $title,
              'description' => $description,
              'idUser' => $idUser))) {
      return $db->lastInsertID();
  } else {
      echo "<h3>Le post n'a pas pu être inséré !</h3>";
  }
}


function getPosts($idUser){
  $db = connectDb();
  $sql = "SELECT idNews, title, description, idUser FROM news "
          . "WHERE idUser = :idUser "
          . "ORDER BY idNews desc";
  $request = $db->prepare($sql);
  if ($request->execute(array(
              'idUser' => $idUser))) {
      $result = $request->fetchAll(PDO::FETCH_ASSOC);
      return $result;
  } else {
      return "Erreur : une erreur s'est produite lors du chargement de votre page.";
  }
}

function postExists($title, $description, $idUser){
    $db = connectDb();
    $sql = "SELECT title, description, idUser FROM news "
            . "WHERE title = :title AND description = :description AND idUser = :idUser";
    $request = $db->prepare($sql);
    if ($request->execute(array(
                'title' => $title,
                'description' => $description,
                'idUser' => $idUser))) {
        $result = $request->fetch(PDO::FETCH_ASSOC);
        if (isset($result['login']) || isset($result['description']) || isset($result['idUser'])) {
          return true;
        }else {
          return false;
        }
    } else {
        return false;
    }
}
