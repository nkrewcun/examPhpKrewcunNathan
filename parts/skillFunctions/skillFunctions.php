<?php

function getUserSkills($pdo)
{
    $query = $pdo->prepare('SELECT * FROM competence
    JOIN user ON competence.id_user = user.id
    WHERE user.id = :id');
    $query->execute([
        'id' => $_SESSION['user']['id']
    ]);
    return $query;
}

function addSkill($pdo)
{
    $req = $pdo->prepare('
        INSERT INTO competence(titre, note, id_user)
        VALUES(:titre, :note, :id_user)
        ');
    $req->execute([
        'titre' => $_POST['titre'],
        'note' => $_POST['note'],
        'id_user' => $_SESSION['user']['id']
    ]);
}

function validateSkillForm() {
    $errors = [];
    if (empty($_POST['titre'])) {
        $errors[] = 'Le titre est requis';
    }
    if (empty($_POST['note'])) {
        $errors[] = 'La note est requise';
    } else if ($_POST['note'] < 1 || $_POST['note'] > 5) {
        $errors[] = 'La note doit être comprise entre 1 et 5';
    }
    return $errors;
}

function showSkills($skillsPDO)
{
    $skills = $skillsPDO->fetchAll();
    if ($skills) {

        echo '<table class="table">
        <thead>
        <tr>
            <th scope="col">Titre</th>
            <th scope="col">Note</th>
        </tr>
        </thead>
        <tbody>';
        foreach ($skills as $skill) {
            echo '<tr>';
            echo '<td>' . $skill['titre'] . '</td>';
            echo '<td>';
            for ($i = 1; $i <= 5; $i++) {
                if ($i <= $skill['note']) {
                    echo '<i class="fas fa-star"></i>';
                } else {
                    echo '<i class="far fa-star"></i>';
                }
            }
            echo '</td>';
        }
        echo '</tbody>
    </table>';
    } else {
        echo '<p>Aucune compétence pour le moment</p>';
    }
    $skillsPDO->closeCursor();
}
