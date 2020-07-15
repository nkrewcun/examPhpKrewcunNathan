<?php

require_once 'parts/includes.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: index.php');
}

if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    header('Location: login.php');
}

$id = $_GET['id'];
$result = getSkillById($pdo, $id);
$skill = $result->fetch();

if (!$skill || $skill['id_user'] !== $_SESSION['user']['id']) {
    header('Location: index.php');
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = validateSkillForm();
    if (count($errors) === 0) {
        updateSkill($pdo, $id);
        header('Location: dashboard.php');
    }
}

?>

    <div class="container-md form">
        <h2>Modifier une compétence</h2>
        <form method="post" action="edit_skill.php?id=<?php echo $skill['id']; ?>">
            <div class="form-group">
                <div class="form-group">
                    <label for="titre">Titre</label>
                    <input type="text" class="form-control" id="titre" name="titre" required
                           value="<?php echo $skill['titre']; ?>">
                </div>
                <div class="form-group">
                    <label for="note">Note</label>
                    <input type="number" class="form-control" id="note" name="note" required min="1" max="5"
                           value="<?php echo $skill['note']; ?>">
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-dark"  placeholder="Modifier"/>
                    <a href="dashboard.php" class="btn btn-dark" >Retour</a>
                </div>
            </div>
            <?php
            displayErrors($errors);
            ?>
        </form>
    </div>

<?php
$result->closeCursor();
require 'parts/footer.php';
