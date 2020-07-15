<?php

session_start();
$isConnected = false;
if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
    $isConnected = true;
}

?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php">Accueil</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <?php if ($isConnected) {
            echo '
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php" role="button">Gérer mon CV</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add_skill.php" role="button">Ajouter une compétence</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add_experience.php" role="button">Ajouter une expérience</a>
                    </li>
                </ul>
             ';
        }
        ?>
        <ul class="navbar-nav ml-auto">
            <?php if ($isConnected) {
                echo '
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php" role="button">Se déconnecter</a>
                    </li>
                ';
            } else {
                echo '
                    <li class="nav-item">
                        <a class="nav-link" href="register.php" role="button">Créer un compte</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php" role="button">Se connecter</a>
                    </li>
            ';
            }
            ?>
        </ul>
    </div>
</nav>
