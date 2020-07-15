<?php
require_once 'parts/includes.php';

if(!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    header('Location: login.php');
}

$skills = [];
$experiences = [];

$skills = getUserSkills($pdo);
$experiences = getUserExperiences($pdo);

echo '<h2>Mes compétences</h2>';
showSkills($skills);
echo '<a href="add_skill.php" role="button" class="btn btn-secondary">Ajouter</a>';

echo '<h2>Mes expériences</h2>';
showExperiences($experiences);
echo '<a href="add_experience.php" role="button" class="btn btn-secondary">Ajouter</a>';

require_once 'parts/footer.php';
