<?php

require_once 'parts/includes.php';

$errors = [];

if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    header('Location: login.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = validateExperienceForm();
    if (count($errors) === 0) {
        addExperience($pdo);
        header('Location: dashboard.php');
    }
}

?>

    <h2>Ajouter une expérience : </h2>
    <div class="container">
        <form method="post" action="add_experience.php">
            <div class="form-group">
                <div class="form-group">
                    <label for="titre">Titre</label>
                    <input type="text" class="form-control" id="titre" name="titre" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label for="date_debut">Date de début</label>
                    <input type="date" class="form-control" id="date_debut" name="date_debut" required/>
                </div>
                <div class="form-group">
                    <label for="date_fin">Date de fin (optionnel)</label>
                    <input type="date" class="form-control" id="date_fin" name="date_fin"/>
                </div>
            </div>

            <input type="submit" placeholder="Ajouter"/>
            <?php
            displayErrors($errors);
            ?>
        </form>
    </div>

<?php
require_once 'parts/footer.php';
