<?php

function getUserSkills($pdo, $id)
{
    $query = $pdo->prepare('SELECT competence.id, titre, note, nom, prenom, email FROM competence
    JOIN user ON competence.id_user = user.id
    WHERE user.id = :id');
    $query->execute([
        'id' => $id
    ]);
    return $query;
}

function getSkillById($pdo, $id)
{
    $query = $pdo->prepare('SELECT * FROM competence WHERE id=:id');
    $query->execute([
        'id' => $id
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

function updateSkill($pdo, $id)
{
    $query = $pdo->prepare('
        UPDATE competence SET 
            titre=:titre,
            note=:note
        WHERE id=:id');
    $query->execute([
        'titre' => $_POST['titre'],
        'note' => $_POST['note'],
        'id' => $id
    ]);
}

function deleteSkill($pdo, $id)
{
    $query = $pdo->prepare('DELETE FROM competence WHERE id=:id');
    $query->execute(['id' => $id]);
}

function validateSkillForm()
{
    $errors = [];
    if (empty($_POST['titre'])) {
        $errors[] = 'Le titre est requis';
    }
    if (empty($_POST['note'])) {
        $errors[] = 'La note est requise';
    } else if (!is_int((int)$_POST['note'])) {
        $errors[] = 'La note doit être un nombre entier';
    } else if ($_POST['note'] < 1 || $_POST['note'] > 5) {
        $errors[] = 'La note doit être comprise entre 1 et 5';
    }
    return $errors;
}

function showSkills($skills, $isDashboard)
{
    if ($skills) {

        echo '<table class="table">
        <thead>
        <tr>
            <th scope="col">Titre</th>
            <th scope="col">Note</th>';
        if ($isDashboard) {
            echo '<th scope="col">Actions</th>';
        }
        echo '</tr>
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
            if ($isDashboard) {
                echo '<td>';
                echo '<a href="edit_skill.php?id=' . $skill['id'] . '" role="button" class="btn btn-secondary"><i class="fas fa-pen"></i></a>';
                echo '<a href="delete_skill.php?id=' . $skill['id'] . '" role="button" class="btn btn-danger"><i class="fas fa-trash"></i></a>';
                echo '</td>';
            }
        }
        echo '</tbody>
    </table>';
    } else {
        echo '<p>Aucune compétence pour le moment</p>';
    }
}
