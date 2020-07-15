<?php
require_once 'parts/includes.php';

if(!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    header('Location: login.php');
}

$skills = [];
$experiences = [];

$skills = getUserSkills($pdo, $_SESSION['user']['id']);
$experiences = getUserExperiences($pdo, $_SESSION['user']['id']);

echo '<h2>Mes compétences</h2>';
echo '<a href="add_skill.php" role="button" class="btn btn-primary"><i class="fas fa-plus"></i></a>';
showSkills($skills->fetchAll(), true);
$skills->closeCursor();

echo '<h2>Mes expériences</h2>';
echo '<a href="add_experience.php" role="button" class="btn btn-primary"><i class="fas fa-plus"></i></a>';
showExperiences($experiences->fetchAll(), true);
$experiences->closeCursor();

require_once 'parts/footer.php';
