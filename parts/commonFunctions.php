<?php

function displayCVs($pdo, $usersPDO)
{
    $users = $usersPDO->fetchAll();
    $skills = [];
    $experiences = [];
    foreach ($users as $user) {
        $skillsPDO = getUserSkills($pdo, $user['id']);
        $experiencesPDO = getUserExperiences($pdo, $user['id']);
        $skills = $skillsPDO->fetchAll();
        $experiences = $experiencesPDO->fetchAll();
        if ($skills || $experiences) {
            echo '<div class="cv container"><h2>CV de ' . $user['prenom'] . ' ' . $user['nom'] . '</h2>';
            echo '<div class="container-md">';
            if ($skills) {
                echo '<div><h3>Compétences</h3></div>';
                showSkills($skills, false);
            }
            if ($experiences) {
                echo '<div><h3>Expériences</h3></div>';
                showExperiences($experiences, false);
            }
            echo '</div>';
        }
        echo '</div>';
        $experiencesPDO->closeCursor();
        $skillsPDO->closeCursor();
    }
    $usersPDO->closeCursor();
}

function displayErrors($errors)
{
    if (count($errors) != 0) {
        echo(' <h2>Erreurs lors de la dernière soumission du formulaire : </h2>');
        foreach ($errors as $error) {
            echo('<div class="error">' . $error . '</div>');
        }
    }
}
