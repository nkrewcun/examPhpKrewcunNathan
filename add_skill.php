<?php

require_once 'parts/includes.php';

$errors = [];

if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    header('Location: login.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = validateSkillForm();
    if (count($errors) === 0) {
        addSkill($pdo);
        header('Location: dashboard.php');
    }
}

?>

    <div class="container-md form">
        <h2>Ajouter une compétence</h2>
        <form method="post" action="add_skill.php">
            <div class="form-group">
                <div class="form-group">
                    <label for="titre">Titre</label>
                    <input type="text" class="form-control" id="titre" name="titre" required>
                </div>
                <div class="form-group">
                    <label for="note">Note</label>
                    <input type="number" class="form-control" id="note" name="note" required min="1" max="5">
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-dark"  placeholder="Ajouter"/>
                    <a href="dashboard.php" class="btn btn-dark" >Retour</a>
                    <?php
                    displayErrors($errors);
                    ?>
                </div>
            </div>
        </form>
    </div>

<?php
require_once 'parts/footer.php';
