<?php

function getUserExperiences($pdo, $id)
{
    $query = $pdo->prepare('SELECT experience.id, titre, description, date_debut, date_fin, nom, prenom, email FROM experience 
    JOIN user ON experience.id_user = user.id
    WHERE user.id = :id');
    $query->execute([
        'id' => $id
    ]);
    return $query;
}

function getExperienceById($pdo, $id)
{
    $query = $pdo->prepare('SELECT * FROM experience WHERE id=:id');
    $query->execute([
        'id' => $id
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

function updateExperience($pdo, $id)
{
    $query = $pdo->prepare('
        UPDATE experience SET 
            titre=:titre,
            description=:description,
            date_debut=:date_debut,
            date_fin=:date_fin
        WHERE id=:id');
    $query->execute([
        'titre' => $_POST['titre'],
        'description' => $_POST['description'],
        'date_debut' => $_POST['date_debut'],
        'date_fin' => $_POST['date_fin'] ? $_POST['date_fin'] : null,
        'id' => $id
    ]);
}

function deleteExperience($pdo, $id)
{
    $query = $pdo->prepare('DELETE FROM experience WHERE id=:id');
    $query->execute(['id' => $id]);
}

function validateExperienceForm()
{
    $errors = [];
    if (empty($_POST['titre'])) {
        $errors[] = 'Le titre est requis';
    }
    if (empty($_POST['description'])) {
        $errors[] = 'La description est requise';
    }
    if (empty($_POST['date_debut'])) {
        $errors[] = 'La date de début est requise';
    } else if (!strtotime($_POST['date_debut'])) {
        $errors[] = 'Le format de la date de début n\'est pas valide';
    }
    if (!empty($_POST['date_fin'])) {
        if (!strtotime($_POST['date_fin'])) {
            $errors[] = 'Le format de la date de fin n\'est pas valide';
        }
    }
    return $errors;
}

function showExperiences($experiences, $isDashboard)
{
    if ($experiences) {
        foreach ($experiences as $experience) {
            echo '
            <div class="card mb-3">
                <div class="row no-gutters">
                    <div class="col-md-12">
                        <div class="card-body">
                            <h5 class="card-title">Du ' . date('d/m/Y', strtotime($experience['date_debut']));
            if ($experience['date_fin']) {
                echo ' au ' . date('d/m/Y', strtotime($experience['date_fin']));
            } else {
                echo ' à aujourd\'hui';
            }
            echo ' : ' . $experience['titre'] . '</h5>
                            <p class="card-text">' . $experience['description'] . '</p>';
            if($isDashboard) {
                echo '<p class="card-text actionButtons">
<a href="edit_experience.php?id=' . $experience['id'] . '" role="button" class="btn btn-secondary"><i class="fas fa-pen"></i></a>
<a href="delete_experience.php?id=' . $experience['id'] . '" role="button" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                        </p>';
            }
                            
                    echo '</div>
                    </div>
                </div>
            </div>';
        }
    } else {
        echo '<p>Aucune expérience pour le moment</p>';
    }
}
