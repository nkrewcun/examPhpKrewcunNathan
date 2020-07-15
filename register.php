<?php

require_once 'parts/includes.php';

if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
    header('Location: dashboard.php');
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = validateRegisterForm($pdo);
    if (count($errors) === 0) {
        addUser($pdo);
        header("Location: login.php");
    }
}

?>

    <h2>Création d'un compte : </h2>
    <div class="container">
        <form method="post" action="register.php">
            <div class="form-group">

                <label for="prenom">Prénom</label>
                <input type="text" class="form-control" id="prenom" name="prenom" required/>

                <label for="nom">Nom</label>
                <input type="text" class="form-control" id="nom" name="nom" required/>

                <label for="email">E-mail</label>
                <input type="email" class="form-control" id="email" name="email" required/>

                <label for="mot_de_passe">Mot de passe</label>
                <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe" required
                       minlength="5"/>

                <label for="passwordConfirm">Confirmer mot de passe</label>
                <input type="password" class="form-control" id="passwordConfirm" name="passwordConfirm" required/>
            </div>

            <input type="submit" placeholder="S'inscrire"/>
            <?php
            displayErrors($errors);
            ?>
        </form>
    </div>


<?php
require_once 'parts/footer.php';
