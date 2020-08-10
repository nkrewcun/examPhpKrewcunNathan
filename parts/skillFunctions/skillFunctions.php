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
        foreach ($skills as $skill) {
            echo '
            <div class="card mb-3">
                <div class="row no-gutters">
                    <div class="col-md-12">
                        <div class="card-body">
                            <h5 class="card-title">' . $skill['titre'] . '</h5>
                            <p class="card-text">';
            for ($i = 1; $i <= 5; $i++) {
                if ($i <= $skill['note']) {
                    echo '<i class="fas fa-star"></i>';
                } else {
                    echo '<i class="far fa-star"></i>';
                }
            }
            echo '</p>';
            if($isDashboard) {
                echo '<p class="card-text actionButtons">
<a href="edit_skill.php?id=' . $skill['id'] . '" role="button" class="btn btn-secondary"><i class="fas fa-pen"></i></a>
<a href="delete_skill.php?id=' . $skill['id'] . '" role="button" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                        </p>';
            }

            echo '</div>
                    </div>
                </div>
            </div>';
        }
    } else {
        echo '<p>Aucune compétence pour le moment</p>';
    }
}
