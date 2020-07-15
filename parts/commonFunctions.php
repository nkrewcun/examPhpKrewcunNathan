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
            echo '<h2>CV de ' . $user['prenom'] . ' ' . $user['nom'] . '</h2>';
            if ($skills) {
                echo '<h3>Compétences</h3>';
                showSkills($skills, false);
            }
            if ($experiences) {
                echo '<h3>Expériences</h3>';
                showExperiences($experiences, false);
            }
        }
    }
    $experiencesPDO->closeCursor();
    $skillsPDO->closeCursor();
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
