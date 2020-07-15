<?php

session_start();
if(!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    header('Location: dashboard.php');
} else {
    session_destroy();
    header('Location: index.php');
}
