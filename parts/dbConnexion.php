<?php

$host = 'localhost';
$dbName = 'examphp';
$user = 'root';
$password = '';

try {
    $pdo = new PDO(
        'mysql:host='.$host.';dbname='.$dbName.';charset=utf8',
        $user,
        $password);
// Cette ligne demandera à pdo de renvoyer les erreurs SQL si il y en a
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
    echo 'Erreur connexion à la base de données : ';
    var_dump($e);
    die();
}
