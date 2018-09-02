<?php

session_start();

/**
*	Test if the username and the password are matching
*	@param	string	$username	In the database, this is the login
* @param	string	$pwd In the database, this is the pwd
*	@return	$result if all is matching, NULL if it's not
*/
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

/**
*	Etablish the connection with our database
*	@return	object	$db if the connection is OK, false if it's not
*/
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

/**
*	Destroy the session of the user that was connected
*/
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

/**
*	Add an user in the database
*	@param	string	$surname	user's surname
* @param	string	$name user's name
* @param  string $login user's $username
* @param string  $pwd password (sha1 already used)
*	@return	$db the last insert id or NULL
*/
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

/**
*	Test if the username exists
*	@param	string	$login	we will compare that with our database
*	@return	boolean true if it already exists and false if not
*/
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


/**
*	Get informations about the user using its login
*	@param	string	$login	In the database, this is the login
*	@return	array $result with all the informations or NULL if process fail
*/
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

/**
*	Get informations about the user using its id
*	@param	int	$idUser	In the database, this is the login
*	@return	array $result with all the informations or NULL if process fail
*/
function getUserById($idUser){
  $db = connectDb();
  $sql = "SELECT idUser, surname, name FROM users " .
          "WHERE idUser = :idUser";
  $request = $db->prepare($sql);
  if ($request->execute(array(
              'idUser' => $idUser))) {
      $result = $request->fetch();

      return $result;
  } else {
      return false;
  }
}


/**
*	Add a new post in the news table
*	@param	string	$title	name of the post
*	@param	string	$description	content of the post
*	@param	int $idUser id of the author of the post
*	@return	 $db last insert id or error message
*/
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


/**
*	Get all the posts in the database to display them
*	@return	 array $result It contains all the posts, error message
*/
function getPosts(){
  $db = connectDb();
  $sql = "SELECT idNews, title, description, creationDate, lastEditDate, idUser FROM news "
          . "ORDER BY idNews desc";
  $request = $db->prepare($sql);
  if ($request->execute()) {
      $result = $request->fetchAll(PDO::FETCH_ASSOC);
      return $result;
  } else {
      return "Erreur : une erreur s'est produite lors du chargement de votre page.";
  }
}

/**
*	Test if the article already exists (by the same author)
*	@param	string	$title	name of the post
*	@param	string	$description	content of the post
*	@param	int $idUser id of the author of the post
*	@return	 boolean true or false depending if it exists or not
*/
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

/**
*	Get a post using its id
*	@param	int $idNews id of the post
*	@return	 array $result It contains the post
*/
function getPostById($idNews){
  $db = connectDb();
  $sql = "SELECT title, description FROM news " .
          "WHERE idNews = :idNews";
  $request = $db->prepare($sql);
  if ($request->execute(array(
              'idNews' => $idNews))) {
      $result = $request->fetch();

      return $result;
  } else {
      return false;
  }
}

/**
*	Update a post (title or description)
*	@param	string	$title	name of the post
*	@param	string	$description	content of the post
*	@param	int $idNews id of the post
*	@return	 boolean true or false depending if it worked well
*/
function updatePost($idNews, $title, $description){
  $db = connectDb();
  $sql = "UPDATE news "
          . "SET title = :title, description = :description "
          . "WHERE idNews = :idNews";
  $request = $db->prepare($sql);
  if ($request->execute(array(
              'title' => $title,
              'description' => $description,
              'idNews' => $idNews))) {
      return true;
  }else {
    return false;
  }
}

/**
*	Delete a post from our database
*	@param	int $idNews So we know which post is going to be deleted
*	@return	 $request
*/
function deletePost($idNews){
  $db = connectDb();
  $sql = "DELETE FROM news WHERE idNews = :idNews";
  $request = $db->prepare($sql);
  return ($request->execute(array(
              "idNews" => $idNews)));
}
