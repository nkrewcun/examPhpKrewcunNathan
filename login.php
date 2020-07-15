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

    <h2>Connexion : </h2>
    <div class="container">
        <form method="post" action="login.php">
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" class="form-control" id="email" name="email" required/>

                <label for="mot_de_passe">Mot de passe</label>
                <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe" required
                       minlength="5"/>
            </div>

            <input type="submit" placeholder="Connexion"/>
            <?php
            displayErrors($errors);
            ?>
        </form>
    </div>

<?php
require_once 'parts/footer.php';
