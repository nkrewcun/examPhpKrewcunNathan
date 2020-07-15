<?php

function getUserExperiences($pdo)
{
    $query = $pdo->prepare('SELECT * FROM experience 
    JOIN user ON experience.id_user = user.id
    WHERE user.id = :id');
    $query->execute([
        'id' => $_SESSION['user']['id']
    ]);
    return $query;
}

function addExperience($pdo)
{
    $req = $pdo->prepare('
        INSERT INTO experience(titre, description, date_debut, date_fin, id_user)
        VALUES(:titre, :description, :date_debut, :date_fin, :id_user)
        ');
    $req->execute([
        'titre' => $_POST['titre'],
        'description' => $_POST['description'],
        'date_debut' => $_POST['date_debut'],
        'date_fin' => $_POST['date_fin'] ? $_POST['date_fin'] : null,
        'id_user' => $_SESSION['user']['id']
    ]);
}

function validateExperienceForm() {
    $errors = [];
    if (empty($_POST['titre'])) {
        $errors[] = 'Le titre est requis';
    }
    if (empty($_POST['description'])) {
        $errors[] = 'La description est requise';
    }
    if (empty($_POST['date_debut'])) {
        $errors[] = 'La date de début est requise';
    }
    return $errors;
}

function showExperiences($experiencesPDO)
{
    $experiences = $experiencesPDO->fetchAll();
    if ($experiences) {

        echo '<table class="table">
        <thead>
        <tr>
            <th scope="col">Titre</th>
            <th scope="col">Description</th>
            <th scope="col">Date de début</th>
            <th scope="col">Date de fin</th>
        </tr>
        </thead>
        <tbody>';
        foreach ($experiences as $experience) {
            echo '<tr>';
            echo '<td>' . $experience['titre'] . '</td>';
            echo '<td>' . $experience['description'] . '</td>';
            echo '<td>' . $experience['date_debut'] . '</td>';
            echo '<td>';
            if($experience['date_fin']) {
                echo $experience['date_fin'];
            } else {
                echo 'En cours';
            }
            echo '</td>';
        }
        echo '</tbody>
    </table>';
    } else {
        echo '<p>Aucune expérience pour le moment</p>';
    }
    $experiencesPDO->closeCursor();
}
