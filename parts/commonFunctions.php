<?php

function displayErrors($errors)
{
    if (count($errors) != 0) {
        echo(' <h2>Erreurs lors de la dernière soumission du formulaire : </h2>');
        foreach ($errors as $error) {
            echo('<div class="error">' . $error . '</div>');
        }
    }
}
