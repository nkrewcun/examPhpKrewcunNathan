<?php

require_once 'parts/includes.php';

if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
    header('Location: dashboard.php');
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = validateLoginForm();
    if (count($errors) === 0) {
        $errors = connectUser($pdo);
        if (!$errors) {
            header("Location: dashboard.php");
        }
    }
}

?>

    <div class="container-md form">
        <h2>Connexion</h2>
        <form method="post" action="login.php">
            <div class="form-group">
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" class="form-control" id="email" name="email" required/>
                </div>
                <div class="form-group">
                    <label for="mot_de_passe">Mot de passe</label>
                    <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe" required
                           minlength="5"/>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-dark"  placeholder="Connexion"/>
                    <a href="index.php" class="btn btn-dark" >Retour</a>
                </div>
            </div>
            <?php
            displayErrors($errors);
            ?>
        </form>
    </div>

<?php
require_once 'parts/footer.php';
