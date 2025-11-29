<?php
    require_once 'modele/modele.php';
    require_once __DIR__.'/bootstrap.php';

    function afficher_page_connexion_inscription(){
        global $twig;
        echo $twig->render('enfant-connexion-inscription.twig.html');
    }

    function inscription_utilisateur($identifiant, $mdp){
        $success = insert_utilisateur($identifiant, $mdp);
        if ($success) {
            return afficher_page_connexion_inscription();
        } else {
            echo "Erreur lors de l'insertion";
        }
    }

    function connexion_utilisateur($identifiant, $mdp){
        $success = connecte_utilisateur($identifiant, $mdp);
        if ($success) {
            return afficher_page_connexion_inscription();
        } else {
            echo "Erreur lors de l'insertion";
        }
    }




?>