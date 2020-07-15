<?php

require_once 'parts/includes.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: index.php');
}

if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    header('Location: login.php');
}

$id = $_GET['id'];
$result = getExperienceById($pdo, $id);
$experience = $result->fetch();

if (!$experience || $experience['id_user'] !== $_SESSION['user']['id']) {
    header('Location: index.php');
} else {
    deleteExperience($pdo, $id);
}

$result->closeCursor();
header('Location: dashboard.php');

require_once 'parts/footer.php';
