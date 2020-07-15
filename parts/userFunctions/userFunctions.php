<?php

function getUsers($pdo) {
    $query = $pdo->prepare('SELECt * FROM user');
    $query->execute();
    return $query;
}

function getUserByNameSurnameEmail($pdo)
{

    $query = $pdo->prepare('SELECT * FROM user WHERE nom=:nom AND prenom=:prenom AND email=:email');
    $query->execute([
        'nom' => $_POST['nom'],
        'prenom' => $_POST['prenom'],
        'email' => $_POST['email']
    ]);
    return $query;

}

function addUser($pdo) {
    $query = $pdo->prepare('INSERT INTO user (nom, prenom, mot_de_passe, email)
VALUES(:nom, :prenom, :mot_de_passe, :email)');
    $query->execute([
        'nom' => $_POST['nom'],
        'prenom' => $_POST['prenom'],
        'mot_de_passe' => md5($_POST['mot_de_passe']),
        'email' => $_POST['email']
    ]);
}

function connectUser($pdo) {
    $errors = [];
    $query = $pdo->prepare('SELECT * FROM user WHERE email = :email AND mot_de_passe = :mot_de_passe');
    $query->execute([
        'email' => $_POST['email'],
        'mot_de_passe' => md5($_POST['mot_de_passe'])
    ]);
    $res = $query->fetch();
    if($res) {
        $_SESSION['user'] = $res;
    } else {
        $errors[] = "Erreur de login/password";
    }
    return $errors;
}

function validateRegisterForm($pdo)
{
    $errors = [];
    if (empty($_POST['prenom'])) {
        $errors[] = 'Le prénom est requis';
    }
    if (empty($_POST['nom'])) {
        $errors[] = 'Le nom est requis';
    }
    if (empty($_POST['email'])) {
        $errors[] = 'L\'adresse email est requise';
    } else if (!preg_match("/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/", $_POST['email'])) {
        $errors[] = "Le format de l'email est invalide";
    }
    if (empty($_POST['mot_de_passe'])) {
        $errors[] = 'Le mot de passe est requis';
    } else if (strlen($_POST['mot_de_passe']) < 5) {
        $errors[] = 'Le mot de passe doit contenir au moins 5 caractères';
    } else if ($_POST['mot_de_passe'] !== $_POST['passwordConfirm']) {
        $errors[] = 'La confirmation du mot de passe est fausse';
    }
    if(count($errors) === 0 ) {
        if(getUserByNameSurnameEmail($pdo) -> fetch()) {
            $errors[] = 'Un utilisateur identique est déjà enregistré';
        }
    }
    return $errors;
}

function validateLoginForm() {
    $errors = [];
    if(empty($_POST['email'])) {
        $errors[] = 'L\'adresse email est requise';
    } else if (!preg_match("/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,5}$/", $_POST['email'])) {
        $errors[] = "Le format de l'email est invalide";
    }
    if(empty($_POST['mot_de_passe'])) {
        $errors[] = "Le mot de passe est requis";
    } else if (strlen($_POST['mot_de_passe']) < 5) {
        $errors[] = 'Le mot de passe doit contenir au moins 5 caractères';
    }
    return $errors;
}
