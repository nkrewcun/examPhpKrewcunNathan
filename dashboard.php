<?php
require_once 'parts/includes.php';

if(!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    header('Location: login.php');
}

$skills = [];
$experiences = [];

$skills = getUserSkills($pdo, $_SESSION['user']['id']);
$experiences = getUserExperiences($pdo, $_SESSION['user']['id']);

echo '<div class="container cv"><h2>Mon CV</h2>';
echo '<div class="container-md skills">';
echo '<div><h3>Mes compétences</h3>';
echo '<a href="add_skill.php" role="button" class="btn btn-success"><i class="fas fa-plus"></i></a></div>';
showSkills($skills->fetchAll(), true);
echo '</div>';
$skills->closeCursor();

echo '<div class="container-md experiences">';
echo '<div><h3>Mes expériences</h3>';
echo '<a href="add_experience.php" role="button" class="btn btn-success"><i class="fas fa-plus"></i></a></div>';
showExperiences($experiences->fetchAll(), true);
echo '</div>';
echo '</div>';
$experiences->closeCursor();

require_once 'parts/footer.php';
