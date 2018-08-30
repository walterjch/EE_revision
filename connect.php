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
    $dbname = 'EE_revision';

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
}
