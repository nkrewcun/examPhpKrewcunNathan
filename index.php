<?php

require_once 'parts/includes.php';

$users = [];
$users = getUsers($pdo);

displayCVs($pdo, $users);

require_once 'parts/footer.php';
