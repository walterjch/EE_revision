<?php

session_start();

function checkUser($username, $pwd){
  if ($username == "admin" && $pwd == "Super") {
      $erreur = false;
      $logged = true;
      $_SESSION['username'] = $username;
      header("Location: gestion.php");
      exit;
  } else {
      $erreur = true;
      $erreurmsg = "Identification ou mot de passe erroné";
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
