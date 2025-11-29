<?php
    // on demande à mysqli de rapporter toutes les erreurs
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    // on tente de se connecter
    // si on arrive à se connecter
    // alors $mysqli contient un objet de classe MySQLi
    // représentant la connexion
    // 4 paramètres d'entrée :
    // 1- l'hôte, 2- l'utilisateur, 3- le mot de passe,
    // 4- le nom de la base de données
    $mysqli = mysqli_connect('localhost', 'root', '', 'sae3012');
?>