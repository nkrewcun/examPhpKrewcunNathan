<?php

require_once 'parts/includes.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: index.php');
}

if(!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    header('Location: login.php');
}

$id = $_GET['id'];
$result = getExperienceById($pdo, $id);
$experience = $result->fetch();

if (!$experience || $experience['id_user'] !== $_SESSION['user']['id']) {
    header('Location: index.php');
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = validateExperienceForm();
    if (count($errors) === 0) {
        updateExperience($pdo, $id);
        header('Location: dashboard.php');
    }
}

?>

    <h2>Modifier une expérience : </h2>
    <div class="container">
        <form method="post" action="edit_experience.php?id=<?php echo $experience['id']; ?>">
            <div class="form-group">
                <div class="form-group">
                    <label for="titre">Titre</label>
                    <input type="text" class="form-control" id="titre" name="titre" required value="<?php echo $experience['titre']; ?>">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required><?php echo $experience['description']; ?>"</textarea>
                </div>
                <div class="form-group">
                    <label for="date_debut">Date de début</label>
                    <input type="date" class="form-control" id="date_debut" name="date_debut" required value="<?php echo $experience['date_debut']; ?>"/>
                </div>
                <div class="form-group">
                    <label for="date_fin">Date de fin (optionnel)</label>
                    <input type="date" class="form-control" id="date_fin" name="date_fin" value="<?php echo $experience['date_fin']; ?>"/>
                </div>
            </div>

            <input type="submit" placeholder="Modifier"/>
            <a href="dashboard.php">Retour</a>
            <?php
            displayErrors($errors);
            ?>
        </form>
    </div>

<?php

require 'parts/footer.php';
